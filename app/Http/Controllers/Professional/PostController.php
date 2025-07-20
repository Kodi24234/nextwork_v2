<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PostController extends Controller
{
    //
    use AuthorizesRequests;

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'], // Max length for a post
        ]);
        $request->user()->posts()->create($validated);

        // 3. Redirect the user back to the feed page.
        return Redirect::route('feed.index')->with('status', 'post-created');
    }
    public function update(Request $request, Post $post): RedirectResponse
    {
        // 1. Authorize that the user owns the post
        $this->authorize('update', $post);

        // 2. Validate the incoming data
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);

        // 3. Update the post
        $post->update($validated);

        // 4. Redirect back to the feed
        return Redirect::route('feed.index')->with('status', 'post-updated');
    }
    public function destroy(Post $post): RedirectResponse
    {
        // 1. Authorize that the user owns the post
        $this->authorize('delete', $post);

        // 2. Delete the post
        $post->delete();

        // 3. Redirect back to the feed
        return Redirect::route('feed.index')->with('status', 'post-deleted');
    }
    // In PostController.php
    public function edit(Post $post): View
    {
        $this->authorize('update', $post); // Security check
        return view('posts.edit', ['post' => $post]);
    }

    public function myPosts()
    {
        $user = Auth::user();

        $posts = $user->posts()
            ->withCount(['likes', 'comments'])
            ->with('comments.user')
            ->latest()
            ->paginate(10);

        return view('professional.my-posts', compact('posts'));
    }

}
