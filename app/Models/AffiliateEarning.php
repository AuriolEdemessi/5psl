<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referred_id',
        'transaction_id',
        'manager_commission',
        'affiliate_amount',
        'nav_at_time',
        'status',
    ];

    protected $casts = [
        'manager_commission' => 'string',
        'affiliate_amount'   => 'string',
        'nav_at_time'        => 'string',
    ];

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
