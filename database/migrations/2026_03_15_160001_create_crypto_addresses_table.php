<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crypto_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('coin', 10)->comment('USDT, USDC, etc.');
            $table->string('network', 50)->comment('TRC20, ERC20, BEP20, SOL, etc.');
            $table->string('address', 255);
            $table->string('label', 100)->nullable()->comment('Libellé optionnel');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crypto_addresses');
    }
};
