@extends('frontend.layouts.app')

@section('content')
            <section id="section-intro" class="section-dark text-light no-top no-bottom position-relative overflow-hidden z-1000 mt-80 mt-sm-50">
            <div class="mh-800 relative">
                <div class="abs w-80 abs-middle z-2 w-100">
                    <div class="abs w-100">
                        <div class="container relative z-2">
                            <div class="row g-4 justify-content-end">
                                <div class="col-md-4 text-lg-end sm-hide">
                                    <p>
                                        Platform pembelajaran interaktif dengan mindmap untuk membantu siswa memahami materi pelajaran dengan cara yang visual dan menyenangkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="text-start">
                                    <h1 class="fs-96 fs-sm-10vw mb-0 wow fadeInLeft">
                                        Belajar dengan
                                    </h1>
                                </div>

                                <div class="text-lg-end">
                                    <h1 class="fs-96 fs-sm-10vw mb-4 wow fadeInRight" data-wow-delay=".2s">
                                        MindMap Interaktif
                                    </h1>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="spacer-double sm-hide"></div>
                </div>
                    <div class="container">
                    <div class="row g-4 text-center">
                            <div class="col-md-3 col-sm-6">
                                <div class="de_count wow fadeInUp" data-wow-delay=".0s">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-brain fs-40 id-color me-3"></i>
                                        <div class="text-start">
                                            <h2 class="fs-32 mb-1 lh-1">10+</h2>
                                            <span>Mata Pelajaran</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="de_count wow fadeInUp" data-wow-delay=".1s">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-lightbulb fs-40 id-color me-3"></i>
                                        <div class="text-start">
                                            <h2 class="fs-32 mb-1 lh-1">500+</h2>
                                            <span>MindMap Materi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="de_count wow fadeInUp" data-wow-delay=".2s">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-graduation-cap fs-40 id-color me-3"></i>
                                        <div class="text-start">
                                            <h2 class="fs-32 mb-1 lh-1">98%</h2>
                                            <span>Hasil Belajar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="de_count wow fadeInUp" data-wow-delay=".3s">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-users fs-40 id-color me-3"></i>
                                        <div class="text-start">
                                            <h2 class="fs-32 mb-1 lh-1">24/7</h2>
                                            <span>Akses Pembelajaran</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="spacer-single"></div>
                        </div>
                    </div>
                </div>
                <div class="swiper" data-0="transform: scale(1);" data-800="transform: scale(1.5);">
                  <!-- Additional required wrapper -->
                  <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide">
                        <div class="swiper-inner" data-bgimage="url({{ asset('frontend/images/slider/1.png') }})">
                            <div class="sw-overlay op-5"></div>
                        </div>
                    </div>
                    <!-- Slides -->
                    <!-- Slides -->
                    <div class="swiper-slide">
                        <div class="swiper-inner" data-bgimage="url({{ asset('frontend/images/slider/2.png') }})">
                            <div class="sw-overlay op-5"></div>
                        </div>
                    </div>                        
                    <!-- Slides -->
                  </div>
                </div>
            </div>
            <div class="gradient-edge-bottom"></div>
            <div class="gradient-edge-end"></div>
        </section>

        <section class="pb-0">
            <div class="container">
                <div class="row g-4 justify-content-center mb-2">
                    <div class="col-lg-6">
                        <div class="text-center">
                            <div class="subtitle wow fadeInUp">Fitur Kami</div>
                            <h2 class="wow fadeInUp" data-wow-delay=".2s">Layanan Pembelajaran</h2>
                        </div>
                    </div>                                       
                </div>

                <div class="row g-4">
                    <!-- service item begin -->
                    <div class="col-lg-4 col-sm-6">
                        <div class="hover rounded-1 overflow-hidden relative text-light text-center wow fadeInRight" data-wow-delay=".0s">
                            <img src="{{ asset('frontend/images/services/1.jpeg') }}" class="hover-scale-1-1 w-100" alt="">
                            <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                <div class="mb-3">
                                    Pelajari materi pelajaran dengan mindmap interaktif yang membantu memahami konsep dengan cara visual dan menyenangkan.
                                </div>
                                <a class="btn-line" href="#">Mulai Belajar</a>
                            </div>
                            <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                            <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                                <h3 class="hs-4 mb-3">MindMap Interaktif</h3>
                            </div>
                            <div class="gradient-edge-bottom color abs w-100 h-70 bottom-0"></div>
                        </div>
                    </div>
                    <!-- service item end -->
                    <!-- service item begin -->
                    <div class="col-lg-4 col-sm-6">
                        <div class="hover rounded-1 overflow-hidden relative text-light text-center wow fadeInRight" data-wow-delay=".3s">
                            <img src="{{ asset('frontend/images/services/2.jpeg') }}" class="hover-scale-1-1 w-100" alt="">
                            <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                <div class="mb-3">
                                    Latih pemahaman dengan kuis interaktif yang memberikan umpan balik instan dan penilaian otomatis.
                                </div>
                                <a class="btn-line" href="#">Ikuti Kuis</a>
                            </div>
                            <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                            <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                                <h3 class="hs-4 mb-3">Kuis Interaktif</h3>
                            </div>
                            <div class="gradient-edge-bottom color abs w-100 h-70 bottom-0"></div>
                        </div>
                    </div>
                    <!-- service item end -->
                    <!-- service item begin -->
                    <div class="col-lg-4 col-sm-6">
                        <div class="hover rounded-1 overflow-hidden relative text-light text-center wow fadeInRight" data-wow-delay=".6s">
                            <img src="{{ asset('frontend/images/services/3.jpeg') }}" class="hover-scale-1-1 w-100" alt="">
                            <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                <div class="mb-3">
                                    Dapatkan bantuan belajar dari AI assistant yang siap menjawab pertanyaan dan memberikan penjelasan materi.
                                </div>
                                <a class="btn-line" href="#">Tanya AI</a>
                            </div>
                            <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                            <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                                <h3 class="hs-4 mb-3">AI Assistant</h3>
                            </div>
                            <div class="gradient-edge-bottom color abs w-100 h-70 bottom-0"></div>
                        </div>
                    </div>
                    <!-- service item end -->
                </div>

            </div>
        </section>

        <section>
            <div class="container relative z-2">

                <div class="row g-4 justify-content-center">

                    <div class="col-sm-6 col-md-3 de-step de-step-arrow wow fadeInRight" data-wow-delay=".3s">
                        <div class="de-step-icon bg-color-op-2">
                            <i class="id-color fas fa-book-open fa-2x wow rotateIn" data-wow-delay=".6s"></i>
                        </div>
                        <h3 class="hs-4">Pilih Materi</h3>
                        <p>
                            Pilih mata pelajaran dan materi yang ingin dipelajari dari berbagai kategori yang tersedia.
                        </p>
                    </div>

                    <div class="col-sm-6 col-md-3 de-step de-step-arrow wow fadeInRight" data-wow-delay=".6s">
                        <div class="de-step-icon bg-color-op-2">
                            <i class="id-color fas fa-project-diagram fa-2x wow rotateIn" data-wow-delay=".9s"></i>
                        </div>
                        <h3 class="hs-4">Pelajari MindMap</h3>
                        <p>
                            Pelajari konsep dengan mindmap interaktif yang memvisualisasikan hubungan antar topik.
                        </p>
                    </div>

                    <div class="col-sm-6 col-md-3 de-step de-step-arrow wow fadeInRight" data-wow-delay=".9s">
                        <div class="de-step-icon bg-color-op-2">
                            <i class="id-color fas fa-question-circle fa-2x wow rotateIn" data-wow-delay="1.2s"></i>
                        </div>
                        <h3 class="hs-4">Latihan & Kuis</h3>
                        <p>
                            Uji pemahaman dengan kuis interaktif dan dapatkan umpan balik instan dari AI.
                        </p>
                    </div>

                    <div class="col-sm-6 col-md-3 de-step wow fadeInRight" data-wow-delay="1.2s">
                        <div class="de-step-icon bg-color-op-2">
                            <i class="id-color fas fa-trophy fa-2x wow rotateIn" data-wow-delay="1.5s"></i>
                        </div>
                        <h3 class="hs-4">Raih Prestasi</h3>
                        <p>
                            Pantau progress belajar dan raih prestasi di leaderboard untuk motivasi berkelanjutan.
                        </p>
                    </div>

                </div>

            </div>
        </section>

        <section class="jarallax bg-dark-1 text-light">
            <img src="{{ asset('frontend/images/background/1.png') }}" class="jarallax-img" alt="">
            <div class="sw-overlay"></div>

            <div class="container">
                
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-12">

                        <div class="owl-2-dots owl-carousel owl-theme wow fadeIn fadeInUp" data-margin="50">

                            <div class="item">
                                <div class="relative">
                                    <div class="abs fs-84 lh-1 id-color">
                                        01
                                    </div>
                                    <div class="ms-100px ps-3">
                                        <h3 class="fs-32 col-lg-6 mb-4 lh-1-4">"Metode Belajar yang Menyenangkan"</h3>
                                        <p>"MindMap membantu saya memahami materi pelajaran dengan cara visual. Sangat mudah diingat dan membuat belajar jadi lebih menyenangkan!"</p>
                                    </div>

                                    <div class="border-bottom op-3 my-4"></div>

                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="w-70px circle me-3" src="{{ asset('frontend/images/testimonial/1.webp') }}" alt="">
                                            <div class="ps-4">
                                                <div class="hs-5 mb-1 fw-500 lh-1">Andi Pratama</div>
                                                <small>Siswa SD Kelas 5</small>
                                            </div>
                                        </div>
                                        <div class="de-rating-ext mt-4 xs-hide">
                                            <span class="d-stars">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                            </span>
                                            <span class="ms-2 text-white">5.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="relative">
                                    <div class="abs fs-84 lh-1 id-color">
                                        02
                                    </div>
                                    <div class="ms-100px ps-3">
                                        <h3 class="fs-32 col-lg-6 mb-4 lh-1-4">"Nilai Saya Meningkat Drastis"</h3>
                                        <p>"Setelah menggunakan MindMap, nilai matematika saya naik dari 70 menjadi 95. Kuis interaktif sangat membantu untuk latihan."</p>
                                    </div>

                                    <div class="border-bottom op-3 my-4"></div>

                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="w-70px circle me-3" src="{{ asset('frontend/images/testimonial/2.webp') }}" alt="">
                                            <div class="ps-4">
                                                <div class="hs-5 mb-1 fw-500 lh-1">Budi Santoso</div>
                                                <small>Siswa SMP Kelas 8</small>
                                            </div>
                                        </div>
                                        <div class="de-rating-ext mt-4 xs-hide">
                                            <span class="d-stars">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                            </span>
                                            <span class="ms-2 text-white">5.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="relative">
                                    <div class="abs fs-84 lh-1 id-color">
                                        03
                                    </div>
                                    <div class="ms-100px ps-3">
                                        <h3 class="fs-32 col-lg-6 mb-4 lh-1-4">"AI Assistant Sangat Membantu"</h3>
                                        <p>"Ketika saya bingung dengan materi, AI assistant selalu siap menjelaskan dengan cara yang mudah dipahami. Sangat recommended!"</p>
                                    </div>

                                    <div class="border-bottom op-3 my-4"></div>

                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="w-70px circle me-3" src="{{ asset('frontend/images/testimonial/3.webp') }}" alt="">
                                            <div class="ps-4">
                                                <div class="hs-5 mb-1 fw-500 lh-1">Citra Lestari</div>
                                                <small>Siswa SMA Kelas 11</small>
                                            </div>
                                        </div>
                                        <div class="de-rating-ext mt-4 xs-hide">
                                            <span class="d-stars">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                            </span>
                                            <span class="ms-2 text-white">5.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="relative">
                                    <div class="abs fs-84 lh-1 id-color">
                                        04
                                    </div>
                                    <div class="ms-100px ps-3">
                                        <h3 class="fs-32 col-lg-6 mb-4 lh-1-4">"Anak Saya Jadi Lebih Semangat Belajar"</h3>
                                        <p>"Sejak menggunakan MindMap, anak saya jadi lebih semangat belajar. Platform ini membuat pembelajaran jadi interaktif dan tidak membosankan."</p>
                                    </div>

                                    <div class="border-bottom op-3 my-4"></div>

                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="w-70px circle me-3" src="{{ asset('frontend/images/testimonial/4.webp') }}" alt="">
                                            <div class="ps-4">
                                                <div class="hs-5 mb-1 fw-500 lh-1">Ibu Ratna</div>
                                                <small>Orang Tua Siswa</small>
                                            </div>
                                        </div>
                                        <div class="de-rating-ext mt-4 xs-hide">
                                            <span class="d-stars">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                            </span>
                                            <span class="ms-2 text-white">5.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="relative">
                                    <div class="abs fs-84 lh-1 id-color">
                                        05
                                    </div>
                                    <div class="ms-100px ps-3">
                                        <h3 class="fs-32 col-lg-6 mb-4 lh-1-4">"Materi Lengkap dan Terstruktur"</h3>
                                        <p>"MindMap memiliki materi yang sangat lengkap dan terstruktur dengan baik. Sangat membantu untuk persiapan ujian sekolah."</p>
                                    </div>

                                    <div class="border-bottom op-3 my-4"></div>

                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="w-70px circle me-3" src="{{ asset('frontend/images/testimonial/5.webp') }}" alt="">
                                            <div class="ps-4">
                                                <div class="hs-5 mb-1 fw-500 lh-1">Dewi Kartika</div>
                                                <small>Guru SD</small>
                                            </div>
                                        </div>
                                        <div class="de-rating-ext mt-4 xs-hide">
                                            <span class="d-stars">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                            </span>
                                            <span class="ms-2 text-white">5.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="relative">
                                    <div class="abs fs-84 lh-1 id-color">
                                        06
                                    </div>
                                    <div class="ms-100px ps-3">
                                        <h3 class="fs-32 col-lg-6 mb-4 lh-1-4">"Platform Pembelajaran Terbaik"</h3>
                                        <p>"Sudah coba banyak platform belajar online, tapi MindMap yang paling saya suka. Desainnya bagus dan materinya mudah dipahami."</p>
                                    </div>

                                    <div class="border-bottom op-3 my-4"></div>

                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="w-70px circle me-3" src="{{ asset('frontend/images/testimonial/6.webp') }}" alt="">
                                            <div class="ps-4">
                                                <div class="hs-5 mb-1 fw-500 lh-1">Eko Prasetyo</div>
                                                <small>Siswa SMA Kelas 12</small>
                                            </div>
                                        </div>
                                        <div class="de-rating-ext mt-4 xs-hide">
                                            <span class="d-stars">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                            </span>
                                            <span class="ms-2 text-white">5.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="relative">
                                    <div class="abs fs-84 lh-1 id-color">
                                        07
                                    </div>
                                    <div class="ms-100px ps-3">
                                        <h3 class="fs-32 col-lg-6 mb-4 lh-1-4">"Leaderboard Membuat Saya Termotivasi"</h3>
                                        <p>"Fitur leaderboard membuat saya termotivasi untuk terus belajar dan berkompetisi dengan teman-teman secara sehat."</p>
                                    </div>

                                    <div class="border-bottom op-3 my-4"></div>

                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="w-70px circle me-3" src="{{ asset('frontend/images/testimonial/7.webp') }}" alt="">
                                            <div class="ps-4">
                                                <div class="hs-5 mb-1 fw-500 lh-1">Fajar Nugraha</div>
                                                <small>Siswa SMP Kelas 7</small>
                                            </div>
                                        </div>
                                        <div class="de-rating-ext mt-4 xs-hide">
                                            <span class="d-stars">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                            </span>
                                            <span class="ms-2 text-white">5.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="relative">
                                    <div class="abs fs-84 lh-1 id-color">
                                        08
                                    </div>
                                    <div class="ms-100px ps-3">
                                        <h3 class="fs-32 col-lg-6 mb-4 lh-1-4">"Sangat Membantu Persiapan UN"</h3>
                                        <p>"MindMap sangat membantu saya dalam persiapan UN. Materinya lengkap dan kuisnya sangat efektif untuk menguji pemahaman."</p>
                                    </div>

                                    <div class="border-bottom op-3 my-4"></div>

                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="w-70px circle me-3" src="{{ asset('frontend/images/testimonial/8.webp') }}" alt="">
                                            <div class="ps-4">
                                                <div class="hs-5 mb-1 fw-500 lh-1">Gita Pertiwi</div>
                                                <small>Siswa SMA Kelas 12</small>
                                            </div>
                                        </div>
                                        <div class="de-rating-ext mt-4 xs-hide">
                                            <span class="d-stars">
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                            </span>
                                            <span class="ms-2 text-white">5.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>                            

                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="pb-0">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="relative">
                            <div class="w-100 pe-5 pb-5 wow scaleIn">
                                <img src="{{ asset('frontend/images/misc/1.jpeg') }}" class="w-100 rounded-1" alt="">
                            </div>
                            <img src="{{ asset('frontend/images/misc/2.jpeg') }}" class="w-40 rounded-1 abs end-0 bottom-0 z-2 soft-shadow wow scaleIn" data-wow-delay=".2s" alt="">
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

                            <a href="#" class="btn-main fx-slide wow fadeInUp" data-wow-delay=".8s">
                                <span>Mulai Belajar</span>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row g-4 gx-5">
                    <div class="col-lg-4">
                        <div class="subtitle id-color wow fadeInUp" data-wow-delay=".0s">
                            Keunggulan MindMap
                        </div>
                        <h2 class="wow fadeInUp" data-wow-delay=".2s">
                            Mengapa Memilih MindMap?
                        </h2>
                        <p class="wow fadeInUp" data-wow-delay=".4s">
                            Kami menggabungkan teknologi modern dengan metode pembelajaran efektif untuk menciptakan pengalaman belajar yang interaktif, menyenangkan, dan hasilnya nyata.
                        </p>
                    </div>
                    <div class="col-lg-8">
                        <div class="row g-4">
                            <div class="col-md-6 wow fadeInUp" data-wow-delay=".3s">
                                <div class="relative">
                                    <span class="abs w-70px p-3 circle bg-color-op-2 d-block">
                                        <img src="{{ asset('frontend/images/icons-color/check.png') }}" class="w-100" alt="">
                                    </span>
                                    <div class="ps-90">
                                        <h3 class="hs-4">Pembelajaran Visual</h3>
                                        <p class="mb-0">
                                            MindMap interaktif membantu siswa memahami konsep kompleks dengan cara visual yang mudah diingat.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 wow fadeInUp" data-wow-delay=".4s">
                                <div class="relative">
                                    <span class="abs w-70px p-3 circle bg-color-op-2 d-block">
                                        <img src="{{ asset('frontend/images/icons-color/check.png') }}" class="w-100" alt="">
                                    </span>
                                    <div class="ps-90">
                                        <h3 class="hs-4">AI Assistant Pintar</h3>
                                        <p class="mb-0">
                                            Dapatkan bantuan belajar 24/7 dari AI yang siap menjawab pertanyaan dan menjelaskan materi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 wow fadeInUp" data-wow-delay=".5s">
                                <div class="relative">
                                    <span class="abs w-70px p-3 circle bg-color-op-2 d-block">
                                        <img src="{{ asset('frontend/images/icons-color/check.png') }}" class="w-100" alt="">
                                    </span>
                                    <div class="ps-90">
                                        <h3 class="hs-4">Kuis Interaktif</h3>
                                        <p class="mb-0">
                                            Latih pemahaman dengan kuis yang memberikan umpan balik instan dan penilaian otomatis.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 wow fadeInUp" data-wow-delay=".6s">
                                <div class="relative">
                                    <span class="abs w-70px p-3 circle bg-color-op-2 d-block">
                                        <img src="{{ asset('frontend/images/icons-color/check.png') }}" class="w-100" alt="">
                                    </span>
                                    <div class="ps-90">
                                        <h3 class="hs-4">Progress Tracking</h3>
                                        <p class="mb-0">
                                            Pantau perkembangan belajar dan raih prestasi di leaderboard untuk motivasi berkelanjutan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="bg-color-op-3">
            <div class="container">
                <div class="row g-4 gx-5 justify-content-center align-items-center">
                    <div class="col-lg-6 text-center">
                        <div class="subtitle wow fadeInUp" data-wow-delay=".3s">Transformasi Belajar</div>
                        <h2 class="wow fadeInUp" data-wow-delay=".6s">
                            Dari Biasa Menjadi Luar Biasa
                        </h2>
                    </div>
                    <div class="col-lg-12">
                        <div class="twentytwenty-container rounded-1 wow fadeInUp">
                            <img src="{{ asset('frontend/images/before-after/2.jpeg') }}" alt="" class="img-responsive">
                            <img src="{{ asset('frontend/images/before-after/1.png') }}" alt="" class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="overflow-hidden pb-0">
            <div class="container">
                <div class="row mb-3 g-4 align-items-center justify-content-between">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay=".2s">
                        <div class="subtitle id-color wow fadeInUp">Materi Terbaru</div>
                        <h2 class="wow fadeInUp">Dibuat dengan Semangat</h2>
                    </div>
                    <div class="col-lg-6">
                        <div class="relative">
                            <div class="de-custom-nav d-flex flex-end" data-target="#services-carousel">
                                <div class="d-prev"></div>
                                <div class="d-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="services-carousel" class="owl-3-cols owl-carousel owl-theme">
                            <!-- item begin -->
                            <div class="item">
                                <div class="relative">
                                    <div class="overflow-hidden rounded-1">
                                        <img src="{{ asset('frontend/images/projects/1.webp') }}" class="w-100" alt="">
                                    </div>
                                </div>
                            </div>
                            <!-- item end -->
                            <!-- item begin -->
                            <div class="item">
                                <div class="relative">
                                    <div class="overflow-hidden rounded-1">
                                        <img src="{{ asset('frontend/images/projects/2.webp') }}" class="w-100" alt="">
                                    </div>
                                </div>
                            </div>
                            <!-- item end -->
                            <!-- item begin -->
                            <div class="item">
                                <div class="relative">
                                    <div class="overflow-hidden rounded-1">
                                        <img src="{{ asset('frontend/images/projects/3.webp') }}" class="w-100" alt="">
                                    </div>
                                </div>
                            </div>
                            <!-- item end -->
                            <!-- item begin -->
                            <div class="item">
                                <div class="relative">
                                    <div class="overflow-hidden rounded-1">
                                        <img src="{{ asset('frontend/images/projects/4.webp') }}" class="w-100" alt="">
                                    </div>
                                </div>
                            </div>
                            <!-- item end -->
                            <!-- item begin -->
                            <div class="item">
                                <div class="relative">
                                    <div class="overflow-hidden rounded-1">
                                        <img src="{{ asset('frontend/images/projects/5.webp') }}" class="w-100" alt="">
                                    </div>
                                </div>
                            </div>
                            <!-- item end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        

        <section>
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

        <section class="p-0" aria-label="section">
            <div class="bg-color-op-8 text-light d-flex py-3 lh-1">
                <div class="de-marquee-list-1">
                    <div class="hs-2 d-inline-block mb-0 fs-48 mx-4">Matematika Interaktif</div>
                    <div class="hs-2 d-inline-block mb-0 fs-48 mx-4 op-5">Bahasa Indonesia Visual</div>
                    <div class="hs-2 d-inline-block mb-0 fs-48 mx-4">IPA Praktis</div>
                    <div class="hs-2 d-inline-block mb-0 fs-48 mx-4 op-5">IPS Menarik</div>
                    <div class="hs-2 d-inline-block mb-0 fs-48 mx-4">MindMap Kreatif</div>
                    <div class="hs-2 d-inline-block mb-0 fs-48 mx-4 op-5">Kuis Menantang</div>
                    <div class="hs-2 d-inline-block mb-0 fs-48 mx-4">AI Assistant Cerdas</div>
                    <div class="hs-2 d-inline-block mb-0 fs-48 mx-4 op-5">Progress Tracking</div>
                    <div class="hs-2 d-inline-block mb-0 fs-48 mx-4">Leaderboard Seru</div>
                    <div class="hs-2 d-inline-block mb-0 fs-48 mx-4 op-5">Pembelajaran Modern</div>
                </div>
            </div>
        </section>  
@endsection