<?php

namespace sifmedtec\Http\Controllers\Api;

use Illuminate\Http\Request;
use sifmedtec\Http\Controllers\Controller;
use sifmedtec\Month;
use sifmedtec\Http\Resources\MonthResource;

class MonthController extends Controller
{
    public function index()
    {
        $months = Month::paginateIf();
        return MonthResource::collection($months);
    }
}
