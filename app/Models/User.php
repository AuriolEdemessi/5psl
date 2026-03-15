<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * Paliers d'investisseur et leurs seuils de capital ($).
     */
    public const TIER_STARTER = 'STARTER';
    public const TIER_PRO     = 'PRO';
    public const TIER_ELITE   = 'ELITE';

    public const TIER_THRESHOLDS = [
        self::TIER_STARTER => ['min' => 100,   'max' => 2500,  'fee' => 20],
        self::TIER_PRO     => ['min' => 2500,  'max' => 10000, 'fee' => 50],
        self::TIER_ELITE   => ['min' => 10000, 'max' => PHP_FLOAT_MAX, 'fee' => 100],
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'kyc_status',
        'grade',
        'tier',
        'high_water_mark',
        'last_withdrawal_at',
        'referrer_id',
        'referral_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'high_water_mark'    => 'decimal:4',
        'last_withdrawal_at' => 'datetime',
    ];

    // ── Relations ──

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user')->withPivot('completed')->withTimestamps();
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_user')->withTimestamps();
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function opportunityVotes()
    {
        return $this->hasMany(OpportunityVote::class);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id');
    }

    public function affiliateEarnings()
    {
        return $this->hasMany(AffiliateEarning::class, 'referrer_id');
    }

    public function affiliateEarningsAsReferred()
    {
        return $this->hasMany(AffiliateEarning::class, 'referred_id');
    }

    public function kycDocuments()
    {
        return $this->hasMany(KycDocument::class);
    }

    // ── Helpers ──

    /**
     * Retourne l'adhésion active courante, ou null.
     */
    public function activeSubscription(): ?Subscription
    {
        return $this->subscriptions()
            ->where('statut', 'active')
            ->where('date_fin', '>=', now()->toDateString())
            ->latest('date_debut')
            ->first();
    }

    /**
     * Détermine le palier approprié en fonction du capital investi.
     */
    public static function determineTier(float $capitalInvested): string
    {
        if ($capitalInvested >= self::TIER_THRESHOLDS[self::TIER_ELITE]['min']) {
            return self::TIER_ELITE;
        }

        if ($capitalInvested >= self::TIER_THRESHOLDS[self::TIER_PRO]['min']) {
            return self::TIER_PRO;
        }

        return self::TIER_STARTER;
    }

    /**
     * Vérifie si l'utilisateur peut effectuer un retrait de gains (fenêtre 30 jours).
     */
    public function canWithdrawGains(): bool
    {
        if (is_null($this->last_withdrawal_at)) {
            return true;
        }

        return $this->last_withdrawal_at->diffInDays(now()) >= 30;
    }

    /**
     * Montant de l'adhésion annuelle pour le palier actuel.
     */
    public function getAnnualFee(): float
    {
        return (float) (self::TIER_THRESHOLDS[$this->tier ?? self::TIER_STARTER]['fee'] ?? 20);
    }
}