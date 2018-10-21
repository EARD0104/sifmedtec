<?php

namespace sifmedtec;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];

    /* relations */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /* accesors */
    public function scopeName($query)
    {
        return $query->when(request()->has('name'), function($q){
            $q->where('name', 'LIKE', '%'.request()->name.'%');
        });
    }
    public function scopeDepartment($query)
    {
        return $query->when(request()->has('department_id'), function($q){
            $q->where('department_id', request()->department_id);
        });
    }
}
