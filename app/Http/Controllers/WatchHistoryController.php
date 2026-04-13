<?php

namespace App\Http\Controllers;

use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchHistoryController extends Controller
{

    //Paginated watch history for the authenticated user.
    //Named history() per the spec — most-recently-watched first.

    public function history()
    {
        $history = Auth::user()
            ->watchHistory()
            ->with('content')
            ->latest('watched_at')
            ->paginate(20);

        return view('user.history', compact('history'));
    }

    //Record (or update) a watch progress entry.

    public function record(Request $request)
    {
        $validated = $request->validate([
            'content_id'      => 'required|exists:contents,id',
            'watched_seconds' => 'required|integer|min:0',
        ]);

        $entry = WatchHistory::updateOrCreate(
            [
                'user_id'    => Auth::id(),
                'content_id' => $validated['content_id'],
            ],
            [
                'watched_seconds' => $validated['watched_seconds'],
                'watched_at'      => now(),
            ]
        );

        if ($request->expectsJson()) {
            return response()->json(['recorded' => true, 'entry_id' => $entry->id]);
        }

        return back()->with('success', 'Progress saved.');
    }
}
