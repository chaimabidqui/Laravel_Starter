<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $data = $request->all();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->save();
        return $user;


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::find($id);
        $user->delete();

    }
}
