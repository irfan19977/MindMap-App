@extends('frontend.layouts.app')

@section('content')
    <style>
        .teacher-detail-section { padding: 60px 0; }
        .teacher-profile-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            padding: 30px;
        }
        .teacher-profile-card img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: block;
        }
        .teacher-profile-card .specialization {
            color: #777;
            font-size: 16px;
            margin-bottom: 15px;
        }
        .teacher-profile-card .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 50%;
            background: #f5f5f5;
            color: #333;
            margin: 0 5px;
            transition: all 0.3s;
        }
        .teacher-profile-card .social-links a:hover {
            background: #333;
            color: #fff;
        }
        .teacher-info-section { margin-bottom: 30px; }
        .teacher-info-section h3 {
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        .info-item i {
            margin-right: 12px;
            margin-top: 3px;
            font-size: 18px;
        }
        .courses-section { padding: 60px 0; background: #f9f9f9; }
        .course-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        .course-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .course-card .course-thumbnail {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .course-card .course-meta span {
            margin-right: 15px;
            font-size: 13px;
        }
        .reviews-section { padding: 60px 0; }
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
    </style>

    <!-- Header Section -->
    <section class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="no-pad bold">Profil <span class="label classic">Pengajar</span></h1>
                        <p class="lead">Kenali lebih dekat pengajar kami yang berdedikasi untuk kesuksesan pembelajaran Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 1: Detail Teacher -->
    <section class="teacher-detail-section">
        <div class="container">
            <div class="row">
                <!-- Left: Profile Card -->
                <div class="col-md-4">
                    <div class="teacher-profile-card text-center">
                        <img src="{{ $teacher->image_url }}" alt="{{ $teacher->name }}">
                        <h2>{{ $teacher->name }}</h2>
                        <p class="specialization">{{ $teacher->specialization }}</p>
                        <div style="margin-bottom: 15px;">
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
                        <div class="social-links" style="margin-bottom: 20px;">
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
                        <a href="{{ route('teacher.index') }}" class="btn btn-dark-border"><i class="ion-ios-arrow-back"></i> Kembali ke Daftar Pengajar</a>
                    </div>
                </div>

                <!-- Right: Detail Info -->
                <div class="col-md-8">
                    <div class="teacher-info-section">
                        <h3><i class="fas fa-user"></i> Tentang Saya</h3>
                        <p>{{ $teacher->description }}</p>
                    </div>

                    @if($teacher->education)
                    <div class="teacher-info-section">
                        <h3><i class="fas fa-graduation-cap"></i> Pendidikan</h3>
                        <div class="info-item">
                            <i class="fas fa-certificate text-primary"></i>
                            <span>{{ $teacher->education }}</span>
                        </div>
                    </div>
                    @endif

                    @if($teacher->experience)
                    <div class="teacher-info-section">
                        <h3><i class="fas fa-briefcase"></i> Pengalaman Mengajar</h3>
                        <div class="info-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>{{ $teacher->experience }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="teacher-info-section">
                        <h3><i class="fas fa-tags"></i> Kategori</h3>
                        <span class="label label-default" style="font-size: 14px; padding: 5px 12px;">{{ ucfirst($teacher->category) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Kelas yang Dibuka/Dibuat -->
    <section class="courses-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Kelas oleh {{ $teacher->name }}</h2>
                    <p class="text-muted">Kelas yang dibuka dan dibuat oleh pengajar ini</p>
                </div>
            </div>
            <div class="row" style="margin-top: 30px;">
                @if($teacher->publishedCourses->count() > 0)
                    @foreach($teacher->publishedCourses->take(4) as $course)
                    <div class="col-md-3 col-sm-6">
                        <div class="course-card">
                            @if($course->cover_image)
                            <img src="{{ $course->cover_image_url }}" alt="{{ $course->name }}" class="course-thumbnail">
                            @endif
                            <h4>{{ $course->name }}</h4>
                            <p class="small text-muted">{{ $course->category->name ?? '' }} - {{ $course->curriculum ?? 'Kurikulum Merdeka' }}</p>
                            <div class="course-meta">
                                <span><i class="fas fa-signal"></i> {{ $course->formatted_grade_level }}</span>
                                <span><i class="fas fa-book"></i> {{ $course->materials->count() }} materi</span>
                            </div>
                            <a href="{{ route('mindmap.show', $course->slug) }}" class="btn btn-sm btn-dark-border">Lihat Kelas</a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-md-12 text-center">
                        <p class="text-muted" style="padding: 40px 0;">
                            <i class="fas fa-book-open fa-3x" style="color: #ddd; display: block; margin-bottom: 15px;"></i>
                            Belum ada kelas yang tersedia saat ini.
                        </p>
                    </div>
                @endif
            </div>
            @if($teacher->publishedCourses->count() > 4)
            <div class="row">
                <div class="col-md-12 text-center" style="margin-top: 10px;">
                    <a href="{{ route('teacher.courses', $teacher->slug) }}" class="btn btn-dark-border">Selengkapnya <i class="ion-ios-arrow-forward"></i></a>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Section 3: Review Siswa -->
    <section class="reviews-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Review Siswa</h2>
                    <p class="text-muted">Apa kata siswa tentang {{ $teacher->name }}</p>
                </div>
            </div>
            <div class="row reviews-row" style="margin-top: 30px;">
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
            </div>
            <div class="row">
                <div class="col-md-12 text-center" style="margin-top: 10px;">
                    <a href="{{ route('teacher.reviews', $teacher->slug) }}" class="btn btn-dark-border">Selengkapnya <i class="ion-ios-arrow-forward"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection
