<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Game extends Model
{
    protected $fillable = [
        'title', 'description', 'image'
    ];

    public function highscores()
    {
        return $this->hasMany('App\Highscore');
    }
    
    public $timestamps = true;

    
}