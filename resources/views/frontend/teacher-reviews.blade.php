@extends('frontend.layouts.app')

@section('content')
    <style>
        .reviews-page-section { padding: 60px 0; }
        .reviews-row {
            display: flex;
            flex-wrap: wrap;
        }
        .reviews-row > [class*="col-"] {
            display: flex;
        }
        .review-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            padding: 25px;
            margin-bottom: 20px;
            width: 100%;
        }
        .review-card .review-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        .review-card .reviewer-name {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 2px;
        }
        .review-card .reviewer-role {
            color: #999;
            font-size: 13px;
        }
        .review-card .review-date {
            color: #999;
            font-size: 13px;
        }
        .review-card .review-stars {
            margin-bottom: 10px;
        }
        .review-card .review-text {
            font-style: italic;
            color: #555;
            line-height: 1.6;
        }
        .teacher-sidebar {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            padding: 30px;
            position: sticky;
            top: 100px;
        }
        .teacher-sidebar img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: block;
        }
        .teacher-sidebar .social-links a {
            display: inline-block;
            width: 36px;
            height: 36px;
            line-height: 36px;
            border-radius: 50%;
            background: #f5f5f5;
            color: #333;
            margin: 0 4px;
            transition: all 0.3s;
        }
        .teacher-sidebar .social-links a:hover {
            background: #333;
            color: #fff;
        }
    </style>

    <!-- Header Section -->
    <section class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="no-pad bold">Review <span class="label classic">Siswa</span></h1>
                        <p class="lead">Semua review siswa untuk {{ $teacher->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- All Reviews -->
    <section class="reviews-page-section">
        <div class="container">
            <div class="row">
                <!-- Teacher Profile Sidebar -->
                <div class="col-md-4">
                    <div class="teacher-sidebar text-center">
                        <img src="{{ $teacher->image_url }}" alt="{{ $teacher->name }}">
                        <h3>{{ $teacher->name }}</h3>
                        <p class="text-muted">{{ $teacher->specialization }}</p>
                        <div style="margin-bottom: 10px;">
                            @php
                                $fullStars = floor($teacher->rating);
                                $hasHalfStar = ($teacher->rating - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            @endphp
                            @for($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor
                            @if($hasHalfStar)
                                <i class="fas fa-star-half-alt text-warning"></i>
                            @endif
                            @for($i = 0; $i < $emptyStars; $i++)
                                <i class="far fa-star text-warning"></i>
                            @endfor
                            <br>
                            <span>{{ number_format($teacher->rating, 1) }} ({{ $teacher->review_count }} reviews)</span>
                        </div>
                        <div class="social-links" style="margin-bottom: 15px;">
                            @if($teacher->linkedin_url)
                            <a href="{{ $teacher->linkedin_url }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            @endif
                            @if($teacher->twitter_url)
                            <a href="{{ $teacher->twitter_url }}" target="_blank"><i class="fab fa-twitter"></i></a>
                            @endif
                            @if($teacher->github_url)
                            <a href="{{ $teacher->github_url }}" target="_blank"><i class="fab fa-github"></i></a>
                            @endif
                            @if($teacher->email)
                            <a href="mailto:{{ $teacher->email }}"><i class="fas fa-envelope"></i></a>
                            @endif
                        </div>
                        <a href="{{ route('teacher.show', $teacher->slug) }}" class="btn btn-dark-border btn-sm">
                            <i class="ion-ios-arrow-back"></i> Kembali ke Profil
                        </a>
                    </div>
                </div>

                <!-- Reviews -->
                <div class="col-md-8">
                    <h3 style="margin-bottom: 25px;">Semua Review ({{ $teacher->review_count }})</h3>
                    <div class="row reviews-row">
                <div class="col-md-6">
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">Andi Pratama</div>
                                <div class="reviewer-role">Mahasiswa Teknik</div>
                            </div>
                            <div class="review-date">2 minggu yang lalu</div>
                        </div>
                        <div class="review-stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="review-text">"Pengajar yang luar biasa! Beliau dapat menjelaskan konsep yang rumit dengan cara yang sangat mudah dipahami. Sangat direkomendasikan!"</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">Siti Rahayu</div>
                                <div class="reviewer-role">Siswa SMA</div>
                            </div>
                            <div class="review-date">1 bulan yang lalu</div>
                        </div>
                        <div class="review-stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                        <p class="review-text">"Metode pengajaran yang sangat interaktif dan engaging. Saya yang awalnya kesulitan, sekarang justru menjadi menyukai pelajaran ini."</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">Budi Kurniawan</div>
                                <div class="reviewer-role">Profesional IT</div>
                            </div>
                            <div class="review-date">2 bulan yang lalu</div>
                        </div>
                        <div class="review-stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="far fa-star text-warning"></i>
                        </div>
                        <p class="review-text">"Sangat membantu dalam pekerjaan saya. Penjelasannya praktis dan langsung bisa diterapkan di dunia kerja."</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">Dewi Lestari</div>
                                <div class="reviewer-role">Mahasiswa</div>
                            </div>
                            <div class="review-date">3 bulan yang lalu</div>
                        </div>
                        <div class="review-stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="review-text">"Tidak hanya mengajarkan teori, tapi juga bagaimana berpikir kritis. Skill yang sangat valuable untuk karir akademis saya."</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">Rizky Firmansyah</div>
                                <div class="reviewer-role">Mahasiswa S2</div>
                            </div>
                            <div class="review-date">3 bulan yang lalu</div>
                        </div>
                        <div class="review-stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="review-text">"Materi yang disampaikan sangat terstruktur dan mudah diikuti. Setiap sesi selalu ada contoh kasus nyata yang membantu pemahaman."</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">Putri Amalina</div>
                                <div class="reviewer-role">Fresh Graduate</div>
                            </div>
                            <div class="review-date">4 bulan yang lalu</div>
                        </div>
                        <div class="review-stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                        <p class="review-text">"Berkat bimbingan beliau, saya berhasil memahami konsep yang sebelumnya terasa sangat sulit. Cara mengajarnya sabar dan detail."</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">Hendra Wijaya</div>
                                <div class="reviewer-role">Karyawan Swasta</div>
                            </div>
                            <div class="review-date">5 bulan yang lalu</div>
                        </div>
                        <div class="review-stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="far fa-star text-warning"></i>
                        </div>
                        <p class="review-text">"Saya mengambil kelas ini untuk meningkatkan skill di tempat kerja. Hasilnya sangat memuaskan, langsung bisa diterapkan di project kantor."</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">Nadia Safitri</div>
                                <div class="reviewer-role">Mahasiswa Informatika</div>
                            </div>
                            <div class="review-date">6 bulan yang lalu</div>
                        </div>
                        <div class="review-stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="review-text">"Pengajar terbaik yang pernah saya temui! Selalu responsif menjawab pertanyaan dan memberikan feedback yang konstruktif."</p>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
