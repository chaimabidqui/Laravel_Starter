<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $book = new Book();
        $book->title =$data['title'];
        $book->save();
        $book->authors()->attach($data['authors_ids']);
        return $book;

    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return $book;

    }
}
