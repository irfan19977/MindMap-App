@extends('frontend.layouts.app')

@section('content')
    <style>
        .courses-page-section { padding: 60px 0; }
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
    </style>

    <!-- Header Section -->
    <section class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="no-pad bold">Kelas <span class="label classic">Pengajar</span></h1>
                        <p class="lead">Semua kelas yang dibuka oleh {{ $teacher->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- All Courses -->
    <section class="courses-page-section">
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

                <!-- Courses -->
                <div class="col-md-8">
                    <h3 style="margin-bottom: 25px;">Semua Kelas oleh {{ $teacher->name }}</h3>
                    <div class="row">
                        @if($teacher->publishedCourses->count() > 0)
                            @foreach($teacher->publishedCourses as $course)
                            <div class="col-md-6 col-sm-6">
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
                </div>
            </div>
        </div>
    </section>
@endsection
