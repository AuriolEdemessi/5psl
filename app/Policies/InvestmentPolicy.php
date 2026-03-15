<?php

namespace App\Policies;

use App\Models\Investment;
use App\Models\User;

class InvestmentPolicy
{
    /**
     * L'admin peut voir tous les investissements.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Un membre ne peut voir que ses propres investissements.
     * L'admin peut voir tous les investissements.
     */
    public function view(User $user, Investment $investment): bool
    {
        return $user->role === 'admin' || $user->id === $investment->user_id;
    }

    /**
     * Seuls les membres authentifiés peuvent investir.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Seul l'admin peut modifier un investissement.
     */
    public function update(User $user, Investment $investment): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seul l'admin peut supprimer un investissement.
     */
    public function delete(User $user, Investment $investment): bool
    {
        return $user->role === 'admin';
    }
}
