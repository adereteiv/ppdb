<x-layouts.app-layout>

<div id="pendaftar-beranda" class="app-content gap">
    <div class="wrapper">
        <x-partials.app-content-title :hideBackLink="true">
            <h5>Status Pendaftaran :&nbsp;</h5>
            <x-status-pendaftaran class="flex align-items-center" :value="$pendaftaran->status ?? null"/>
        </x-partials.app-content-title>
        <div class="content-padding-side-rem">
            @if ($pendaftaran->status === 'Lengkap')
                <x-flash-message flash='green' icon='success'>Pendaftaran Anda sudah lengkap, kami akan segera melakukan validasi kebenaran data Anda.</x-flash-message>
            @elseif ($pendaftaran->status === 'Terverifikasi')
                <x-flash-message flash='blue' icon='success'>Pendaftaran Anda sudah divalidasi, silakan menunggu pengumuman daftar peserta didik dan tanggal masuk akan segera diumumkan.</x-flash-message>
            @endif
            <x-flash-message class="bg-blue" icon>
                @if ($batch && now() >= $batch->waktu_tenggat)
                    <p>Masa pendaftaran sudah lewat. Hubungi operator jika ingin melakukan perubahan data pendaftaran.</p>
                @else
                    <p>Silakan menekan pilihan tombol berikut untuk melengkapi pendaftaran Anda.</p>
                    <p>Indikator akan menyala ketika data sudah tersimpan.</p>
                @endif
            </x-flash-message>
        </div>
        <div class="list-stepper flex gap scrollable content-padding-side-rem content-padding-bottom-rem">
            <a class="flex-1 {{ $buktiBayarLengkap ? 'active' : '' }}" href="{{ route('pendaftar.buktiBayar') }}"><li class="content-padding {{ $buktiBayarLengkap ? 'active' : '' }}">1. Bukti Pembayaran</li></a>
            <a class="flex-1 {{ $formulirLengkap ? 'active' : '' }}" href="{{ route('pendaftar.formulir') }}"><li class="content-padding {{ $formulirLengkap ? 'active' : '' }}">2. Formulir Pendaftaran</li></a>
            <a class="flex-1 {{ $dokumenLengkap ? 'active' : '' }}" href="{{ route('pendaftar.dokumen') }}"><li class="content-padding {{ $dokumenLengkap ? 'active' : '' }}">3. Dokumen Persyaratan</li></a>
        </div>
    </div>

    {{-- Pengumuman refer to DashboardController, where status = 'Khusus Pendaftar' --}}
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
                <h5>Tata Cara Pendaftaran</h5>
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
