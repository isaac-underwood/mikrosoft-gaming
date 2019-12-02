<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GameHighscoreSort;
use App\User;
use App\Group;
class PagesController extends Controller
{
    /**
     * Show index page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //Only get the games from view that have high scores
        $top_games = GameHighscoreSort::where('scoreCount', '>', '0')->get()->take(5); 
        
        //generate top users and limit amount to 5
        $top_users = $this->generateTopUsers()->take(5); 

        //Get the top 5 groups by getting a total count of the users' highscores that are in each group
        //Note: Using DB::table was more efficient for this solution
        $top_groups = \DB::table('groups')
                        ->join('users', 'users.group_id', '=', 'groups.id')
                        ->join('highscores', 'highscores.user_id', '=', 'users.id')
                        ->select(\DB::raw('*, count(highscores.user_id) as highscore_count'))
                        ->orderBy('highscore_count', 'desc')
                        ->groupBy('groups.name')->get()->take(5);
        
        return view('pages.index',[
            'users' => $top_users,
            'groups' => $top_groups,
            'top5' => $top_games,
        ]);
    }

    /**
     * Generates top 5 users
     */
    public function generateTopUsers()
    {
        $users = User::all();
        foreach ($users as $key=>$user) //loop through all users
        {
            if ($user->highscores->count() == 0) //check if user has 0 highsccores
            {
                unset($users[$key]); //remove from results
            }
        }
        return $users; //return all users with at least 1 highscore
    }
    
    /**
     * Show About page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function about(){
        return view('pages.about');
    }

   
}
