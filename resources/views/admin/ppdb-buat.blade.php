<x-layouts.app-layout>

<div id="admin-ppdb-buat" class="app-content wrapper">
    <div class="content-title margin-vertical">Buka Gelombang PPDB</div>
    <form id="ppdbBuat" method="post" action="/admin/ppdb/buat" class="ppdb-buat scrollable flex">@csrf
        <div class="flex-1 content-padding gap content-margin-right ">
            {{-- <script>
                function ppdbForm(options, existingBatches) {
                    return {
                        tahunAjaran: "",
                        gelombang: "",

                        incrementGelombang() {
                            if (!this.tahunAjaran) {
                                this.gelombang = "";
                                return;
                            }

                            if (existingBatches[this.tahunAjaran]) {
                                let latestGelombang = existingBatches[this.tahunAjaran].slice(-1)[0].gelombang;
                                this.gelombang = latestGelombang + 1;
                            } else {
                                this.gelombang = 1;
                            }
                        }
                    };
                }
            </script> --}}
            <div>
                 {{-- x-data="ppdbForm({{ json_encode($options) }}, {{ json_encode($existingBatch) }})"> --}}
                <x-inputbox for="tahun_ajaran">
                    <x-slot:label><h6>Tahun Ajaran</h6></x-slot>
                    <x-input-select name="tahun_ajaran" :options="$options" class="form-item" id="tahun_ajaran" required
                    {{-- x-model="tahunAjaran" @change="incrementGelombang"  --}}
                    />
                </x-inputbox>
                <x-inputbox for="gelombang">
                    <x-slot:label><h6>Gelombang</h6></x-slot>
                    <x-input type="text" name="gelombang" class="form-item" id="gelombang" disabled required
                    {{-- x-model="gelombang" --}}
                    />
                </x-inputbox>
                <script type="application/json" id="gelombangData">
                    {!! json_encode($gelombang) !!}
                </script>
            </div>

            <script>
                function ppdbDateValidation() {
                    return {
                        minMulai: "",
                        // maxMulai: "",
                        waktuMulai: "",
                        waktuTenggat: "",
                        waktuTutup: "",

                        init() {
                            this.updateMinMulai();
                        },

                        updateMinMulai() {
                            let now = new Date();
                            let offset = now.getTimezoneOffset() * 60000;
                            let localTime = new Date(now.getTime() - offset).toISOString().slice(0, 16);

                            this.minMulai = localTime;
                            // this.waktuMulai = localTime; //Sets waktu_mulai to current time

                            // let maxDate = new Date(now);
                            // maxDate.setUTCMonth(now.getUTCMonth() + 4);
                            // this.maxMulai = maxDate.toISOString().slice(0, 16);
                        },

                        get minTenggat() {
                            if (!this.waktuMulai) return this.minMulai;
                            let date = new Date(this.waktuMulai);
                            date.setUTCMonth(date.getUTCMonth() + 1);
                            return date.toISOString().slice(0, 16);
                        },

                        get maxTenggat() {
                            if (!this.waktuMulai) return this.MinMulai;
                            let date = new Date(this.waktuMulai);
                            date.setUTCMonth(date.getUTCMonth() + 4);
                            return date.toISOString().slice(0, 16);
                        }
                    };
                }
            </script>
            <div x-data="ppdbDateValidation()">
                <x-inputbox for="jadwal">
                    <x-slot:label><h6>Periode Pendaftaran</h6></x-slot>
                    <div class="flex justify-center">
                        <x-input type="datetime-local" name="waktu_mulai" class="form-item" id="jadwal" required
                        x-model="waktuMulai"
                        x-bind:min="minMulai"
                        {{-- x-bind:max="maxMulai" --}}
                        />
                        <span style="margin:5px;">&nbsp;sampai dengan&nbsp;</span>
                        <x-input type="datetime-local" name="waktu_tenggat" class="form-item" id="jadwal" required
                        x-model="waktuTenggat"
                        x-bind:min="minTenggat"
                        x-bind:max="maxTenggat"
                        />
                    </div>
                </x-inputbox>
                <x-inputbox for="waktu_tutup">
                    <x-slot:label><h6>Periode Evaluasi<font color="#ff6d00"> (PPDB otomatis tertutup)</font></h6></x-slot>
                    <x-input type="datetime-local" name="waktu_tutup" class="form-item" id="waktu_tutup"
                    x-model="waktuTutup"
                    x-bind:min="waktuTenggat"
                    x-bind:disabled="!waktuTenggat"
                    />
                </x-inputbox>
            </div>
        </div>
        <div class="flex-1 content-padding flex flex-nowrap flex-col">
            <div class="flex justify-between">
                <h6>Atur Syarat Dokumen</h6>
                <div class="flex">
                    <button type="button" class="tombol-mini tombol-netral" alt="Tambah" data-url="/admin/ppdb/buat/syarat-dokumen">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                        Tambah
                    </button>
                </div>
            </div>
            <div class="frame scrollable flex gap">
                @foreach ($syaratDokumen as $syarat)
                @php
                    $label = $syarat->tipeDokumen->tipe;
                    $name = Str::slug($label, '_');
                @endphp
                <div class="checkmenu">
                    <input id="checkbox{{ $name }}" type="checkbox" name="include[{{ $name }}]" value="{{ $syarat->tipeDokumen->id }}">
                    <div>
                        <x-inputbox for="keterangan_{{ $name }}">
                            <x-slot:label><h6>{{ $syarat->tipeDokumen->id }}. {{ $label }}</h6></x-slot>
                            <p>Keterangan :</p>
                            <textarea id="keterangan_{{ $name }}" name="keterangan[{{ $name }}]" class="form-item" required>{{ $syarat->keterangan }}</textarea>
                        </x-inputbox>
                        <div>
                            <input id="wajib{{ $name }}" type="checkbox" name="is_wajib[{{ $name }}]" value="1" {{ $syarat->is_wajib ? 'checked' : '' }}><label for="wajib{{ $syarat->id }}"> Wajibkan</label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </form>
    <div class="margin-vertical text-align-center">
        <button type="submit" class="tombol-besar tombol-netral" form="ppdbBuat">Simpan</button>
    </div>
</div>

<x-modal/>

</x-layouts.app-layout>
