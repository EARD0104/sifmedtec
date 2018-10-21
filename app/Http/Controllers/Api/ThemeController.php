<?php

namespace sifmedtec\Http\Controllers\Api;

use Illuminate\Http\Request;
use sifmedtec\Http\Controllers\Controller;
use sifmedtec\Theme;
use sifmedtec\Http\Resources\ThemeResource;
use sifmedtec\Http\Requests\ThemeStore;
use sifmedtec\Http\Requests\ThemeUpdate;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $themes = Theme::name()->area()->orderByDesc('area_id')->with('area')->paginateIf();
        return ThemeResource::collection($themes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThemeStore $request)
    {
        $theme = Theme::create(request()->only('name', 'area_id', 'description'));
        return new ThemeResource($theme);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ThemeUpdate $request, Theme $theme)
    {
        $theme->update(request()->only('name', 'area_id', 'description'));
        return new ThemeResource($theme);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theme $theme)
    {
        $theme->delete();
        return response()->json([], 204);
    }
}
