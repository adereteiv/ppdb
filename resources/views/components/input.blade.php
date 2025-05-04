@props(['name' => '', 'value' => '', 'type' => 'text'])

<input type="{{ $type }}" name="{{ $name }}"
{{ $attributes->merge(['class'=>'form-item']) }}
value="{{ old($name, $value) }}"

@if ($type == 'number')
step="1" min="0" max="200"
@endif

@if ($type == 'tel')
placeholder="Contoh: +6289912345678"
pattern="(?:\+?\d{1,3})?[ \-]?\d{10,15}"
@endif

@if ($type == 'date')
    @if ($name == 'tanggal_pindah')
        x-data="() => {
            const today = new Date().toISOString().split('T')[0];
            const minDate = new Date(new Date().setFullYear(new Date().getFullYear() - 4)).toISOString().split('T')[0];
            return {
            today,
            maxDate: today,
            minDate,
            errorMessage: ''
            };
        }"

        x-bind:max="maxDate" x-bind:min="minDate"
        @input="
            errorMessage = '';
            let selectedDate = new Date($event.target.value);
            let maxDateObject = new Date(maxDate);
            let minDateObject = new Date(minDate);

            if (selectedDate > maxDateObject) {
                errorMessage = 'Tanggal pindah tidak bisa di masa depan.';
            } else if (selectedDate <= minDateObject) {
                errorMessage = 'Tanggal pindah melebihi kriteria minimal umur.';
            }
        "
    @elseif ($name == 'tanggal_lahir')
        x-data="{
            today: new Date().toISOString().split('T')[0],
            maxDate: new Date(new Date().setFullYear(new Date().getFullYear() - 4)).toISOString().split('T')[0],
            minDate: new Date(new Date().setFullYear(new Date().getFullYear() - 7)).toISOString().split('T')[0],
            errorMessage: ''
        }"
        x-bind:max="maxDate" x-bind:min="minDate"
        @input="
            errorMessage = '';
            let selectedDate = new Date($event.target.value);
            let maxDateObject = new Date(maxDate);
            let minDateObject = new Date(minDate);

            if (selectedDate > maxDateObject) {
                errorMessage = 'Anak harus berusia minimal 4 tahun.';
            } else if (selectedDate <= minDateObject) {
                errorMessage = 'Anak tidak boleh berusia 7 tahun atau lebih.';
            }
        "
    @endif
@endif
/>

@error($name)
<br><p class="flex flex-start teks-negatif">{{ $message }}</p>
@enderror

{{--
<x-input name="nama_anak" value="$infoAnak->nama_anak ?? ''" />
<x-input name="email" type="email" class="bg-gray-200 border rounded" />
<x-input name="password" type="password" class="border-red-500" placeholder="Enter your password" />
--}}
