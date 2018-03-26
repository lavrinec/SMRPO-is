<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
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
        $users = User::all();
        return view('users.list')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ],
            [
                'required' => 'Polje ne sme ostati prazno!',
                'max' => 'Elektronski naslov je lahko dolg največ 255 znakov!',
                'min'  => 'Geslo mora biti dolgo vsaj 8 znakov!',
                'unique' => 'Elektronski naslov že obstaja v naši bazi!',
                'confirmed'  => 'Geslo se ne ujema s potrditvijo!',
                'email' => 'Elektronski naslov je napačne oblike!',
            ]);
        if ($validator->fails()) {
            return view('users.create')->withErrors($validator);
        }
//        $data = $request->toArray();
        $data = request()->except('_token');
        $data['password'] = bcrypt($request->password);
        $user = new User($data);
        $user->save();
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
        $user = User::where('id', $id)->first();
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
        $user = User::where('id', $id)->first();
        return view('users.edit')->with('users', $user);
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

        $data = $request->toArray();
        if(isset($data['password']))
            $data['password'] = bcrypt($request->password);
        User::where('id', $id)->update($data);
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
}
