import ModalControl from "./modal.js";

export function appendSyaratDokumen(form) {
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // csrf token harus available site-wide -> app-layout
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // closeModal();
            ModalControl.close();

            const container = document.querySelector('.frame');
            const sorting = container.getAttribute('data-sorting');

            if (sorting == 'asc') {
                container.insertAdjacentHTML('beforeend', data.html); // add the json key
            } else {
                container.insertAdjacentHTML('afterbegin', data.html); // add the json key
            }

            updateNumeration();
        } else if (data.error) {
            document.getElementById('dokumen-error').innerText = data.error;
        }
    })
    .catch(error => console.error('Error:', error));

    function updateNumeration() {
        const sorting = document.querySelector('.frame').getAttribute('data-sorting');
        const items = document.querySelectorAll('.checkmenu');

        items.forEach((item, index) => {
            const num = sorting === 'asc' ? index + 1 : items.length - index;
            const label = item.querySelector('.number');
            label.innerText = label.innerText.replace(/^\d+\.\s*/, '');
            label.innerText = `${num}. ${label.innerText}`;
        });
    }
}
