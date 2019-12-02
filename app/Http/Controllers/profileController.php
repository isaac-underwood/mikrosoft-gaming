<?php

namespace App\Http\Controllers;

use App\Game;
use App\Highscore;
use DB;
use App\User;
use Auth;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    use UploadTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

     /**
     * Show currently logged in user's profile page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $highscores = Highscore::where('user_id', auth()->id())->orderBy('game_id', 'asc')->paginate(10);
        $user = User::findOrFail(auth()->id());
        
        return view('profile.index', compact('highscores', 'user'));
    }

    /**
     * Displays the edit profile page for currently logged in user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $user = User::findOrFail(auth()->id());
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
        $rules = [
            'location' => 'max:191',
            'favourite_games' => 'max:191',
            'email' => 'max:191',
            'username' => 'max:191',
            'real_name' => 'max:191',
            'interests'  => 'max:191',
            'profile_image'     =>  'image|mimes:jpeg,png,jpg,gif|max:4096|dimensions:min_width=50,min_height=50'
        ];
        //custom validation error messages
        $messages = [
            '*.max' => 'This field must be less than 191 characters',
        ];
        //First Validate the form data
        $request->validate($rules,$messages);

        $user = User::findOrFail(Auth::user()->id);

        $user->real_name = request('real_name');
        $user->interests = request('interests');
        $user->location = request('location');
        $user->favourite_games = request('favourite_games');

        // Check if a profile image has been uploaded
        if ($request->has('profile_image')) {
            // Get image file
            $image = $request->file('profile_image');
            // Make a image name based on user name and current timestamp
            $name = str_slug($user->username).'_'.time();
            // Define folder path
            $folder = 'img/users/profile/';
            // Make a file path where image will be stored (folder path + file name + file extension)
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $user->profile_image = $filePath;
        }
        
        $user->save();
        $user = User::find(Auth::user()->id);
       
        $highscores = Highscore::where('user_id', auth()->id())->orderBy('game_id', 'asc')->paginate(10);
        return view('profile.index', compact('user', 'highscores'));
    }
}
