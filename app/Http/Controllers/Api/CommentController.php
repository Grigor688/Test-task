<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest\StoreRequest;
use App\Http\Requests\CommentRequest\UpdateRequest;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $comments = Comment::cursor();
        return response($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        Comment::create([
            'title' => $request['title']
        ]);

        return response(['message' => 'You are successfully created the comment'], Response::HTTP_OK);

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
     * @param UpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateRequest $request, int $id): Response
    {
        $post = Comment::findOrFail($id);
        $post->update($request->validated());

        return response(['message' => 'You are successfully updated the comment'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        Comment::findOrFail($id)->delete();

        return response(['message' => 'Comment successfully deleted'], Response::HTTP_OK);
    }
}
