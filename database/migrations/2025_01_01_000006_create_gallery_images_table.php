<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('galleries')->onDelete('cascade');
            $table->string('image_path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
        // Drop old single image column if exists
        if (Schema::hasColumn('galleries', 'image_path')) {
            Schema::table('galleries', function(Blueprint $table){
                $table->dropColumn('image_path');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_images');
        // Note: not restoring old column
    }
};