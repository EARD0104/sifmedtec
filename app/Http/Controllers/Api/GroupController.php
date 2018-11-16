<?php

namespace sifmedtec\Http\Controllers\Api;

use sifmedtec\Group;
use Illuminate\Http\Request;
use sifmedtec\Http\Controllers\Controller;
use sifmedtec\Http\Resources\GroupResource;
use sifmedtec\Http\Requests\GroupStore;
use sifmedtec\Http\Requests\GroupUpdate;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = Group::query()->dates()->status()->school()->month()->with('school.city.department', 'month', 'evaluations', 'themes.area')->orderByDesc('id')->paginateIf();
        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupStore $request)
    {
        $group = Group::create(request()->only(['school_id', 'month_id']));
        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  \sifmedtec\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sifmedtec\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(GroupUpdate $request, Group $group)
    {
        $group->update(request()->only(['school_id', 'month_id', 'status']));
        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \sifmedtec\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->status = !$group->status;
        $group->save();
        return response()->json([],204);
    }
}
