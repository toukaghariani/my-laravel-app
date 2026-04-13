<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{

    //Display the authenticated user's watchlist.
    //Watchlist is an independent entity — each row is a user+content bookmark.

    public function index()
    {
        $items = Auth::user()
            ->watchlist()
            ->with('content.genres')
            ->latest()
            ->paginate(20);

        return view('user.watchlist', compact('items'));
    }


    //Add a content item to the user's watchlist.
    //Silently ignores duplicates (unique constraint on user_id + content_id).

    public function add(Content $content)
    {
        $user = Auth::user();

        // Respect the unique constraint — only insert if not already in list
        $alreadyAdded = Watchlist::where('user_id', $user->id)
                                  ->where('content_id', $content->id)
                                  ->exists();

        if (!$alreadyAdded) {
            Watchlist::create([
                'user_id'    => $user->id,
                'content_id' => $content->id,
            ]);
        }

        $message = '"' . $content->title . '" added to your watchlist.';

        if (request()->expectsJson()) {
            return response()->json(['added' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    //Remove a content item from the user's watchlist.

    public function remove(Content $content)
    {
        Watchlist::where('user_id', Auth::id())
                 ->where('content_id', $content->id)
                 ->delete();

        $message = '"' . $content->title . '" removed from your watchlist.';

        if (request()->expectsJson()) {
            return response()->json(['removed' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
