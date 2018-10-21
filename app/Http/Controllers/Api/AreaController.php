<?php

namespace sifmedtec\Http\Controllers\Api;

use Illuminate\Http\Request;
use sifmedtec\Http\Controllers\Controller;
use sifmedtec\Area;
use sifmedtec\Http\Resources\AreaResource;
use sifmedtec\Http\Requests\AreaUpdate;
use sifmedtec\Http\Requests\AreaStore;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $areas = Area::name()->orderByDesc('id')->paginateIf();
        return AreaResource::collection($areas);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaStore $request)
    {
        $area = Area::create(request()->only('name', 'description'));
        return new AreaResource($area);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AreaUpdate $request, Area $area)
    {
        $area->update(request()->only('name', 'description'));
        return new AreaResource($area);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $area->delete();
        return response([], 204);
    }
}
