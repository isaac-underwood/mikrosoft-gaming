<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $table = 'bans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'third_party_user_id', 'reason', 'banned_until'
    ];

    protected $dates = [
        'banned_until'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
