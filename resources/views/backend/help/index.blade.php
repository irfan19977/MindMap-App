@extends('backend.layouts.app')

@section('title', 'Pusat Bantuan - MindMap')

@section('content')
        <div class="nxl-content pt-0">
            <!-- [ page-header ] start -->
            <div class="row g-0 align-items-center border-bottom help-center-content-header">
                <div class="col-lg-6 offset-lg-3 text-center">
                    <h2 class="fw-bolder mb-2 text-dark">Pusat Bantuan</h2>
                    <p class="text-muted">Temukan panduan lengkap penggunaan platform MindMap Education.</p>
                    <form id="helpSearchForm" action="javascript:void(0);" class="my-4 d-none d-sm-block search-form">
                        <div class="input-group select-wd-sm">
                            <select id="helpSearchSelect" class="form-control" data-select2-selector="icon">
                                <option value="all" data-icon="feather-help-circle">Semua</option>
                                <option value="memulai" data-icon="feather-airplay">Memulai</option>
                                <option value="konten" data-icon="feather-folder">Konten</option>
                                <option value="mindmap" data-icon="feather-git-branch">MindMap</option>
                                <option value="faq" data-icon="feather-help-circle">FAQ</option>
                                <option value="pengguna" data-icon="feather-users">Pengguna</option>
                                <option value="laporan" data-icon="feather-bar-chart-2">Laporan</option>
                            </select>
                            <input id="helpSearchInput" type="text" class="form-control w-25" placeholder="Cari topik atau pertanyaan di sini...">
                            <button type="submit" class="btn btn-primary">
                                <i class="feather-search"></i>
                                <span class="ms-2">Cari</span>
                            </button>
                        </div>
                        <div id="helpSearchStatus" class="mt-3 text-muted small"></div>
                    </form>
                    <div class="mt-2 d-none d-sm-block">
                        <span class="fs-12 text-muted">Populer:</span>
                        <a href="javascript:void(0);" class="badge bg-gray-100 shadow-sm text-muted mx-1 help-popular-badge" onclick="handlePopularBadgeClick(event, 'Bagaimana cara membuat materi pembelajaran baru?')">Membuat Materi</a>
                        <a href="javascript:void(0);" class="badge bg-gray-100 shadow-sm text-muted mx-1 help-popular-badge" onclick="handlePopularBadgeClick(event, 'Bagaimana cara membuat mind map untuk materi?')">MindMap</a>
                        <a href="javascript:void(0);" class="badge bg-gray-100 shadow-sm text-muted mx-1 help-popular-badge" onclick="handlePopularBadgeClick(event, 'Bagaimana cara mengelola quiz dan soal?')">Quiz</a>
                        <a href="javascript:void(0);" class="badge bg-gray-100 shadow-sm text-muted mx-1 help-popular-badge" onclick="handlePopularBadgeClick(event, 'Bagaimana cara menambahkan user dan mengatur role?')">Manajemen User</a>
                        <a href="javascript:void(0);" class="badge bg-gray-100 shadow-sm text-muted mx-1 help-popular-badge" onclick="handlePopularBadgeClick(event, 'Bagaimana cara melihat hasil pembelajaran siswa?')">Laporan</a>
                    </div>
                </div>
                <!--! ================================================================ !-->
                <!--! END: Content Sub Header [content-sub-header] !-->
                <!--! ================================================================ !-->
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content container-lg px-4 help-center-main-contet-area overflow-visible">
                <!--! BEGIN: [help-quick-card] !-->
                <div class="row help-quick-card">
                    <div class="col-lg-4">
                        <div class="card mb-4 mb-lg-0">
                            <div class="card-body p-5">
                                <div class="wd-50 ht-50 d-flex align-items-center justify-content-center mb-5">
                                    <img src="{{ asset('backend/assets/images/icons/line-icon/idea.png') }}" class="img-fluid" alt="">
                                </div>
                                <h2 class="fs-16 fw-bold mb-3">Panduan Pengguna</h2>
                                <p class="fs-12 fw-medium text-muted text-truncate-3-line">Pelajari dasar-dasar penggunaan platform MindMap Education, mulai dari login dashboard hingga mengelola konten pembelajaran.</p>
                                <a href="javascript:void(0);" class="fs-12" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas" onclick="(function(){const all=Array.from(document.querySelectorAll('.topic-category-section a[data-bs-target="#topicsDetailsOffcanvas"], .topic-tranding-section a[data-bs-target="#topicsDetailsOffcanvas"]')); const link=all.find(l=>/materi/i.test(l.textContent)); if(link){link.click();}})()">Pelajari Lebih Lanjut &rarr;</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-4 mb-lg-0">
                            <div class="card-body p-5">
                                <div class="wd-50 ht-50 d-flex align-items-center justify-content-center mb-5">
                                    <img src="{{ asset('backend/assets/images/icons/line-icon/support.png') }}" class="img-fluid" alt="">
                                </div>
                                <h2 class="fs-16 fw-bold mb-3">Hubungi Support</h2>
                                <p class="fs-12 fw-medium text-muted text-truncate-3-line">Butuh bantuan lebih lanjut? Tim support kami siap membantu mengatasi kendala teknis dan pertanyaan seputar platform.</p>
                                <a href="https://wa.me/6285802733781?text=Halo%20MindMap%20Support%2C%20saya%20membutuhkan%20bantuan." target="_blank" class="fs-12">Hubungi via WhatsApp &rarr;</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-4 mb-lg-0">
                            <div class="card-body p-5">
                                <div class="wd-50 ht-50 d-flex align-items-center justify-content-center mb-5">
                                    <img src="{{ asset('backend/assets/images/icons/line-icon/rocket.png') }}" class="img-fluid" alt="">
                                </div>
                                <h2 class="fs-16 fw-bold mb-3">FAQ</h2>
                                <p class="fs-12 fw-medium text-muted text-truncate-3-line">Jawaban cepat untuk pertanyaan yang sering diajukan oleh admin, guru, dan pengguna platform.</p>
                                <a href="javascript:void(0);" class="fs-12" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas" onclick="(function(){const all=Array.from(document.querySelectorAll('.topic-category-section a[data-bs-target="#topicsDetailsOffcanvas"], .topic-tranding-section a[data-bs-target="#topicsDetailsOffcanvas"]')); const link=all.find(l=>/materi/i.test(l.textContent)); if(link){link.click();}})()">Lihat FAQ &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--! BEGIN: [topic-category-section] !-->
                <section class="topic-category-section">
                    <div class="d-flex flex-column align-items-center justify-content-center mb-5">
                        <h2 class="fs-20 fw-bold mb-3">Kategori Dokumentasi</h2>
                        <p class="px-5 mx-5 text-center text-muted text-truncate-3-line">Pilih kategori panduan sesuai dengan kebutuhan Anda dalam mengelola platform MindMap Education.</p>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-6">
                            <div class="card p-4 mb-4">
                                <div class="d-sm-flex align-items-center">
                                    <div class="wd-50 ht-50 p-2 d-flex align-items-center justify-content-center border rounded-3">
                                        <img src="{{ asset('backend/assets/images/icons/line-icon/safe.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="ms-0 ms-sm-3 mt-4 mt-sm-0">
                                        <h2 class="fs-14 fw-bold mb-1">Memulai</h2>
                                        <span class="fs-10 fw-semibold text-uppercase text-muted">5 topik</span>
                                    </div>
                                </div>
                                <ul class="list-unstyled mb-0 mt-4 ms-sm-5 ps-sm-3">
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Login ke Dashboard</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Mengenal Tampilan Dashboard</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Peran Admin dan Guru</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Mengubah Tema Tampilan</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Logout dengan Aman</a>
                                    </li>
                                </ul>
                                <div class="mt-4 ms-5 ps-3">
                                    <a href="javascript:void(0);" class="fs-12">Lebih Banyak Topik &rarr;</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6">
                            <div class="card p-4 mb-4">
                                <div class="d-sm-flex align-items-center">
                                    <div class="wd-50 ht-50 p-2 d-flex align-items-center justify-content-center border rounded-3">
                                        <img src="{{ asset('backend/assets/images/icons/line-icon/mexican.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="ms-0 ms-sm-3 mt-4 mt-sm-0">
                                        <h2 class="fs-14 fw-bold mb-1">Kelola Konten</h2>
                                        <span class="fs-10 fw-semibold text-uppercase text-muted">6 topik</span>
                                    </div>
                                </div>
                                <ul class="list-unstyled mb-0 mt-4 ms-sm-5 ps-sm-3">
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Menambah Kategori</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Menambah Sub Kategori</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Membuat Materi Baru</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Mengubah Status Materi</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Mengonversi PDF ke Materi</a>
                                    </li>
                                </ul>
                                <div class="mt-4 ms-5 ps-3">
                                    <a href="javascript:void(0);" class="fs-12">Lebih Banyak Topik &rarr;</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6">
                            <div class="card p-4 mb-4">
                                <div class="d-sm-flex align-items-center">
                                    <div class="wd-50 ht-50 p-2 d-flex align-items-center justify-content-center border rounded-3">
                                        <img src="{{ asset('backend/assets/images/icons/line-icon/shield.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="ms-0 ms-sm-3 mt-4 mt-sm-0">
                                        <h2 class="fs-14 fw-bold mb-1">MindMap</h2>
                                        <span class="fs-10 fw-semibold text-uppercase text-muted">4 topik</span>
                                    </div>
                                </div>
                                <ul class="list-unstyled mb-0 mt-4 ms-sm-5 ps-sm-3">
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Membuat MindMap</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Menyimpan MindMap</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Memuat MindMap</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Mengaitkan MindMap dengan Materi</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Tips Visualisasi MindMap</a>
                                    </li>
                                </ul>
                                <div class="mt-4 ms-5 ps-3">
                                    <a href="javascript:void(0);" class="fs-12">Lebih Banyak Topik &rarr;</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6">
                            <div class="card p-4 mb-4">
                                <div class="d-sm-flex align-items-center">
                                    <div class="wd-50 ht-50 p-2 d-flex align-items-center justify-content-center border rounded-3">
                                        <img src="{{ asset('backend/assets/images/icons/line-icon/money-bag.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="ms-0 ms-sm-3 mt-4 mt-sm-0">
                                        <h2 class="fs-14 fw-bold mb-1">Quiz & Evaluasi</h2>
                                        <span class="fs-10 fw-semibold text-uppercase text-muted">5 topik</span>
                                    </div>
                                </div>
                                <ul class="list-unstyled mb-0 mt-4 ms-sm-5 ps-sm-3">
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Membuat Quiz</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Mengelola Soal Quiz</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Melihat Hasil Quiz Siswa</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Export Hasil Quiz</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Mengatur Passing Grade</a>
                                    </li>
                                </ul>
                                <div class="mt-4 ms-5 ps-3">
                                    <a href="javascript:void(0);" class="fs-12">Lebih Banyak Topik &rarr;</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6">
                            <div class="card p-4 mb-4">
                                <div class="d-sm-flex align-items-center">
                                    <div class="wd-50 ht-50 p-2 d-flex align-items-center justify-content-center border rounded-3">
                                        <img src="{{ asset('backend/assets/images/icons/line-icon/lifebuoy.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="ms-0 ms-sm-3 mt-4 mt-sm-0">
                                        <h2 class="fs-14 fw-bold mb-1">Manajemen Pengguna</h2>
                                        <span class="fs-10 fw-semibold text-uppercase text-muted">5 topik</span>
                                    </div>
                                </div>
                                <ul class="list-unstyled mb-0 mt-4 ms-sm-5 ps-sm-3">
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Menambah User Baru</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Mengelola Role</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Mengelola Permission</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Reset Password User</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Membedakan Admin dan Guru</a>
                                    </li>
                                </ul>
                                <div class="mt-4 ms-5 ps-3">
                                    <a href="javascript:void(0);" class="fs-12">Lebih Banyak Topik &rarr;</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6">
                            <div class="card p-4 mb-4">
                                <div class="d-sm-flex align-items-center">
                                    <div class="wd-50 ht-50 p-2 d-flex align-items-center justify-content-center border rounded-3">
                                        <img src="{{ asset('backend/assets/images/icons/line-icon/award.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="ms-0 ms-sm-3 mt-4 mt-sm-0">
                                        <h2 class="fs-14 fw-bold mb-1">Laporan & Analitik</h2>
                                        <span class="fs-10 fw-semibold text-uppercase text-muted">4 topik</span>
                                    </div>
                                </div>
                                <ul class="list-unstyled mb-0 mt-4 ms-sm-5 ps-sm-3">
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Melihat Dashboard Analitik</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Tracking Hasil Pembelajaran</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Export Data Laporan</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Memahami Statistik Quiz</a>
                                    </li>
                                    <li class="mb-2">
                                        <i class="feather-file-text me-2 fs-13"></i>
                                        <a href="javascript:void(0);" class="fs-13 fw-medium" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Aktivitas Platform</a>
                                    </li>
                                </ul>
                                <div class="mt-4 ms-5 ps-3">
                                    <a href="javascript:void(0);" class="fs-12">Lebih Banyak Topik &rarr;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--! BEGIN: [topic-tranding-section] !-->
                <section class="topic-tranding-section">
                    <div class="d-flex flex-column align-items-center justify-content-center mb-5">
                        <h2 class="fs-20 fw-bold mb-3">Topik Populer</h2>
                        <p class="px-5 mx-5 text-center text-muted text-truncate-3-line">Panduan cepat untuk fitur yang paling sering digunakan di platform MindMap Education.</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara menambahkan kategori pembelajaran?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara membuat materi pembelajaran baru?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara membuat mind map untuk materi?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara mengelola quiz dan soal?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara melihat hasil pembelajaran siswa?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara menambahkan user dan mengatur role?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara mengubah tema tampilan dashboard?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara mengonversi PDF menjadi materi?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara export laporan hasil quiz?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Apa perbedaan admin dan guru di platform ini?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara melihat aktivitas platform?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara mengatur permission pengguna?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara reset password user?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card border rounded-3 mb-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                            <i class="feather-file-text"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="text-truncate-1-line" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">Bagaimana cara logout dengan aman?</a>
                                    </div>
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm me-3" data-bs-toggle="offcanvas" data-bs-target="#topicsDetailsOffcanvas">
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--! BEGIN: [still-question-section] !-->
                <section class="still-question-section">
                    <div class="d-flex flex-column align-items-center justify-content-center mb-5">
                        <h2 class="fs-20 fw-bold mb-3">Masih Punya Pertanyaan?</h2>
                        <p class="px-5 mx-5 text-center text-muted text-truncate-3-line">Tim support MindMap Education siap membantu Anda. Hubungi kami melalui salah satu channel di bawah ini.</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card card-body pb-0 pb-lg-4 text-center">
                                <a href="mailto:mindmapeducation1997@gmail.com" class="card stretch stretch-full p-5 mb-4 mb-lg-0 d-flex flex-column flex-fill align-items-center justify-content-center border rounded-3">
                                    <div class="mb-4 wd-50 ht-50">
                                        <img src="{{ asset('backend/assets/images/icons/line-icon/email.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="fs-14 fw-bold d-block mb-1">mindmapeducation1997@gmail.com</div>
                                    <div class="fs-12 fw-medium text-muted text-truncate-1-line">Cara terbaik untuk mendapatkan jawaban cepat.</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card card-body pb-0 pb-lg-4 text-center">
                                <a href="tel:+6285802733781" class="card stretch stretch-full p-5 mb-4 mb-lg-0 d-flex flex-column flex-fill align-items-center justify-content-center border rounded-3">
                                    <div class="mb-4 wd-50 ht-50">
                                        <img src="{{ asset('backend/assets/images/icons/line-icon/phone.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="fs-14 fw-bold d-block mb-1">+62 858 0273 3781</div>
                                    <div class="fs-12 fw-medium text-muted text-truncate-1-line">Hubungi kami pada jam kerja.</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card card-body pb-0 pb-lg-4 text-center">
                                <a href="mailto:mindmapeducation1997@gmail.com?subject=Ticket%20Support" class="card stretch stretch-full p-5 mb-4 mb-lg-0 d-flex flex-column flex-fill align-items-center justify-content-center border rounded-3">
                                    <div class="mb-4 wd-50 ht-50">
                                        <img src="{{ asset('backend/assets/images/icons/line-icon/notebook.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="fs-14 fw-bold d-block mb-1">Kirim Tiket</div>
                                    <div class="fs-12 fw-medium text-muted text-truncate-1-line">Jelaskan kendala Anda secara detail.</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    <div class="offcanvas offcanvas-end topics-details-offcanvas" tabindex="-1" id="topicsDetailsOffcanvas" aria-labelledby="topicsDetailsOffcanvas">
        <div class="offcanvas-header border-bottom px-4">
            <div class="d-flex">
                <a href="javascript:void(0);">Bantuan</a>
                <span class="mx-2 text-muted">/</span>
                <a href="javascript:void(0);">Konten</a>
                <span class="mx-2 text-muted">/</span>
                <div class="text-muted">Materi</div>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="p-lg-5 mx-lg-5 help-center details-content-body">
                <h2 class="fs-18">Bagaimana cara membuat materi pembelajaran baru?</h2>
                <p class="fs-12 text-muted">Terakhir diperbarui: <span class="text-dark fw-medium">7 Juli 2026</span></p>
                <hr class="my-4">
                <h4 class="fs-14">Langkah-langkah Membuat Materi</h4>
                <p class="text-muted">Materi pembelajaran adalah unit utama konten di platform MindMap Education. Berikut langkah-langkah untuk membuat materi baru:</p>
                <ul class="text-muted my-4">
                    <li class="mb-2"><strong class="text-dark">1. Navigasi ke Menu Materi</strong> — Pilih menu <em>Konten Edukasi &gt; Materi</em> pada sidebar.</li>
                    <li class="mb-2"><strong class="text-dark">2. Klik Tombol Tambah</strong> — Pilih <em>Tambah Materi</em> atau klik tombol plus di halaman daftar materi.</li>
                    <li class="mb-2"><strong class="text-dark">3. Isi Informasi Materi</strong> — Masukkan judul, pilih kategori dan sub kategori, serta isi konten utama.</li>
                    <li class="mb-2"><strong class="text-dark">4. Tambahkan MindMap</strong> — Jika diperlukan, buat atau pilih mind map yang sudah ada untuk materi tersebut.</li>
                    <li class="mb-2"><strong class="text-dark">5. Atur Status</strong> — Pilih status aktif atau draft sesuai kebutuhan.</li>
                    <li><strong class="text-dark">6. Simpan</strong> — Klik tombol <em>Simpan</em> untuk mempublikasikan materi.</li>
                </ul>
                <div class="mt-5">
                    <h2 class="fs-13 fw-700 mb-3">Fitur Pendukung Materi</h2>
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-center mb-2">
                            <span class="avatar-text avatar-sm bg-soft-success text-success me-2">
                                <i class="feather-check fs-10"></i>
                            </span>
                            <span>Konversi otomatis dari file PDF menjadi materi.</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <span class="avatar-text avatar-sm bg-soft-success text-success me-2">
                                <i class="feather-check fs-10"></i>
                            </span>
                            <span>Integrasi mind map interaktif pada setiap materi.</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <span class="avatar-text avatar-sm bg-soft-success text-success me-2">
                                <i class="feather-check fs-10"></i>
                            </span>
                            <span>Penyusunan hierarki kategori dan sub kategori.</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <span class="avatar-text avatar-sm bg-soft-success text-success me-2">
                                <i class="feather-check fs-10"></i>
                            </span>
                            <span>Status aktif/draft untuk kontrol publikasi.</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <span class="avatar-text avatar-sm bg-soft-success text-success me-2">
                                <i class="feather-check fs-10"></i>
                            </span>
                            <span>Dapat diakses siswa melalui halaman kelas di frontend.</span>
                        </li>
                    </ul>
                </div>
                <div class="mb-5">
                    <pre><code class="language-html">
