<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TaskController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request $request
     * @return array|\Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->except('_token', 'id');
        $id = $request->id;
        if(empty($data['estimation'])){
            $data['estimation'] = 0;
        }
        //dd($data);
        if($id == 0){
            $data["is_finished"] = false;
            $order = Task::where('card_id', $data['card_id'])->orderBy('order', 'desc')->first();
            if(!isset($order)){
                $order = 1;
            } else {
                $order = $order->order + 1;
            }
            $data["order"] = $order;
            $task = Task::create($data);
        } else {
            $task = Task::where('id', $id)->first();
            $task->update($data);
        }
        $return = [
          'task' => $task,
           'taskHtml' => View::make('tasks.td')->with('task',$task)->render()
        ];

        return $return;
    }

}
