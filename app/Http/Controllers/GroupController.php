<?php

namespace sifmedtec\Http\Controllers;

use Illuminate\Http\Request;
use sifmedtec\Http\Resources\GroupResource;
use sifmedtec\Group;

class GroupController extends Controller
{
    public function show(Request $request, $group)
    {
        request()->merge(['group_id' => $group]);

        $request->validate([
            'group_id' => 'required|exists:groups,id'
        ]);


        $group = Group::find($group);

        return new GroupResource($group);


    }
}
