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
        Schema::create('info_anak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->onDelete('cascade');
            $table->string('nama_anak');
            $table->string('panggilan_anak');
            $table->enum('gender', ['Perempuan','Laki-Laki']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('agama', ['Buddha','Hindu','Islam','Katolik','Khonghucu','Kristen Protestan']);
            $table->enum('kewarganegaraan', ['WNI', 'WNA']);
            $table->text('alamat_anak');
            $table->enum('status_tinggal', ['Bersama Orang Tua','Bersama Wali','Panti Asuhan','Asrama']);
            $table->enum('status_anak', ['Anak Kandung','Bukan Anak Kandung']);
            $table->enum('bahasa_harian', ['Bahasa Indonesia','Bahasa Asing','Bahasa Daerah']);
            $table->unsignedInteger('anak_ke');
            $table->unsignedInteger('saudara_kandung')->nullable();
            $table->unsignedInteger('saudara_tiri')->nullable();
            $table->unsignedInteger('saudara_angkat')->nullable();
            $table->decimal('berat_badan', 4, 2);
            $table->decimal('tinggi_badan', 5, 2);
            $table->string('riwayat_penyakit')->nullable();
            // Asal muasal anak
            $table->enum('info_pindah', ['Murid Baru','Pindahan']);
            $table->string('sekolah_lama')->nullable();
            $table->date('tanggal_pindah')->nullable();
            $table->enum('dari_kelompok', ['TK A','TK B'])->nullable();
            $table->date('tanggal_diterima')->nullable();
            $table->enum('di_kelompok', ['TK A','TK B'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_anak');
    }
};
