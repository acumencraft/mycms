<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Publication;
use Illuminate\Support\Facades\RateLimiter;

class CommentController extends Controller
{
    public function store(Request $request, Publication $publication)
    {
        if (!auth()->check()) {
            return back()->with('error', 'You must be logged in to comment.');
        }

        $key = 'comment:' . auth()->id();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Too many comments. Try again in {$seconds} seconds.");
        }
        RateLimiter::hit($key, 60);

        $data = $request->validate([
            'content'          => 'required|string|min:3|max:1000',
            'parent_id'        => 'nullable|integer|exists:comments,id',
            'reply_to_user_id' => 'nullable|integer|exists:users,id',
        ]);

        $publication->comments()->create([
            'content'          => $data['content'],
            'user_id'          => auth()->id(),
            'parent_id'        => $data['parent_id'] ?? null,
            'reply_to_user_id' => $data['reply_to_user_id'] ?? null,
            'is_approved'      => true,
        ]);

        return back()->with('success', 'Comment added!');
    }
}
