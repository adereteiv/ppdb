/* Formulir Fields */
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
export function toggleRequiredFields() {
    const selected = document.querySelector('input[name="yang_mendaftarkan"]:checked');
    const isOrangTua = selected && selected.value === "Orang Tua";

    document.querySelectorAll(".ayah-input, .ibu-input").forEach(input => input.required = isOrangTua);
    document.querySelectorAll(".wali-input").forEach(input => input.required = !isOrangTua);
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

/* Admin PPDB */
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
