<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Http\Requests\StoreTaskRequest;

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

    public function store(StoreTaskRequest $request)
    {
        // $validated = $request->validate([
        //     'title'=>'required|max:255',
        // ]);

        $validated = $request->validated();

        $task = Task::create($validated);

        return new TaskResource($task);
    }
}