&lt;!-- Contoh struktur materi di frontend --&gt;
&lt;div class="materi-card"&gt;
    &lt;h3&gt;Judul Materi&lt;/h3&gt;
    &lt;p&gt;Deskripsi atau konten pembelajaran.&lt;/p&gt;
    &lt;div class="mindmap-preview"&gt;&lt;/div&gt;
&lt;/div&gt;
                    </code>
                        </pre>
                </div>
                <h4 class="fs-13">Tips Pengelolaan Materi</h4>
                <p class="text-muted mb-4">Pastikan setiap materi memiliki kategori yang jelas dan mind map yang relevan agar siswa dapat belajar dengan lebih efektif. Gunakan fitur quiz untuk evaluasi pemahaman siswa.</p>
                <h4 class="fs-13">Pemecahan Masalah</h4>
                <p class="text-muted mb-4">Jika materi tidak muncul di frontend, periksa status materi (harus aktif) dan pastikan kategori serta sub kategori sudah benar.</p>
                <hr class="my-5">
                <p class="text-muted">Setelah materi dibuat, Anda dapat mengaitkannya dengan quiz dan mind map untuk memberikan pengalaman belajar yang lebih interaktif.</p>
                <ul class="text-muted my-4">
                    <li class="mb-2"><strong class="text-dark">MindMap</strong> — visualisasi konsep pembelajaran.</li>
                    <li class="mb-2"><strong class="text-dark">Quiz</strong> — evaluasi pemahaman siswa.</li>
                    <li class="mb-2"><strong class="text-dark">Tracking</strong> — pantau progress siswa.</li>
                    <li class="mb-2"><strong class="text-dark">Export</strong> — unduh laporan hasil pembelajaran.</li>
                </ul>
                <hr class="my-5">
                <div class="w-100 p-5 bg-gray-100 text-center">
                    <h2 class="fs-16 mb-2">Kesulitan saat login?</h2>
                    <p class="text-muted">Lihat panduan umum atau hubungi tim support kami.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="javascript:void(0);" class="btn btn-sm btn-success">Baca FAQ</a>
                        <a href="mailto:mindmapeducation1997@gmail.com" class="btn btn-sm btn-danger">Hubungi Support</a>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <div class="d-flex align-items-center text-muted">
                        <span class="fs-11 me-3">Apakah artikel ini membantu?</span>
                        <a href="javascript:void(0);" class="wd-15 ht-15 d-flex align-items-center justify-content-center p-2 rounded-3 bg-gray-100 m-1">
                            <i class="feather-x fs-12 text-danger"></i>
                        </a>
                        <a href="javascript:void(0);" class="wd-15 ht-15 d-flex align-items-center justify-content-center p-2 rounded-3 bg-gray-100 m-1">
                            <i class="feather-check fs-12 text-success"></i>
                        </a>
                    </div>
                </div>
                <hr class="my-5">
                <div class="mb-4">
                    <h2 class="fs-18 mb-1">Topik dalam koleksi ini</h2>
                    <p class="fs-12 text-muted">6 topik lain dalam koleksi Kelola Konten</p>
                </div>
                <div class="row">
                    <div class="col-xxl-6">
                        <div class="card border rounded-3 mb-3 overflow-hidden">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                        <i class="feather-file-text"></i>
                                    </div>
                                    <a href="javascript:void(0);">Bagaimana cara menambahkan kategori?</a>
                                </div>
                                <a href="javascript:void(0);" class="avatar-text avatar-sm me-3">
                                    <i class="feather-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card border rounded-3 mb-3 overflow-hidden">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                        <i class="feather-file-text"></i>
                                    </div>
                                    <a href="javascript:void(0);">Bagaimana cara membuat sub kategori?</a>
                                </div>
                                <a href="javascript:void(0);" class="avatar-text avatar-sm me-3">
                                    <i class="feather-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card border rounded-3 mb-3 overflow-hidden">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                        <i class="feather-file-text"></i>
                                    </div>
                                    <a href="javascript:void(0);">Bagaimana cara mengonversi PDF ke materi?</a>
                                </div>
                                <a href="javascript:void(0);" class="avatar-text avatar-sm me-3">
                                    <i class="feather-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6">
                        <div class="card border rounded-3 mb-3 overflow-hidden">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                        <i class="feather-file-text"></i>
                                    </div>
                                    <a href="javascript:void(0);">Bagaimana cara mengubah status materi?</a>
                                </div>
                                <a href="javascript:void(0);" class="avatar-text avatar-sm me-3">
                                    <i class="feather-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card border rounded-3 mb-3 overflow-hidden">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                        <i class="feather-file-text"></i>
                                    </div>
                                    <a href="javascript:void(0);">Bagaimana cara mengaitkan mind map dengan materi?</a>
                                </div>
                                <a href="javascript:void(0);" class="avatar-text avatar-sm me-3">
                                    <i class="feather-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card border rounded-3 mb-3 overflow-hidden">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="wd-50 ht-50 bg-gray-100 me-3 d-flex align-items-center justify-content-center">
                                        <i class="feather-file-text"></i>
                                    </div>
                                    <a href="javascript:void(0);">Bagaimana cara menambah quiz pada materi?</a>
                                </div>
                                <a href="javascript:void(0);" class="avatar-text avatar-sm me-3">
                                    <i class="feather-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    .topic-category-section .card,
    .topic-tranding-section .card {
        transition: all 0.25s ease;
        cursor: pointer;
    }

    .topic-category-section .card.is-active,
    .topic-tranding-section .card.is-active {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.12);
        border-color: #0d6efd !important;
        background: linear-gradient(135deg, #f8fbff 0%, #eef5ff 100%);
    }

    .topic-category-section .card.is-active .feather-arrow-right,
    .topic-tranding-section .card.is-active .feather-arrow-right {
        transform: translateX(3px);
        color: #0d6efd;
    }

    .help-action-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .help-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    .help-action-btn:active {
        transform: translateY(0);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .help-action-btn.clicked {
        animation: buttonClick 0.6s ease;
    }

    @keyframes buttonClick {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const offcanvas = document.querySelector('.topics-details-offcanvas');
        const headerWrap = offcanvas?.querySelector('.offcanvas-header .d-flex');
        const body = offcanvas?.querySelector('.details-content-body');

        if (!offcanvas || !headerWrap || !body) return;

        const topicData = {
            login: {
                title: 'Cara Login ke Dashboard',
                breadcrumb: ['Bantuan', 'Akses', 'Login'],
                updated: '24 Juli 2026',
                summary: 'Gunakan akun yang sudah terdaftar untuk masuk ke dashboard sesuai peran Anda sebagai admin atau guru.',
                steps: [
                    'Buka halaman login dan masukkan email atau username beserta password.',
                    'Klik tombol Masuk, lalu pilih dashboard yang sesuai dengan akses Anda.',
                    'Jika muncul pesan gagal login, periksa password dan pastikan akun Anda aktif.'
                ],
                tips: 'Pastikan browser sudah diperbarui dan Anda tidak menggunakan password yang salah atau kadaluarsa.',
                problem: 'Jika tetap tidak bisa masuk, gunakan fitur reset password atau hubungi tim support.'
            },
            dashboard: {
                title: 'Mengenal Tampilan Dashboard',
                breadcrumb: ['Bantuan', 'Dashboard', 'Tampilan'],
                updated: '24 Juli 2026',
                summary: 'Dashboard menampilkan ringkasan fitur utama seperti materi, quiz, pengguna, dan laporan.',
                steps: [
                    'Lihat panel utama untuk melihat statistik dan aktivitas terbaru.',
                    'Gunakan menu samping untuk berpindah ke modul yang Anda butuhkan.',
                    'Pilih tombol cepat di bagian atas untuk akses fitur yang sering dipakai.'
                ],
                tips: 'Biasakan melihat menu samping terlebih dahulu supaya navigasi menjadi lebih cepat.',
                problem: 'Jika panel terlihat kosong, cek apakah Anda memiliki akses ke modul yang sedang dibuka.'
            },
            admin: {
                title: 'Peran Admin dan Guru',
                breadcrumb: ['Bantuan', 'Pengguna', 'Peran'],
                updated: '24 Juli 2026',
                summary: 'Admin dan guru memiliki akses berbeda sesuai tanggung jawab masing-masing dalam platform.',
                steps: [
                    'Admin biasanya mengelola pengguna, konten, dan pengaturan platform.',
                    'Guru lebih fokus pada pembuatan materi, quiz, dan pemantauan pembelajaran.',
                    'Peran dapat diatur melalui menu manajemen pengguna.'
                ],
                tips: 'Pastikan setiap akun memiliki peran yang sesuai agar hak akses tetap aman dan teratur.',
                problem: 'Jika Anda tidak melihat fitur tertentu, cek apakah role akun Anda sudah sesuai.'
            },
            theme: {
                title: 'Mengubah Tema Tampilan',
                breadcrumb: ['Bantuan', 'Pengaturan', 'Tema'],
                updated: '24 Juli 2026',
                summary: 'Tema tampilan dapat diubah agar dashboard lebih nyaman dipakai sesuai preferensi Anda.',
                steps: [
                    'Masuk ke menu pengaturan atau preferensi tampilan.',
                    'Pilih tema yang tersedia, misalnya terang atau gelap.',
                    'Simpan perubahan untuk menerapkan tampilan baru.'
                ],
                tips: 'Pilih tema yang nyaman untuk mata, terutama saat bekerja dalam waktu lama.',
                problem: 'Jika perubahan tema tidak muncul, coba refresh halaman atau cek akses pengaturan Anda.'
            },
            logout: {
                title: 'Logout dengan Aman',
                breadcrumb: ['Bantuan', 'Akses', 'Logout'],
                updated: '24 Juli 2026',
                summary: 'Logout yang aman membantu melindungi akun Anda dari akses yang tidak sah.',
                steps: [
                    'Klik profil atau avatar Anda di bagian kanan atas.',
                    'Pilih opsi Logout.',
                    'Pastikan halaman login muncul sebelum menutup browser.'
                ],
                tips: 'Selalu logout saat menggunakan perangkat publik atau bersama orang lain.',
                problem: 'Jika sesi masih aktif, tutup semua tab browser yang terkait dengan aplikasi.'
            },
            category: {
                title: 'Menambahkan Kategori Pembelajaran',
                breadcrumb: ['Bantuan', 'Konten', 'Kategori'],
                updated: '24 Juli 2026',
                summary: 'Kategori membantu mengelompokkan materi agar struktur konten lebih rapi dan mudah ditemukan.',
                steps: [
                    'Buka menu Konten Edukasi lalu pilih Kategori.',
                    'Klik tombol Tambah Kategori.',
                    'Isi nama kategori dan simpan perubahan.'
                ],
                tips: 'Gunakan nama kategori yang singkat, jelas, dan sesuai dengan topik pembelajaran.',
                problem: 'Jika kategori tidak muncul, cek apakah data sudah disimpan dan statusnya aktif.'
            },
            subcategory: {
                title: 'Menambahkan Sub Kategori',
                breadcrumb: ['Bantuan', 'Konten', 'Sub Kategori'],
                updated: '24 Juli 2026',
                summary: 'Sub kategori digunakan untuk mengelompokkan materi lebih rinci di dalam satu kategori utama.',
                steps: [
                    'Pilih kategori induk yang ingin ditambahkan sub kategorinya.',
                    'Klik tombol Tambah Sub Kategori.',
                    'Isi nama sub kategori lalu simpan.'
                ],
                tips: 'Buat sub kategori yang spesifik agar pencarian materi menjadi lebih mudah.',
                problem: 'Jika sub kategori tidak tersimpan, cek apakah kategori induk sudah dipilih dengan benar.'
            },
            material: {
                title: 'Membuat Materi Pembelajaran Baru',
                breadcrumb: ['Bantuan', 'Konten', 'Materi'],
                updated: '24 Juli 2026',
                summary: 'Materi adalah unit utama konten pembelajaran yang bisa dilengkapi dengan mind map dan quiz.',
                steps: [
                    'Buka menu Konten Edukasi lalu pilih Materi.',
                    'Klik tombol Tambah Materi.',
                    'Isi judul, kategori, sub kategori, dan isi konten utama.',
                    'Simpan materi agar tampil di frontend.'
                ],
                tips: 'Sertakan ringkasan singkat dan judul yang jelas agar siswa lebih mudah memahami isi materi.',
                problem: 'Jika materi tidak tampil, cek status materi apakah sudah aktif dan kategori sudah benar.'
            },
            status: {
                title: 'Mengubah Status Materi',
                breadcrumb: ['Bantuan', 'Konten', 'Status Materi'],
                updated: '24 Juli 2026',
                summary: 'Status materi menentukan apakah materi tersebut dapat dilihat oleh pengguna atau masih dalam tahap draft.',
                steps: [
                    'Buka daftar materi yang ingin diubah.',
                    'Pilih materi lalu ubah status menjadi Aktif atau Draft.',
                    'Simpan perubahan agar status diterapkan.'
                ],
                tips: 'Gunakan status Draft saat sedang revisi, lalu ubah ke Aktif saat siap dipublikasikan.',
                problem: 'Jika materi tetap tidak muncul, periksa apakah status sudah aktif dan perubahan sudah disimpan.'
            },
            pdf: {
                title: 'Mengonversi PDF ke Materi',
                breadcrumb: ['Bantuan', 'Konten', 'PDF'],
                updated: '24 Juli 2026',
                summary: 'File PDF dapat diubah menjadi materi pembelajaran agar lebih mudah dikelola di platform.',
                steps: [
                    'Siapkan file PDF yang ingin dikonversi.',
                    'Pilih fitur Konversi PDF ke Materi pada menu konten.',
                    'Lengkapi informasi materi lalu simpan hasil konversi.'
                ],
                tips: 'Gunakan PDF yang rapi dan terstruktur agar hasil konversi lebih jelas.',
                problem: 'Jika hasil konversi kurang baik, cek kualitas file PDF dan format dokumen.'
            },
            mindmap: {
                title: 'Mengelola Mind Map',
                breadcrumb: ['Bantuan', 'MindMap', 'Panduan'],
                updated: '24 Juli 2026',
                summary: 'Mind map membantu memvisualisasikan konsep pembelajaran dengan struktur yang lebih mudah dipahami.',
                steps: [
                    'Buka fitur MindMap dari menu yang tersedia.',
                    'Buat node utama lalu tambahkan sub node sesuai topik.',
                    'Simpan mind map dan kaitkan dengan materi jika diperlukan.'
                ],
                tips: 'Gunakan kata kunci singkat pada setiap node agar visualisasi tetap jelas.',
                problem: 'Jika mind map tidak tersimpan, cek koneksi internet dan pastikan tombol simpan sudah ditekan.'
            },
            quiz: {
                title: 'Membuat dan Mengelola Quiz',
                breadcrumb: ['Bantuan', 'Quiz', 'Panduan'],
                updated: '24 Juli 2026',
                summary: 'Quiz digunakan untuk mengukur pemahaman siswa melalui pertanyaan interaktif.',
                steps: [
                    'Buka menu Quiz pada materi yang ingin diberi evaluasi.',
                    'Tambahkan pertanyaan dan opsi jawaban.',
                    'Tentukan jawaban benar lalu simpan quiz.'
                ],
                tips: 'Buat pertanyaan yang jelas, singkat, dan sesuai target pembelajaran siswa.',
                problem: 'Jika quiz tidak muncul, cek apakah quiz sudah dipublikasikan dan materi terkait aktif.'
            },
            quizresult: {
                title: 'Melihat Hasil Quiz Siswa',
                breadcrumb: ['Bantuan', 'Quiz', 'Hasil'],
                updated: '24 Juli 2026',
                summary: 'Hasil quiz membantu melihat pemahaman siswa dan bagian mana yang masih perlu diperbaiki.',
                steps: [
                    'Buka halaman hasil quiz dari menu evaluasi.',
                    'Pilih quiz yang ingin dilihat.',
                    'Lihat skor, jawaban benar, dan detail pengerjaan siswa.'
                ],
                tips: 'Bandingkan hasil antar materi untuk mengetahui topik yang paling sulit dipahami.',
                problem: 'Jika hasil tidak tampil, pastikan quiz sudah memiliki data jawaban dari siswa.'
            },
            exportquiz: {
                title: 'Export Hasil Quiz',
                breadcrumb: ['Bantuan', 'Quiz', 'Export'],
                updated: '24 Juli 2026',
                summary: 'Export hasil quiz memudahkan admin atau guru untuk menyimpan laporan dalam format yang siap dibagikan.',
                steps: [
                    'Buka halaman hasil quiz.',
                    'Pilih quiz dan periode data yang ingin diekspor.',
                    'Klik tombol Export lalu unduh file yang tersedia.'
                ],
                tips: 'Simpan file export secara teratur agar data laporan tetap aman dan mudah diakses.',
                problem: 'Jika export gagal, cek koneksi internet dan pastikan data quiz sudah lengkap.'
            },
            passinggrade: {
                title: 'Mengatur Passing Grade',
                breadcrumb: ['Bantuan', 'Quiz', 'Passing Grade'],
                updated: '24 Juli 2026',
                summary: 'Passing grade membantu menentukan batas nilai minimum agar siswa dianggap lulus quiz.',
                steps: [
                    'Buka pengaturan quiz yang ingin diatur.',
                    'Masukkan nilai passing grade yang diinginkan.',
                    'Simpan perubahan untuk menerapkan batas kelulusan.'
                ],
                tips: 'Tetapkan passing grade yang realistis sesuai tingkat kesulitan materi.',
                problem: 'Jika batas kelulusan tidak berubah, pastikan perubahan sudah disimpan.'
            },
            user: {
                title: 'Menambah User dan Mengatur Role',
                breadcrumb: ['Bantuan', 'Pengguna', 'User'],
                updated: '24 Juli 2026',
                summary: 'User dapat ditambahkan dan diberi role yang sesuai untuk mengakses fitur platform.',
                steps: [
                    'Masuk ke menu Manajemen User.',
                    'Klik tombol Tambah User.',
                    'Isi data akun, pilih role, lalu simpan.'
                ],
                tips: 'Berikan role yang paling sesuai agar pengguna hanya melihat fitur yang mereka butuhkan.',
                problem: 'Jika akun belum bisa masuk, cek data akun dan role yang telah ditetapkan.'
            },
            permission: {
                title: 'Mengatur Permission Pengguna',
                breadcrumb: ['Bantuan', 'Pengguna', 'Permission'],
                updated: '24 Juli 2026',
                summary: 'Permission menentukan fitur apa saja yang bisa diakses oleh setiap pengguna di platform.',
                steps: [
                    'Buka menu Permission pada manajemen pengguna.',
                    'Pilih role atau pengguna yang ingin diatur.',
                    'Aktifkan atau nonaktifkan hak akses sesuai kebutuhan.'
                ],
                tips: 'Batasi permission hanya untuk fitur yang benar-benar diperlukan.',
                problem: 'Jika fitur tidak terlihat, cek apakah permission untuk role tersebut sudah aktif.'
            },
            resetpassword: {
                title: 'Reset Password User',
                breadcrumb: ['Bantuan', 'Pengguna', 'Password'],
                updated: '24 Juli 2026',
                summary: 'Reset password membantu mengembalikan akses akun jika pengguna lupa kata sandi.',
                steps: [
                    'Masuk ke daftar user yang ingin direset.',
                    'Pilih opsi Reset Password.',
                    'Buat password baru lalu kirimkan ke pengguna yang bersangkutan.'
                ],
                tips: 'Sarankan pengguna untuk segera mengganti password setelah login ulang.',
                problem: 'Jika reset password gagal, cek apakah akun yang dipilih sudah aktif dan terdaftar benar.'
            },
            analytics: {
                title: 'Melihat Laporan dan Analitik',
                breadcrumb: ['Bantuan', 'Laporan', 'Analitik'],
                updated: '24 Juli 2026',
                summary: 'Laporan dan analitik membantu memantau aktivitas pembelajaran, progress siswa, dan kinerja platform.',
                steps: [
                    'Buka menu Laporan atau Analitik.',
                    'Pilih periode data yang ingin dilihat.',
                    'Gunakan grafik dan tabel untuk menilai perkembangan pembelajaran.'
                ],
                tips: 'Periksa laporan secara berkala agar Anda bisa mengambil keputusan pembelajaran yang lebih baik.',
                problem: 'Jika data tidak muncul, pastikan periode yang dipilih benar dan data sudah tersedia.'
            },
            activity: {
                title: 'Melihat Aktivitas Platform',
                breadcrumb: ['Bantuan', 'Laporan', 'Aktivitas'],
                updated: '24 Juli 2026',
                summary: 'Aktivitas platform membantu Anda melihat log dan perubahan yang terjadi di dalam sistem.',
                steps: [
                    'Buka menu aktivitas atau log sistem.',
                    'Pilih periode waktu yang ingin dilihat.',
                    'Periksa tindakan pengguna dan perubahan penting yang terjadi.'
                ],
                tips: 'Pantau aktivitas secara berkala untuk mendeteksi perubahan atau masalah yang muncul.',
                problem: 'Jika log tidak muncul, pastikan Anda memiliki akses ke modul log sistem.'
            }
        };

        function normalize(text) {
            return (text || '').toLowerCase().replace(/[^a-z0-9]+/g, ' ').trim();
        }

        function getTopicData(questionText) {
            const q = normalize(questionText);

            if (q.includes('login') || q.includes('masuk ke dashboard')) return topicData.login;
            if (q.includes('tampilan dashboard') || q.includes('mengenal dashboard')) return topicData.dashboard;
            if (q.includes('tema tampilan') || q.includes('mengubah tema')) return topicData.theme;
            if (q.includes('perbedaan admin') || q.includes('admin dan guru') || q.includes('admin') || q.includes('guru')) return topicData.admin;
            if (q.includes('logout') || q.includes('keluar')) return topicData.logout;
            if (q.includes('sub kategori') || q.includes('membuat sub kategori')) return topicData.subcategory;
            if (q.includes('kategori pembelajaran') || q.includes('menambahkan kategori') || q.includes('membuat kategori') || q.includes('kategori')) return topicData.category;
            if (q.includes('status materi') || q.includes('mengubah status')) return topicData.status;
            if (q.includes('pdf') || q.includes('konversi pdf') || q.includes('pdf menjadi materi')) return topicData.pdf;
            if (q.includes('mind map') || q.includes('mindmap')) return topicData.mindmap;
            if (q.includes('quiz dan soal') || q.includes('mengelola quiz') || q.includes('quiz') && q.includes('soal')) return topicData.quiz;
            if (q.includes('hasil pembelajaran siswa') || q.includes('hasil quiz') || q.includes('hasil pembelajaran') || q.includes('skor')) return topicData.quizresult;
            if (q.includes('export laporan') || q.includes('export hasil quiz') || q.includes('export') && q.includes('quiz')) return topicData.exportquiz;
            if (q.includes('passing grade') || q.includes('passing')) return topicData.passinggrade;
            if ((q.includes('user') || q.includes('role')) && !q.includes('permission')) return topicData.user;
            if (q.includes('permission') || q.includes('izin')) return topicData.permission;
            if (q.includes('reset password') || q.includes('password user')) return topicData.resetpassword;
            if (q.includes('aktivitas platform') || q.includes('aktivitas')) return topicData.activity;
            if (q.includes('analitik') || q.includes('laporan') || q.includes('statistik')) return topicData.analytics;
            if (q.includes('materi pembelajaran') || q.includes('membuat materi') || q.includes('materi')) return topicData.material;
            return topicData.material;
        }

        function renderTopic(questionText) {
            const data = getTopicData(questionText);
            headerWrap.innerHTML = data.breadcrumb.map((item, index) => {
                const isLast = index === data.breadcrumb.length - 1;
                return isLast
                    ? `<div class="text-muted">${item}</div>`
                    : `<a href="javascript:void(0);">${item}</a><span class="mx-2 text-muted">/</span>`;
            }).join('');

            body.innerHTML = `
                <div class="mb-3">
                    <span class="badge bg-light text-primary">Pertanyaan terkait</span>
                    <p class="fs-12 text-muted mt-2 mb-0">${questionText}</p>
                </div>
                <h2 class="fs-18">${data.title}</h2>
                <p class="fs-12 text-muted">Terakhir diperbarui: <span class="text-dark fw-medium">${data.updated}</span></p>
                <hr class="my-4">
                <h4 class="fs-14">Jawaban Singkat</h4>
                <p class="text-muted">${data.summary}</p>
                <ul class="text-muted my-4">
                    ${data.steps.map(step => `<li class="mb-2">${step}</li>`).join('')}
                </ul>
                <div class="mt-5">
                    <h2 class="fs-13 fw-700 mb-3">Tips yang Bisa Dicoba</h2>
                    <p class="text-muted">${data.tips}</p>
                </div>
                <div class="mb-5">
                    <h4 class="fs-13">Jika Masih Bermasalah</h4>
                    <p class="text-muted mb-4">${data.problem}</p>
                </div>
                <hr class="my-5">
                <div class="w-100 p-5 bg-gray-100 text-center">
                    <h2 class="fs-16 mb-2">Butuh bantuan lebih lanjut?</h2>
                    <p class="text-muted">Coba cek panduan lain atau hubungi tim support kami.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-sm btn-success help-action-btn" id="helpFaqBtn" onclick="handleFaqClick(event)">Baca FAQ</button>
                        <a href="https://wa.me/6285802733781?text=Halo%20MindMap%20Support%2C%20saya%20membutuhkan%20bantuan." target="_blank" class="btn btn-sm btn-danger help-action-btn" id="helpSupportBtn" onclick="handleSupportClick(event)">Hubungi Tim Support</a>
                    </div>
                </div>
            `;
        }

        function filterTopics(query, category) {
            const categoryCards = Array.from(document.querySelectorAll('.topic-category-section .card'));
            const popularCards = Array.from(document.querySelectorAll('.topic-tranding-section .card'));
            const matches = [];

            categoryCards.forEach(card => {
                const heading = normalize(card.querySelector('h2, h3, h4')?.textContent || '');
                let cardCategory = 'all';

                if (heading.includes('memulai')) cardCategory = 'memulai';
                else if (heading.includes('konten')) cardCategory = 'konten';
                else if (heading.includes('mindmap')) cardCategory = 'mindmap';
                else if (heading.includes('quiz')) cardCategory = 'faq';
                else if (heading.includes('pengguna')) cardCategory = 'pengguna';
                else if (heading.includes('laporan')) cardCategory = 'laporan';

                const links = Array.from(card.querySelectorAll('a[data-bs-target="#topicsDetailsOffcanvas"]'));
                const categoryMatch = category === 'all' || cardCategory === category;
                const queryMatch = !query || links.some(link => normalize(link.textContent).includes(query));
                const shouldShow = categoryMatch && queryMatch;

                card.classList.toggle('d-none', !shouldShow);

                if (shouldShow) {
                    matches.push(...links);
                }
            });

            popularCards.forEach(card => {
                card.classList.remove('d-none');
                const links = Array.from(card.querySelectorAll('a[data-bs-target="#topicsDetailsOffcanvas"]'));
                if (query) {
                    const hasMatch = links.some(link => normalize(link.textContent).includes(query));
                    if (hasMatch) {
                        matches.push(...links);
                    }
                }
            });

            return matches;
        }

        const searchForm = document.getElementById('helpSearchForm');
        const searchInput = document.getElementById('helpSearchInput');
        const searchSelect = document.getElementById('helpSearchSelect');
        const searchStatus = document.getElementById('helpSearchStatus');

        if (searchForm && searchInput && searchSelect && searchStatus) {
            searchForm.addEventListener('submit', function (event) {
                event.preventDefault();

                try {
                    const query = normalize(searchInput.value.trim());
                    const category = searchSelect.value || 'all';
                   
                    if (!query) {
                        searchStatus.textContent = 'Masukkan kata kunci untuk mencari topik bantuan.';
                        searchStatus.classList.remove('text-danger');
                        searchStatus.classList.add('text-muted');
                        document.querySelectorAll('.topic-category-section .card').forEach(card => card.classList.remove('d-none'));
                        document.querySelectorAll('.topic-tranding-section .card').forEach(card => card.classList.remove('d-none'));
                        return;
                    }
                   
                    const matches = filterTopics(query, category);

                    if (matches.length) {
                        searchStatus.textContent = `✓ Ditemukan ${matches.length} topik yang sesuai dengan \"${searchInput.value.substring(0, 30)}${searchInput.value.length > 30 ? '...' : ''}\"`;
                        searchStatus.classList.remove('text-danger');
                        searchStatus.classList.add('text-success');
                        matches[0].click();
                    } else {
                        searchStatus.textContent = `✗ Tidak ditemukan topik untuk \"${searchInput.value.substring(0, 30)}${searchInput.value.length > 30 ? '...' : ''}\". Coba kata kunci lain atau lihat topik populer.`;
                        searchStatus.classList.remove('text-success', 'text-muted');
                        searchStatus.classList.add('text-danger');
                        renderTopic('notfound');
                    }
                } catch (error) {
                    console.error('Search error:', error);
                    searchStatus.textContent = 'Terjadi kesalahan saat mencari. Silahkan coba lagi.';
                    searchStatus.classList.remove('text-success', 'text-muted');
                    searchStatus.classList.add('text-danger');
                }
            });
        }

        document.addEventListener('click', function (event) {
            const trigger = event.target.closest('.topic-category-section a[data-bs-target="#topicsDetailsOffcanvas"], .topic-tranding-section a[data-bs-target="#topicsDetailsOffcanvas"]');
            if (!trigger) return;

            const questionText = (trigger.textContent || trigger.innerText || '').trim();
            const card = trigger.closest('.card');

            document.querySelectorAll('.topic-category-section .card, .topic-tranding-section .card').forEach(item => item.classList.remove('is-active'));
            if (card) {
                card.classList.add('is-active');
            }

            renderTopic(questionText);
        });

        const firstTopic = document.querySelector('.topic-category-section a[data-bs-target="#topicsDetailsOffcanvas"]');
        if (firstTopic) {
            renderTopic(firstTopic.textContent || firstTopic.innerText || '');
        }
    });

    function handleFaqClick(event) {
        const btn = event.target;
        btn.classList.add('clicked');
       
        setTimeout(() => {
            btn.classList.remove('clicked');
           
            // Scroll to FAQ section atau tampilkan notifikasi
            const faqBtn = document.querySelector('[data-bs-toggle="offcanvas"][data-bs-target="#topicsDetailsOffcanvas"]');
            if (faqBtn) {
                // Cari topik FAQ
                const allLinks = Array.from(document.querySelectorAll('.topic-category-section a[data-bs-target="#topicsDetailsOffcanvas"], .topic-tranding-section a[data-bs-target="#topicsDetailsOffcanvas"]'));
                const faqLink = allLinks.find(link => link.textContent.toLowerCase().includes('faq'));
                if (faqLink) {
                    faqLink.click();
                }
            }
        }, 300);
    }

    function handleSupportClick(event) {
        const btn = event.target;
        btn.classList.add('clicked');
       
        setTimeout(() => {
            btn.classList.remove('clicked');
            console.log('Membuka WhatsApp support...');
        }, 300);
    }

    function handlePopularBadgeClick(event, questionText) {
        event.preventDefault();
        const badge = event.target;
        badge.classList.add('clicked');
       
        setTimeout(() => {
            badge.classList.remove('clicked');
           
            const allLinks = Array.from(document.querySelectorAll('.topic-category-section a[data-bs-target="#topicsDetailsOffcanvas"], .topic-tranding-section a[data-bs-target="#topicsDetailsOffcanvas"]'));
            const matchingLink = allLinks.find(link => link.textContent.trim() === questionText);
            if (matchingLink) {
                matchingLink.click();
                setTimeout(() => {
                    const offcanvas = document.querySelector('.topics-details-offcanvas');
                    if (offcanvas) offcanvas.scrollTop = 0;
                }, 100);
            }
        }, 300);
    }

    function handleQuickCardClick(type) {
        const card = event.target.closest('.help-quick-item');
        if (card) {
            card.style.transform = 'scale(0.98)';
            setTimeout(() => {
                card.style.transform = 'scale(1)';
               
                if (type === 'panduan') {
                    const firstTopic = document.querySelector('.topic-category-section a[data-bs-target="#topicsDetailsOffcanvas"]');
                    if (firstTopic) firstTopic.click();
                } else if (type === 'faq') {
                    const allLinks = Array.from(document.querySelectorAll('.topic-category-section a[data-bs-target="#topicsDetailsOffcanvas"], .topic-tranding-section a[data-bs-target="#topicsDetailsOffcanvas"]'));
                    const faqLink = allLinks.find(link => link.textContent.toLowerCase().includes('faq'));
                    if (faqLink) faqLink.click();
                } else if (type === 'support') {
                    const whatsappUrl = 'https://wa.me/6285802733781?text=Halo%20MindMap%20Support%2C%20saya%20membutuhkan%20bantuan.';
                    window.open(whatsappUrl, '_blank');
                }
            }, 150);
        }
    }
</script>
    @include('backend.layouts.scriptcustom-minimal')
@endpushgit