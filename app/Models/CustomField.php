<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    /** @use HasFactory<\Database\Factories\CustomFieldFactory> */
    use HasFactory;
    protected $fillable = ['name', 'field_type', 'options'];
    protected $casts = ['options' => 'array'];

}
