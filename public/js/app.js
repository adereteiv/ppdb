import { fetchContent, alert, copyToClipboard } from './misc.js';
import { togglePindahanBit, toggleRequiredFields, toggleKelompokUmur, initAdjustPhoneInput, initGelombangSelection } from './form.js';
import ModalControl from "./modal.js";

document.addEventListener("DOMContentLoaded", function () {
    // [✓] Works
    alert();

    // [✓] Works, put app.js to x-layouts.home-layout
    copyToClipboard();

    // [✓] Works
    document.body.addEventListener("click", async function (event) {
        if (event.target.matches(".load-content")) {
            event.preventDefault();
            const url = event.target.dataset.url;
            const target = event.target.dataset.target;
            await fetchContent(url, target);
        }
    });

    // [✓] Works
    document.body.addEventListener("click", async function (event) {
        const modalUrl = event.target.closest("[data-url]")?.dataset.url;
        if (modalUrl) {
            event.preventDefault();
            ModalControl.loadModalContent(modalUrl);
            return;
        }

        const modalContent = event.target.closest("[data-content]")?.dataset.content;
        if (modalContent) {
            event.preventDefault();
            ModalControl.open(modalContent);
            return;
        }

        if (event.target.closest(".modal-button")) {
            ModalControl.close();
            return;
        }

        if (event.target.matches(".modal")) {
            ModalControl.closeOnClick(event);
            return;
        }
    });

    // [✓] Works
    document.querySelectorAll('input[name="mendaftar_sebagai"]').forEach(radio => {
        radio.addEventListener("change", togglePindahanBit);
    });
    // togglePindahanBit();

    // [✓] Works
    document.querySelectorAll('input[name="yang_mendaftarkan"]').forEach(radio => {
        radio.addEventListener("change", toggleRequiredFields);
    });
    // toggleRequiredFields();

    // [✓] Works
    toggleKelompokUmur();

    // [✓] Works
    initAdjustPhoneInput();

    // [✓] Works
    initGelombangSelection();
});

