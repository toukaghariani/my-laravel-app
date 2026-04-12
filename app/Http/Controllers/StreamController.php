<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StreamController extends Controller
{
    //Gate and serve the video player page.

    public function stream(Content $content)
    {
        $user = Auth::user();

        // user not logged in
        if (!$user) {
            return redirect()->route('login')
                ->with('info', 'Please sign in to watch content.');
        }

        // premium content w no active subscription
        if ($content->isPremium() && !$user->hasActiveSub()) {
            return redirect()->route('subscriptions.plans')
                ->with('warning', 'A premium subscription is required to stream this title.');
        }

        // retrieve the watch history row (start position for player)
        $history = WatchHistory::firstOrCreate(
            [
                'user_id'    => $user->id,
                'content_id' => $content->id,
            ],
            [
                'watched_seconds' => 0,
                'watched_at'      => now(),
            ]
        );

        $content->load('genres');

        return view('stream.play', compact('content', 'history'));
    }

    //updates watched_seconds every N seconds

    public function progress(Request $request)
    {
        $validated = $request->validate([
            'content_id'      => 'required|exists:contents,id',
            'watched_seconds' => 'required|integer|min:0',
        ]);

        WatchHistory::updateOrCreate(
            [
                'user_id'    => Auth::id(),
                'content_id' => $validated['content_id'],
            ],
            [
                'watched_seconds' => $validated['watched_seconds'],
                'watched_at'      => now(),
            ]
        );

        return response()->json(['ok' => true]);
    }
}
