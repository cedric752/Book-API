<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator as PaginationPaginator;
use App\Http\Requests\BookRequest;
use App\Http\Requests\BookFilterRequest;

class BookController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Book::class, 'book');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BookFilterRequest $request)
    {
        return Book::with('author')->where('name', 'like', "%".$request->search."%")
        ->orderBy('name', $request->sort_direction ?? 'asc')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $book = Book::create($request->validated());
        $book->genres()->attach(collect($request->genres)->pluck('id'));
        $book->genres;
        return $book;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $book->author;
        $book->genres;
        return $book;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent();
    }

    public function search($name)
    {
        return Book::where('name', 'like', '%'.$name.'%')->get();
    }
}
