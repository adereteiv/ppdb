@props(['search' => '', 'menu' => '', 'colgroup' => '', 'thead' => '', 'pagination' => false])

<div {{ $attributes->merge(['class'=>'content-padding-bottom-rem content-padding-side-rem gap']) }}>
    <hr style="border: 1px solid rgba(0, 0, 0, .15);">

    <div class="flex justify-between">
        {{-- SearchBar --}}
        {{ $search }}

        {{-- Menu --}}
        {{ $menu }}
    </div>
    <div class="scrollable">
        <table class="alternate fixed">
            <colgroup>
               {{ $colgroup }}
            </colgroup>
            <thead>
                <tr>
                    {{ $thead }}
                </tr>
            </thead>
            <tbody id="tableBody">
                {{ $slot }}
            </tbody>
        </table>
    </div>
    {{ $pagination }}
</div>

{{--
<x-table-list>
    <x-slot:menu></x-slot:menu>
    <x-slot:search></x-slot:search>
    <x-slot:css></x-slot:css>
    <x-slot:colgroup></x-slot:colgroup>
    <x-slot:thead></x-slot:thead>
</x-table-list>
--}}
