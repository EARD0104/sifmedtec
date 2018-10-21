<?php

namespace sifmedtec;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
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
