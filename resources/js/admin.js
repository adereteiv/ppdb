import { initGelombangSelection, appendSyaratDokumen, initAutosave } from './form1.js';
import { restoreTableState } from './table.js';

document.addEventListener("DOMContentLoaded", function () {
    /** table.js
     * [✓] restoreTableState
     */
    if (window.location.pathname === '/admin/ppdb/aktif' || window.location.pathname === '/admin/ppdb/arsip' || window.location.pathname === '/admin/pengumuman' ) {
        restoreTableState();
    }

    /** form.js
     * [✓] initGelombangSelection
     * [✓] appendSyaratDokumen
     * [✓] initAutosave
     * */
    initGelombangSelection();
    document.body.addEventListener('submit', function (event) {
        if (event.target.matches('#tambahSyaratDokumenForm')) {
            event.preventDefault();
            appendSyaratDokumen(event.target);
        }
    });
    initAutosave();
});
