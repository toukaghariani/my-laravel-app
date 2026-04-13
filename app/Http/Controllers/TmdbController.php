<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Genre;
use App\Services\TmdbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TmdbController extends Controller
{
    protected TmdbService $tmdb;

    public function __construct(TmdbService $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    // ─── Admin gate ────────────────────────────────────────────

    private function authorizeAdmin(): void
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Administrator access required.');
        }
    }

    // ─── Search page ───────────────────────────────────────────

    /**
     * Show the TMDB search/import page (admin only).
     */
    public function search(Request $request)
    {
        $this->authorizeAdmin();

        $results    = [];
        $query      = $request->input('q', '');
        $type       = $request->input('type', 'multi');
        $page       = (int) $request->input('page', 1);
        $totalPages = 1;

        if ($query) {
            $data = match ($type) {
                'movie' => $this->tmdb->searchMovies($query, $page),
                'tv'    => $this->tmdb->searchTv($query, $page),
                default => $this->tmdb->searchMulti($query, $page),
            };

            if ($data) {
                $results    = $data['results'] ?? [];
                $totalPages = $data['total_pages'] ?? 1;

                // Filter out people from multi-search
                $results = array_filter($results, fn ($r) =>
                    in_array($r['media_type'] ?? $type, ['movie', 'tv'])
                );

                // Mark items already in our database
                $tmdbIds  = collect($results)->pluck('id')->toArray();
                $existing = Content::whereIn('tmdb_id', $tmdbIds)->pluck('tmdb_id')->toArray();

                $results = array_map(function ($r) use ($existing, $type) {
                    $r['_already_imported'] = in_array($r['id'], $existing);
                    $r['_type'] = $r['media_type'] ?? $type;
                    $r['_title'] = $r['title'] ?? $r['name'] ?? 'Unknown';
                    $r['_year'] = $this->extractYear($r['release_date'] ?? $r['first_air_date'] ?? '');
                    $r['_poster'] = $r['poster_path']
                        ? $this->tmdb->imageUrl($r['poster_path'])
                        : null;
                    return $r;
                }, $results);
            }
        }

        return view('admin.tmdb.search', compact('results', 'query', 'type', 'page', 'totalPages'));
    }

    // ─── Import a single title ─────────────────────────────────

    /**
     * Import a movie or TV show from TMDB into our local Content table.
     */
    public function import(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'tmdb_id' => 'required|integer',
            'type'    => 'required|in:movie,tv',
        ]);

        $tmdbId = (int) $request->input('tmdb_id');
        $type   = $request->input('type');

        // Already imported?
        if (Content::where('tmdb_id', $tmdbId)->exists()) {
            return back()->with('info', 'This title is already in your catalogue.');
        }

        // Fetch full details from TMDB
        $details = $type === 'movie'
            ? $this->tmdb->getMovie($tmdbId)
            : $this->tmdb->getTvShow($tmdbId);

        if (!$details) {
            return back()->with('error', 'Could not fetch details from TMDB. Please try again.');
        }

        // Normalise
        $data = $this->tmdb->normalise($details, $type);
        $genreIds = $data['genre_ids'] ?? [];
        unset($data['genre_ids']);

        // Default streaming_url to empty — admin can set an embed URL later
        $data['streaming_url'] = '';
        $data['is_premium']    = $request->boolean('is_premium');

        $content = Content::create($data);

        // Sync genres — create any missing ones
        $this->syncTmdbGenres($content, $genreIds, $type);

        return back()->with('success', "\"{$content->title}\" imported successfully.");
    }

    // ─── Bulk import trending ──────────────────────────────────

    /**
     * Import current trending titles from TMDB.
     */
    public function importTrending(Request $request)
    {
        $this->authorizeAdmin();

        $window = $request->input('window', 'week');
        $data   = $this->tmdb->trending($window);

        if (!$data || empty($data['results'])) {
            return back()->with('error', 'Could not fetch trending titles from TMDB.');
        }

        $imported = 0;
        $skipped  = 0;

        foreach ($data['results'] as $item) {
            $mediaType = $item['media_type'] ?? null;
            if (!in_array($mediaType, ['movie', 'tv'])) continue;

            // Skip already imported
            if (Content::where('tmdb_id', $item['id'])->exists()) {
                $skipped++;
                continue;
            }

            $normalised = $this->tmdb->normalise($item, $mediaType);
            $genreIds   = $normalised['genre_ids'] ?? [];
            unset($normalised['genre_ids']);

            $normalised['streaming_url'] = '';
            $normalised['is_premium']    = false;

            $content = Content::create($normalised);
            $this->syncTmdbGenres($content, $genreIds, $mediaType);
            $imported++;
        }

        return back()->with('success', "Imported {$imported} titles ({$skipped} already existed).");
    }

    // ─── Helpers ───────────────────────────────────────────────

    /**
     * Sync TMDB genre IDs to our local genres table, creating any missing genres.
     */
    private function syncTmdbGenres(Content $content, array $tmdbGenreIds, string $type): void
    {
        if (empty($tmdbGenreIds)) return;

        // Fetch TMDB's genre name map
        $genreList = $type === 'movie'
            ? $this->tmdb->movieGenres()
            : $this->tmdb->tvGenres();

        $tmdbGenreMap = collect($genreList['genres'] ?? [])
            ->pluck('name', 'id')
            ->toArray();

        $localGenreIds = [];
        foreach ($tmdbGenreIds as $tgId) {
            $name = $tmdbGenreMap[$tgId] ?? null;
            if (!$name) continue;

            $genre = Genre::firstOrCreate(
                ['name' => $name],
            );
            $localGenreIds[] = $genre->id;
        }

        $content->genres()->sync($localGenreIds);
    }

    private function extractYear(?string $date): ?int
    {
        if (!$date) return null;
        $year = (int) substr($date, 0, 4);
        return $year > 0 ? $year : null;
    }
}
