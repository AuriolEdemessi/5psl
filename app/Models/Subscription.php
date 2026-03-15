<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tier',
        'montant',
        'date_debut',
        'date_fin',
        'statut',
    ];

    protected $casts = [
        'montant'    => 'decimal:4',
        'date_debut' => 'date',
        'date_fin'   => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Vérifie si l'adhésion est actuellement active.
     */
    public function isActive(): bool
    {
        return $this->statut === 'active'
            && $this->date_fin->isFuture();
    }
}
