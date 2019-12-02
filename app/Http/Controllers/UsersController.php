<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EditUserRequest;

class UsersController extends Controller
{

    //Updates a User's profile
    public function putUpdateUser(EditUserRequest $request)
    {
        $user = Auth::user();

        $favoriteCoffee       = $request->get('favorite_coffee');

        /*
            Ensure the user has entered a favorite coffee
        */
        if( $favoriteCoffee != '' ){
            $user->favorite_coffee    = $favoriteCoffee;
        }

        $user->save();

        /*
            Return a response that the user was updated successfully.
        */
        return response()->json( ['user_updated' => true], 201 );
    }
}