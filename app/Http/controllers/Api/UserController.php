<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request )

    {

        $users = User::all();
        return  UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
       $user = new User();
       $user->name = $data['name'];
       $user->email =  $data['email'];
       $user->password = $data['password'];
       $user->save();
       return $user;

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
    
       return  new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */

    }
    public function update(Request $request, User $user)
    {
    
        $data = $request->all();
     
        $user->name = $data['name'];
        $user->email =  $data['email'];
        $user->password = $data['password'];
        $user->save();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
