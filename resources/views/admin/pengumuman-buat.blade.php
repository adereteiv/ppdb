<x-layouts.app-layout>
<div id="admin-pengumuman-buat" class="app-content wrapper">
    <div class="content-title margin-vertical">Buat Pengumuman</div>
    <div class="scrollable constrict">
        <form method="post" action="">
            <div class="inputbox">
                <label for="judul">Judul Pengumuman</label>
                <input class="form-item" type="text" id="judul" placeholder="" required="">
            </div>
            <div class="inputbox">
                <label for="keterangan">Keterangan Pengumuman</label>
                <textarea class="form-item" type="text" id="keterangan" rows="4" required=""></textarea>
            </div>
            <div class="inputbox">
                <label for="dokumen">Dokumen Pelengkap (opsional)</label>
                <input type="file" id="dokumen" class="" hidden="">
                <label for="dokumen" class="">
                    <div class="inputbox-y form-item">Telusuri</div>
                    <div class="inputbox-x form-item">Pilih Berkas</div>
                </label>
            </div>
            <div class="inputbox">
                <label for="jadwal">Jadwalkan (opsional)</label>
                <input class="form-item" type="datetime-local" id="jadwal" placeholder="">
            </div>
            <div class="content-padding-vertical text-align-center">
                <input id="" class="tombol-besar tombol-netral" type="submit" value="Simpan" disabled="">
            </div>
        </form>
    </div>
</div>
</x-layouts.app-layout>
