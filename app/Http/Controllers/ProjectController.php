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
        $project->start_date = date("Y-m-d", strtotime($project->start_date));
        $project->end_date = date("Y-m-d", strtotime($project->end_date));
       
        
        $project->save();
        return redirect()->route('projects.show', $project->id);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = request()->except(['_token']);
        $startRequired = true;
        if($this->areThereCards($project)){
            unset($data['start_date']);
            $startRequired = false;
        } else $data['start_date'] = date("Y-m-d", strtotime($data['start_date']));
        $data['end_date'] = date("Y-m-d", strtotime($data['end_date']));
        $project->update($data);
        return redirect()->route('projects.show', $project->id);
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
        $hasCards = $this->areThereCards($project);
        return view('projects.edit')->with('projects', $project)->with('hasCards', $hasCards);
    }


    public function validateProject(Request $request, $startRequired = true){
        $validator = Validator::make($request->all(), [
            'board_name' => 'required|max:255',
            'description' => 'required|max:255',
            'buyer_name' => 'required|max:255',
            'start_date' => ($startRequired ? 'required|' : '') . 'date|before_or_equal:today',
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
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if($this->areThereCards($project)){
            return redirect()->back()->withErrors(['msg' => 'Izbris ni mogoč. Najprej izbrišite kartice v projektu!']);
        }
        $project->delete();
        return redirect()->route('projects.list');
    }

    private function areThereCards(Project $project){
        $board = $project->board()->first();
        if(!empty($board) && $board->cards()->count() > 0){
            return true;
        }
        return false;
    }
}
