<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'asset_id',
        'montant',
        'nombre_de_parts',
        'highest_value_reached',
        'date',
    ];

    protected $casts = [
        'montant'                => 'decimal:4',
        'nombre_de_parts'        => 'decimal:4',
        'highest_value_reached'  => 'string',
        'date'                   => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
