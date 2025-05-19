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
            $table->string('id')->primary();
            // $table->id();
            $table->foreignId('batch_id')->constrained('batch_ppdb')->onDelete('cascade');
            $table->string('user_id')->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['Menunggu', 'Mengisi', 'Lengkap', 'Terverifikasi'])->default('Menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });

        Schema::create('info_anak', function (Blueprint $table) {
            $table->id();
            $table->string('pendaftaran_id')->nullable()->index();
            $table->foreign('pendaftaran_id')->references('id')->on('pendaftaran')->onDelete('cascade');
            // $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->onDelete('cascade');
            $table->string('nama_anak');
            $table->string('panggilan_anak');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->unsignedInteger('jarak_tempuh');
            $table->text('alamat_anak')->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki','Perempuan'])->nullable();
            $table->enum('kewarganegaraan', ['WNI','WNA Keturunan'])->nullable();
            $table->enum('agama', ['Buddha','Hindu','Islam','Katolik','Khonghucu','Kristen Protestan'])->nullable();
            $table->enum('status_tinggal', ['Bersama Orang Tua','Bersama Wali'])->nullable();
            $table->enum('yang_mendaftarkan', ['Orang Tua','Wali'])->nullable();
            $table->enum('status_anak', ['Anak Kandung','Bukan Anak Kandung'])->nullable();
            $table->enum('bahasa_di_rumah', ['Bahasa Indonesia','Bahasa Asing','Bahasa Daerah'])->nullable();
            $table->unsignedInteger('anak_ke')->nullable();
            $table->unsignedInteger('saudara_kandung')->nullable();
            $table->unsignedInteger('saudara_tiri')->nullable();
            $table->unsignedInteger('saudara_angkat')->nullable();
            $table->decimal('berat_badan', 5, 2)->unsigned()->nullable();
            $table->decimal('tinggi_badan', 5, 2)->unsigned()->nullable();
            $table->enum('golongan_darah',['Belum Periksa','O','AB','A','B'])->nullable();
            $table->enum('ukuran_baju',['M', 'L', 'XL', 'XXL'])->nullable();
            $table->string('riwayat_penyakit')->nullable();
            // Asal muasal anak
            $table->enum('mendaftar_sebagai', ['Murid Baru','Pindahan'])->nullable();
            $table->string('sekolah_lama')->nullable();
            $table->date('tanggal_pindah')->nullable();
            $table->enum('dari_kelompok', ['TK A','TK B'])->nullable();
            // $table->date('tanggal_diterima')->nullable();
            $table->enum('ke_kelompok', ['TK A','TK B'])->nullable();
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
        Schema::dropIfExists('info_anak');
    }
};
