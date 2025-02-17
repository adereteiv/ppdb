<div {{ $attributes->merge(['class' => 'form-login_item flex justify-between reminder margin-vertical'])}} x-data="{ show: true }" x-show="show" >
    <span class="flex-1 align-self-center">
        {{ $slot }}
    </span>
    <div><button class="tombol tombol-negatif" @click="show = false"><i class="bi bi-x-lg"></i></button></div>
</div>
