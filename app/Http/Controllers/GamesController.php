<?php
namespace App\Http\Controllers;

use DB;
use App\Game;
use App\GameHighscoreSort;
use App\Highscore;
use App\Http\Controllers\HighscoresController;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;

class GamesController extends Controller
{
    use UploadTrait;
    /**
     * Display the the Games.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all the games from DB view with pagination.  
        $games = GameHighscoreSort::paginate(10);
        
        $highscores = Highscore::orderBy('created_at');

        return view('games.index',[
            'games' => $games,
            'highscores' => $highscores,
        ]);
    }
    /**
     * Show the form for creating a new game.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('games.create');
    }
    /**
     * Store a new game in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation rules
        $rules = [
            'title' => 'required|string|unique:games,title|min:2|max:191',
            'body'  => 'required|string|min:5|max:1000',
            'game_image'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:4096|dimensions:min_width=500,min_height=350'
        ];
        //custom validation error messages
        $messages = [
            'title.unique' => 'Game title should be unique',
        ];
        //First Validate the form data
        $request->validate($rules,$messages);

        //Create a game
        $game = new Game;
        // Check if a game image has been uploaded
        if ($request->has('game_image')) {
            // Get image file
            $image = $request->file('game_image');
            // Make a image name based on game name and current timestamp
            $name = str_slug($request->title).'_'.time();
            // Define folder path
            $folder = 'img/games/';
            // Make a file path where image will be stored (folder path + file name + file extension)
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set game image path in database to filePath
            $game->image = $filePath;
        }
        $game->title = $request->title;
        $game->body  = $request->body;
        $game->save(); // save it to the database.
        //Redirect to a specified route with flash message.
        return redirect()
            ->route('games.index')
            ->with('status','Added new Game!');
    }

    /**
     * Asks highscores controller to store new highscore in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $user_id
     * @param int $game_id    
     * @param string $title
     * @param string $description
     * 
     */
    public function storeHighScore(Request $request, int $user_id, int $game_id)
    {
        HighscoresController::store($user_id, $game_id, $request->title, $request->description);
    }

    /**
     * Asks highscores controller to store new highscore in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createHighScore(Request $request)
    {
        $gameId = $request->gameId;
        return view('/highscores/create', compact('gameId'));
    }

    /**
     * Display a specified game.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //Find a game by it's ID
        $game = Game::findOrFail($id);
        $highscores = Highscore::where('game_id', $id)->orderBy('score', 'desc')->paginate(20);
        //return a view with all the games.
        return view('games.show',compact('game','highscores'));
    }
    /**
     * Show a form for editing a specified game.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Find a game by it's ID
        $game = Game::findOrFail($id);
        return view('games.edit',[
            'game' => $game,
        ]);
    }
    /**
     * Update a specified game from the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validation rules
        $rules = [
            'title' => "required|string|unique:games,title,{$id}|min:2|max:191",
            'body'  => 'required|string|min:5|max:1000',
        ];
        //custom validation error messages
        $messages = [
            'title.unique' => 'Game title should be unique',
        ];
        //First Validate the form data
        $request->validate($rules,$messages);
        //Update the game
        $game        = Game::findOrFail($id);
        $game->title = $request->title;
        $game->body  = $request->body;
        $game->save(); //Can be used for both creating and updating
        //Redirect to a specified route with flash message.
        return redirect()
            ->route('games.show',$id)
            ->with('status','Updated the selected game!');
    }
    /**
     * Remove the specified game from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete the game
        $game = Game::findOrFail($id);
        $game->delete();
        // game::destroy([id]) is also avaliable
        //Redirect to a specified route with flash message.
        return redirect()
            ->route('games.index')
            ->with('status','Deleted the selected game!');
    }
}