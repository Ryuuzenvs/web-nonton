Schema::create('animes', function (Blueprint $table) {
    $table->id();
    $table->string('title');        // Nama Alias (Naruto)
    $table->string('folder_name');  // Nama folder acak (asdf-123)
    $table->string('file_pattern'); // Awalan file (otakudesu-naruto-eps-)
    $table->integer('max_eps');     // 12
    $table->timestamps();
});
