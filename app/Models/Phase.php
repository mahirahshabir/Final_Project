<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    /** @use HasFactory<\Database\Factories\PhaseFactory> */
    use HasFactory;
    protected $fillable = ['name', 'project_id', 'ordering']; // Removed 'status', added 'ordering'
    public function project() {
        return $this->belongsTo(Project::class);
    }
    // Define many-to-many relationship with Task
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_phase')->withTimestamps();
    }
}
