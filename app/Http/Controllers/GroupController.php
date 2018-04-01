<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Group;
use App\Models\UsersGroup;
use App\Models\UsersRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $groups = Group::withTrashed()->get();
        return view('groups.list')->with('groups', $groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $usersgroup = UsersGroup::all();
        $users = User::all();
        $roles = Role::all();
        
        //$users = collect();
        //$role = $user->usersRoles;
        return view('groups.create')->with('usersgroup', $usersgroup)->with('users', $users)->with('roles',$roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        /*
            This is where we put code to insert data of groups...
        */
        if ($validator = $this->validateGroup($request)) return redirect()->route('groups.create')->withErrors($validator);

        // gets array with 1 element: 'roles' => [array of selected roles]
        // or gets empty array (if no role is selected)


        //we get all selected users from create group mask;
        $users = request()->only('users');
    


        //$data = request()->except(['_token', 'roles']);
        $data = request()->only(['group_name', 'description']);

        //save if group is valid, otherwise return error
        $validGroup = $this->checkRoles($request);
        if ($validGroup){
            $group = new Group($data);
            $group->save();
            $this->updateUsersGroup($group->id, $users);
        }else{
            //return error
            throw ValidationException::withMessages([
                "invalidGroup" => ["V skupini mora biti natanko en product owner in kanban master ter eden ali več razvijalcev"],
            ]);
        }
       

        //$this->updateUserRoles($user->id, $roles_data);


        request()->session()->flash(
            'message', 'Uspešno kreirana skupina.'
        );

        
        return  redirect()->route('groups.show', $group->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $groups = Group::withTrashed()->where('id', $id)->first();
        $users = Group::find(1)->users()->get();
        /*return view('groups.show', [
            "groups"=>$groups, "users"=>$users
        ]);*/
        return view('groups.show')->with('groups', $groups)->with('users', $users);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $groups = Group::where('id', $id)->first();
        $users = User::all();
        return view('groups.edit')->with('groups', $groups)->with('users', $users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Group $group
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        //
        if ($validator = $this->validateGroup($request, $id)) {
            return redirect()->route('groups.edit', $id)->withErrors($validator);
        }
        $data = request()->only(['group_name', 'description']);
        $users = request()->only('users');
        $group = Group::where('id', $id)->update($data);
        $this->updateUsersGroup($id, $users);
        return redirect()->route('groups.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $group = Group::where('id', $id);
        if ($group->first() != null) {
            $group->delete();
        } else {
            return redirect()->route('groups.show')->withErrors(['someError' => 'yes']);
        }
        return redirect()->route('groups.list');
    }

    public function validateGroup(Request $request, $group = false)
    {
        $validator = Validator::make($request->all(), [
            'group_name' => 'required|max:255',
            'description' => 'max:255'
        ],
            [
                'required' => 'Polje ne sme ostati prazno!',
                'max' => 'Maksimalna dolžina je največ 255 znakov!'
            ]);
        if ($validator->fails()) {
            return $validator;
        }

        return false;
    }


    private function checkRoles($request){
            //count the roles checked in request, allow only roles if user is checked above them, check group validity
            $roles = [];
            $developers = 0;
            $owner = 0;
            $k_m = 0;
            
            //roles: 1:admin, 2:product owner, 3:kanban master, 4:developer
            if($request->users == null){
                throw ValidationException::withMessages([
                    "noUsersSelected" => ["Skupine ne morete ustvariti brez uporabnikov in pripadajočih vlog."],
                ]);
            }
            foreach($request->users as $user) {
                $roles[$user] = $request ->$user;
                $array = $request ->$user;
                foreach ((array)$array as $role){
                    switch($role){
                        case 4:$developers++;
                        break;
                        case 3:$k_m++;
                        break;
                        case 2:$owner++;
                        break;
                        //default vrni napako
                    }
                 }
            }
            
            $correctGroup = $owner===1 && $k_m===1 && $developers>=1;

            return $correctGroup;

    }



    private function updateUsersGroup($group_id, $users_data)
    {
        if (array_key_exists('users', $users_data)) {
            /*
             * We extract/get users object from collection so that we do not have to ...
             * ... always search through properties.
             * */
            $users_data = $users_data['users'];
        } else {
            $users_data = [];
        }
        $group = Group::where('id', $group_id)->with('usersGroups')->first();
        foreach ($group->usersGroups as $userGroup) {
            $user_id = $userGroup->id;
            if (in_array($user_id, $users_data)) {
                $users_data = array_diff($users_data, [$user_id]);
            } else {
                $userGroup->delete();
            }
        }
        foreach ($users_data as $user_id) {
            $group->usersGroups()->create(['user_id' => $user_id, 'is_active' => 1]);
        }

    }

    public function getUsersGroupInitialData(Request $request){
        $users = User::all();
        $roles = Role::all();
        $usersGroups = array();
        /*if($group_id != null){
            $usersGroups = UsersGroup::all();
        }*/
        return view('groups.usersgroup')->with('users', $users)->with('roles', $roles)->with('usersGroups', $usersGroups);

    }



}
