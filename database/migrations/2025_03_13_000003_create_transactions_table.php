<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Table des transactions financières (dépôts et retraits) des membres.
     * Chaque transaction trace un mouvement d'argent sur le compte d'un membre.
     * Le statut permet de gérer un workflow de validation (en_attente → approuvé/rejeté).
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Clé étrangère vers users : identifie le membre effectuant la transaction
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Type de transaction : dépôt (ajout de fonds) ou retrait (sortie de fonds)
            $table->enum('type', ['depot', 'retrait']);

            // decimal(15,4) pour la précision des montants financiers
            $table->decimal('montant', 15, 4);

            // Statut de la transaction pour le workflow de validation
            $table->enum('statut', ['en_attente', 'approuve', 'rejete'])->default('en_attente');

            $table->text('description')->nullable();
            $table->timestamps();

            // Index pour les requêtes fréquentes par utilisateur
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
