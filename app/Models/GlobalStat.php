<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_aum',
        'current_nav',
        'total_shares',
        'total_fees_collected',
        'total_hwm_commissions',
    ];

    protected $casts = [
        'total_aum'             => 'string',
        'current_nav'           => 'string',
        'total_shares'          => 'string',
        'total_fees_collected'  => 'string',
        'total_hwm_commissions' => 'string',
    ];

    /**
     * Récupère l'unique ligne de stats globales (singleton).
     */
    public static function current(): self
    {
        return static::firstOrCreate([], [
            'total_aum'    => '0',
            'current_nav'  => '10.00000000',
            'total_shares' => '0',
        ]);
    }
}
