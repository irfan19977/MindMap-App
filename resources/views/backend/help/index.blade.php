@extends('backend.layouts.app')

@section('title', 'Pusat Bantuan - MindMap')

@section('content')
        <div class="nxl-content pt-0">
            <!-- [ page-header ] start -->
            <div class="row g-0 align-items-center border-bottom help-center-content-header">
                <div class="col-lg-6 offset-lg-3 text-center">
                    <h2 class="fw-bolder mb-2 text-dark">Pusat Bantuan</h2>
                    <p class="text-muted">Temukan panduan lengkap penggunaan platform MindMap Education.</p>
                    <form action="javascript:void(0);" class="my-4 d-none d-sm-block search-form">
                        <div class="input-group select-wd-sm">
                            <select class="form-control" data-select2-selector="icon">
                                <option data-icon="feather-airplay">Memulai</option>
                                <option data-icon="feather-folder">Konten</option>
                                <option data-icon="feather-git-branch">MindMap</option>
                                <option data-icon="feather-help-circle">FAQ</option>
                                <option data-icon="feather-users">Pengguna</option>
                                <option data-icon="feather-bar-chart-2">Laporan</option>
                            </select>
                            <input type="text" class="form-control w-25" placeholder="Cari topik atau pertanyaan di sini...">
                            <button type="submit" class="btn btn-primary">
                                <i class="feather-search"></i>
                                <span class="ms-2">Cari</span>
                            </button>
                        </div>
                    </form>
                    <div class="mt-2 d-none d-sm-block">
                        <span class="fs-12 text-muted">Populer:</span>
                        <a href="javascript:void(0);" class="badge bg-gray-100 shadow-sm text-muted mx-1">Membuat Materi</a>
                        <a href="javascript:void(0);" class="badge bg-gray-100 shadow-sm text-muted mx-1">MindMap</a>
                        <a href="javascript:void(0);" class="badge bg-gray-100 shadow-sm text-muted mx-1">Quiz</a>
                        <a href="javascript:void(0);" class="badge bg-gray-100 shadow-sm text-muted mx-1">Manajemen User</a>
                        <a href="javascript:void(0);" class="badge bg-gray-100 shadow-sm text-muted mx-1">Laporan</a>
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
                                <a href="javascript:void(0);" class="fs-12">Pelajari Lebih Lanjut &rarr;</a>
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
                                <a href="javascript:void(0);" class="fs-12">Pelajari Lebih Lanjut &rarr;</a>
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
                                <a href="javascript:void(0);" class="fs-12">Pelajari Lebih Lanjut &rarr;</a>
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

@push('scripts')
    @include('backend.layouts.scriptcustom-minimal')
@endpush
