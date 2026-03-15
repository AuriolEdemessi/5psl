<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    /**
     * L'admin voit toutes les transactions.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Un membre ne peut voir que ses propres transactions.
     * L'admin peut voir toutes les transactions.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        return $user->role === 'admin' || $user->id === $transaction->user_id;
    }

    /**
     * Un membre authentifié peut créer une transaction (dépôt/retrait).
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Seul l'admin peut approuver/rejeter (modifier) une transaction.
     */
    public function update(User $user, Transaction $transaction): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seul l'admin peut supprimer une transaction.
     */
    public function delete(User $user, Transaction $transaction): bool
    {
        return $user->role === 'admin';
    }
}
