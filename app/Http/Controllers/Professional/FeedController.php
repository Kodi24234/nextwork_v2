<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class FeedController extends Controller
{

    public function index(): View
    {
        $posts = Post::with([
            'user.profile',
            'comments' => fn($q) => $q->orderBy('created_at', 'asc'),
            'comments.user.profile',
        ])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->get();
        return view('feed.index', [
            'posts' => $posts,
        ]);
    }

}
