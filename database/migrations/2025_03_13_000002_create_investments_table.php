<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Table des investissements individuels des membres du club.
     * Chaque ligne représente un investissement d'un utilisateur dans un actif spécifique.
     * Le nombre_de_parts est calculé au moment de l'investissement en fonction de la NAV.
     */
    public function up(): void
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();

            // Clé étrangère vers users : identifie le membre qui investit
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Clé étrangère vers assets : identifie l'actif dans lequel le membre investit
            $table->foreignId('asset_id')
                ->constrained('assets')
                ->onDelete('cascade');

            // decimal(15,4) pour la précision des montants financiers
            $table->decimal('montant', 15, 4);
            $table->decimal('nombre_de_parts', 15, 4);
            $table->date('date');
            $table->timestamps();

            // Index composite pour les requêtes fréquentes par utilisateur et actif
            $table->index(['user_id', 'asset_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
