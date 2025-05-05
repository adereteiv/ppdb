<x-layouts.app-layout>

@if (session()->has('success'))
<x-flash-message alert="green">{{ session('success') }}</x-flash-message>
@endif

<div id="admin-ppdb-buat" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title>
            <x-slot:backLink>/admin/ppdb</x-slot:backLink>
            <x-slot:title><h6>Buka Gelombang PPDB</h6></x-slot:title>
        </x-partials.app-content-title>
        {{-- <div class="content-title content-padding"><h3>Buka Gelombang PPDB</h3></div> --}}
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="content-padding-bottom content-padding-side-rem">
            <form id="ppdbBuat" method="POST" action="{{ route('admin.ppdb.buat.store') }}" class="ppdb-buat scrollable flex">@csrf
                <div class="flex-1 content-padding gap">
                    <div>
                        <x-inputbox for="tahun_ajaran" class="content-padding-bottom">
                            <x-slot:label><b>Tahun Ajaran</b></x-slot>
                            <x-input-select name="tahun_ajaran" :options="$options" id="tahun_ajaran" required/>
                        </x-inputbox>
                        <x-inputbox for="gelombang" class="content-padding-top content-padding-bottom">
                            <x-slot:label><b>Gelombang</b></x-slot>
                            <x-input type="text" name="gelombang" id="gelombang" readonly required/>
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
                        <x-inputbox for="jadwal" class="content-padding-top content-padding-bottom">
                            <x-slot:label><b>Periode Pendaftaran</b></x-slot>
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
                        <x-inputbox for="waktu_tutup" class="content-padding-top">
                            <x-slot:label><b>Periode Evaluasi<font color="#ff6d00"> (PPDB otomatis tertutup)</font></b></x-slot>
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
                        <b>Atur Syarat Dokumen</b>
                        <div class="flex">
                            <button type="button" class="tombol-mini tombol-netral" alt="Tambah" data-url="{{ route('admin.ppdb.buat.syaratDokumen') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
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
    </div>
</div>

</x-layouts.app-layout>
