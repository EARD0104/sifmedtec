<?php

namespace sifmedtec\Http\Controllers\Api;

use Illuminate\Http\Request;
use sifmedtec\Http\Controllers\Controller;
use sifmedtec\Http\Resources\UserResource;
use sifmedtec\User;

class UserSchoolController extends Controller
{
    public function update(Request $request, User $user)
    {
        $user->schools()->attach($request->school_id);
        return new UserResource($user);
    }
}
