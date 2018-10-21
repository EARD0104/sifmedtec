<?php

namespace sifmedtec;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = [];

    /* relations */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /* accesors */
    public function scopeName($query)
    {
        return $query->when(request()->has('name'), function($q){
            $q->where('name', 'LIKE', '%'.request()->name.'%');
        });
    }
    public function scopeQuestion($query)
    {
        return $query->when(request()->has('question_id'), function($q){
            $q->where('question_id', request()->question_id);
        });
    }
}
