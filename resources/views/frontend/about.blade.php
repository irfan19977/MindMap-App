@extends('frontend.layouts.app')

@section('content')
            <section class="jarallax relative overflow-hidden z-1000 mt-80">
            <img src="{{ asset('frontend/images/background/3.webp') }}" class="jarallax-img" alt="">
            <div class="sw-overlay op-2"></div>
            <div class="gradient-edge-start light w-40 start-40 op-9 z-2"></div>
            <div class="abs w-40 h-100 bg-white top-0 start-0 op-9 z-2"></div>
            <div class="container relative z-2">
                <div class="row wow fadeInRight">
                    <div class="col-lg-10">
                        <h1 class="fs-sm-10vw mb-0">
                            Tentang Kami
                        </h1>

                        <ul class="crumb">
                            <li><a href="/">Home</a></li>
                            <li class="active">Tentang Kami</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="relative">
                            <div class="w-100 pe-5 pb-5 wow scaleIn">
                                <img src="{{ asset('frontend/images/misc/l1.webp') }}" class="w-100 rounded-1" alt="">
                            </div>
                            <img src="{{ asset('frontend/images/misc/s1.webp') }}" class="w-40 rounded-1 abs end-0 bottom-0 z-2 soft-shadow wow scaleIn" data-wow-delay=".2s" alt="">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="ps-lg-3">

                            <div class="subtitle wow fadeInUp" data-wow-delay=".2s">
                                Tentang MindMap
                            </div>

                            <h2 class="wow fadeInUp" data-wow-delay=".4s">
                                Platform Pembelajaran <br> Berbasis MindMap
                            </h2>

                            <p class="wow fadeInUp" data-wow-delay=".6s">
                                MindMap adalah platform pembelajaran interaktif yang menggunakan mindmap untuk membantu siswa memahami materi pelajaran dengan cara visual dan menyenangkan. Dengan fitur-fitur modern seperti AI assistant, kuis interaktif, dan sistem progress tracking, kami membuat belajar menjadi lebih efektif dan engaging.
                            </p>

                            <a href="/contact" class="btn-main fx-slide wow fadeInUp" data-wow-delay=".8s">
                                <span>Mulai Belajar</span>
                            </a>

                        </div>
                    </div>
                </div>

                <div class="spacer-double"></div>

                <div class="row g-4">
                    <div class="col-md-3 wow fadeInUp" data-wow-delay=".3s">
                        <div class="relative">
                            <span class="abs w-70px p-3 circle bg-color-op-2 d-block">
                                <img src="{{ asset('frontend/images/icons-color/check.png') }}" class="w-100" alt="">
                            </span>
                            <div class="ps-90">
                                <h3 class="hs-4">Pembelajaran Visual</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 wow fadeInUp" data-wow-delay=".4s">
                        <div class="relative">
                            <span class="abs w-70px p-3 circle bg-color-op-2 d-block">
                                <img src="{{ asset('frontend/images/icons-color/check.png') }}" class="w-100" alt="">
                            </span>
                            <div class="ps-90">
                                <h3 class="hs-4">AI Assistant Pintar</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 wow fadeInUp" data-wow-delay=".5s">
                        <div class="relative">
                            <span class="abs w-70px p-3 circle bg-color-op-2 d-block">
                                <img src="{{ asset('frontend/images/icons-color/check.png') }}" class="w-100" alt="">
                            </span>
                            <div class="ps-90">
                                <h3 class="hs-4">Kuis Interaktif</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 wow fadeInUp" data-wow-delay=".6s">
                        <div class="relative">
                            <span class="abs w-70px p-3 circle bg-color-op-2 d-block">
                                <img src="{{ asset('frontend/images/icons-color/check.png') }}" class="w-100" alt="">
                            </span>
                            <div class="ps-90">
                                <h3 class="hs-4">Progress Tracking</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="jarallax bg-dark-1 text-light">
            <img src="{{ asset('frontend/images/background/1.webp') }}" class="jarallax-img" alt="">
            <div class="sw-overlay"></div>

            <div class="container">
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-12 text-center">

                        <div class="owl-single-dots owl-carousel owl-theme">

                            <div class="item">
                                <span class="d-stars id-color d-block mb-3">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </span>
                                <h3 class="mb-4 wow fadeInUp fs-36">
                                    MindMap membantu saya memahami materi pelajaran dengan cara visual yang sangat mudah diingat. Belajar jadi jauh lebih menyenangkan!
                                </h3>
                                <span class="wow fadeInUp">Sarah Putri</span>
                            </div>

                            <div class="item">
                                <span class="d-stars id-color d-block mb-3">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </span>
                                <h3 class="mb-4 wow fadeInUp fs-36">
                                    Nilai matematika saya naik drastis setelah menggunakan MindMap. Kuis interaktif sangat membantu untuk latihan dan pemahaman.
                                </h3>
                                <span class="wow fadeInUp">Budi Santoso</span>
                            </div>

                            <div class="item">
                                <span class="d-stars id-color d-block mb-3">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </span>
                                <h3 class="mb-4 wow fadeInUp fs-36">
                                    AI assistant selalu siap membantu ketika saya bingung dengan materi. Penjelasannya mudah dipahami dan sangat membantu.
                                </h3>
                                <span class="wow fadeInUp">Citra Lestari</span>
                            </div>

                            <div class="item">
                                <span class="d-stars id-color d-block mb-3">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </span>
                                <h3 class="mb-4 wow fadeInUp fs-36">
                                    Sejak menggunakan MindMap, anak saya jadi lebih semangat belajar. Platform ini membuat pembelajaran jadi interaktif.
                                </h3>
                                <span class="wow fadeInUp">Ibu Ratna</span>
                            </div>

                            <div class="item">
                                <span class="d-stars id-color d-block mb-3">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </span>
                                <h3 class="mb-4 wow fadeInUp fs-36">
                                    MindMap memiliki materi yang sangat lengkap dan terstruktur dengan baik. Sangat membantu untuk persiapan ujian sekolah.
                                </h3>
                                <span class="wow fadeInUp">Pak Ahmad</span>
                            </div>

                            <div class="item">
                                <span class="d-stars id-color d-block mb-3">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                </span>
                                <h3 class="mb-4 wow fadeInUp fs-36">
                                    Fitur leaderboard membuat siswa termotivasi untuk terus belajar dan berkompetisi dengan teman-teman secara sehat.
                                </h3>
                                <span class="wow fadeInUp">Bu Kartika</span>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center">
                            <div class="subtitle wow fadeInUp">Tim Kami</div>
                            <h2 class="wow fadeInUp" data-wow-delay=".2s">Tim Pengembang MindMap</h2>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3 text-center">
                        <div class="bg-white relative border-gray rounded-1 overflow-hidden">
                            <img src="{{ asset('frontend/images/team/1.webp') }}" class="w-100" alt="">
                            <div class="abs w-100 start-0 bottom-0 z-3">
                                <div class="p-40 text-light relative z-2">
                                    <h3 class="mb-0 text-uppercase lh-1-2">Andi<br>Pratama</h3>
                                </div>
                                <div class="gradient-edge-bottom color h-100"></div>
                            </div>
                        </div>
                        <h4 class="mt-3">Founder & CEO</h4>
                        <div class="social-icons">
                            <a href="#"><i class="bg-color-op-2 id-color bg-hover-2 text-hover-white fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="bg-color-op-2 id-color bg-hover-2 text-hover-white fa-brands fa-x-twitter"></i></a>
                            <a href="#"><i class="bg-color-op-2 id-color bg-hover-2 text-hover-white fa-brands fa-instagram"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 text-center">
                        <div class="bg-white relative border-gray rounded-1 overflow-hidden">
                            <img src="{{ asset('frontend/images/team/2.webp') }}" class="w-100" alt="">
                            <div class="abs w-100 start-0 bottom-0 z-3">
                                <div class="p-40 text-light relative z-2">
                                    <h3 class="mb-0 text-uppercase lh-1-2">Siti<br>Rahayu</h3>
                                </div>
                                <div class="gradient-edge-bottom color h-100"></div>
                            </div>
                        </div>
                        <h4 class="mt-3">Head of Education</h4>
                        <div class="social-icons">
                            <a href="#"><i class="bg-color-op-2 id-color bg-hover-2 text-hover-white fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="bg-color-op-2 id-color bg-hover-2 text-hover-white fa-brands fa-x-twitter"></i></a>
                            <a href="#"><i class="bg-color-op-2 id-color bg-hover-2 text-hover-white fa-brands fa-instagram"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 text-center">
                        <div class="bg-white relative border-gray rounded-1 overflow-hidden">
                            <img src="{{ asset('frontend/images/team/3.webp') }}" class="w-100" alt="">
                            <div class="abs w-100 start-0 bottom-0 z-3">
                                <div class="p-40 text-light relative z-2">
                                    <h3 class="mb-0 text-uppercase lh-1-2">Budi<br>Santoso</h3>
                                </div>
                                <div class="gradient-edge-bottom color h-100"></div>
                            </div>
                        </div>
                        <h4 class="mt-3">Lead Developer</h4>
                        <div class="social-icons">
                            <a href="#"><i class="bg-color-op-2 id-color bg-hover-2 text-hover-white fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="bg-color-op-2 id-color bg-hover-2 text-hover-white fa-brands fa-x-twitter"></i></a>
                            <a href="#"><i class="bg-color-op-2 id-color bg-hover-2 text-hover-white fa-brands fa-instagram"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 text-center">
                        <div class="bg-white relative border-gray rounded-1 overflow-hidden">
                            <img src="{{ asset('frontend/images/team/4.webp') }}" class="w-100" alt="">
                            <div class="abs w-100 start-0 bottom-0 z-3">
                                <div class="p-40 text-light relative z-2">
                                    <h3 class="mb-0 text-uppercase lh-1-2">Dewi<br>Kartika</h3>
                                </div>
                                <div class="gradient-edge-bottom color h-100"></div>
                            </div>
                        </div>
                        <h4 class="mt-3">Content Creator</h4>
                        <div class="social-icons">
                            <a href="#"><i class="bg-color-op-2 id-color bg-hover-2 text-hover-white fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="bg-color-op-2 id-color bg-hover-2 text-hover-white fa-brands fa-x-twitter"></i></a>
                            <a href="#"><i class="bg-color-op-2 id-color bg-hover-2 text-hover-white fa-brands fa-instagram"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="bg-color-op-1">
            <div class="container">
                <div class="row g-4 justify-content-between">

                    <div class="col-lg-4">
                        <div class="subtitle id-color wow fadeInUp">FAQ</div>

                        <h2 class="wow fadeInUp" data-wow-delay=".2s">
                            Punya Pertanyaan?
                        </h2>
                    </div>

                    <div class="col-lg-8">
                        <div class="de-tab">

                            <ul class="d-tab-nav mb-4">
                                <li class="active-tab">Tentang MindMap</li>
                                <li>Cara Menggunakan</li>
                                <li>Harga &amp; Paket</li>
                            </ul>

                            <ul class="d-tab-content">

                                <!-- Tentang MindMap -->
                                <li>
                                    <div class="accordion">
                                        <div class="accordion-section">

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-a1">
                                                    Apa itu MindMap?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-a1">
                                                    MindMap adalah platform pembelajaran interaktif yang menggunakan mindmap untuk membantu siswa memahami materi pelajaran dengan cara visual dan menyenangkan.
                                                </div>
                                            </div>

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-a2">
                                                    Materi apa saja yang tersedia?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-a2">
                                                    Kami menyediakan materi untuk berbagai mata pelajaran seperti Matematika, Bahasa Indonesia, IPA, IPS, dan lainnya untuk tingkat SD, SMP, dan SMA.
                                                </div>
                                            </div>

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-a3">
                                                    Apakah MindMap gratis?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-a3">
                                                    Ya, MindMap dapat digunakan gratis dengan akses ke materi dasar. Kami juga menyediakan paket premium dengan fitur tambahan.
                                                </div>
                                            </div>

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-a4">
                                                    Apakah cocok untuk semua jenjang?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-a4">
                                                    Ya, MindMap dirancang untuk siswa SD, SMP, dan SMA dengan materi yang disesuaikan dengan kurikulum masing-masing jenjang.
                                                </div>
                                            </div>

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-a5">
                                                    Apakah ada fitur untuk guru?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-a5">
                                                    Ya, kami menyediakan fitur khusus untuk guru seperti membuat kelas, memantau progress siswa, dan membuat materi kustom.
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </li>

                                <!-- Cara Menggunakan -->
                                <li>
                                    <div class="accordion">
                                        <div class="accordion-section">

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-b1">
                                                    Bagaimana cara mulai belajar?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-b1">
                                                    Daftar akun gratis, pilih mata pelajaran dan materi yang ingin dipelajari, lalu mulai dengan mindmap interaktif yang tersedia.
                                                </div>
                                            </div>

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-b2">
                                                    Bagaimana cara menggunakan AI Assistant?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-b2">
                                                    AI Assistant tersedia di setiap halaman materi. Cukup ketik pertanyaan Anda dan AI akan memberikan penjelasan yang membantu.
                                                </div>
                                            </div>

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-b3">
                                                    Bagaimana sistem kuis bekerja?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-b3">
                                                    Setiap materi memiliki kuis latihan. Jawab soal dan dapatkan umpan balik instan. Kuis essay akan dinilai oleh AI secara otomatis.
                                                </div>
                                            </div>

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-b4">
                                                    Apakah progress belajar tersimpan?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-b4">
                                                    Ya, semua progress belajar Anda akan tersimpan otomatis. Anda bisa melihat statistik dan pencapaian di dashboard personal.
                                                </div>
                                            </div>

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-b5">
                                                    Apakah bisa belajar offline?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-b5">
                                                    Saat ini MindMap membutuhkan koneksi internet. Kami sedang mengembangkan fitur offline untuk penggunaan di masa depan.
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </li>

                                <!-- Harga & Paket -->
                                <li>
                                    <div class="accordion">
                                        <div class="accordion-section">

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-c1">
                                                    Berapa biaya berlangganan premium?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-c1">
                                                    Paket premium tersedia dengan harga terjangkau. Cek halaman pricing untuk detail lengkap paket dan fitur yang tersedia.
                                                </div>
                                            </div>

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-c2">
                                                    Apa perbedaan paket gratis dan premium?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-c2">
                                                    Paket gratis memiliki akses terbatas. Premium memberikan akses penuh ke semua materi, AI tanpa batas, dan fitur eksklusif lainnya.
                                                </div>
                                            </div>

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-c3">
                                                    Apakah ada biaya tersembunyi?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-c3">
                                                    Tidak. Kami transparan dengan harga. Semua biaya akan dijelaskan sebelum Anda berlangganan paket premium.
                                                </div>
                                            </div>

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-c4">
                                                    Bagaimana cara berlangganan?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-c4">
                                                    Masuk ke akun Anda, pilih menu paket, dan pilih paket yang sesuai. Pembayaran dapat dilakukan melalui berbagai metode.
                                                </div>
                                            </div>

                                            <div class="accordion-s1">
                                                <div class="accordion-section-title" data-tab="#accordion-c5">
                                                    Apakah bisa refund?
                                                </div>
                                                <div class="accordion-section-content" id="accordion-c5">
                                                    Kami memiliki kebijakan refund yang adil. Hubungi tim support kami jika Anda mengalami masalah dengan langganan.
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </li>

                            </ul>

                        </div>
                    </div>

                </div>
            </div>
        </section>
@endsection