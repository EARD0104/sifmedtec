<?php

namespace sifmedtec;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    /* relations */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /* accesors */
    public function scopeName($query)
    {
        return $query->when(request()->has('name'), function($q){
            $q->where('name', 'LIKE', '%'.request()->name.'%');
        });
    }
    public function scopeArea($query)
    {
        return $query->when(request()->has('area_id'), function($q){
            $q->where('area_id', request()->area_id);
        });
    }
}
