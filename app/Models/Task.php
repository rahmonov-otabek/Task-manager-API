<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_done',
        'project_id',
        'scheduled_at',
        'due_at'
    ];

    protected $casts = [
        'is_done' => 'boolean',
    ];
 
    public function creator(){
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'creator_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scopeScheduledBetween(Builder $query, string $fromDate, string $toDate){
        $query->where('scheduled_at', '>=', $fromDate)->where('scheduled_at', '<=', $toDate);
    }

    public function scopeDueBetween(Builder $query, string $fromDate, string $toDate){
        $query->where('due_at', '>=', $fromDate)->where('due_at', '<=', $toDate);
    }
    
    public function scopeDue(Builder $query, string $filter)
    {
        if ($filter == 'today'){
            $query->where('due_at', '=', Carbon::today()->toDateString);
        } elseif ($filter == 'past'){
            $query->where('due_at', '<', Carbon::today()->toDateString);
        }
    }

    protected static function booted()
    {
        static::addGlobalScope('creator', function(Builder $builder){
            $builder->where('creator_id', Auth::id())
                ->orWhereIn('project_id', Auth::user()->memberships->pluck('id'));
        });
    }
}
