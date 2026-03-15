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
        'valeur_initiale',
        'valeur_actuelle',
        'is_active',
        'opportunity_id',
    ];

    protected $casts = [
        'valeur_initiale' => 'decimal:4',
        'valeur_actuelle' => 'decimal:4',
        'is_active' => 'boolean',
    ];

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function opportunity()
    {
        return $this->belongsTo(InvestmentOpportunity::class, 'opportunity_id');
    }

    public function performances()
    {
        return $this->hasMany(AssetPerformance::class)->orderByDesc('date');
    }

    public function latestPerformance()
    {
        return $this->hasOne(AssetPerformance::class)->latestOfMany('date');
    }

    public function roiPct(): float
    {
        if ($this->valeur_initiale <= 0) {
            return 0;
        }
        return (($this->valeur_actuelle - $this->valeur_initiale) / $this->valeur_initiale) * 100;
    }
}
