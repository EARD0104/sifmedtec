<?php

namespace sifmedtec\Http\Controllers\Api;

use Illuminate\Http\Request;
use sifmedtec\Http\Controllers\Controller;
use sifmedtec\Department;
use sifmedtec\Http\Resources\DepartmentResource;
use sifmedtec\Http\Requests\DepartmentStore;
use sifmedtec\Http\Requests\DepartmentUpdate;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departmens = Department::name()->orderByDesc('id')->paginateIf();

        return DepartmentResource::collection($departmens);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentStore $request)
    {
        $department = Department::create(request()->only('name'));
        return new DepartmentResource($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentUpdate $request, Department $department)
    {
        $department->update(request()->only('name'));
        return new DepartmentResource($department);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json([], 204);
    }
}
