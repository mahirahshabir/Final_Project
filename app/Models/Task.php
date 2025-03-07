<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
     use HasFactory;
    protected $fillable = ['name', 'description','deadline', 'project_id', ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'task_user')->withPivot('created_by');
    }

     // Define many-to-many relationship with Phase
    public function phases()
    {
        return $this->belongsToMany(Phase::class, 'task_phase')->withTimestamps();
    }

    public function assignee()
{
    return $this->belongsTo(User::class, 'assignee_id');
}

// Relationship with Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
