<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
        'name', 'description', 'image'
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function highscores()
    {
        return $this->hasManyThrough('App\Highscore', 'App\User');
    }
    
    public $timestamps = true;
}
