@props(['button' => null, 'clicker' => null])

<div x-data="{open: false}" class="dropdown position-relative">
    @if ($button)
        <button class="tombol tombol-netral" @click="open = !open" @click.outside="open = false">
            {{ $button }}
        </button>
    @else
        {{ $clicker }}
    @endif
    <div x-show="open" {{ $attributes->merge(['class' => 'dropdown-list position-absolute flex flex-col padding-0']) }}>
        {{ $slot }}
    </div>
</div>
