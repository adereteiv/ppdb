<form id="tambahSyaratDokumenForm" method="POST" action="{{ route('admin.ppdb.buat.syaratDokumen.store') }}">@csrf
    <div class="content-padding-rem">
        <x-inputbox class="padding-10" for="dokumen">
            <x-slot:label><h6>Tambah Syarat Dokumen Baru</h6></x-slot>
            <x-input type="text" name="nama_dokumen" class="content-margin-top" id="dokumen" placeholder="Nama Dokumen"/>
            <p id="dokumen-error" class="flex flex-start teks-negatif"></p>
        </x-inputbox>
        <div class="margin-vertical text-align-center">
            <button type="submit" class="tombol-besar tombol-netral">Tambah</button>
        </div>
    </div>
</form>
