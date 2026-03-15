<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Table des opportunités d'investissement proposées par l'administrateur.
     * Les membres peuvent voter (approuver/rejeter) avant que le club ne procède.
     * created_by référence l'admin qui a publié l'opportunité.
     */
    public function up(): void
    {
        Schema::create('investment_opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->enum('type', ['action', 'obligation', 'crypto', 'immobilier', 'fonds', 'autre']);

            // decimal(15,4) pour la précision du montant estimé de l'investissement
            $table->decimal('montant_estime', 15, 4)->nullable();

            // Statut de l'opportunité dans le cycle de décision du club
            $table->enum('statut', ['ouverte', 'approuvee', 'rejetee', 'cloturee'])->default('ouverte');

            // Clé étrangère vers users : identifie l'admin qui a créé l'opportunité
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade');

            $table->date('date_limite_vote')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_opportunities');
    }
};
