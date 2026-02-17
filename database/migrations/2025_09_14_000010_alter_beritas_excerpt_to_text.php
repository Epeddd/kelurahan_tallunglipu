<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Ubah excerpt dari string/varchar ke TEXT agar lebih panjang
            $table->text('excerpt')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Kembalikan ke string(255) jika diperlukan rollback
            $table->string('excerpt')->nullable()->change();
        });
    }
};