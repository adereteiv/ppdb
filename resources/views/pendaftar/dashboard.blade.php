<x-layouts.app-layout>

<div id="pendaftar-beranda" class="app-content gap">
    <div class="wrapper">
        <x-partials.app-content-title :hideBackLink="true">
            <h5>Status Pendaftaran :&nbsp;</h5>
            <x-status-pendaftaran class="flex align-items-center" :value="$pendaftaran->status ?? null"/>
        </x-partials.app-content-title>
        <div class="stepper scrollable content-padding-side-rem content-padding-bottom-rem">
            <li class="content-padding {{ $buktiBayarLengkap ? 'active' : '' }}">Bukti Pembayaran</li>
            <li class="content-padding {{ $formulirLengkap ? 'active' : '' }}">Formulir Pendaftaran</li>
            <li class="content-padding {{ $dokumenLengkap ? 'active' : '' }}">Dokumen Persyaratan</li>
        </div>
    </div>
    @isset($pengumuman)
        <div class="wrapper">
            <x-pengumuman-preview
                :jadwal="$pengumuman->jadwal_posting"
                :judul="$pengumuman->judul"
                :keterangan="$pengumuman->keterangan"
                :file="$pengumuman->file_paths"
            />
        </div>
    @endisset
    <div class="flex gap">
        <div class="wrapper flex-1">
            <x-partials.app-content-title :hideBackLink="true">
                <h5>Prosedur Pendaftaran</h5>
            </x-partials.app-content-title>
            <div class="content-padding-side-rem content-padding-bottom">
                <x-partials.list-alur-pendaftaran/>
            </div>
        </div>
        <div class="wrapper flex-1">
            <x-partials.app-content-title :hideBackLink="true">
                <h5>Syarat & Ketentuan</h5>
            </x-partials.app-content-title>
            <div class="content-padding-side-rem content-padding-bottom">
                <x-partials.list-syarat-pendaftaran/>
            </div>
        </div>
    </div>
</div>

</x-layouts.app-layout>
