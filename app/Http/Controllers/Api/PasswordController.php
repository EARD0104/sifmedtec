<?php

namespace sifmedtec\Http\Controllers\Api;

use Illuminate\Http\Request;
use sifmedtec\Http\Controllers\Controller;
use sifmedtec\Http\Requests\PasswordRequest;

class PasswordController extends Controller
{
    public function store(PasswordRequest $request)
    {
        auth()->user()->update(request()->only(['password']));
        return response()->json([]);
    }
}
