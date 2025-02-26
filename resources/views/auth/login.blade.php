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
                <p>
                    <strong id="userId" class="text-center">{{ session('user_id') }}</strong>
                    <button id="copyButton" class="tombol-none tooltip">
                        <span id="tooltiptext" class="tooltiptext">Salin</span>
                        <i fill="currentColor" class="bi bi-copy"></i>
                    </button>
                </p>
                <br>
                <p><small>Salin dan simpan ID Pengguna Anda untuk keperluan login! Anda tidak akan melihat pesan ini lagi.</small></p>
                <script>
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

                                tooltiptext.textContent = `ID Anda ${userIdElement.textContent} berhasil disalin!`;
                            }
                        });

                        copyButton.addEventListener("mouseleave", function () {
                            tooltiptext.textContent = "Salin";
                        });
                    });
                </script>
            </x-flash-message>
            @endif
            @if(session()->has('error'))
            <x-flash-message flash="red">{{ session('error') }}</x-flash-message>
            @endif

            {{--
            @error('id')
            <div class="form-login_item flex justify-between reminder bg-red teks-putih margin-vertical" x-data="{ show: true }" x-show="show" >
                <span class="flex-1 align-self-center">{{ $message }}</span>
                <div><button class="tombol tombol-negatif" @click="show = false"><i class="bi bi-x-lg"></i></button></div>
            </div>
            @enderror

            @error('password')
            <div class="form-login_item flex justify-between reminder bg-red teks-putih margin-vertical" x-data="{ show: true }" x-show="show" >
                <span class="flex-1 align-self-center">{{ $message }}</span>
                <div><button class="tombol tombol-negatif" @click="show = false"><i class="bi bi-x-lg"></i></button></div>
            </div>
            @enderror
            --}}

            <form method="post" action="/login">@csrf
                <div class="gap">
                    <x-input type="text" name="id" class="form-login_item" placeholder="ID Pengguna" autofocus required/>
                    {{-- <input type="text" name="id" class="form-login_item" placeholder="ID Pengguna" value="{{old('id')}}" autofocus required> --}}
                </div>
                <div class="gap">
                    <x-input type="password" name="password" class="form-login_item" placeholder="Kata Sandi" required/>
                    {{-- <input type="password" name="password" class="form-login_item" placeholder="Kata Sandi" required> --}}
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
