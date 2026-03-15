<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajout du parrain sur la table users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('referrer_id')->nullable()->after('last_withdrawal_at')
                  ->constrained('users')->nullOnDelete();
            $table->string('referral_code', 20)->nullable()->unique()->after('referrer_id');
        });

        // Ajout du sommet historique sur les investissements
        Schema::table('investments', function (Blueprint $table) {
            $table->decimal('highest_value_reached', 20, 8)->default(0)->after('nombre_de_parts');
        });

        // Table des gains d'affiliation
        Schema::create('affiliate_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade')
                  ->comment('Le parrain qui reçoit la commission');
            $table->foreignId('referred_id')->constrained('users')->onDelete('cascade')
                  ->comment('Le filleul à l\'origine du gain');
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->nullOnDelete()
                  ->comment('Transaction de profit originale pour audit');
            $table->decimal('manager_commission', 20, 8)->comment('Commission gestionnaire 30% dont est tiré le 10%');
            $table->decimal('affiliate_amount', 20, 8)->comment('10% de la commission gestionnaire');
            $table->decimal('nav_at_time', 20, 8)->comment('NAV au moment du calcul');
            $table->enum('status', ['pending', 'credited', 'paid'])->default('pending');
            $table->timestamps();
        });

        // Historique NAV
        Schema::create('nav_history', function (Blueprint $table) {
            $table->id();
            $table->decimal('nav_value', 20, 8);
            $table->decimal('total_aum', 20, 8);
            $table->decimal('total_shares', 20, 8);
            $table->decimal('club_drawdown_pct', 10, 4)->default(0)->comment('% de perte depuis le sommet du club');
            $table->string('event', 50)->nullable()->comment('deposit, withdrawal, rebalance, monthly_close');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nav_history');
        Schema::dropIfExists('affiliate_earnings');

        Schema::table('investments', function (Blueprint $table) {
            $table->dropColumn('highest_value_reached');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('referrer_id');
            $table->dropColumn('referral_code');
        });
    }
};
