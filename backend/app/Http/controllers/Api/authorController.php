<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\author;
use Illuminate\Http\Request;

class authorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return author::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $author = new author();
        $author->name = $data['name'];
        $author->save();
        return $author;
    }

    /**
     * Display the specified resource.
     */
    public function show(author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(author $author)
    {
        //
    }
}
