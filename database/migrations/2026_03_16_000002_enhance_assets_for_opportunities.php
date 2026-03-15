<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add valeur_initiale to assets (opportunity_id and categorie already exist)
        if (!Schema::hasColumn('assets', 'valeur_initiale')) {
            Schema::table('assets', function (Blueprint $table) {
                $table->decimal('valeur_initiale', 15, 4)->default(0)->after('description');
            });
        }

        // Performance log table for tracking asset returns over time
        Schema::create('asset_performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->date('date');
            $table->decimal('valeur_avant', 15, 4);
            $table->decimal('valeur_apres', 15, 4);
            $table->decimal('variation_pct', 8, 4)->default(0);
            $table->decimal('variation_absolue', 15, 4)->default(0);
            $table->string('type_periode')->default('daily'); // daily, weekly, monthly
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['asset_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_performances');

        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['opportunity_id']);
            $table->dropColumn(['opportunity_id', 'categorie', 'valeur_initiale']);
        });
    }
};
