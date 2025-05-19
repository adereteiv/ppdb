import modalControl from "./modal.js";

/* Role - Admin */
/* Prevents rapid request */
export function debounce(func, delay) {
	let timeout;
	return (...args) => {
	clearTimeout(timeout);
	timeout = setTimeout(() => func(...args), delay);
	};
}
/* Form action via ajax */
export function ajaxForm({ form, url, method = 'POST', data = null, headers = {}, onSuccess, onError }) {
    const defaultHeaders = {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // csrf token harus available site-wide -> app-layout
        'Accept': 'application/json',
        ...headers,
    };

    const isFormData = data instanceof FormData;
    const body = isFormData ? data : JSON.stringify(data);
    const targetUrl = url || form?.action;

    if (!targetUrl) {
        throw new Error('ajaxForm() missing required params, no form action or URL detected.');
    }

    fetch(targetUrl, {
        method,
        headers: isFormData ? defaultHeaders : { ...defaultHeaders, 'Content-Type': 'application/json' },
        body,
    })
    .then(async response => {
        const result = await response.json();
        if (response.ok) {
            onSuccess?.(result);
        } else {
            onError?.(result?.error || result?.message || 'Unknown error (are you sure of your method or api routes definition?).');
        }
    })
    .catch(error => {
        console.error('AJAX Error:', error);
        onError?.(error.message || 'Terjadi kesalahan (recheck your code).');
    });
}
// window.ajaxForm = ajaxForm;
// [✓] Auto-increment gelombang
export function initGelombangSelection() {
    const tahunSelect = document.getElementById("tahun_ajaran");
    const gelombangInput = document.getElementById("gelombang");
    const gelombangDataElement = document.getElementById("gelombangData");

    if (!tahunSelect || !gelombangInput || !gelombangDataElement) return;

    const gelombangData = JSON.parse(gelombangDataElement.textContent);

    function updateGelombang() {
        const selectedPeriode = tahunSelect.value;
        gelombangInput.value = selectedPeriode ? (gelombangData[selectedPeriode] || 1) : "";
    }

    tahunSelect.addEventListener("change", updateGelombang);
    updateGelombang();
}
/* Ajax form */
// [✓] Create new syarat dokumen without page-reload
export function appendSyaratDokumen(form) {
    ajaxForm({
        form,
        method: 'POST',
        data: new FormData(form),
        onSuccess: (data) => {
            if (data.success) {
                // closeModal();
                modalControl.close();

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
        },
        onError: (error) => {
            console.error('Error:', error);
        }
    });

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
// [✓] Update/patches 'pendaftaran'-only part in the admin.form-edit-pendaftaran without page-reload
export function initAutosave() {
    const form = document.getElementById('patchForm');
    if (!form) return;
    const textarea = form.querySelector('textarea[name="catatan_admin"]');
    const statusInput = document.getElementById('statusInput');
    const statusDisplay = document.getElementById('status');

    const autosave = () => {
        const data = new FormData(form);
        // for (const [key, value] of data.entries()) {
        //     console.log(`${key}:`, value);
        // }
        ajaxForm({
            form,
            method: 'POST', // POST as in default html GET/POST, moreover we're using laravel's magic @method('PATCH') so we don't have to restate PATCH in the js, as well as the api route already using patch
            data,
            onSuccess: (res) => {
                console.log('Autosave success:', res);

                // Update DOM with returned data (optional, dynamic sync)
                if (res.data?.status) {
                    updateStatusDisplay(res.data.status);
                }
                if (res.data?.catatan_admin !== undefined) {
                    textarea.value = res.data.catatan_admin;
                }
            },
            onError: (err) => {
                console.error('Autosave error:', err);
            }
        });
    };

    const debouncedAutosave = debounce(autosave, 300);

    // Handle textarea input
    textarea.addEventListener('input', debouncedAutosave);

    // Handle status selection and UI update
    function updateStatusDisplay(status) {
        statusInput.value = status;
        statusDisplay.textContent = status;
        statusDisplay.classList.remove('tombol-yellowdark', 'tombol-positif', 'tombol-netral');

        if (status === 'Mengisi') {
            statusDisplay.classList.add('tombol-yellowdark');
        } else if (status === 'Lengkap') {
            statusDisplay.classList.add('tombol-positif');
        } else if (status === 'Terverifikasi') {
            statusDisplay.classList.add('tombol-netral');
        }
    }

    const statusMengisi = document.getElementById('statusMengisi')
    if (statusMengisi) {
        statusMengisi.addEventListener('click', () => {
            updateStatusDisplay('Mengisi');
            autosave();
            document.getElementById('statusInput').remove();
            document.querySelector('.dropdown-list').remove();
        });
    }

    const statusLengkap = document.getElementById('statusLengkap');
    const statusTerverifikasi = document.getElementById('statusTerverifikasi');
    if (statusLengkap && statusTerverifikasi) {

        statusLengkap.addEventListener('click', () => {
            updateStatusDisplay('Lengkap');
            autosave();
        });

        statusTerverifikasi.addEventListener('click', () => {
            updateStatusDisplay('Terverifikasi');
            autosave();
        });
    }
}
