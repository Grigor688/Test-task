<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest\StoreRequest;
use App\Http\Requests\TagRequest\UpdateRequest;
use App\Models\Comment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tags = Tag::cursor();
        return response($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        Tag::create([
            'name' => $request['name']
        ]);

        return response(['message' => 'You are successfully created the tag'], Response::HTTP_OK);
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
        $post = Tag::findOrFail($id);
        $post->update($request->validated());

        return response(['message' => 'You are successfully updated the tag'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        Tag::findOrFail($id)->delete();

        return response(['message' => 'Tag successfully deleted'], Response::HTTP_OK);
    }
}
