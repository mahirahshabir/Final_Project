<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFieldValue extends Model
{
    /** @use HasFactory<\Database\Factories\CustomFieldValueFactory> */
    use HasFactory;
    use HasFactory;
    protected $fillable = ['custom_field_id', 'model_id', 'model_type', 'value'];

}

