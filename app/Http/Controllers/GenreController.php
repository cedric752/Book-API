<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Requests\GenreRequest;
use App\Models\Book;
use App\Http\Resources\GenreResource;
/**
 * @group Genres
 *
 * APIs for managing genres
 */

class GenreController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Genre::class, 'genre');
    }
    /**
     * genres.index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GenreResource::collection(Genre::all());
    }

    /**
     * genres.store
     * @authenticated
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GenreRequest $request)
    {
        return Genre::create($request->validated());
    }

    /**
     * genres.show
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genre)
    {
        return new GenreResource($genre);
    }

    /**
     * genres.update
     * @authenticated
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GenreRequest $request, Genre $genre)
    {
        $genre->update($request->validated());
        return new GenreResource($genre);
    }

    /**
     * genres.destroy
     * @authenticated
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->noContent();
    }
}
