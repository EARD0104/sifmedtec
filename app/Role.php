<?php

namespace sifmedtec;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /* accessors */

    public function scopeName($query)
    {
        if (request()->has('name'))
        {
            return $query->where('name', 'LIKE', '%'.request()->name.'%');
        }
    }


}
