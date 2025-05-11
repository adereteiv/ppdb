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
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('posted_by')->nullable()->index();
            $table->foreign('posted_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('judul');
            $table->text('keterangan');
            $table->enum('tipe_pengumuman', ['Umum', 'Khusus Pendaftar'])->default('Umum');
            $table->json('file_paths')->nullable();
            $table->datetime('jadwal_posting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};
