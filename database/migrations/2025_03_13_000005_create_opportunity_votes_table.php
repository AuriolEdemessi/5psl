<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Table des votes des membres sur les opportunités d'investissement.
     * Chaque membre ne peut voter qu'une seule fois par opportunité (contrainte unique).
     * Le vote est binaire : approuver ou rejeter.
     */
    public function up(): void
    {
        Schema::create('opportunity_votes', function (Blueprint $table) {
            $table->id();

            // Clé étrangère vers investment_opportunities : l'opportunité concernée
            $table->foreignId('investment_opportunity_id')
                ->constrained('investment_opportunities')
                ->onDelete('cascade');

            // Clé étrangère vers users : le membre qui vote
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Vote : approuver ou rejeter
            $table->enum('vote', ['approuver', 'rejeter']);

            $table->timestamps();

            // Contrainte unique : un seul vote par utilisateur par opportunité
            $table->unique(['investment_opportunity_id', 'user_id'], 'unique_vote_per_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunity_votes');
    }
};
