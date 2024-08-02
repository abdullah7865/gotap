<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_id',
        'status',
    ];

    /**
     * Get the user associated with the UserCard.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the card associated with the UserCard.
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
