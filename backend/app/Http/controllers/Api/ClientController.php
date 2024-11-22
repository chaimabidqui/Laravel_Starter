<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $client = new Client();
        $client->full_name = $data['full_name'];
        $client->email = $data['email'];
        $client->phone = $data['phone'];
        $client->save();
        return $client;

    }

    /**
     * Display the specified resource.
     */
    public function show(client $client)
    {
        return $client->products;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, client $client)
    {
        $data = $request->all();
        $client->full_name = $data['full_name'];
        $client->email = $data['email'];
        $client->phone = $data['phone'];
        $client->save();
        return $client;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(client $client)
    {
        $client->delete();
    }
}
