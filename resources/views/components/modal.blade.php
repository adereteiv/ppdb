<div class="modal">
    <div class="modal-content" role="dialog" aria-modal="true" tabindex="-1">
        <button class="modal-button tombol tombol-blank">
            <svg width="20" height="20" viewBox="0 0 20 20"><path d="M10 10l5.09-5.09L10 10l5.09 5.09L10 10zm0 0L4.91 4.91 10 10l-5.09 5.09L10 10z" stroke="currentColor" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </button>
        <div class="modal-body">
            {{ $slot }}
            {{-- <img id="modalImage" class="content" src="" alt="Uploaded Image"> --}}
        </div>
    </div>
</div>

{{--
Use the modal in intended blade view
<x-modal/>
call the method to show it by the element that needs it, for example, button.preview, or plain button, could be anything
onclick="openModal('call the content')"
--}}

{{--
<script>
    function openModal(content = '') {
        const modal = document.getElementById('modal');
        const modalBody = modal.querySelector('.modal-body');
        modalBody.innerHTML = content;
        modal.style.display = 'flex';
        trapFocus(modal);
    }
    function closeModal() {
        const modal = document.getElementById('modal');
        modal.style.display = 'none';
        modal.querySelector('.modal-body').innerHTML = '';
        document.removeEventListener('keydown', handleKeyDown);
    }
    function closeModalOnClick() {
        if (event.target === event.currentTarget) {
            closeModal();
        }
    }
    function trapFocus(element) {
        const focusElement  = element.querySelectorAll('a, button, input, textarea, select');
        if (focusElement.length === 0) return;

        let firstElement = focusElement[0];
        let lastElement = focusElement[focusElement.length-1];

        firstElement.focus();
        document.addEventListener('keydown', handleKeyDown);

        function handleKeyDown(event) {
            if (event.key == 'Tab') {
                if(event.shiftKey) {
                    if(document.activeElement === firstElement) {
                        event.preventDefault();
                        lastElement.focus();
                    }
                } else {
                    if(document.activeElement === lastElement) {
                        event.preventDefault();
                        firstElement.focus();
                    }
                }
            } else if(event.key == 'Escape') {
                closeModal();
            }
        }
    }
</script> --}}
