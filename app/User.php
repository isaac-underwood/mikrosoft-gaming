<?php

namespace App;

use App\Notifications\ConfirmBan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'banned_until', 'profile_image', 'interests', 'favourite_games', 'location', 'real_name'
    ];

    protected $dates = [
        'banned_until'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function highscores()
    {
        return $this->hasMany('App\Highscore');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function bans()
    {
        return $this->hasMany('App\Ban');
    }

    public function getImageAttribute()
    {
        return $this->profile_image;
    }
}
