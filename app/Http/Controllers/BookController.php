<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\BookRequest;
use App\Transformers\BookTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @var BookTransformer
     */

    private $bookTransformer;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display a listing of the resource.
     * @param  \League\Fractal\Manager  $fractal
     * @param  \App\Transformers\BookTransformer  $bookTransformer
     */

    function __construct(Manager $fractal, BookTransformer $bookTransformer)
    {
        $this->fractal = $fractal;
        $this->bookTransformer = $bookTransformer;
    }

    public function index()
    {
        $books_with_paginator = Book::paginate(10);
        $books = new Collection($books_with_paginator->items(), $this->bookTransformer);
        $books->setPaginator(new IlluminatePaginatorAdapter($books_with_paginator));
        $books = $this->fractal->createData($books);

        return $books->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BookRequest  $book_request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $book_request)
    {
        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
            $book = $user->book()->create($book_request->all());
        }else{
            $book =Book::create($book_request->all());
        }
        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return response()->json(['book'=>$book->load('user')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BookRequest  $book_request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $book_request, Book $book)
    {
        $book->update($book_request->all());
        return response()->json($book, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return null
     */

    public function destroy(Book $book)
    {
        $user = Auth::guard('api')->user();

        if( $user->id == $book->user_id) $book->delete();
        if( $user->role=='admin') $book->forceDelete();

        return response()->json(null, 204);
    }
}
