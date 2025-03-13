document.addEventListener("DOMContentLoaded", function () {
    alert();
    initCopyToClipboard();
    togglePindahanBit();
    toggleRequiredFields();
    initAdjustPhoneInput();
    initGelombangSelection();
});

// [✓] Alert
function alert() {
    setTimeout(() => {
        let alert = document.querySelector(".alert"); //must have .alert selector
        if (alert) {
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 2000/*ms*/); // fade-out for X-ms then remove
        }
    }, 10000/*ms*/); // Auto-dismiss after X-ms
}

/* Modal */
// [✓] Showing the modal
function loadModalContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(content => {
            openModal(content);
        });
        // .catch(error => console.error("Error loading modal content:", error));
}
function openModal(content = '') {
    const modal = document.querySelector('.modal');
    const modalBody = modal.querySelector('.modal-body');
    modalBody.innerHTML = content;
    modal.style.display = 'flex';
    trapFocus(modal);
}
// [✓] Close with button call
function closeModal() {
    const modal = document.querySelector('.modal');
    modal.style.display = 'none';
    modal.querySelector('.modal-body').innerHTML = '';
    document.removeEventListener('keydown', handleKeyDown);
}
// [✓] Close by clicking outside the modal
function closeModalOnClick() {
    if (event.target === event.currentTarget) {
        closeModal();
    }
}
// [✓] Trapping tab focus inside modal
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

// [✓] Copy ID to Clipboard
function initCopyToClipboard() {
    const copyButton = document.getElementById("copyButton");
    const userIdElement = document.getElementById("userId");
    const tooltiptext = document.getElementById("tooltiptext");

    if (!copyButton || !userIdElement || !tooltiptext) return;
    const copiedText = userIdElement.textContent.trim();

    copyButton.addEventListener("click", function () {
        if(navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(copiedText)
                .then(() => { tooltiptext.textContent = `ID ${copiedText} disalin!`; })
                .catch(() => { tooltiptext.textContent = `Gagal menyalin!`; });

        } else {
            const tempInput = document.createElement("textarea");
            tempInput.value = copiedText;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            tooltiptext.textContent = `ID ${copiedText} disalin!`;
        }
    });

    copyButton.addEventListener("mouseleave", function () {
        tooltiptext.textContent = "Salin";
    });
}

/* Formulir Fields */
// [✓] Mendaftar Sebagai
function togglePindahanBit() {
    const pindahanBit = document.getElementById("pindahanBit");
    const pindahanInputs = document.querySelectorAll(".pindahan-input");
    const selected = document.querySelector('input[name="mendaftar_sebagai"]:checked');
    const isPindahan = selected && selected.value === "Pindahan";

    if (pindahanBit) {
        pindahanBit.style.display = isPindahan ? "table-row-group" : "none";
        pindahanInputs.forEach(input => input.required = isPindahan);
    }
}
document.querySelectorAll('input[name="mendaftar_sebagai"]').forEach(radio => {
    radio.addEventListener("change", togglePindahanBit);
});
// [✓] Yang Mendaftarkan
function toggleRequiredFields() {
    const selected = document.querySelector('input[name="yang_mendaftarkan"]:checked');
    const isOrangTua = selected && selected.value === "Orang Tua";

    document.querySelectorAll(".ayah-input, .ibu-input").forEach(input => input.required = isOrangTua);
    document.querySelectorAll(".wali-input").forEach(input => input.required = !isOrangTua);
}
document.querySelectorAll('input[name="yang_mendaftarkan"]').forEach(radio => {
    radio.addEventListener("change", toggleRequiredFields);
});
function initAdjustPhoneInput() {
    const phoneInputs = document.querySelectorAll("input[type='tel']");

    phoneInputs.forEach(phoneInput => {
        phoneInput.addEventListener("input", function (e) {
            let rawValue = e.target.value.replace(/[^0-9+ -]/g, "");
            let cleanedValue = rawValue.replace(/[^0-9]/g, "");

            if (cleanedValue.length > 15) {
                rawValue = rawValue.slice(0, -1);
            }

            e.target.value = rawValue;
        });
    });
}

// [✓] Buat PPDB
function initGelombangSelection() {
    const tahunSelect = document.getElementById("tahun_ajaran");
    const gelombangInput = document.getElementById("gelombang");
    const gelombangDataElement = document.getElementById("gelombangData");

    if (!tahunSelect || !gelombangInput || !gelombangDataElement) return;

    const gelombangData = JSON.parse(gelombangDataElement.textContent);

    function updateGelombang() {
        const selectedPeriode = tahunSelect.value;
        gelombangInput.value = selectedPeriode ? (gelombangData[selectedPeriode] || 1 ) : "";
    }

    tahunSelect.addEventListener("change", updateGelombang);
    updateGelombang();
}
