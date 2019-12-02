<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Ban;
use App\BanRequest;
use App\Notifications\ConfirmBan;

class UserBanController extends Controller
{
    /**
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user_to_ban = $request->userId;
        return view('/bans/request', compact('user_to_ban'));
    }

    /**
     * Show the form for requesting to ban a user
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id_to_ban = $request->userId;
        $user_to_be_banned = User::find($user_id_to_ban); //find username of user to be banned
        return view('bans.request', compact('user_id_to_ban', 'user_to_be_banned'));
    }

    /**
     * Determine which action to take based off POST
     *
     * @param Illuminate\Http\Request $request
     * 
     */
    public function checkRequest(Request $request)
    {
        if ($request->has('submitBanRequest'))
        {
            $this->store($request);
        }
        else if ($request->has('userId'))
        {
            $this->create($request);
        }
    }
        /**
     * Store a ban in the database
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $gameId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation rules
        $reason = $request->reason;
        $rules = [
            'reason' => 'bail|required|min:5|max:191',
        ];
        //custom validation error messages
        $messages = [
            'reason.required' => 'You must enter a reason for the ban.',
            'reason.min' => 'You must enter a ban reason that is sufficiently long enough.',
        ];
        //First Validate the form data
        $request->validate($rules,$messages);
        //Create a new ban request
        $ban_request = new BanRequest;
        $ban_request->ban_user_id = $request->user_id_to_ban;
        $ban_request->requested_by_user_id = Auth::user()->id;
        $ban_request->reason = $reason;
        $ban_request->save(); // save it to the database.
        //Redirect to a specified route with flash message.
        $test = $this->checkBanRequests($request->user_id_to_ban);
        return redirect()
            ->route('pages.index')
            ->with('status','Thank you, your ban request has been submitted.');
    }

    /**
     * Checks and returns the amount of ban requests on a user within the past one month
     * @param int $id
     * @return int
     */
    public function checkBanRequests(int $id)
    {
        $ban_request_amount = BanRequest::where('ban_user_id', $id)->where('created_at', '>', now()->subDays(30))->count();
        if ($ban_request_amount >= 2)
        {
            $this->createBan($id);
        }
        return $ban_request_amount;
    }

    /**
     * Stores a new ban in the bans table
     * @param int $id
     */
    public function createBan(int $id)
    {
        $ban = new Ban;
        $ban->user_id = $id;

        //Check if user has been banned before
        $banned_before = Ban::where('user_id', $id)->count();
        if ($banned_before >= 1) //Next ban is 'permanent'
        {
            $ban->banned_until = now()->addDays(3650);
        }
        else //User's first ban, ban for 1 week
        {
            $ban->banned_until = now()->addDays(7);
        }

        //Add ban to database
        $ban->save();
    }
}
