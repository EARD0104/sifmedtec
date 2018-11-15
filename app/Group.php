<?php

namespace sifmedtec;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function getTotalAnswersAttribute()
    {
        $count =0;

        foreach ($this->evaluations as $evaluation) {
            $count = $count + $evaluation->details->count();
        }
        return $count;
    }

    public function getAnswersCorrectAttribute()
    {
        $count =0;

        foreach ($this->evaluations as $evaluation) {
            $count = $count + $evaluation->details()->where('answer',1)->get()->count();
        }
        return $count;
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

    public function scopeStatus($query)
    {
        return $query->when(request()->has('status'), function ($q)
        {
            $q->where('status', request()->status);
        });
    }

    public function scopeDates($query)
    {
        return $query->when(request()->has('from') && request()->has('to'), function ($q)
        {
            $from = Carbon::parse(request()->from)->format('Y-m-d h:m');
            $to = Carbon::parse(request()->to)->format('Y-m-d h:m');
            $q->whereBetween('created_at', [$from, $to]);
        });
    }
}
