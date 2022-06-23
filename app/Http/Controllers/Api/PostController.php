<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest\StoreRequest;
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
        return response($posts);
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
        return response('You are successfully created the post');
    }

    public function createTag(TagsRequest $request)
    {
        $post_id = $request->post_id;
        $post = Post::find($post_id);
        $post->tags()->attach([$request->all()]);

        return response('You are successfully added tag to post');

    }
    public function getTag($id)
    {
        $tags = Tag::where('id', $id)->with(['posts' => function($q){
            $q->join('post_tag as rel', 'rel.post_id', 'posts.id')
                ->join('tags', 'tags.id', 'post_tag.tag_id')
                ->groupBy('posts.id')
                ->select(['posts.*', DB::raw("Group_concat(tags.name) as tags")]);
        }])->get();

        return response($tags);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}