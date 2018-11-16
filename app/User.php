<?php

namespace sifmedtec;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at'];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /* accessors */

    public function scopeName($query)
    {
        if (request()->has('name'))
        {
            return $query->where('name', 'LIKE', '%'.request()->name.'%');
        }
    }

    public function isAdmin()
    {
        return $this->role_id == 1;
    }

    public function isReporter()
    {
        return $this->role_id == 1;
    }
}
