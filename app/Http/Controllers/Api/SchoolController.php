<?php

namespace sifmedtec\Http\Controllers\Api;

use Illuminate\Http\Request;
use sifmedtec\Http\Controllers\Controller;
use sifmedtec\School;
use sifmedtec\Http\Resources\SchoolResource;
use sifmedtec\Http\Requests\SchoolStore;
use sifmedtec\Http\Requests\SchoolUpdate;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $schools = School::name()->with(['city'])->paginateIf();
        return SchoolResource::collection($schools);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolStore $request)
    {
        $school = School::create(request()->only('name', 'city_id','principal_name',
        'principal_phone',
        'principal_email',
        'phone',
        'other_phone',
        'teachers',
        'email'));

        return new SchoolResource($school);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolUpdate $request, School $school)
    {
        $school->update(request()->only('name', 'city_id','principal_name',
        'principal_phone',
        'principal_email',
        'phone',
        'other_phone',
        'teachers',
        'email'));

        return new SchoolResource($school);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        $school->delete();
        return response()->json([], 204);
    }
}
