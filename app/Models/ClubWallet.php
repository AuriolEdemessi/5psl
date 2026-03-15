<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'network',
        'address',
        'recovery_phrase',
        'private_key',
        'notes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'recovery_phrase',
        'private_key',
    ];
}
