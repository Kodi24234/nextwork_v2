<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    //
    public function store(Request $request, Post $post): JsonResponse
    {
        $post->likes()->syncWithoutDetaching($request->user()->id);

        return response()->json(['status' => 'liked']);
    }

    public function destroy(Request $request, Post $post): JsonResponse
    {
        $post->likes()->detach($request->user()->id);

        return response()->json(['status' => 'unliked']);
    }
}
