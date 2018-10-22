<?php

namespace sifmedtec;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $guarded = [];

    /* relations */

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /* accesors */
    public function scopeName($query)
    {
        return $query->when(request()->has('name'), function($q){
            $q->where('name', 'LIKE', '%'.request()->name.'%');
        });
    }
}
