<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

use App\Http\Resources\TaskCollection;

class TaskController extends Controller
{
    // public function index(Request $request){
    //     return response()->json(Task::all());
    // }

    public function index(Request $request){
        // dd(Task::all());
        return new TaskCollection(Task::all());
    }
}
