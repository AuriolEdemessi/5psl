<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'date',
        'valeur_avant',
        'valeur_apres',
        'variation_pct',
        'variation_absolue',
        'type_periode',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'date'              => 'date',
        'valeur_avant'      => 'decimal:4',
        'valeur_apres'      => 'decimal:4',
        'variation_pct'     => 'decimal:4',
        'variation_absolue' => 'decimal:4',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
