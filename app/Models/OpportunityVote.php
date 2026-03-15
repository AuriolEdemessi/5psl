<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunityVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'investment_opportunity_id',
        'user_id',
        'vote',
    ];

    public function opportunity()
    {
        return $this->belongsTo(InvestmentOpportunity::class, 'investment_opportunity_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
