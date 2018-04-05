<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Card;
use App\Models\Column;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->except('_token');
        $card = new Card($data);
        $card->save();
        request()->session()->flash(
            'message', 'Uspešno kreirana kartica.'
        );

        return redirect()->route('cards.show', $card);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Board $board = null, Column $column = null)
    {
        $data = ['card' => null, 'column' => $column, 'board' => $board];
        if($id != 0){
            $data['card'] = Card::findOrFail($id);
            if(!isset($board)) $data['board'] = $data['card']->board()->first();
            if(!isset($column)) $data['column'] = $data['card']->column()->first();
            $data['moves'] = $data['card']->moves()->with('old_column', 'new_column')->get();
            $data['WipViolations'] = $data['card']->wipViolations()->with('old_column', 'new_column')->get();
            //dd($data);
        } else if(! isset($column)) {
            $data['column'] = $data['board']->columns();
            if(Auth::user()->isPO()){
                $column = $data['column']->where('parent_id', null)->where('left_id', null)->with('leftChild')->orderBy('order')->first();
                $data['column'] = $this->getLowestLeftColumn($column);
                if(! isset($data['column'])){
                    return view('cards.error')->with(['error' => 'Tabela je brez stolpcev! Najprej dodajte stolpce!']);
                }
            } else {
                $data['column'] = $data['column']->where('high_priority', true)->first();
                if(! isset($data['column'])){
                    return view('cards.error')->with(['error' => 'Tabela je brez high priority stolpca! Zato dodajanje kartic ni mogoče za Kanban Masterja.']);
                }
            }
        }
        $data['projects'] = $data['board']->projects()->get();

        $data['users'] = User::
            join('users_groups', 'users_groups.user_id', '=', 'users.id')
            ->join('groups', 'users_groups.group_id', '=', 'groups.id')
            ->join('projects', 'projects.group_id', '=', 'groups.id')
            ->join('boards', 'projects.board_id', '=', 'boards.id')
            ->where('boards.id', $data['board']->id)
            ->where('projects.deleted_at', null)
            ->where('groups.deleted_at', null)
            ->where('boards.deleted_at', null)
            ->where('users_groups.deleted_at', null)
            //->groupBy('users.id')
            ->select('users.*', 'projects.deactivated')
            ->distinct()
            ->get();
            //->unique(['user_id', 'deactivated']);
        //dd($data);

        return view('cards.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $data = request()->except('_token');
        if(!isset($data['user_id']) || $data['user_id'] == 0) $data['user_id'] = null;
        if(!isset($data['deadline']) || $data['deadline'] == '') $data['deadline'] = null;
        if(!isset($data['estimation']) || $data['estimation'] == '') $data['estimation'] = 0;
        if(Auth::user()->isPo())
            $data['is_critical'] = (! (!isset($data['is_critical']) || $data['is_critical'] == '' || $data['is_critical'] == 'off'));
        $data['is_rejected'] = (! (!isset($data['is_rejected']) || $data['is_rejected'] == '' || $data['is_rejected'] == 'off'));
        if($id == 0){
            $maxOrder = Card::where('column_id', $data['column_id'])->orderBy('order','desc')->first();
            $data['order'] = $maxOrder ? $maxOrder->order + 1 : 1;
            //dd($data);
            $card = Card::create($data);
            checkWipViolation($card, "Dodajanje nove kartice");
        } else {
            $card = Card::where('id', $id)->update($data);
        }
        return $card;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        $card->delete();
        return redirect()->route('boards.list');
    }

    private function getLowestLeftColumn($column)
    {
        if(! $column || ! $column->leftChild) return $column;
        $column = $column->leftChild()->with('leftChild')->first();
        if(! $column || ! $column->leftChild)
            return $column;
        else
            return $this->getLowestLeftColumn($column);
    }
}
