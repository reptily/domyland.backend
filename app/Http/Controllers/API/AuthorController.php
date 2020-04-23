<?php

namespace App\Http\Controllers\API;

use App\Author;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AuthorCollection
     */
    public function index()
    {
        return new AuthorCollection(Author::get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AuthorRequest $request
     * @return AuthorResource
     */
    public function store(AuthorRequest $request)
    {
        $author = Author::create([
            'name' => $request->name,
        ]);

        return new AuthorResource($author);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return AuthorResource
     */
    public function show($id)
    {
        return new AuthorResource(Author::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Author::find($id);
        if (empty($author)) {
            return response()->json(['error' => 'author_not_found'], 404);
        }

        $author->delete();
        return response()->json(['deleted' => true]);
    }
}
