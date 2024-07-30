<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'icon', 'pro', 'category_id', 'status', 'placeholder_en',
        'placeholder_sv', 'description_en', 'description_sv',
        'baseURL', 'input'
    ];
}
