<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajout des colonnes de palier (tier), high-water mark et fenêtre de retrait
     * sur la table users. Ajout de colonnes de frais sur transactions.
     * Ajout de la catégorie de répartition sur assets.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Palier d'investisseur basé sur le capital investi
            $table->enum('tier', ['STARTER', 'PRO', 'ELITE'])->default('STARTER')->after('kyc_status');

            // High-Water Mark : sommet historique de la valeur du portefeuille
            // La commission 30% n'est prélevée que si la valeur dépasse ce seuil
            $table->decimal('high_water_mark', 15, 4)->default(0)->after('tier');

            // Date du dernier retrait de gains (fenêtre 30 jours)
            $table->timestamp('last_withdrawal_at')->nullable()->after('high_water_mark');
        });

        // Ajouter les colonnes de frais et de commission sur les transactions
        Schema::table('transactions', function (Blueprint $table) {
            // Frais d'entrée (2% sur chaque dépôt)
            $table->decimal('frais_entree', 15, 4)->default(0)->after('montant');

            // Montant net après frais (montant - frais_entree)
            $table->decimal('montant_net', 15, 4)->default(0)->after('frais_entree');

            // Commission HWM prélevée (30% des plus-values au-delà du HWM)
            $table->decimal('commission_hwm', 15, 4)->default(0)->after('montant_net');
        });

        // Ajouter la catégorie de répartition 50/30/20 sur les actifs
        Schema::table('assets', function (Blueprint $table) {
            // Catégorie de répartition du portefeuille global
            // securite = 50% (Bons du Trésor)
            // croissance = 30% (Actions/ETF)
            // opportunite = 20% (Crypto/Startups)
            $table->enum('categorie', ['securite', 'croissance', 'opportunite'])->default('securite')->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tier', 'high_water_mark', 'last_withdrawal_at']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['frais_entree', 'montant_net', 'commission_hwm']);
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('categorie');
        });
    }
};
