<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sortable;

class Highscore extends Model
{

    

    protected $table = 'highscores';

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public $timestamps = true;
    public $sortable = ['Game', 'Score Catergory', 'Score Value', 'Date'];
}
