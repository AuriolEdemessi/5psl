<?php

namespace App\Providers;

use App\Models\Investment;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Policies\InvestmentPolicy;
use App\Policies\SubscriptionPolicy;
use App\Policies\TransactionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Investment::class   => InvestmentPolicy::class,
        Transaction::class  => TransactionPolicy::class,
        Subscription::class => SubscriptionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
