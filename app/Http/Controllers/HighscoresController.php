<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Highscore;
use App\Game;
use Auth;

class HighscoresController extends Controller
{
    
    /**
     * Show the form for creating a new highscore
     *
     * @param int $game_id
     * @return \Illuminate\Http\Response
     */
    public function create($game_id = "")
    {
        $gameId = null;
        $games = Game::all();
        return view('highscores.create', compact('games', 'gameId'));

        if ($game_id == null)
        {
            return redirect('/login');
        }
        else
        {
            $games = Game::all();
            return view('highscores.create', compact('games'));
        }
        
    }

    /**
     * Store a new highscore in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $highscore = new Highscore;

        $rules = [
            'title' => 'required|string|min:2|max:191',
            'score'  => 'required|integer|min:1',
        ];
        //custom validation error messages
        $messages = [
            'title.unique' => 'Highscore title should be from 2-191 characters',
            'score.required' => 'Please enter a score',
            'title.required' => 'Please enter a title for your highscore'
        ];
        $request->validate($rules,$messages);

        if (!$request->has('gameId') && $request->gameIDs[0] == "-1")
        {
            $this->validateHighscoreFromGameIds($request);
        }
        
        //Check if highscore is being created by selecting a game from select box
        if ($request->has('gameIDs'))
        {
            
            $gameId = $request->gameIDs[0];
        }

        //User has clicked add highscore for particular game
        else {
            $gameId = $request->gameId;
        }

        $highscore->game_id = $gameId;
        $highscore->user_id = Auth::user()->id;
        $highscore->title = $request->title;
        $highscore->score  = $request->score;
        $highscore->save(); // save it to the database.
        //Redirect to a specified route with flash message.
        $game = Game::find($gameId);
        return redirect()
            ->route('games.show', $highscore->game_id)
            ->with('status','You added a new highscore for ' . $game->title);
    }
}
