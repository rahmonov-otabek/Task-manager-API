<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class CommentController extends Controller
{
    public function __construct()
    {
        Route::bind('task', function($value){
            return Task::findorFail($value);
        });

        Route::bind('project', function($value){
            return Project::findorFail($value);
        }); 
    }

    public function index(Request $request, Project|Task $model)
    { 
        $comments = $model->comments()->orderByDesc('created_at')->paginate();

        return new CommentCollection($comments);
    }

    public function store(StoreCommentRequest $request, Project|Task $model)
    {
        $validated = $request->validated();

        $comment = $model->comments()->make($validated);

        $comment->user()->associate(Auth::user());

        $comment->save();

        return new CommentResource($comment);
    }
}
