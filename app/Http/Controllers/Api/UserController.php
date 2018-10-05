<?php

namespace sifmedtec\Http\Controllers\Api;

use Illuminate\Http\Request;
use sifmedtec\Http\Controllers\Controller;
use sifmedtec\Http\Resources\UserResource;
use sifmedtec\User;
use sifmedtec\Http\Requests\UserStore;
use sifmedtec\Http\Requests\UserUpdate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::name()->orderByDesc('id')->paginate();
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStore $request)
    {
        request()->merge(['api_token' => str_random(100)]);
        $user = User::create(request()->all());
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdate $request, User $user)
    {
        $user->update(request()->all());
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response([], 204);
    }
}
