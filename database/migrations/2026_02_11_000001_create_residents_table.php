<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik')->unique();
            $table->string('no_kk');
            $table->string('wilayah'); // Bo'ne Limbong, Bo'ne Matampu' Selatan, Bo'ne Matampu' Utara, Bo'ne Randanan
            $table->enum('status', ['Tallunglipu', 'Non-Permanent']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
