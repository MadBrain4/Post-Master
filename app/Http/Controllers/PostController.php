<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostController extends Controller
{
    public function index() : JsonResource
    {
        return PostResource::collection(Post::all());
    }
    public function store(PostStoreRequest $request) : JsonResponse
    {
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Post created successfully',
            'success' => true
        ], 201);
    }

    public function show(Post $post) : JsonResource
    {
        return new PostResource($post);
    }

    public function update(PostUpdateRequest $request, Post $post) : JsonResponse
    {
        $post->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response()->json([
            'message' => 'Post updated successfully',
            'success' => true,
            'data' => new PostResource($post)
        ]);
    }
    public function destroy(Post $post) : JsonResponse
    {
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully',
            'success' => true,
            'data' => new PostResource($post)    
        ]);
    }   
}
