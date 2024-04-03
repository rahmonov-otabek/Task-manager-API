<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{

    public function index(Request $request)
    { 
        return new TaskCollection(Task::all());
    }

    public function show(Request $request, Task $task)
    { 
        return new TaskResource($task);
    }
}
