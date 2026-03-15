<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'montant',
        'frais_entree',
        'montant_net',
        'commission_hwm',
        'statut',
        'description',
    ];

    protected $casts = [
        'montant'        => 'decimal:4',
        'frais_entree'   => 'decimal:4',
        'montant_net'    => 'decimal:4',
        'commission_hwm' => 'decimal:4',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
