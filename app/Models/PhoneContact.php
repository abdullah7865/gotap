<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'photo',
        'work_email',
        'company_name',
        'job_title',
        'address',
        'phone',
        'work_phone',
        'website',
    ];
}
