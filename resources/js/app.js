// import './bootstrap';
import { fetchContent, alert, copyToClipboard, tooltip, toggleStaticOpen } from './misc.js';
import modalControl from "./modal.js";
import { initGalleryLightbox } from "./lightbox.js";
import { togglePindahanBit, toggleKelompokUmur, toggleYangMendaftarkan, initAdjustPhoneInput } from './form.js';

document.addEventListener("DOMContentLoaded", function () {
    /** misc.js
     * [✓] fetchContent, fetch injected pre-rendered element
     * [✓] alert
     * [✓] copyToClipboard
     * [✓] tooltip
     * [✓] toggleStaticOpen
     */
    document.body.addEventListener("click", async function (event) {
        if (event.target.matches(".load-content")) {
            event.preventDefault();
            const url = event.target.dataset.url;
            const target = event.target.dataset.target;
            await fetchContent(url, target);
        }
    });
    alert();
    copyToClipboard();
    tooltip();
    toggleStaticOpen();

    /** modal.js
     * [✓] modalControl regulates modal behavior
     */
    document.body.addEventListener("click", async function (event) {
        const modalUrl = event.target.closest("[data-url]")?.dataset.url;
        if (modalUrl) {
            event.preventDefault();
            modalControl.loadModalContent(modalUrl);
            return;
        }

        const modalContent = event.target.closest("[data-content]")?.dataset.content;
        if (modalContent) {
            event.preventDefault();
            modalControl.open(modalContent);
            return;
        }

        if (event.target.closest(".modal-button")) {
            modalControl.close();
            return;
        }

        if (event.target.matches(".modal")) {
            modalControl.closeOnClick(event);
            return;
        }
    });
    initGalleryLightbox();

    /** form.js
     * [✓] togglePindahanBit
     * [✓] toggleYangMendaftarkan
     * [✓] toggleKelompokUmur
     * [✓] initAdjustPhoneInput
     */
    document.querySelectorAll('input[name="mendaftar_sebagai"]').forEach(radio => {
        radio.addEventListener("change", togglePindahanBit);
    });
    document.querySelectorAll('input[name="yang_mendaftarkan"]').forEach(radio => {
        radio.addEventListener("change", toggleYangMendaftarkan);
    });
    toggleKelompokUmur();
    initAdjustPhoneInput();
});

