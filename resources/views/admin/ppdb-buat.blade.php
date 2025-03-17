<x-layouts.app-layout>

@if(session()->has('success'))
<x-flash-message class="alert" flash="green">{{ session('success') }}</x-flash-message>
@endif

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
                    <x-input-select name="tahun_ajaran" :options="$options" id="tahun_ajaran" required
                    {{-- x-model="tahunAjaran" @change="incrementGelombang"  --}}
                    />
                </x-inputbox>
                <x-inputbox for="gelombang">
                    <x-slot:label><h6>Gelombang</h6></x-slot>
                    <x-input type="text" name="gelombang" id="gelombang" readonly required
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
                        <x-input type="datetime-local" name="waktu_mulai" id="jadwal" required
                        x-model="waktuMulai"
                        x-bind:min="minMulai"
                        {{-- x-bind:max="maxMulai" --}}
                        />
                        <span style="margin:5px;">&nbsp;sampai dengan&nbsp;</span>
                        <x-input type="datetime-local" name="waktu_tenggat" id="jadwal" required
                        x-model="waktuTenggat"
                        x-bind:min="minTenggat"
                        x-bind:max="maxTenggat"
                        />
                    </div>
                </x-inputbox>
                <x-inputbox for="waktu_tutup">
                    <x-slot:label><h6>Periode Evaluasi<font color="#ff6d00"> (PPDB otomatis tertutup)</font></h6></x-slot>
                    <x-input type="datetime-local" name="waktu_tutup" id="waktu_tutup"
                    x-model="waktuTutup"
                    x-bind:min="waktuTenggat"
                    x-bind:disabled="!waktuTenggat"
                    />
                </x-inputbox>
            </div>
        </div>
        <section class="flex-1 content-padding flex flex-nowrap flex-col">
            <div class="flex justify-between">
                <h6>Atur Syarat Dokumen</h6>
                <div class="flex">
                    <button type="button" class="tombol-mini tombol-netral" alt="Tambah" data-url="/admin/ppdb/buat/syarat-dokumen">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20px" width="20px"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                        Tambah
                    </button>
                </div>
            </div>

            @php
            $asc = $tipeDokumen->isNotEmpty() && $tipeDokumen->first()->id < $tipeDokumen->last()->id;
            @endphp
            <div class="frame scrollable flex gap" data-sorting="{{ $asc ? 'asc' : 'desc' }}">
                @foreach ($tipeDokumen as $index => $tipe)
                    @php
                        $label = $tipe->tipe;
                        $name = Str::slug($label, '_');
                        $syarat = $tipe->syaratDokumen->first();
                        $num = $asc ? $index + 1 : count($tipeDokumen) - $index;
                    @endphp
                    <x-checkmenu
                        checkboxName="include[{{ $label }}]" checkboxId="checkbox_{{ $label }}" checkboxValue="{{ $tipe->id }}"
                        label="{{ $num }}. {{ $label }}"
                        keteranganName="keterangan[{{ $label }}]" keteranganId="keterangan_{{ $label }}" keterangan="{{ $syarat ? $syarat->keterangan : '' }}"
                        wajibName="is_wajib[{{ $label }}]" wajibId="wajib_{{ $label }}" wajibChecked="{{ $syarat && $syarat->is_wajib ? 'checked' : '' }}"
                    />
                @endforeach
            </div>
        </section>
    </form>
    <div class="margin-vertical text-align-center">
        <button type="submit" class="tombol-besar tombol-netral" form="ppdbBuat">Simpan</button>
    </div>
</div>

<x-modal/>

</x-layouts.app-layout>
