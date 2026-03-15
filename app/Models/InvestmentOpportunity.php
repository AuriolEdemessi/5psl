<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentOpportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'type',
        'montant_estime',
        'statut',
        'created_by',
        'date_limite_vote',
    ];

    protected $casts = [
        'montant_estime' => 'decimal:4',
        'date_limite_vote' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function votes()
    {
        return $this->hasMany(OpportunityVote::class);
    }

    public function approvals()
    {
        return $this->votes()->where('vote', 'approuver');
    }

    public function rejections()
    {
        return $this->votes()->where('vote', 'rejeter');
    }

    public function hasUserVoted(int $userId): bool
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }

    public function getUserVote(int $userId): ?string
    {
        $vote = $this->votes()->where('user_id', $userId)->first();
        return $vote?->vote;
    }

    public function asset()
    {
        return $this->hasOne(Asset::class, 'opportunity_id');
    }

    public function isConvertedToAsset(): bool
    {
        return $this->asset()->exists();
    }
}
