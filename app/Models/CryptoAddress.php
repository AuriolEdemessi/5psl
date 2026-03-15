<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'coin',
        'network',
        'address',
        'label',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope : actives uniquement.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Retourne les adresses actives groupées par coin.
     */
    public static function activeGroupedByCoin(): array
    {
        return static::active()
            ->orderBy('coin')
            ->orderBy('network')
            ->get()
            ->groupBy('coin')
            ->toArray();
    }
}
