<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\EditUserRequest;

class UsersController extends Controller
{
    /*
|-------------------------------------------------------------------------------
| Updates a User's Profile
|-------------------------------------------------------------------------------
| URL:            /api/v1/user
| Method:         PUT
| Description:    Updates the authenticated user's profile
*/
public function putUpdateUser(EditUserRequest $request){
    $user = Auth::user();

    $realName = $request->get('real_name');
    $interests = $request->get('interests');
    $profileVisibility = $request->get('profile_visibility');
    $location = $request->get('location');
    $favouriteGames = $request->get('favourite_games');

    /*
        Ensure the user has entered a real name
    */
    if( $realName != '' ){
        $user->real_name    = $realName;
    }

    /*
        Ensure the user has entered some interests
    */
    if( $interests != '' ){
        $user->interests       = $interests;
    }

    /*
        Ensure the user has submitted a profile visibility update
    */
    if( $profileVisibility != '' ){
        $user->profile_visibility = $profileVisibility;
    }

    /*
        Ensure the user has entered something for location
    */
    if( $location != '' ){
        $user->location   = $location;
    }

    /*
        Ensure the user has entered something for favourite games
    */
    if( $favouriteGames  != '' ){
        $user->favourite_games  = $favouriteGames ;
    }

    $user->save();

    /*
        Return a response that the user was updated successfully.
    */
    return response()->json( ['user_updated' => true], 201 );
}
}
