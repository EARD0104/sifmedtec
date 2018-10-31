<?php

namespace sifmedtec;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
}
