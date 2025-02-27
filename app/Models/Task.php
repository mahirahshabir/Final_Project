<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
     use HasFactory;
    protected $fillable = ['name', 'description', 'project_id', 'deadline'];
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
}
