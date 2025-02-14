<x-layouts.app-layout>

<div id="pendaftar-formulir" class="app-content wrapper">
    <div class="content-title margin-vertical">Formulir Pendaftaran</div>
    <!-- Form - Scrollable Flex -->
    <div class="scrollable">
        <form method="post" action="">
            <div class="flex">
                <div class="flex-1">
                    <!-- Form - Table Layout -->
                    <div class="form-section">
                        <h6>Data Anak</h6>
                        <table>
                            <!-- Form - Text Input -->
                            <tr><td width="180px">Nama</td>
                                <td>: <input class="form-item" type="text" name="nama_anak" value="Slot" required></td></tr>
                            <tr><td>Nama Panggilan</td>
                                <td>: <input class="form-item" type="text" name="panggilan_anak" required></td></tr>
                            <!-- Form - Radiobutton -->
                            <tr><td>Jenis Kelamin</td>
                                <td>:
                                    <label><input class="form-item" type="radio" name="gender" value="1">&nbsp;Laki-Laki</label>&nbsp;
                                    <label><input class="form-item" type="radio" name="gender" value="2" checked>&nbsp;Perempuan</label>&nbsp;
                                </td></tr>
                            <tr><td>Tempat Lahir</td>
                                <td>: <input class="form-item" type="text" name="tempat_lahir" required></td></tr>
                            <tr><td>Tanggal Lahir</td>
                                <td>: <input class="form-item" type="date" name="tanggal_lahir" required></td></tr>
                            <!-- Form - Select Dropdown -->
                            <tr><td>Agama</td>
                                <td>: <select class="form-item" name="agama" required>
                                        <option value="">--</option>
                                        <option value="1">Islam</option>
                                        <option value="2">Katolik</option>
                                        <option value="3">Protestan</option>
                                        <option value="4">Hindu</option>
                                        <option value="5">Budha</option>
                                        <option value="6">Khonghucu</option>
                                    </select></td></tr>
                            <tr><td>Kewarganegaraan</td>
                                <td>: <select class="form-item" name="kewarganegaraan" required>
                                        <option value="">--</option>
                                        <option value="1">WNI</option>
                                        <option value="2">WNA</option>
                                    </select></td></tr>
                            <!-- Form - Textarea -->
                            <tr><td>Alamat</td>
                                <td>: <textarea class="form-item" type="text" name="alamat_anak" rows="3" cols="23" required></textarea></td></tr>
                            <tr><td>Status Tinggal</td>
                                <td>: <select class="form-item" name="status_tinggal" required>
                                        <option>--</option>
                                        <option>Bersama Orang Tua</option>
                                        <option>Wali</option>
                                        <option>Panti Asuhan</option>
                                        <option>Lainnya</option>
                                    </select></td></tr>
                            <tr><td>Bahasa di Rumah</td>
                                <td>:
                                    <select class="form-item" name="bahasa_rumah" required>
                                        <option value="">--</option>
                                        <option value="1">Bahasa Indonesia</option>
                                        <option value="2">Bahasa Daerah</option>
                                        <option value="3">Bahasa Asing</option>
                                    </select></td></tr>
                            <!-- Form - Number Input -->
                            <tr><td>Anak Ke-</td>
                                <td>: <input class="form-item" type="number" name="anak_ke" min="1" required></td></tr>
                            <tr><td>Saudara Kandung</td>
                                <td>: <input class="form-item" type="number" name="saudara_kandung" min="0" required></td></tr>
                            <tr><td>Saudara Tiri</td>
                                <td>: <input class="form-item" type="number" name="saudara_tiri" min="0" required></td></tr>
                            <tr><td>Saudara Angkat</td>
                                <td>: <input class="form-item" type="number" name="saudara_angkat" min="0" required></td></tr>
                            <tr><td>Berat Badan</td>
                                <td>: <input class="form-item" type="number" name="berat_badan" required></td></tr>
                            <tr><td>Tinggi Badan</td>
                                <td>: <input class="form-item" type="number" name="tinggi_badan" required></td></tr>
                            <tr><td>Golongan Darah</td>
                                <td>:
                                    <select class="form-item" name="gol_darah" required>
                                        <option value="">--</option>
                                        <option value="1">A</option>
                                        <option value="2">B</option>
                                        <option value="3">O</option>
                                        <option value="4">AB</option>
                                        <option value="5">Belum Periksa</option>
                                    </select></td></tr>
                            <tr><td>Riwayat Penyakit</td>
                                <td>: <input class="form-item" type="text" name="penyakit" required></td></tr>
                            <tr><td>Mendaftar Sebagai</td>
                                <td>:
                                    <select class="form-item" name="daftar_sebagai" required>
                                        <option value="1">Murid Baru</option>
                                        <option value="2">Murid Pindahan</option>
                                    </select></td></tr>
                            <tr><td>Sekolah Lama</td>
                                <td>: <input class="form-item" type="text" name="sekolah_lama"></td></tr>
                            <!-- Form - Date Input -->
                            <tr><td>Tanggal Pindah</td>
                                <td>: <input class="form-item" type="date" name="tanggal_keluar"></td></tr>
                            <tr><td>Dari Kelompok</td>
                                <td>:
                                    <select class="form-item" name="kelompok_keluar">
                                        <option value="">--</option>
                                        <option value="1">TK A</option>
                                        <option value="2">TK B</option>
                                    </select></td></tr>
                            <tr><td>Tanggal Diterima</td>
                                <td>: <input class="form-item" type="date" name="tanggal_masuk"></td></tr>
                            <tr><td>Di Kelompok</td>
                                <td>: <select class="form-item" name="kelompok_masuk">
                                        <option value="">--</option>
                                        <option value="1">TK A</option>
                                        <option value="2">TK B</option>
                                    </select></td></tr>
                        </table>
                    </div>
                </div>
                <div class="flex-1">
                    <!-- Form - Table Layout -->
                    <div class="form-section">
                        <h6>Data Ayah</h6>
                        <table>
                            <tr><td width="180px">Nama</td>
                                <td>: <input class="form-item" type="text" name="nama_ayah" ></td></tr>
                            <tr><td>Pendidikan</td>
                                <td>:
                                    <select class="form-item" name="pendidikan_ayah" required>
                                        <option value="">--</option>
                                        <option value="">Tidak Sekolah</option>
                                        <option value="">Paket A</option>
                                        <option value="">Paket B</option>
                                        <option value="">Paket C</option>
                                        <option value="">SD/Sederajat</option>
                                        <option value="">SLTP/Sederajat</option>
                                        <option value="">SLTA/Sederajat</option>
                                        <option value="">D-1</option>
                                        <option value="">D-2</option>
                                        <option value="">D-3</option>
                                        <option value="">D-4</option>
                                        <option value="">S-1</option>
                                        <option value="">S-2</option>
                                        <option value="">S-3</option>
                                    </select>
                                </td></tr>
                            <tr><td>Pekerjaan</td>
                                <td>:
                                    <select class="form-item" name="pekerjaan_ayah" title="">
                                        <option value="">--</option>
                                        <option value="">Sudah Meninggal</option>
                                        <option value="">Mengurus Rumah Tangga</option>
                                        <option value="">Petani</option>
                                        <option value="">Nelayan</option>
                                        <option value="">Peternak</option>
                                        <option value="">Buruh</option>
                                        <option value="">Pedagang Besar</option>
                                        <option value="">Pedagang Kecil</option>
                                        <option value="">Tenaga Kerja Indonesia</option>
                                        <option value="">Pegawai Swasta</option>
                                        <option value="">PNS</option>
                                        <option value="">Guru</option>
                                        <option value="">Dosen</option>
                                        <option value="">Dokter</option>
                                        <option value="">TNI</option>
                                        <option value="">Polisi</option>
                                        <option value="">Wiraswasta</option>
                                        <option value="">Pensiunan</option>
                                    </select>
                                </td></tr>
                            <tr><td>Alamat</td>
                                <td>:
                                    <textarea class="form-item" type="text" name="alamat_ayah" rows="3" cols="23" required></textarea>
                                </td></tr>
                            <tr><td>Nomor HP</td>
                                    <td>:
                                    <input class="form-item" type="text" name="hp_ayah">
                                </td></tr>
                        </table>
                    </div>
                    <div class="form-section">
                        <h6>Data Ayah</h6>
                        <table>
                            <tr><td width="180px">Nama</td>
                                <td>: <input class="form-item" type="text" name="nama_ayah" ></td></tr>
                            <tr><td>Pendidikan</td>
                                <td>:
                                    <select class="form-item" name="pendidikan_ayah" required>
                                        <option value="">--</option>
                                        <option value="">Tidak Sekolah</option>
                                        <option value="">Paket A</option>
                                        <option value="">Paket B</option>
                                        <option value="">Paket C</option>
                                        <option value="">SD/Sederajat</option>
                                        <option value="">SLTP/Sederajat</option>
                                        <option value="">SLTA/Sederajat</option>
                                        <option value="">D-1</option>
                                        <option value="">D-2</option>
                                        <option value="">D-3</option>
                                        <option value="">D-4</option>
                                        <option value="">S-1</option>
                                        <option value="">S-2</option>
                                        <option value="">S-3</option>
                                    </select>
                                </td></tr>
                            <tr><td>Pekerjaan</td>
                                <td>:
                                    <select class="form-item" name="pekerjaan_ayah" title="">
                                        <option value="">--</option>
                                        <option value="">Sudah Meninggal</option>
                                        <option value="">Mengurus Rumah Tangga</option>
                                        <option value="">Petani</option>
                                        <option value="">Nelayan</option>
                                        <option value="">Peternak</option>
                                        <option value="">Buruh</option>
                                        <option value="">Pedagang Besar</option>
                                        <option value="">Pedagang Kecil</option>
                                        <option value="">Tenaga Kerja Indonesia</option>
                                        <option value="">Pegawai Swasta</option>
                                        <option value="">PNS</option>
                                        <option value="">Guru</option>
                                        <option value="">Dosen</option>
                                        <option value="">Dokter</option>
                                        <option value="">TNI</option>
                                        <option value="">Polisi</option>
                                        <option value="">Wiraswasta</option>
                                        <option value="">Pensiunan</option>
                                    </select>
                                </td></tr>
                            <tr><td>Alamat</td>
                                <td>:
                                    <textarea class="form-item" type="text" name="alamat_ayah" rows="3" cols="23" required></textarea>
                                </td></tr>
                            <tr><td>Nomor HP</td>
                                    <td>:
                                    <input class="form-item" type="text" name="hp_ayah">
                                </td></tr>
                        </table>
                    </div>
                    <div class="form-section">
                        <h6>Data Ayah</h6>
                        <table>
                            <tr><td width="180px">Nama</td>
                                <td>: <input class="form-item" type="text" name="nama_ayah" ></td></tr>
                            <tr><td>Pendidikan</td>
                                <td>:
                                    <select class="form-item" name="pendidikan_ayah" required>
                                        <option value="">--</option>
                                        <option value="">Tidak Sekolah</option>
                                        <option value="">Paket A</option>
                                        <option value="">Paket B</option>
                                        <option value="">Paket C</option>
                                        <option value="">SD/Sederajat</option>
                                        <option value="">SLTP/Sederajat</option>
                                        <option value="">SLTA/Sederajat</option>
                                        <option value="">D-1</option>
                                        <option value="">D-2</option>
                                        <option value="">D-3</option>
                                        <option value="">D-4</option>
                                        <option value="">S-1</option>
                                        <option value="">S-2</option>
                                        <option value="">S-3</option>
                                    </select>
                                </td></tr>
                            <tr><td>Pekerjaan</td>
                                <td>:
                                    <select class="form-item" name="pekerjaan_ayah" title="">
                                        <option value="">--</option>
                                        <option value="">Sudah Meninggal</option>
                                        <option value="">Mengurus Rumah Tangga</option>
                                        <option value="">Petani</option>
                                        <option value="">Nelayan</option>
                                        <option value="">Peternak</option>
                                        <option value="">Buruh</option>
                                        <option value="">Pedagang Besar</option>
                                        <option value="">Pedagang Kecil</option>
                                        <option value="">Tenaga Kerja Indonesia</option>
                                        <option value="">Pegawai Swasta</option>
                                        <option value="">PNS</option>
                                        <option value="">Guru</option>
                                        <option value="">Dosen</option>
                                        <option value="">Dokter</option>
                                        <option value="">TNI</option>
                                        <option value="">Polisi</option>
                                        <option value="">Wiraswasta</option>
                                        <option value="">Pensiunan</option>
                                    </select>
                                </td></tr>
                            <tr><td>Alamat</td>
                                <td>:
                                    <textarea class="form-item" type="text" name="alamat_ayah" rows="3" cols="23" required></textarea>
                                </td></tr>
                            <tr><td>Nomor HP</td>
                                    <td>:
                                    <input class="form-item" type="text" name="hp_ayah">
                                </td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="margin-vertical text-align-center">
                <input class="tombol-besar" type="submit" value="Simpan" disabled>
            </div>
        </form>
    </div>
</div>

</x-layouts.app-layout>
