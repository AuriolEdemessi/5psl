<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Table des actifs du club d'investissement.
     * Chaque actif représente un instrument financier (action, obligation, crypto, immobilier, etc.)
     * détenu par le club. La valeur_actuelle est mise à jour régulièrement pour refléter
     * la valeur de marché et calculer la Valeur Liquidative (NAV).
     */
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->enum('type', ['action', 'obligation', 'crypto', 'immobilier', 'fonds', 'autre']);
            $table->text('description')->nullable();
            // decimal(15,4) pour garantir la précision des montants financiers
            $table->decimal('valeur_actuelle', 15, 4)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
