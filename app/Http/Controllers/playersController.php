<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Highscore;
use Auth;
use App\Ban;
use App\BanRequest;

class PlayersController extends Controller
{
    
    public function show($id)
    {
        if ($id == Auth::user()->id) //Check if user has navigated to own profile, if so redirect to profile/index instead of players/show
        {
            return redirect()->action('ProfileController@index');
        }
        else
        {
            $user = User::findOrFail($id);

            $user_banned = Ban::where('user_id', $id)->where('banned_until', '>', now());

            $user_already_requested_ban = $this->checkAlreadyRequestedBan(Auth::user()->id, $id);

            $highscores = Highscore::where('user_id', $id)->orderBy('game_id', 'asc')->paginate(10);
            
            return view('players.show', compact('user', 'highscores', 'user_banned', 'user_already_requested_ban'));
        }
        
    }

    /**
     * Checks if user is currently banned - used to display request ban button or not
     * @param int $id
     * @return boolean
     */
    public function checkCurrentlyBanned(int $id)
    {
        $ban_count = Ban::where('user_id', $id)->where('banned_until', '>', now())->count();
        
        if ($ban_count >= 1)
        {
            return true;
        }

        else
        {
            return false;
        }
        
    }

    /**
     * Checks if currently logged in user has already submitted a ban request on this user within past 7 days
     * @param int $id
     */
    public function checkAlreadyRequestedBan(int $requested_by_id, int $ban_target_id)
    {
        return BanRequest::where('requested_by_user_id', $requested_by_id)
                                    ->where('created_at', '>', now()->subDays(7))
                                    ->where('ban_user_id', $ban_target_id);
        
        
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'asc')->paginate(20);
        return view('players.index', compact('users'));
    }
}
