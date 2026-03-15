<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('club_wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., 'Main Pool', 'High Risk Crypto'
            $table->string('network')->nullable(); // e.g., 'TRC20', 'ERC20', 'Solana'
            $table->string('address')->nullable(); // The public address
            $table->text('recovery_phrase')->nullable(); // The 12-24 word seed phrase (Should ideally be encrypted in production, but we will store it for the admin interface as requested)
            $table->text('private_key')->nullable(); // Private key if applicable
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_wallets');
    }
};
