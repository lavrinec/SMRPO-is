<?php

namespace App\Http\Controllers;

use App\Models\UsersGroupsRoles;
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
        $currentUsersGroupsRoles = array();
        //$users = collect();
        //$role = $user->usersRoles;
        return view('groups.create')->with('usersgroup', $usersgroup)->with('users', $users)->with('roles', $roles)->with('currentUsersGroupsRoles', $currentUsersGroupsRoles);
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
        $users = request()->only('users');
        $data = request()->only(['group_name', 'description']);
        $usersgroups = (json_decode($request->usersgroups));

        //dd($usersgroups);

        $validGroup = $this->checkRoles($usersgroups);
        $newUsersGroups = $usersgroups->users;
        if ($validGroup) {
            $group = new Group($data);
            $group->save();
            $this->updateUsersGroup($group->id, $usersgroups);
        } else {
            //return error
            throw ValidationException::withMessages([
                "invalidGroup" => ["V skupini mora biti natanko en product owner in kanban master ter eden ali več razvijalcev"],
            ]);
        }
        if ($validator = $this->validateGroup($request)) return redirect()->route('groups.create')->withErrors($validator);

        if (json_last_error() > 0 || $usersgroups == null) {
            throw ValidationException::withMessages([
                "invalidJSON" => ["Očitno je prišlo do napake pri prenosu podatkov iz brskalnika v zaledje."]
            ]);
        }


        request()->session()->flash(
            'message', 'Uspešno kreirana skupina.'
        );


        return redirect()->route('groups.show', $group->id);
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
        /*
         * Potrebna struktura za prikaz uporabnikov in izbranih vlog
         * {
         *      users:
         *          {
         *              user_id:
         *                      {
         *                          id: string,
         *                          roles: {
         *                                      _role_id_: string
         *                                  }
         *
         *          }
         * }
         * */
        //dd(json_encode($testObjectCreation));

        $groups = Group::where('id', $id)->first();
        $users = User::all();
        $roles = Role::all();
        $testGroups = (UsersGroup::where("group_id", $id)->with('role')->get());
        $theArray = array();
        $objectToSendInJson = $this-> generateUsersGroupsRolesStructureForClient($testGroups, $id); //$objectToSend;//json_encode($objectToSend);






        //$this->updateUsersGroup($id, json_decode(json_encode($objectToSend)));
        return view('groups.edit')->with('groups', $groups)->with('users', $users)->with('currentUsersGroupsRoles', $objectToSendInJson)->with('roles', $roles);
    }

    private function generateUsersGroupsRolesStructureForClient ($users_group, $group_id){
        $objectToSend = array();
        $currentUsersGroupsRoles = array();
        $index = 0;
        $someotherarray = array();
        foreach ($users_group as $groupie) {
            //here we get UsersGroups
            $someotherarray[$index] = "User id : " . $groupie->user_id;
            $theUser = array();
            $theUser['id'] = $groupie->user_id;
            $userRoles = array();
            foreach ($groupie->role as $role) {
                //Here we get UsersGroupsRoles
                //$theArray[$role->role_id] = "group id is: " . $role->role_id;
                $userRoles[$role->role_id] = $role->role_id;
            }
            $theUser['roles'] = $userRoles;
            $currentUsersGroupsRoles[$groupie->user_id] = $theUser;
            $index++;
        }
        $objectToSend['users'] = $currentUsersGroupsRoles;
        return $objectToSend;
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
        $usersgroups = (json_decode($request->usersgroups));
        if ($validator = $this->validateGroup($request, $id)) {
            return redirect()->route('groups.edit', $id)->withErrors($validator);
        }

        if(!$this->checkRoles($usersgroups)){
            throw ValidationException::withMessages([
                "invalidGroup" => ["V skupini mora biti natanko en product owner in kanban master ter eden ali več razvijalcev. Vsak član mora imeti tudi svojo vlogo."],
            ]);
        }
        $data = request()->only(['group_name', 'description']);
        $users = request()->only('users');
        $group = Group::where('id', $id)->update($data);
        $this->updateUsersGroup($id, $usersgroups);
        $updatedUsersGroupsRoles = (UsersGroup::where("group_id", $id)->with('role')->get());//for future use if we need to show roles cards on show.page
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


    private function checkRoles($request)
    {
        //count the roles checked in request, allow only roles if user is checked above them, check group validity
        $roles = [];
        $developers = 0;
        $owner = 0;
        $k_m = 0;


        if ($request == null || $request == [] || $request == array()) {
            throw ValidationException::withMessages([
                "noUsersSelected" => ["Skupine ne morete ustvariti brez uporabnikov in pripadajočih vlog."],
            ]);
        }

        //roles: 1:admin, 2:product owner, 3:kanban master, 4:developer
        if ($request->users == null) {
            throw ValidationException::withMessages([
                "noUsersSelected" => ["Skupine ne morete ustvariti brez uporabnikov in pripadajočih vlog."],
            ]);
        }
        $users = $request->users;
        foreach ($users as $key => $value) {
            //key = userid
            //value = object => id-> userid , roles->object
            if (!(property_exists($users->{$key}, "roles"))) {
                throw ValidationException::withMessages([
                    "noRolesSelected" => ["Za vsakega uporabnika morate izbrati vlogo v skupini."]
                ]);
            }
            $userHasOneRole = false;
            foreach ($users->{$key}->roles as $key => $value) {
                $userHasOneRole = true;
                switch ($value) {
                    case 4:
                        $developers++;
                        break;
                    case 3:
                        $k_m++;
                        break;
                    case 2:
                        $owner++;
                        break;
                }
            }
            if(!$userHasOneRole){
                throw ValidationException::withMessages([
                    "noRolesSelected" => ["Za vsakega uporabnika morate izbrati vlogo v skupini."]
                ]);
            }
        }


        $correctGroup = $owner === 1 && $k_m === 1 && $developers >= 1;

        return $correctGroup;

    }


    private function createArrayOfIds($rolesObject)
    {
        $arrayToReturn = array();

        foreach ($rolesObject as $key => $value) {
            array_push($arrayToReturn, (int)$value);
        }

        return $arrayToReturn;
    }

    private function createIdsFromRecord($record, $fieldName){
        $ids = array();
        foreach($record as $role){
            array_push($ids, $role->{$fieldName});
        }
        return $ids;
    }

    private function deleteRecordFromDb($dbRoles, $frontendRoles, $fieldToCompare , $deleteSubType = false, $subType= '')
    {
        foreach($dbRoles as &$role){
            if(!in_array($role->{$fieldToCompare}, $frontendRoles)){
                if($deleteSubType){
                    UsersGroupsRoles::where('users_group_id',$role->id)->delete();
                }
                $role->delete();
            }
        }
    }




    private function insertRoles($dbRoles, $frontendRoles, $users_group){
        foreach($frontendRoles as $role_id){
            if(!in_array($role_id,$dbRoles)){
                $newRole = new UsersGroupsRoles();
                $newRole->users_group_id = (int) $users_group;
                $newRole->role_id = (int) $role_id;
                $newRole->save();
            }
        }
    }

    private function createUsersIdsArray($usersObject){
        $usersIds = array();
        foreach($usersObject as $key=>$value){
            array_push($usersIds, (int)$value->id);
        }
        return $usersIds;
    }


    private function updateUsersGroup($group_id, $users_data)
    {
        /*
         * New code which is dependant of JSON structure - object
         *
         * IMPROTANT -> if you create new object from model, then you have to save the object before you get
         * .. id of an object!!!!! --- just like salesforce!
         * */

        /*
         * If there are no user groups we get
         * Collection { #items : [] }
         * */

        $usersGroupsRolesPerGroup = UsersGroup::where("group_id", $group_id)->with('usersGroupsRoles');

        if (property_exists($users_data, "users")) {
            $users_data = $users_data->users;
        } else {
            throw ValidationException::withMessages([
                "noUsersSelected" => ["Skupine ne morete ustvariti brez uporabnikov in pripadajočih vlog."],
            ]);
        }
        $currentUsersGroup = $this->createUsersIdsArray($users_data);
        foreach ($users_data as $key => $value) {
            //key=userid
            //value = object => id:userid, roles: {}

            $newUserGroup = UsersGroup::where('user_id', (int)$value->id)->where('group_id', $group_id)->with('role')->get();
            $roleOfCurrentUserGroup = $this->createArrayOfIds($value->roles);
            $allUsersGroup = UsersGroup::where('group_id', (int) $group_id)->with('role')->get();
            $this->deleteRecordFromDb($allUsersGroup,$currentUsersGroup,"user_id", true, 'role');

            if($newUserGroup->first() != null){
                //go into update phase
                foreach ($newUserGroup as $userGroup) {
                    $roleIdsFromDb = $this->createIdsFromRecord($userGroup->role, 'role_id');
                    $this->deleteRecordFromDb($userGroup->role, $roleOfCurrentUserGroup, 'role_id');
                    $this->insertRoles($roleIdsFromDb, $roleOfCurrentUserGroup, $userGroup->id );
                }
            }
            else{
                //go into create phase
                $newUserGroup = new UsersGroup();
                $newUserGroup->user_id = (int)$value->id;
                $newUserGroup->group_id = $group_id;
                $newUserGroup->is_active = 1;
                $newUserGroup->save();
                foreach ($users_data->{$key}->roles as $key => $value) {
                    $newUsersGroupsRole = new UsersGroupsRoles();
                    $newUsersGroupsRole->users_group_id = $newUserGroup->id;
                    $newUsersGroupsRole->role_id = (int)$value;
                    $newUsersGroupsRole->save();
                }
            }

        }

    }

    private function checkDifferenceInRoles($frontEndRoles, $databaseRoles)
    {
        //get roles that need to be deleted --> one array
        // get roles that need to be inserted --> second array
        $usersGroupsRolesToDelete = array();
        $usersGroupsRolesToInsert = array();
        dd($databaseRoles);
        foreach ($frontEndRoles as $key => $value) {
            foreach ($databaseRoles as $key => $value) {
                //value == usersGroup
                dd($value);
            }
        }

    }

    public function getUsersGroupInitialData(Request $request)
    {
        /*
         * Parameters are actually stored in $request --- retireve them by using following notatiton:
         * $request->_____name_of_the_parameter_set_in_dataAttribute_in_ajax_call_____
         * */
        $group_id = $request->group_id;
        $users = User::all();
        $roles = Role::all();
        $usersGroups = UsersGroup::where('group_id', $group_id)->get();

        return array(
            'users' => $users,
            'usersGroups' => $usersGroups,
            'roles' => $roles,
            'currentUsersGroups' => array()
        );

    }


}
