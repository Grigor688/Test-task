<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest\StoreRequest;
use App\Http\Requests\CategoryRequest\UpdateRequest;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = Category::cursor();
        return response($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        Category::create([
            'name' => $request['name']
        ]);

        return response(['message' => 'You are successfully created the category'], Response::HTTP_OK);
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
        $post = Category::findOrFail($id);
        $post->update($request->validated());

        return response(['message' => 'You are successfully updated the category'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        Category::findOrFail($id)->delete();

        return response(['message' => 'Category successfully deleted'], Response::HTTP_OK);
    }
}
