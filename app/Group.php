<?php

namespace sifmedtec;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];

    /* relations */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function month()
    {
        return $this->belongsTo(Month::class);
    }

    /* accesors */
    public function scopeMonth($query)
    {
        return $query->when(request()->has('month_id'), function ($q)
        {
            $q->where('month_id', request()->month_id);
        });
    }

    public function scopeSchool($query)
    {
        return $query->when(request()->has('school_id'), function ($q)
        {
            $q->where('school_id', request()->school_id);
        });
    }
}
