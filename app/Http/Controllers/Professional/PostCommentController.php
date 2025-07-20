<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PostCommentController extends Controller
{
    //
    use AuthorizesRequests;
    public function store(Request $request, Post $post)
    {
        // 1. Validate the incoming data.
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2500'],
        ]);

        // 2. Create the new Comment and associate it with the post and the user.
        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'body'    => $validated['body'],
        ]);

        // 3. Return JSON if it's an AJAX request
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Comment posted',
                'comment' => $comment->load('user'), // eager load user for frontend use
            ]);
        }

        // 4. Fallback to normal redirect
        return Redirect::back()->with('status', 'comment-posted');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        // 1. Authorize that the user can delete this comment.
        $this->authorize('delete', $comment);

        // 2. Delete the comment.
        $comment->delete();

        // 3. Redirect back.
        return Redirect::back()->with('status', 'comment-deleted');
    }
}
