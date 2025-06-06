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
        Schema::create('orang_tua_wali', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('info_anak')->onDelete('cascade');
            $table->enum('relasi', ['ayah', 'ibu', 'wali'])->nullable();
            $table->string('nama')->nullable();
            $table->enum('pendidikan',['Tidak Sekolah','Paket A','Paket B','Paket C','SD/MI','SMP/MTs','SMA/SMK/MA','D-1','D-2','D-3','D-4','S-1','S-2','S-3'])->nullable();
            $table->enum('pekerjaan',['Sudah Meninggal','Mengurus Rumah Tangga','Petani','Nelayan','Peternak','Buruh','Pedagang Kecil','Pedagang Besar','Pegawai Swasta','Guru','PNS','Dokter','TNI','Polisi','Dosen','Karyawan BUMN','Wiraswasta','Tenaga Kerja Indonesia'])->nullable();
            $table->enum('penghasilan', ['Kurang dari Rp500.000','Rp500.000 - Rp1.000.000','Rp1.000.000 - Rp3.000.000','Rp3.000.000 - Rp5.000.000','Lebih dari Rp5.000.000'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orang_tua_wali');
    }
};
