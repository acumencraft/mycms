<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;     
use App\Models\Publication;

class CommentController extends Controller
{
    public function store(Request $request, Publication $publication)
    {
        // მხოლოდ ავტორიზებულებს ვაძლევთ უფლებას ბაკენდზეც
        if (!auth()->check()) {
            return back()->with('error', 'Unauthorized');
        }

        $data = $request->validate([
            'content' => 'required|min:3|max:1000',
        ]);

        $publication->comments()->create([
            'content' => $data['content'],
            'user_id' => auth()->id(),
            'is_approved' => true, // შეგიძლიათ false დააყენოთ, თუ მოდერაცია გინდათ
        ]);

        return back()->with('success', 'Comment added!');
    }
}
