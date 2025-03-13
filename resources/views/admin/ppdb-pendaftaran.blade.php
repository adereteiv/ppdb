<x-layouts.app-layout>

<div id="admin-ppdb-entry" class="app-content wrapper">
    <div class="content-title margin-vertical">Profil Pendaftar</div>
    <!-- Button: for PPDB - Aktif -->
    <div class="flex justify-flex-end" style="display:none;">
        <button class="tombol tombol-netral">
            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
            Edit
        </button>
        <div class="dropdown">
            <button class="tombol tombol-netral" onclick="tampilkanLanjutan(this)">
                Atur Status
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-360 280-560h400L480-360Z"/></svg>
            </button>
            <div id="myDropdown" class="dropdown-content">
                <a href="#">Belum Lengkap</a>
                <a href="#">Ditinjau</a>
                <a href="#">Diverifikasi</a>
                <a href="#">Ditolak</a>
                <a href="#">Diterima</a>
            </div>
        </div>
        <button class="tombol tombol-negatif">
            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
            <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/></svg> -->
            Hapus
        </button>
    </div>
    <div class="flex justify-flex-end">
        <button class="tombol tombol-positif">
            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px"><path d="M840-680v480q0 33-23.5 56.5T760-120H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h480l160 160Zm-80 34L646-760H200v560h560v-446ZM480-240q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM240-560h360v-160H240v160Zm-40-86v446-560 114Z"/></svg>
            Simpan
        </button>
        <button class="tombol tombol-negatif">&#10006; Batal</button>
    </div>
    <!-- Content -->
    <div class="biodata">
        <div class="flex-1">
            <div class="inputbox">
                <label class="" for="catatan-admin"><h6>Catatan Admin</h6></label>
                <textarea class="form-item" type="text" id="catatan-admin" rows="6" placeholder="" required></textarea>
            </div>
        </div>
        <div class="flex-4 biodata-info scrollable">
            <form id="" class="flex gap">
                <div class="flex">
                    <!-- Form - Table Layout -->
                    <div class="flex-1">
                        <div class="content-padding-no-top">
                            <table>
                                <!-- Form - Text Input -->
                                <tr><td width="180px">ID Pengguna</td>
                                    <td><input class="form-item" type="text" name="nama_anak" value="Slot" required></td></tr>
                                <tr><td>ID Pendaftaran</td>
                                    <td><input class="form-item" type="text" name="panggilan_anak" required></td></tr>
                                <tr><td>Mendaftar Pada</td>
                                    <td><input class="form-item" type="text" name="panggilan_anak" required></td></tr>
                            </table>
                        </div>
                        <div class="content-padding-no-top">
                            <h6>Data Anak</h6>
                            <table>
                                <!-- Form - Text Input -->
                                <tr><td width="180px">Nama</td>
                                    <td><input class="form-item" type="text" name="nama_anak" value="Slot" required></td></tr>
                                <tr><td>Nama Panggilan</td>
                                    <td><input class="form-item" type="text" name="panggilan_anak" required></td></tr>
                                <!-- Form - Radiobutton -->
                                <tr><td>Jenis Kelamin</td>
                                    <td>
                                        <label><input class="form-item" type="radio" name="gender" value="1">&nbsp;Laki-Laki</label>&nbsp;
                                        <label><input class="form-item" type="radio" name="gender" value="2" checked>&nbsp;Perempuan</label>&nbsp;
                                    </td></tr>
                                <tr><td>Tempat Lahir</td>
                                    <td><input class="form-item" type="text" name="tempat_lahir" required></td></tr>
                                <tr><td>Tanggal Lahir</td>
                                    <td><input class="form-item" type="date" name="tanggal_lahir" required></td></tr>
                                <!-- Form - Select Dropdown -->
                                <tr><td>Agama</td>
                                    <td><select class="form-item" name="agama" required>
                                            <option value="">--</option>
                                            <option value="1">Islam</option>
                                            <option value="2">Katolik</option>
                                            <option value="3">Protestan</option>
                                            <option value="4">Hindu</option>
                                            <option value="5">Budha</option>
                                            <option value="6">Khonghucu</option>
                                        </select></td></tr>
                                <tr><td>Kewarganegaraan</td>
                                    <td><select class="form-item" name="kewarganegaraan" required>
                                            <option value="">--</option>
                                            <option value="1">WNI</option>
                                            <option value="2">WNA</option>
                                        </select></td></tr>
                                <!-- Form - Textarea -->
                                <tr><td>Alamat</td>
                                    <td><textarea class="form-item" type="text" name="alamat_anak" rows="4" cols="23" required></textarea></td></tr>
                                <tr><td>Status Tinggal</td>
                                    <td><select class="form-item" name="status_tinggal" required>
                                            <option>--</option>
                                            <option>Bersama Orang Tua</option>
                                            <option>Wali</option>
                                            <option>Panti Asuhan</option>
                                            <option>Lainnya</option>
                                        </select></td></tr>
                                <tr><td>Bahasa di Rumah</td>
                                    <td>
                                        <select class="form-item" name="bahasa_rumah" required>
                                            <option value="">--</option>
                                            <option value="1">Bahasa Indonesia</option>
                                            <option value="2">Bahasa Daerah</option>
                                            <option value="3">Bahasa Asing</option>
                                        </select></td></tr>
                                <!-- Form - Number Input -->
                                <tr><td>Anak Ke-</td>
                                    <td><input class="form-item" type="number" name="anak_ke" min="1" required></td></tr>
                                <tr><td>Saudara Kandung</td>
                                    <td><input class="form-item" type="number" name="saudara_kandung" min="0" required></td></tr>
                                <tr><td>Saudara Tiri</td>
                                    <td><input class="form-item" type="number" name="saudara_tiri" min="0" required></td></tr>
                                <tr><td>Saudara Angkat</td>
                                    <td><input class="form-item" type="number" name="saudara_angkat" min="0" required></td></tr>
                                <tr><td>Berat Badan</td>
                                    <td><input class="form-item" type="number" name="berat_badan" required></td></tr>
                                <tr><td>Tinggi Badan</td>
                                    <td><input class="form-item" type="number" name="tinggi_badan" required></td></tr>
                                <tr><td>Golongan Darah</td>
                                    <td>
                                        <select class="form-item" name="gol_darah" required>
                                            <option value="">--</option>
                                            <option value="1">A</option>
                                            <option value="2">B</option>
                                            <option value="3">O</option>
                                            <option value="4">AB</option>
                                            <option value="5">Belum Periksa</option>
                                        </select></td></tr>
                                <tr><td>Riwayat Penyakit</td>
                                    <td><input class="form-item" type="text" name="penyakit" required></td></tr>
                                <tr><td>Mendaftar Sebagai</td>
                                    <td>
                                        <select class="form-item" name="daftar_sebagai" required>
                                            <option value="1">Murid Baru</option>
                                            <option value="2">Murid Pindahan</option>
                                        </select></td></tr>
                                <tr><td>Sekolah Lama</td>
                                    <td><input class="form-item" type="text" name="sekolah_lama"></td></tr>
                                <!-- Form - Date Input -->
                                <tr><td>Tanggal Pindah</td>
                                    <td><input class="form-item" type="date" name="tanggal_keluar"></td></tr>
                                <tr><td>Dari Kelompok</td>
                                    <td>
                                        <select class="form-item" name="kelompok_keluar">
                                            <option value="">--</option>
                                            <option value="1">TK A</option>
                                            <option value="2">TK B</option>
                                        </select></td></tr>
                                <tr><td>Tanggal Diterima</td>
                                    <td><input class="form-item" type="date" name="tanggal_masuk"></td></tr>
                                <tr><td>Di Kelompok</td>
                                    <td><select class="form-item" name="kelompok_masuk">
                                            <option value="">--</option>
                                            <option value="1">TK A</option>
                                            <option value="2">TK B</option>
                                        </select></td></tr>
                            </table>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="content-padding-no-top">
                            <h6>Data Orang Tua</h6>
                            <table>
                                <tr><td width="180px">Nama</td>
                                    <td><input class="form-item" type="text" name="nama_ayah" ></td></tr>
                                <tr><td>Pendidikan</td>
                                    <td><select class="form-item" name="pendidikan_ayah" required>
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
                                        </select></td></tr>
                                <tr><td>Pekerjaan</td>
                                    <td><select class="form-item" name="pekerjaan_ayah" title="">
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
                                        </select></td></tr>
                                <tr><td>Alamat</td>
                                    <td><textarea class="form-item" type="text" name="alamat_ayah" rows="4" cols="23" required></textarea>
                                    </td></tr>
                                <tr><td>Nomor HP</td>
                                    <td><input class="form-item" type="text" name="hp_ayah">
                                    </td></tr>
                            </table>
                        </div>
                        <div class="content-padding-no-top">
                            <h6>Data Ibu</h6>
                            <table>
                                <tr><td width="180px">Nama</td>
                                    <td><input class="form-item" type="text" name="nama_ayah" ></td></tr>
                                <tr><td>Pendidikan</td>
                                    <td><select class="form-item" name="pendidikan_ayah" required>
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
                                        </select></td></tr>
                                <tr><td>Pekerjaan</td>
                                    <td><select class="form-item" name="pekerjaan_ayah" title="">
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
                                        </select></td></tr>
                                <tr><td>Alamat</td>
                                    <td><textarea class="form-item" type="text" name="alamat_ayah" rows="4" cols="23" required></textarea>
                                    </td></tr>
                                <tr><td>Nomor HP</td>
                                    <td><input class="form-item" type="text" name="hp_ayah">
                                    </td></tr>
                            </table>
                        </div>
                        <div class="flex">
                            <div class="content-padding-no-top">
                                <h6>Kartu Keluarga</h6>
                                <table>
                                    <td><img src="https://placehold.co/160x120?text=Dummy+Image" alt="container image"></td>
                                </table>
                            </div>
                            <div class="content-padding-no-top">
                                <h6>Akta Kelahiran</h6>
                                <table>
                                    <td><img src="https://placehold.co/160x120?text=Dummy+Image" alt="container image"></td>
                                </table>
                            </div>
                            <div class="content-padding-no-top">
                                <h6>KTP Orang Tua</h6>
                                <table>
                                    <td><img src="https://placehold.co/160x120?text=Dummy+Image" alt="container image"></td>
                                </table>
                            </div>
                            <div class="content-padding-no-top">
                                <h6>Kartu Keluarga</h6>
                                <table>
                                    <td><img src="https://placehold.co/160x120?text=Dummy+Image" alt="container image"></td>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</x-layouts.app-layout>
