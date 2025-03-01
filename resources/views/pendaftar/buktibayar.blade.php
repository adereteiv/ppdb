<x-layouts.app-layout>

<div id="pendaftar-buktibayar" class="app-content wrapper">
    <div class="content-title margin-vertical">Unggah Bukti Pembayaran</div>
    <div class="constrict">
        <form method="post" action="">
            <div class="dropzone">
                <input id="dropzoneInput" type="file" accept=".jpg,.jpeg,.png,.pdf" hidden/>
                <div class="dropzone-card">
                    <svg xmlns="http://www.w3.org/2000/svg" height="78" width="78" viewBox="0 -960 960 960"><path d="M440-320v-326L336-542l-56-58 200-200 200 200-56 58-104-104v326h-80ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z"/></svg>
                    <p>Upload file Anda</p>
                    <p>(JPEG, JPG, PNG, PDF)</p>
                </div>
                <div class="progress-container">
                    <div id="progressBar" class="progress-bar"></div>
                </div>
                <div id="error" class="error"></div>
                <div id="preview" class="preview"></div>
            </div>
            <div class="margin-vertical text-align-center">
                <input id="uploadBtn" class="tombol-besar" type="submit" value="Simpan" disabled>
            </div>
        </form>
    </div>
</div>

</x-layouts.app-layout>
