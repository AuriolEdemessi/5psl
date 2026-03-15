<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavHistory extends Model
{
    use HasFactory;

    protected $table = 'nav_history';

    protected $fillable = [
        'nav_value',
        'total_aum',
        'total_shares',
        'club_drawdown_pct',
        'event',
        'notes',
    ];

    protected $casts = [
        'nav_value'         => 'string',
        'total_aum'         => 'string',
        'total_shares'      => 'string',
        'club_drawdown_pct' => 'string',
    ];

    /**
     * NAV la plus haute jamais atteinte par le club.
     */
    public static function allTimeHighNAV(): string
    {
        return static::max('nav_value') ?? '10.00000000';
    }
}
