<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table des adhésions annuelles au club.
     *
     * Tarifs par palier :
     * - STARTER  ($500 - $2,500)  → $20/an
     * - PRO      ($2,500 - $10,000) → $50/an
     * - ELITE    (> $10,000)      → $100/an
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Palier au moment du paiement de l'adhésion
            $table->enum('tier', ['STARTER', 'PRO', 'ELITE']);

            // Montant de l'adhésion payée (decimal(15,4) pour précision financière)
            $table->decimal('montant', 15, 4);

            // Période couverte par l'adhésion
            $table->date('date_debut');
            $table->date('date_fin');

            $table->enum('statut', ['active', 'expiree', 'annulee'])->default('active');

            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
