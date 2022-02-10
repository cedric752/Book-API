<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\AuthorRequest;

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
        return Author::all();
    }

    /**
     * authors.store
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorRequest $request)
    {
        $author = Author::create($request->validated());
        $author->books()->attach(collect($request->books)->pluck('id'));
        $author->books;
        return $author;
    }

    /**
     * authors.show
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        $author->books;
        return $author;
    }

    /**
     * authors.update
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorRequest $request, Author $author)
    {
        $author->update($request->validated());
        return $author;
    }

    /**
     * authors.destroy
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return response()->noContent();
    }
}
