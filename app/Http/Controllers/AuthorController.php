<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;

/**
 * @group Authors 
 *
 * APIs for managing authors
 */

class AuthorController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Author::class, 'author');
    }
    /**
     * authors.index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AuthorResource::collection(Author::all());
    }

    /**
     * authors.store
     * @authenticated
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorRequest $request)
    {
        $author = Author::create($request->validated());
        $author->books()->attach(collect($request->books)->pluck('id'));
        return new AuthorResource($author);
    }

    /**
     * authors.show
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    /**
     * authors.update
     * @authenticated
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorRequest $request, Author $author)
    {
        $author->update($request->validated());
        return new AuthorResource($author);
    }

    /**
     * authors.destroy
     * @authenticated
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return response()->noContent();
    }
}
