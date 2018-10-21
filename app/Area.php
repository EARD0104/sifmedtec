<?php

namespace sifmedtec;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $guarded = [];

    /* accesors */
    public function scopeName($query)
    {
        return $query->when(request()->has('name'), function($q){
            $q->where('name', 'LIKE', '%'.request()->name.'%');
        });
    }
}
