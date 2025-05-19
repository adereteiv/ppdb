<x-layouts.home-layout>
    <section id="section-struktur" class="home-section">
        <div class="struktur-title text-align-center margin-vertical">
            <h1>Struktur Organisasi</h1>
            <h2>TK Negeri Pembina Sungai Kakap</h2>
        </div>
        <div class="container">
            <div>
                <div class="text-align-center">
                    <!-- 1 col, keep adding div.flex-1 to increase the amount in a row-->
                    <div class="flex justify-around">
                        <div class="org-card justify-items-center content-padding margin-vertical">
                            <div class="org-member">
                                {{-- <img src="https://placehold.co/150x200?text=Dummy+Image" alt="container image"> --}}
                                <img class="org-profile" src="{{ asset('static/Guru_R_compre.png') }}" alt="container image">
                            </div>
                            <div>
                                <h5>Rosni, S.Pd., M.Pd.</h5>
                                <p>Kepala TK</p>
                            </div>
                        </div>
                    </div>
                    <!-- 2 cols, keep adding div.flex-1 to increase the amount in a row-->
                    <div class="flex justify-around">
                        <div class="org-card justify-items-center content-padding margin-vertical">
                            <div class="org-member">
                                <img class="org-profile" src="{{ asset('static/Guru_A_compre.png') }}" alt="container image">
                            </div>
                            <div>
                                <h5>Abasiah, S. Pd.</h5>
                                <p>Operator</p>
                            </div>
                        </div>
                        <div class="org-card justify-items-center content-padding margin-vertical">
                            <div class="org-member">
                                <img class="org-profile" src="{{ asset('static/Guru_Sym_compre.png') }}" alt="container image">
                            </div>
                            <div>
                                <h5>Suyemi</h5>
                                <p>Bendahara</p>
                            </div>
                        </div>
                    </div>
                    <!-- 3 cols, keep adding div.flex-1 to increase the amount in a row-->
                    <div class="flex justify-around">
                        <div class="org-card justify-items-center content-padding margin-vertical">
                            <div class="org-member">
                                <img class="org-profile" src="{{ asset('static/Guru_TS_compre.png') }}" alt="container image">
                            </div>
                            <div>
                                <h5>Tien Suhartini, S. Pd.</h5>
                                <p>Pendidik</p>
                            </div>
                        </div>
                        <div class="org-card justify-items-center content-padding margin-vertical">
                            <div class="org-member">
                                <img class="org-profile" src="{{ asset('static/Guru_USN_compre.png') }}" alt="container image">
                            </div>
                            <div>
                                <h5>Utin Setia Ningrum, S. Pd.</h5>
                                <p>Pendidik</p>
                            </div>
                        </div>
                        <div class="org-card justify-items-center content-padding margin-vertical">
                            <div class="org-member">
                                <img class="org-profile" src="{{ asset('static/Guru_M_compre.png') }}" alt="container image">
                            </div>
                            <div>
                                <h5>Maskupah, S. Pd.</h5>
                                <p>Pendidik</p>
                            </div>
                        </div>
                    </div>
                    <!-- 3 cols, keep adding div.flex-1 to increase the amount in a row-->
                    <div class="flex justify-around">
                        <div class="org-card justify-items-center content-padding margin-vertical">
                            <div class="org-member">
                                <img class="org-profile" src="{{ asset('static/Guru_Sym_compre.png') }}" alt="container image">
                            </div>
                            <div>
                                <h5>Suyemi</h5>
                                <p>Pendidik</p>
                            </div>
                        </div>
                        <div class="org-card justify-items-center content-padding margin-vertical">
                            <div class="org-member">
                                <img class="org-profile" src="{{ asset('static/Guru_FS_compre.png') }}" alt="container image">
                            </div>
                            <div>
                                <h5>Fitria Susana</h5>
                                <p>Pendidik</p>
                            </div>
                        </div>
                        <div class="org-card justify-items-center content-padding margin-vertical">
                            <div class="org-member">
                                <img class="org-profile" src="{{ asset('static/Guru_A_compre.png') }}" alt="container image">
                            </div>
                            <div>
                                <h5>Abasiah, S. Pd.</h5>
                                <p>Pendidik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.home-layout>
