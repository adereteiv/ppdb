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
        Schema::create('batch_ppdb', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran');
            $table->tinyInteger('gelombang');
            $table->unique(['tahun_ajaran', 'gelombang'], 'unique_tahun_ajaran_gelombang');
            $table->boolean('status')->default(false);
            $table->datetime('waktu_mulai');
            $table->datetime('waktu_tenggat');
            $table->datetime('waktu_tutup');
            $table->timestamps();
        });

        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batch_ppdb')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['Belum Lengkap', 'Lengkap', 'Terverifikasi'])->default('Belum Lengkap');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_ppdb');
        Schema::dropIfExists('pendaftaran');
    }
};
