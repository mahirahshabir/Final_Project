<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;
     use HasFactory;
    protected $fillable = ['name', 'description', 'status', 'manager_id'];
    public function manager() {
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
