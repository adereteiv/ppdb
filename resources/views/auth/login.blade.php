<x-layouts.home-layout :hideFooter='true'>
<section id="section-login" class="home-section">
    <div class="container">
        <div class="text-align-center margin-vertical">
            <h2>Masuk</h2>
        </div>
        <div class="form-login margin-vertical">

            @if(session()->has('loginDulu'))
            <x-flash-message flash="blue">{{ session('loginDulu') }}</x-flash-message>
            @endif

            @if(session()->has('success'))
            <x-flash-message flash="green">
                {{ session('success') }}
            </x-flash-message>
            <x-flash-message flash>
                <h6>Perhatian!</h6>
                <hr>
                <p>ID Pengguna Anda:</p>
                <sup>
                    <strong id="userId" class="text-center">{{ session('user_id') }}</strong>
                    <button id="copyButton" class="tombol-none tooltip">
                        <span id="tooltiptext" class="tooltiptext">Salin</span>
                        <i fill="currentColor" class="bi bi-copy"></i>
                    </button>
                </sup>
                <br>
                <p><small>Salin dan simpan ID Pengguna Anda untuk keperluan login! Anda tidak akan melihat pesan ini lagi.</small></p>
                {{-- <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const copyButton = document.getElementById("copyButton");
                        const userIdElement = document.getElementById("userId");
                        const tooltiptext = document.getElementById("tooltiptext");

                        copyButton.addEventListener("click", function () {
                            if(navigator.clipboard && navigator.clipboard.writeText){
                                navigator.clipboard.writeText(userIdElement.textContent)
                                .then(() => {
                                    tooltiptext.textContent = `ID Anda ${userIdElement.textContent} berhasil disalin!`;
                                })
                                .catch(err => {
                                    console.error("Failed to copy: ", err);
                                    tooltiptext.textContent = `Gagal menyalin!`;
                                });
                            }
                            else{
                                const tempInput = document.createElement("textarea");
                                tempInput.value = userIdElement.textContent;
                                document.body.appendChild(tempInput);
                                tempInput.select();

                                document.execCommand("copy");
                                document.body.removeChild(tempInput);

                                tooltiptext.textContent = `Berhasil menyalin ID ${userIdElement.textContent}!`;
                            }
                        });

                        copyButton.addEventListener("mouseleave", function () {
                            tooltiptext.textContent = "Salin";
                        });
                    });
                </script> --}}
            </x-flash-message>
            @endif

            @if(session()->has('error'))
            <x-flash-message flash>{{ session('error') }}</x-flash-message>
            @endif

            <form method="post" action="/login">@csrf
                <div class="gap">
                    <x-input type="text" name="id" class="form-login_item" placeholder="ID Pengguna" autofocus required/>
                </div>
                <div class="gap">
                    <x-input type="password" name="password" class="form-login_item" placeholder="Kata Sandi" required/>
                </div>
                <div class="margin-vertical">
                    <button type="submit" class="form-login_item tombol-besar tombol-netral">Log In</button>
                </div>
            </form>

            <p class="form-login_item text-align-center">Belum punya Akun? <a href="/daftar">Silakan daftar</a></p>
        </div>
    </div>
</section>
</x-layouts.home-layout>
