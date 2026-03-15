<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    /**
     * Catégories de répartition du portefeuille (règle 50/30/20).
     */
    public const CATEGORIE_SECURITE   = 'securite';    // 50% - Bons du Trésor
    public const CATEGORIE_CROISSANCE = 'croissance';  // 30% - Actions/ETF
    public const CATEGORIE_OPPORTUNITE = 'opportunite'; // 20% - Crypto/Startups

    public const ALLOCATION_TARGETS = [
        self::CATEGORIE_SECURITE   => 0.50,
        self::CATEGORIE_CROISSANCE => 0.30,
        self::CATEGORIE_OPPORTUNITE => 0.20,
    ];

    protected $fillable = [
        'nom',
        'type',
        'categorie',
        'description',
        'valeur_actuelle',
        'is_active',
    ];

    protected $casts = [
        'valeur_actuelle' => 'decimal:4',
        'is_active' => 'boolean',
    ];

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
