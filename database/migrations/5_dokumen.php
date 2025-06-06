<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipe_dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('tipe')->unique();
            $table->timestamps();
        });

        Schema::create('syarat_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batch_ppdb')->onDelete('cascade');
            $table->foreignId('tipe_dokumen_id')->constrained('tipe_dokumen')->onDelete('restrict')->onUpdate('restrict');
            $table->boolean('is_wajib')->default(true);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('dokumen_persyaratan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('info_anak')->onDelete('cascade');
            $table->foreignId('tipe_dokumen_id')->constrained('tipe_dokumen')->onDelete('restrict')->onUpdate('restrict');
            $table->string('file_path');
            // ->nullable();
            $table->timestamps();
        });

        Schema::create('bukti_bayar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('info_anak')->onDelete('cascade');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipe_dokumen');
        Schema::dropIfExists('syarat_dokumen');
        Schema::dropIfExists('dokumen_persyaratan');
        Schema::dropIfExists('bukti_bayar');
    }
};
