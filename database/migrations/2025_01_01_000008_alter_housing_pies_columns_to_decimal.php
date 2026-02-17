<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Use raw SQL to avoid requiring doctrine/dbal for column type changes
        // Adjust for MySQL-compatible syntax; Laragon typically uses MySQL/MariaDB
        DB::statement("ALTER TABLE `housing_pies` 
            MODIFY `livable` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0,
            MODIFY `unlivable` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0");
    }

    public function down(): void
    {
        // Revert back to unsigned BIGINT (will truncate decimals)
        DB::statement("ALTER TABLE `housing_pies` 
            MODIFY `livable` BIGINT UNSIGNED NOT NULL DEFAULT 0,
            MODIFY `unlivable` BIGINT UNSIGNED NOT NULL DEFAULT 0");
    }
};