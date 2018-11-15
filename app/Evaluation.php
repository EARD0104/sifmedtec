<?php

namespace sifmedtec;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];

    /* relations */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function details()
    {
        return $this->hasMany(EvaluationDetail::class);
    }
}
