<?php

namespace App\Http\Controllers;
use App\Models\Project;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('projects.list')->with('projects', $projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if($validator = $this->validateProject($request)) return redirect()->route('projects.create')->withErrors($validator);


        $data = request()->except(['_token', 'roles']);
        $data["lane_number"] = 0;
        $project = new Project($data);
        
        $project->save();
        return $project;//redirect()->route('projects.show', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::withTrashed()->where('id', $id)->first();        
        return view('projects.show')->with('projects', $project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $project = Project::where('id', $id)->first();
        return view('projects.edit')->with('projects', $project);
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
        //
        $data = request()->except(['_token', 'roles']);
        $project = Project::where('id', $id)->update($data);
        return $project; //redirect()->route('projects.show', $id);
    }


    public function validateProject(Request $request){
        $validator = Validator::make($request->all(), [
            'board_name' => 'required|max:255',
            'description' => 'required|max:255',
            'buyer_name' => 'required|max:255',
            'start_date' => 'required|date|before_or_equal:today',
            'end_date' => 'required|date|after:start_date',


        ],
            [
                'required' => 'Polje ne sme ostati prazno!',
                'max' => 'Maksimalna dolžina je največ 255 znakov!',
                'date'  => 'Vpišite datum v obliki dd.mm.llll',
                'before_or_equal' => "Projekt se lahko začne najkasneje z današnjim dnem!",
                'after'=> "Datum konca projekta mora biti kasnejši od datuma začetka!"
                
            ]);
        if ($validator->fails()) {
            return $validator;
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Project::where('id', $id)->delete();
        return redirect()->route('projects.list');
    }
}
