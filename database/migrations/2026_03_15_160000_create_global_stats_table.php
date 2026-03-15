<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('global_stats', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_aum', 20, 8)->default(0)->comment('Total Assets Under Management en USDT');
            $table->decimal('current_nav', 20, 8)->default(10)->comment('Valeur liquidative par part');
            $table->decimal('total_shares', 20, 8)->default(0)->comment('Total de parts en circulation');
            $table->decimal('total_fees_collected', 20, 8)->default(0)->comment('Frais d\'entrée collectés');
            $table->decimal('total_hwm_commissions', 20, 8)->default(0)->comment('Commissions HWM collectées');
            $table->timestamps();
        });

        // Insert initial row
        DB::table('global_stats')->insert([
            'total_aum' => 0,
            'current_nav' => 10.00000000,
            'total_shares' => 0,
            'total_fees_collected' => 0,
            'total_hwm_commissions' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('global_stats');
    }
};
