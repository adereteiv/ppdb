<x-layouts.app-layout>

<div id="admin-ppdb-buat" class="app-content wrapper">
    <div class="content-title margin-vertical">Buka Gelombang PPDB</div>
    <form id="ppdbCreate" class="ppdb-buat scrollable flex">
        <div class="content-padding gap content-margin-right ">
            <div class="inputbox">
                <label class="" for="tahunajar"><h6>Tahun Ajaran</h6></label>
                <input class="form-item" type="text" id="tahunajar" placeholder="" required>
            </div>
            <div class="inputbox">
                <label class="" for="gelombang"><h6>Gelombang</h6></label>
                <textarea class="form-item" type="text" id="gelombang" required></textarea>
            </div>
            <div class="inputbox">
                <label class="" for="jadwal"><h6>Periode Pendaftaran</h6></label>
                <div class="flex justify-center">
                    <input class="form-item" type="datetime-local" id="jadwal" name="" placeholder="">
                    <span style="margin:5px;">&nbsp;sampai dengan&nbsp;</span>
                    <input class="form-item" type="datetime-local" id="jadwal" name="" placeholder="">
                </div>
            </div>
            <div class="inputbox">
                <label class="" for="jadwal"><h6>Periode Evaluasi<font color="#ff6d00"> (PPDB otomatis tertutup)</font></h6></label>
                <input class="form-item" type="datetime-local" id="jadwal" name="" placeholder="">
            </div>
        </div>
        <div class="flex-1 content-padding flex flex-nowrap flex-col">
            <div class="flex justify-between">
                <h6>Atur Syarat Dokumen</h6>
                <div class="flex">
                    <button class="tombol-mini tombol-netral" alt="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="16px" width="16px"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                        Edit
                    </button>
                    <button class="tombol-mini tombol-netral" alt="Tambah"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                        Tambah
                    </button>
                </div>
            </div>
            <div class="frame scrollable flex gap">
                <!-- Example document requirements -->
                <div class="checkmenu">
                    <input id="checkbox1" type="checkbox" value="test">
                    <div>
                        <label for="checkbox1">
                            <h6>Nama Dokumen</h6>
                            <p>Keterangan dokumen</p>
                        </label>
                        <div>
                            <input id="wajib1" type="checkbox" value="test"><label for="wajib1"> wajib</label>
                        </div>
                        <!-- Shows by javascript -->
                        <div class="flex" style="display: slot;">
                            <button class="tombol-mini tombol-positif">&#x2714; Simpan</button>
                            <button class="tombol-mini tombol-negatif">&#10006; Batal</button>
                        </div>
                    </div>
                </div>
                <div class="checkmenu">
                    <input id="checkbox2" type="checkbox" value="test">
                    <div>
                        <label for="checkbox2">
                            <h6>Nama Dokumen</h6>
                            <p>Keterangan dokumen</p>
                        </label>
                        <div>
                            <form action="">
                                <input id="wajib2" type="radio" name="is_wajib"><label for="wajib2"> wajib</label>
                                <input id="opsional2" type="radio" name="is_wajib"><label for="opsional2"> opsional</label>
                            </form>
                            <!-- Shows by javascript -->
                            <div class="flex" style="display: slot;">
                                <button class="tombol-mini tombol-positif">&#x2714; Simpan</button>
                                <button class="tombol-mini tombol-negatif">&#10006; Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="checkmenu">
                    <input id="checkbox2" type="checkbox" value="test">
                    <div>
                        <label for="checkbox2">
                            <h6>Nama Dokumen</h6>
                            <p>Keterangan dokumen dokumen dokumen dokumen dokumen</p>
                        </label>
                        <div>
                            <form action="">
                                <input id="wajib2" type="radio" name="is_wajib"><label for="wajib2"> wajib</label>
                                <input id="opsional2" type="radio" name="is_wajib"><label for="opsional2"> opsional</label>
                            </form>
                            <!-- Shows by javascript -->
                            <div class="flex" style="display: slot;">
                                <button class="tombol-mini tombol-positif">&#x2714; Simpan</button>
                                <button class="tombol-mini tombol-negatif">&#10006; Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="checkmenu">
                    <input id="checkbox2" type="checkbox" value="test">
                    <div>
                        <label for="checkbox2">
                            <h6>Nama Dokumen</h6>
                            <p>Keterangan dokumen dokumen dokumen dokumen dokumen</p>
                        </label>
                        <div>
                            <form action="">
                                <input id="wajib2" type="radio" name="is_wajib"><label for="wajib2"> wajib</label>
                                <input id="opsional2" type="radio" name="is_wajib"><label for="opsional2"> opsional</label>
                            </form>
                            <!-- Shows by javascript -->
                            <div class="flex" style="display: slot;">
                                <button class="tombol-mini tombol-positif">&#x2714; Simpan</button>
                                <button class="tombol-mini tombol-negatif">&#10006; Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="margin-vertical text-align-center">
        <button type="submit" class="tombol-besar tombol-netral" form="ppdbCreate">Simpan</button>
    </div>
</div>

</x-layouts.app-layout>
