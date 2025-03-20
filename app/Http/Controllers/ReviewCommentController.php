<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewComment;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewCommentController extends Controller
{
    public function store(Request $request, User $user, Review $review)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'min:10'],
            'parent_id' => ['nullable', 'exists:review_comments,id']
        ]);

        $comment = new ReviewComment();
        $comment->content = $validated['content'];
        $comment->user_id = auth()->id();
        $comment->review_id = $review->id;

        if ($request->filled('parent_id')) {
            $comment->parent_id = $validated['parent_id'];
        }

        $comment->save();

        return back()->with('success', 'Your comment has been posted.');
    }

    public function destroy(User $user, Review $review, ReviewComment $comment)
    {
        $comment->delete();

        return back();
    }
}
