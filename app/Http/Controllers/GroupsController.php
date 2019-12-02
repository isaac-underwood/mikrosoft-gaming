<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\User;
use App\Group;
use Auth;
use App\Highscore;
use App\Traits\UploadTrait;

class GroupsController extends Controller
{
    use UploadTrait;
    /**
     * Display the the groups.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $groups = Group::paginate(15);
        return view('groups.index',[
            'groups' => $groups,
        ]);
    }
  /**
     * Show the form for creating a new highscore
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::user()->id)
                        ->where('group_id', 0)
                        ->orWhereNull('group_id')
                        ->orderBy('username')
                        ->get();
        return view('groups.create', compact('users'));
    }

    /**
     * Store a new highscore in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|unique:groups,name|min:2|max:191',
            'description' => 'required|string',
        ];
        //custom validation error messages
        $messages = [
            'name.unique' => 'Group title should be unique',
            'description.required' => 'A group description is required'
         ];
        //First Validate the form data
        $request->validate($rules,$messages);
        $group        = new Group;
        if ($request->has('group_image')) {
            // Get image file
            $image = $request->file('group_image');
            // Make a image name based on group name and current timestamp
            $name = str_slug($request->name).'_'.time();
            // Define folder path
            $folder = 'img/groups/';
            // Make a file path where image will be stored (folder path + file name + file extension)
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set game image path in database to filePath
            $group->image = $filePath;
        }
        
        $group->name = $request->name;
        $group->owner_id = Auth::user()->id;
        $group->description = $request->description;
        $group->save(); // save it to the database.
        Auth::user()->group_id = $group->id;
        Auth::user()->save();
        $userIDs = $request->userIDs;
        if ($userIDs != null)
        {
            foreach ($userIDs as $userID)
            {
                echo $userID;
                
                $user = User::findOrFail($userID);
                $user->group_id = $group->id;
                $user->save();
            }
        }
        
        //Redirect to a specified route with flash message.
        // return redirect()
        //     ->route('groups.create', $group->user_id);
            return redirect()
            ->route('groups.show', $group->id)
            ->with('status','Added new Group!');
    }
        /**
     * Asks highscores controller to store new highscore in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $user_id
     * @param int $group_id    
     * @param string $title
     * @param string $description
     * 
     */
    public function storeHighScore(Request $request, int $user_id, int $group_id)
    {
        HighscoresController::store($user_id, $group_id, $request->title, $request->description);
    }
/**
     * Asks highscores controller to store new highscore in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createGroup(Request $request)
    {
        $groupId = $request->groupId;
        return view('/groups.create', compact('groupId'));

    }
    /**
     * Display a specified group.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::findOrFail($id);
        $user_owner = User::where('id', '=', $group->owner_id)->first();
        $users = User::where('group_id', $id)->paginate(10);   
        return view('groups.show',compact('group', 'users', 'user_owner'));
    }
    /**
     * Show a form for editing a specified group.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Find a group by it's ID
        $group = Group::findOrFail($id);
        return view('groups.edit',[
            'group' => $group,
        ]);
    }

    /**
     * Show a page for adding more users to specified group
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addUsers($id)
    {
        $group = Group::findOrFail($id);
        $users = User::where('id', '!=', Auth::user()->id)
                        ->where('group_id', null)
                        ->orWhereNull('group_id')
                        ->orderBy('username')
                        ->get();
        return view('groups.users.add', compact('group', 'users'));
    }

    /**
     * Show a page for removing users from specified group
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showRemoveUsers($id)
    {
        $group = Group::findOrFail($id);
        $users = User::where('id', '!=', Auth::user()->id)
                        ->where('group_id', $group->id)
                        ->orderBy('username')
                        ->get();
        return view('groups.users.remove', compact('group', 'users'));
    }

    /**
     * Removes given users from the group
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function removeUsers(Request $request, $id)
    {
        $userIDs = $request->userIDs;
        $group = Group::find($id);

        if ($userIDs != null)
        {
            foreach ($userIDs as $userID)
            {
                $user = User::find($userID);
                $user->group_id = null;
                $user->save();
            }
            return redirect()
            ->route('groups.show', $group->id)
            ->with('status','Removed ' . count($userIDs) . ' users from ' . $group->name);
        }

        else
        {
            return redirect()
            ->route('groups.show', $group->id)
            ->with('status','No users were removed from the group.');
        }
    }

    public function updateUsers(Request $request, $id)
    {
        $userIDs = $request->userIDs;
        $group = Group::find($id);

        if ($userIDs != null)
        {
            foreach ($userIDs as $userID)
            {
                $user = User::find($userID);
                $user->group_id = $group->id;
                $user->save();
            }
            return redirect()
            ->route('groups.show', $group->id)
            ->with('status','Added ' . count($userIDs) . ' users to ' . $group->name);
        }

        else
        {
            return redirect()
            ->route('groups.show', $group->id)
            ->with('status','No new users were added to the group.');
        }
    }

    /**
     * Update a specified group from the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|min:2|max:191',
            'description' => 'required|string',
            'game_image' =>  'image|mimes:jpeg,png,jpg,gif|max:4096'
        ];
        //custom validation error messages
        $messages = [
            'name.unique' => 'Group title should be unique',
            'description.required' => 'A group description is required'
         ];
        //First Validate the form data
        $request->validate($rules,$messages);
        $group = Group::find($id);

        if ($request->has('group_image')) {
            // Get image file
            $image = $request->file('group_image');
            // Make a image name based on group name and current timestamp
            $name = str_slug($request->name).'_'.time();
            // Define folder path
            $folder = 'img/groups/';
            // Make a file path where image will be stored (folder path + file name + file extension)
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set game image path in database to filePath
            $group->image = $filePath;
        }
        
        $group->name = $request->name;
        $group->description = $request->description;
        $group->save(); // save it to the database.
        //Redirect to a specified route with flash message.
        return redirect()
            ->route('groups.show', $id)
            ->with('status','Successfully updated ' . $group->name);
    }
    /**
     * Remove the specified group from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete the group
        $group = Group::findOrFail($id);
        $group->delete();
        // group::destroy([id]) is also avaliable
        //Redirect to a specified route with flash message.
        return redirect()
            ->route('groups.index')
            ->with('status','Deleted the selected group!');
    }

    public function removeUser(Request $request){
        $user = User::find(Auth::user()->id);
        $group = Group::find($user->group_id);

        //Check if user leaving the group is the owner, if so choose a new owner
        if ($group->owner_id)
        {
            if ($group->owner_id == $user->id)
            {
                if ($group->users->count() > 1) //Check if there are users other than current owner
                {
                    $new_owner = $group->users->where('owner_id', '!=', $user->id)->first(); //Get first user to be owner
                    $group->owner_id = $new_owner->id;
                }
                else
                {
                    $group->owner_id = null; //No users left in group, set owner id to 0
                }
                $group->save();
            }
        }
            
        $user->group_id = null;
        $user->save();
        $groups = Group::all();
        return redirect()
            ->route('groups.index', compact('groups'))
            ->with('status','You removed yourself from the group.');
    }
}
