@props(['id' => null, 'buttonDataAttributes' => null])

<div @if ($id) id="{{ $id }}" @endif class="modal overlay">
    <div class="modal-content flex flex-col" role="dialog">
        <div class="flex justify-flex-end content-margin-bottom-10">
            <button {{ $buttonDataAttributes }} class="modal-button flex flex-center tombol-blank">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="24px" width="24px"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg>
                {{-- <svg width="24" height="24" viewBox="0 0 20 20"><path d="M10 10l5.09-5.09L10 10l5.09 5.09L10 10zm0 0L4.91 4.91 10 10l-5.09 5.09L10 10z" stroke="currentColor" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg> --}}
            </button>
        </div>
        {{-- <div class="modal-body"> --}}
        <div {{ $attributes->merge(['class'=>'modal-body wrapper flex flex-center']) }}>
                {{ $slot }}
            {{-- <img id="modalImage" class="content" src="" alt="Uploaded Image"> --}}
        </div>
    </div>
</div>

{{--
Use the modal in intended blade view
<x-modal/>
call the method to show it by the element that needs it, for example, button.preview, or plain button, could be anything
call the content using data-url=""
--}}
