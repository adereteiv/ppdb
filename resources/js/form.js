/* General - Formulir Fields */
// [✓] Mendaftar Sebagai
export function togglePindahanBit() {
    const pindahanBit = document.getElementById("pindahanBit");
    const pindahanInputs = document.querySelectorAll(".pindahan-input");
    const selected = document.querySelector('input[name="mendaftar_sebagai"]:checked');
    const isPindahan = selected && selected.value === "Pindahan";

    if (pindahanBit) {
        pindahanBit.style.display = isPindahan ? "table-row-group" : "none";
        pindahanInputs.forEach(input => input.required = isPindahan);
    }
}
// [✓] Pindah Kelompok Umur
export function toggleKelompokUmur() {
    const dariKelompok = document.querySelector('select[name="dari_kelompok"]');
    const keKelompok = document.querySelector('select[name="ke_kelompok"]');

    if (!dariKelompok || !keKelompok) return;

    function updateKelompokUmur () {
        if (dariKelompok.value === "TK B") {
            keKelompok.value = "TK B";
            keKelompok.setAttribute("disabled", "disabled");
        } else {
            keKelompok.removeAttribute("disabled")
        }
    }
    dariKelompok.addEventListener("change", updateKelompokUmur);
    updateKelompokUmur();
}
// [✓] Yang Mendaftarkan
export function toggleYangMendaftarkan() {
    const selected = document.querySelector('input[name="yang_mendaftarkan"]:checked');
    const isOrangTua = selected && selected.value === "Orang Tua";

    const ayahInputs = document.querySelectorAll(".ayah-input");
    const ibuInputs = document.querySelectorAll(".ibu-input");
    [...ayahInputs, ...ibuInputs].forEach(input => input.required = isOrangTua);

    const waliInputs = document.querySelectorAll(".wali-input");
    waliInputs.forEach(input => input.required = !isOrangTua);

    const allRelevantInputs = [...ayahInputs, ...ibuInputs, ...waliInputs];
    allRelevantInputs.forEach(input => {
        const isRequired = input.required;
        let label = null;

        if (input.id) {
            label = document.querySelector(`label[for="${input.id}"]`);
        }
        if (!label) {
            label = input.closest('label');
        }

        const existingAsterisk = label?.querySelector('sup.subtext');

        if (label) {
            if (isRequired && !existingAsterisk) {
                label.insertAdjacentHTML('beforeend', '<sup class="subtext" style="color:#FF0000;">*</sup>');
            } else if (!isRequired && existingAsterisk) {
                existingAsterisk.remove();
            }
        }
    });
}
// [✓] Sanitize Phone Input
export function initAdjustPhoneInput() {
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
