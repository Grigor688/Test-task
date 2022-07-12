<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostResourceCollection;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest\StoreRequest;
use App\Http\Requests\PostRequest\UpdateRequest;
use App\Http\Requests\PostRequest\PostTagStoreRequest as TagsRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user_id = auth()->user()['id'];
        $posts = Post::query()->with(['user','comments', 'category', 'tags'])->where('user_id', $user_id)->get();
//        return response($posts);
        return new PostResourceCollection($posts);
    }

    /**
     * @param StoreRequest $request
     */
    public function store(StoreRequest $request)
    {
        $user_id = auth()->user()['id'];
        $post = Post::query();
        $post->create([
            'user_id' => $user_id,
            'category_id' => $request['category_id'],
            'title' => $request['title'],
            'comment_id' => $request['comment_id'],
        ]);

        return response(['message' => 'You are successfully created the post'], Response::HTTP_OK);
    }


    /**
     * @param TagsRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function createTag(TagsRequest $request)
    {
        $post_id = $request->post_id;
        $post = Post::find($post_id);
        $post->tags()->attach([$request->all()]);

        return response(['message' => 'You are successfully added tag to post'], Response::HTTP_OK);

    }

    /**
     * @param TagsRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function removeTag(TagsRequest $request)
    {
        $post_id = $request->post_id;
        $tag_id = $request->tag_id;
        $post = Post::find($post_id);
        $tag = Tag::find($tag_id);
        $post->tags()->detach($tag);

        return response(['message' => 'You are successfully deleted post tag'], Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function getTag(int $id): Response
    {
        $tags = Tag::where('id', $id)->with(['posts' => function($q){
            $q->join('post_tag as rel', 'rel.post_id', 'posts.id')
                ->join('tags', 'tags.id', 'post_tag.tag_id')
                ->groupBy('posts.id')
                ->select(['posts.*', DB::raw("Group_concat(tags.name) as tags")]);
        }])->get();

        return response([$tags], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateRequest $request, int $id): Response
    {
        $post = Post::findOrFail($id);
        $post->update($request->validated());

        return response(['message' => 'You are successfully updated the post'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        Post::findOrFail($id)->delete();

        return response(['message' => 'Post successfully deleted'], Response::HTTP_OK);
    }
}
