<form method="post" action="admin/ppdb/buat/syarat-dokumen">@csrf
    <x-inputbox for="dokumen">
        <x-slot:label><h6>Nama Dokumen</h6></x-slot>
        <x-input type="text" name="nama_dokumen" class="form-item" id="dokumen"/>
    </x-inputbox>
    <x-inputbox for="keterangan">
        <x-slot:label><h6>Keterangan</h6></x-slot>
        <textarea name="keterangan" class="form-item" id="keterangan"></textarea>
    </x-inputbox>
    <div class="margin-vertical text-align-center">
        <button type="submit" class="tombol-besar tombol-netral">Tambah</button>
    </div>
</form>
