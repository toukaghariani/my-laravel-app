<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{

    public function index(Request $request)
    {
        $query = Content::with('genres');
        if ($request->filled('genre')) {
            $query->whereHas('genres', fn ($q) =>
                $q->where('name', $request->genre)
            );
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(fn ($q) =>
                $q->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
            );
        }

        $contents = $query->latest()->paginate(20)->withQueryString();
        $genres   = Genre::orderBy('name')->get();

        return view('content.index', compact('contents', 'genres'));
    }

    //Blocks premium content for non-subscribers.
    public function show(Content $content)
    {
        $user = Auth::user();

        if ($content->isPremium() && (!$user || !$user->hasActiveSub())) {
            return redirect()->route('subscriptions.plans')
                ->with('warning', 'A premium subscription is required to watch this title.');
        }

        $content->load('genres');
        $related = Content::with('genres')
            ->whereHas('genres', fn ($q) =>
                $q->whereIn('genres.id', $content->genres->pluck('id'))
            )
            ->where('id', '!=', $content->id)
            ->when(!$user || !$user->hasActiveSub(), fn ($q) => $q->where('is_premium', false))
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('content.show', compact('content', 'related'));
    }

    //admin crud

    public function adminIndex()
    {
        $this->authorizeAdmin();
        $contents = Content::with('genres')->latest()->paginate(20);
        return view('admin.content.index', compact('contents'));
    }
    // Show the admin form for creating new content.
    public function create()
    {
        $this->authorizeAdmin();
        $genres = Genre::orderBy('name')->get();
        return view('admin.content.create', compact('genres'));
    }

    // Persist new content to the database.

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'language'      => 'nullable|string|max:50',
            'type'          => 'required|in:movie,series',
            'release_year'  => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'thumbnail_url' => 'nullable|url|max:1000',
            'streaming_url' => 'required|url|max:1000',
            'is_premium'    => 'boolean',
            'genre_ids'     => 'nullable|array',
            'genre_ids.*'   => 'exists:genres,id',
        ]);

        $validated['is_premium'] = $request->boolean('is_premium');
        $content = Content::create($validated);

        if (!empty($validated['genre_ids'])) {
            $content->genres()->sync($validated['genre_ids']);
        }

        return redirect()->route('admin.content.index')
            ->with('success', "\"{$content->title}\" has been added to the catalogue.");
    }

    // Show the admin edit form.

    public function edit(Content $content)
    {
        $this->authorizeAdmin();
        $genres         = Genre::orderBy('name')->get();
        $selectedGenres = $content->genres->pluck('id')->toArray();
        return view('admin.content.edit', compact('content', 'genres', 'selectedGenres'));
    }

    //Persist updates to an existing content record.

    public function update(Request $request, Content $content)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'language'      => 'nullable|string|max:50',
            'type'          => 'required|in:movie,series',
            'release_year'  => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'thumbnail_url' => 'nullable|url|max:1000',
            'streaming_url' => 'required|url|max:1000',
            'is_premium'    => 'boolean',
            'genre_ids'     => 'nullable|array',
            'genre_ids.*'   => 'exists:genres,id',
        ]);

        $validated['is_premium'] = $request->boolean('is_premium');
        $content->update($validated);
        $content->genres()->sync($validated['genre_ids'] ?? []);

        return redirect()->route('admin.content.index')
            ->with('success', "\"{$content->title}\" has been added to the catalogue.");
    }

    // Delete a content record (and detach its genre pivots automatically).

    public function destroy(Content $content)
    {
        $this->authorizeAdmin();
        $title = $content->title;
        $content->genres()->detach();
        $content->delete();

        return redirect()->route('admin.content.index')
            ->with('success', "\"{$title}\" has been removed from the catalogue.");
    }

    //helpers

    private function authorizeAdmin(): void
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Administrator access required.');
        }
    }
}

