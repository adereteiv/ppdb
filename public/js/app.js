import { fetchContent, alert, copyToClipboard, tooltip, toggleStaticOpen } from './misc.js';
import modalControl from "./modal.js";
import { togglePindahanBit, toggleRequiredFields, toggleKelompokUmur, initAdjustPhoneInput, initGelombangSelection, appendSyaratDokumen, initAutosave } from './form.js';
import { restoreTableState } from './table.js';

document.addEventListener("DOMContentLoaded", function () {
    /** misc.js
     * [✓] fetchContent, related to modal
     * [✓] alert
     * [✓] copyToClipboard
     * [✓] tooltip
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

    /** table.js
     * [✓] restoreTableState
     */

    if (window.location.pathname === '/admin/ppdb/aktif' || window.location.pathname === '/admin/ppdb/arsip' ) {
        restoreTableState();
    }

    /** modal.js
     * [✓] modalControl.loadModalContent, use fetchContent()
     * [✓] modalControl.open
     * [✓] modalControl.close
     * [✓] modalControl.closeOnClick
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

    /** form.js
     * [✓] togglePindahanBit
     * [✓] toggleRequiredFields
     * [✓] toggleKelompokUmur
     * [✓] initAdjustPhoneInput
     * [✓] initGelombangSelection
     * [✓] appendSyaratDokumen
     */
    document.querySelectorAll('input[name="mendaftar_sebagai"]').forEach(radio => {
        radio.addEventListener("change", togglePindahanBit);
    });
    document.querySelectorAll('input[name="yang_mendaftarkan"]').forEach(radio => {
        radio.addEventListener("change", toggleRequiredFields);
    });
    toggleKelompokUmur();
    initAdjustPhoneInput();
    initGelombangSelection();
    document.body.addEventListener('submit', function (event) {
        if (event.target.matches('#tambahSyaratDokumenForm')) {
            event.preventDefault();
            appendSyaratDokumen(event.target);
        }
    });
    initAutosave();
});

