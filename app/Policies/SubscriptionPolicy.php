<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionPolicy
{
    /**
     * L'admin peut voir toutes les adhésions.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Un membre ne peut voir que ses propres adhésions.
     */
    public function view(User $user, Subscription $subscription): bool
    {
        return $user->role === 'admin' || $user->id === $subscription->user_id;
    }

    /**
     * Seul l'admin peut créer une adhésion (ou le système).
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seul l'admin peut modifier une adhésion.
     */
    public function update(User $user, Subscription $subscription): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seul l'admin peut supprimer une adhésion.
     */
    public function delete(User $user, Subscription $subscription): bool
    {
        return $user->role === 'admin';
    }
}
