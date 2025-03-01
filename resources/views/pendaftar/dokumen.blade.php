<x-layouts.app-layout>

<div id="pendaftar-kirim-dokumen" class="app-content wrapper">
    <div class="content-title margin-vertical">Unggah Dokumen Persyaratan</div>
    <div class="scrollable">
        <div class="constrict">
            <form method="post" action="">
                @foreach ($syarat_dokumen as $dokumen)
                <div class="inputbox">
                    <label for="id">
                        {{$tipe_dokumen->tipe}}
                        <span class="subtext">
                            @if ($is_wajib -> true)
                            <font color="#FF0000">*</font>
                            @elseif ($if_wajib -> false)
                            "(opsional)"
                            @endif
                        </span>
                        <span class="subtext">
                            @if ($keterangan -> null)

                            @else
                            {{ $syarat_dokumen -> keterangan }}
                            @endif
                        </span>
                    </label>
                    <input type="file" id="id" class="" hidden required>
                    <label for="aktalahir">
                        <div class="inputbox-y form-item">Telusuri</div>
                        <div class="inputbox-x form-item">Pilih Berkas</div>
                    </label>
                </div>
                @endforeach

                <div class="inputbox">
                    <label for="aktalahir">
                        Akta Kelahiran Anak
                        <span class="subtext">{Slot if_wajib=1 -> <font color="#FF0000">*</font>}{if_wajib=0 -> (opsional)}</span>
                        <span class="subtext">{Slot, if_keterangan=null->shows nothing}</span>
                    </label>
                    <input type="file" id="aktalahir" class="" hidden required>
                    <label for="aktalahir">
                        <div class="inputbox-y form-item">Telusuri</div>
                        <div class="inputbox-x form-item">Pilih Berkas</div>
                    </label>
                </div>

                <div class="inputbox">
                    <label for="dokumen">
                        Kartu Keluarga
                        <span class="subtext">(opsional)</span>
                        <span class="subtext">Satu saja : Ayah / Ibu / Wali</span>
                    </label>
                    <input type="file" id="dokumen" class="" hidden>
                    <label for="dokumen" class="">
                        <div class="inputbox-y form-item">Telusuri</div>
                        <div class="inputbox-x form-item">Pilih Berkas</div>
                    </label>
                </div>

                <div class="margin-vertical text-align-center">
                    <input id="uploadBtn" class="tombol-besar" type="submit" value="Simpan" disabled>
                </div>
            </form>
        </div>
    </div>
</div>

</x-layouts.app-layout>
