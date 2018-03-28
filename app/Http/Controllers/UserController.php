<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UsersRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::withTrashed()->get();
        return view('users.list')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create')->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($validator = $this->validateUser($request)) return redirect()->route('users.create')->withErrors($validator);

        // gets array with 1 element: 'roles' => [array of selected roles]
        // or gets empty array (if no role is selected)
        $roles_data = request()->only('roles');

        $data = request()->except(['_token', 'roles']);
        $data['password'] = bcrypt($request->password);
        $user = new User($data);

        $user->save();

        $this->updateUserRoles($user->id, $roles_data);


        request()->session()->flash(
            'message', 'Uspešno kreiran profil.'
        );


        return redirect()->route('users.show', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::withTrashed()->with('usersRoles.role')->where('id', $id)->first();
        //$user_roles = UsersRole::where('user_id', $id)->get(['role_id']);

        //$roles = Role::where('id', $user_roles->role_id);

        // TODO: get names of roles and send them to view (along with user data)


        return view('users.show')->with('users', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->with('usersRoles.role')->first();
        $roles = Role::all();
        return view('users.edit')->with('users', $user)->with('roles', $roles);
    }

    public function validateUser(Request $request, $user=false){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users' . ($user ? ',email,' . $user : ''),
            'password' => ($user ? '' : 'required|') . 'min:8|confirmed',
        ],
            [
                'required' => 'Polje ne sme ostati prazno!',
                'max' => 'Maksimalna dolžina je največ 255 znakov!',
                'min'  => 'Minimalna dolžina je vsaj 8 znakov!',
                'unique' => 'Elektronski naslov že obstaja v naši bazi!',
                'confirmed'  => 'Geslo se ne ujema s potrditvijo!',
                'email' => 'Elektronski naslov je napačne oblike!',
            ]);
        if ($validator->fails()) {
            return $validator;
        }

        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($validator = $this->validateUser($request, $id)){
            return redirect()->route('users.edit', $id)->withErrors($validator);
        }
        $roles_data = request()->only('roles');

        $data = request()->except(['_token', 'roles', 'password']);
        $user = User::where('id', $id)->update($data);

        $this->updateUserRoles($id, $roles_data);
        return redirect()->route('users.show', $id);
    }

    /**
     * Update user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passwordUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
        ],
            [
                'required' => 'Polje ne sme ostati prazno!',
                'min'  => 'Minimalna dolžina je vsaj 8 znakov!',
                'confirmed'  => 'Geslo se ne ujema s potrditvijo!',
            ]);
        if ($validator->fails()) {
//            return dd($validator);
            return redirect()->route('users.edit', $id)->withErrors($validator);
        }
        $user = User::where('id', $id)->first();
        if (Hash::check($request->old_password, $user->password))
        {
            $user['password'] = bcrypt($request->password);
            $user->update();
            return redirect()->route('users.show', $id);
        }
        else{
            return redirect()->route('users.edit', $id)->withErrors(['old_password'=>'Vpisano trenutno geslo se ne ujema s tistim v bazi.']);
        }
        return redirect()->route('users.show', $id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('users.list');
    }

    private function updateUserRoles($id, $roles_data)
    {
        if (array_key_exists('roles', $roles_data)) {
            $roles_data = $roles_data['roles'];
        } else {
            $roles_data = [];
        }
        $user = User::where('id', $id)->with('usersRoles')->first();
        foreach ($user->usersRoles as $role){
            $role_id = $role->role_id;
            if(in_array($role_id, $roles_data)){
                $roles_data = array_diff( $roles_data, [$role_id] );
            } else {
                $role->delete();
            }
        }

        foreach ($roles_data as $role_id){
            $user->usersRoles()->create( [ 'role_id' => $role_id ] );
        }
    }
}
