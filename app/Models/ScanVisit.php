<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'visiting_id',
        'visited_id',
    ];

    /**
     * Get the user who visited.
     */
    public function visitor()
    {
        return $this->belongsTo(User::class, 'visiting_id');
    }

    /**
     * Get the user who was visited.
     */
    public function visited()
    {
        return $this->belongsTo(User::class, 'visited_id');
    }
}
