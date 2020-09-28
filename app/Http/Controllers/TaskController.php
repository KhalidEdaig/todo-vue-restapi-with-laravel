<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Task::all()->jsonSerialize(),Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task=new Task();
        $task->title=$request->title;
        $task->priority=$request->priority;
        $task->save();
        return response($task->jsonSerialize(),Response::HTTP_CREATED);

    }

    public function update(Request $request,$id)
    {
        $task=Task::find($id);
        $task->title=$request->title;
        $task->priority=$request->priority;
        $task->update();
        return response($task->jsonSerialize(),Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if($task->delete()){
            return response(null,Response::HTTP_OK);
        }

    }
}
