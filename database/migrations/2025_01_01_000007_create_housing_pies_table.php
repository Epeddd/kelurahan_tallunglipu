<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('housing_pies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('livable')->default(0);    // Layak Huni
            $table->unsignedBigInteger('unlivable')->default(0);  // Tidak Layak Huni
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('housing_pies');
    }
};