<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator as PaginationPaginator;
use App\Http\Requests\BookRequest;
use App\Http\Requests\BookFilterRequest;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @group Books
 *
 * APIs for managing books
 */
class BookController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Book::class, 'book');
    }
    /**
     * books.index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BookFilterRequest $request)
    {
        $books = Book::with(['authors','genres'])->where('name', 'like', "%".$request->search."%")
        ->orderBy('name', $request->sort_direction ?? 'asc')->paginate(10);
        return BookResource::collection($books);
    }

    /**
     * books.store
     * @authenticated
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $book = Book::create($request->validated());
        $book->genres()->attach(collect($request->genres)->pluck('id'));
        $book->authors()->attach(collect($request->authors)->pluck('id'));
        return new BookResource($book);
    }

    /**
     * books.show
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * books.update
     * @authenticated
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return new BookResource($book);
    }

    /**
     * books.destroy
     * @authenticated
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent();
    }
}
