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
        Schema::create('animes', function (Blueprint $table) {
    $table->id();
    $table->string('title');        // Nama Alias (Naruto)
    $table->string('folder_name');  // Nama folder acak (asdf-123)
    $table->string('file_pattern'); // Awalan file (otakudesu-naruto-eps-)
    $table->integer('max_eps');     // 12
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
