<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN kyc_status ENUM('not_started', 'pending', 'verified', 'rejected') DEFAULT 'not_started'");

        // Update existing users who have 'pending' status but no KYC documents to 'not_started'
        DB::statement("
            UPDATE users 
            SET kyc_status = 'not_started' 
            WHERE kyc_status = 'pending' 
            AND id NOT IN (SELECT DISTINCT user_id FROM kyc_documents)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert not_started back to pending
        DB::statement("UPDATE users SET kyc_status = 'pending' WHERE kyc_status = 'not_started'");
        DB::statement("ALTER TABLE users MODIFY COLUMN kyc_status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending'");
    }
};
