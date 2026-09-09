@extends('frontend.layouts.app')

@section('content')
    <style>
        :root {
            --olive: #7C815D;
            --olive-dark: #656A49;
            --olive-light: #EEF0E6;
            --text: #22231C;
            --muted: #8B8D7E;
            --border: #ECECE4;
        }
        
        .teacher-profile-section {
            padding: 50px 0 80px;
            background: #F7F7F3;
        }
        
        .sidebar-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.03);
        }
        
        .sidebar-card img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 12px;
        }
        
        .sidebar-card h5 {
            margin: 0 0 4px;
            font-size: 16px;
            font-weight: 700;
        }
        
        .sidebar-card span {
            color: var(--muted);
            font-size: 13px;
        }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 12px;
            font-weight: 600;
            font-size: 15px;
            background: white;
            color: var(--text);
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .sidebar-link:hover {
            color: var(--olive);
        }
        
        .sidebar-link.active {
            background: var(--olive);
            color: white;
        }
        
        .sidebar-link i {
            width: 18px;
            text-align: center;
        }
        
        .content-card {
            background: white;
            border-radius: 16px;
            padding: 36px;
            margin-bottom: 24px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.03);
            position: relative;
        }
        
        .card-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .content-card h4 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .content-card h4 i {
            color: var(--olive);
        }
        
        .profile-top {
            display: flex;
            gap: 26px;
            align-items: center;
        }
        
        .avatar-wrap {
            position: relative;
            width: 110px;
            min-width: 110px;
        }
        
        .avatar-wrap img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .avatar-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--olive);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            border: 3px solid white;
        }
        
        .profile-name {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 10px;
        }
        
        .badge-role {
            display: inline-block;
            background: var(--olive-light);
            color: var(--olive-dark);
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        
        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .info-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 14.5px;
        }
        
        .info-list li:last-child {
            margin-bottom: 0;
        }
        
        .info-list i {
            color: var(--olive);
            width: 18px;
            text-align: center;
        }
        
        .info-list .label {
            color: var(--muted);
            min-width: 120px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 40px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 16px;
            font-size: 14.5px;
        }
        
        .info-row .label {
            color: var(--muted);
            min-width: 140px;
        }
        
        .info-row .sep {
            margin-right: 8px;
        }
        
        .review-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
            margin-bottom: 20px;
            border: 1px solid var(--border);
        }
        
        .review-card .review-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        
        .review-card .reviewer-name {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 4px;
            color: var(--text);
        }
        
        .review-card .reviewer-role {
            color: var(--muted);
            font-size: 13px;
        }
        
        .review-card .review-date {
            color: var(--muted);
            font-size: 13px;
        }
        
        .review-card .review-stars {
            margin-bottom: 12px;
        }
        
        .review-card .review-stars i {
            color: #FFC107;
            font-size: 16px;
        }
        
        .review-card .review-text {
            color: var(--muted);
            line-height: 1.6;
            font-style: italic;
            margin: 0;
        }
        
        .btn-pill {
            background: var(--olive);
            color: white;
            padding: 10px 22px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
            text-decoration: none;
        }
        
        .btn-pill:hover {
            background: var(--olive-dark);
            color: white;
        }
        
        .btn-pill-outline {
            background: white;
            color: var(--text);
            border: 1px solid var(--border);
        }
        
        @media (max-width: 900px) {
            .profile-top {
                flex-direction: column;
                text-align: center;
            }
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Pagination styling */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin: 20px 0;
        }
        
        .pagination .page-item {
            margin: 0;
        }
        
        .pagination .page-link {
            color: var(--text);
            background: transparent;
            border: none;
            padding: 10px 14px;
            border-radius: 50%;
            font-weight: 600;
            transition: all 0.2s;
            min-width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination .page-link:hover {
            background: var(--olive-light);
            color: var(--olive);
        }

        .pagination .page-item.active .page-link {
            background: var(--olive);
            color: white;
        }
        
        .pagination .page-item.disabled .page-link {
            color: var(--muted);
            background: transparent;
        }

        /* Course card styling */
        .course-card-item .hover {
            border-radius: 16px !important;
        }

        .course-card-item img {
            border-radius: 16px !important;
        }
    </style>

    <!-- Hero Section -->
    <section class="jarallax relative overflow-hidden z-1000 mt-80">
        <img src="{{ asset('frontend/images/background/1.webp') }}" class="jarallax-img" alt="">
        <div class="sw-overlay op-2"></div>
        <div class="gradient-edge-start light w-40 start-40 op-9 z-2"></div>
        <div class="abs w-40 h-100 bg-white top-0 start-0 op-9 z-2"></div>
        <div class="container relative z-2">
            <div class="row wow fadeInRight">
                <div class="col-lg-10">
                    <h1 class="fs-sm-10vw mb-0">Profil Pengajar</h1>
                    <ul class="crumb">
                        <li><a href="/">Home</a></li>
                        <li><a href="{{ route('teacher.index') }}">Pengajar</a></li>
                        <li class="active">{{ $teacher->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="teacher-profile-section">
        <div class="container">
            <div class="row">
                
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="sidebar-card">
                        @if($teacher->image_url)
                            <img src="{{ $teacher->image_url }}" alt="{{ $teacher->name }}">
                        @else
                            <div style="width: 70px; height: 70px; border-radius: 50%; background: var(--olive); color: white; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; margin: 0 auto 12px;">
                                {{ strtoupper(substr($teacher->name, 0, 1)) }}
                            </div>
                        @endif
                        <h5>{{ $teacher->name }}</h5>
                        <span>Pengajar</span>
                    </div>

                    <a href="#" onclick="showSection('profile'); return false;" class="sidebar-link active" id="link-profile">
                        <i class="fa-solid fa-user"></i> Profil Pengajar
                    </a>
                    <a href="#" onclick="showSection('courses'); return false;" class="sidebar-link" id="link-courses">
                        <i class="fa-solid fa-book"></i> Kelas
                    </a>
                    <a href="#" onclick="showSection('reviews'); return false;" class="sidebar-link" id="link-reviews">
                        <i class="fa-solid fa-star"></i> Review
                    </a>
                </div>

                <!-- Content -->
                <div class="col-lg-9">
                    
                    <!-- Profile Section -->
                    <div id="section-profile">
                    <!-- Ringkasan Profil -->
                    <div class="content-card">
                        <div class="profile-top">
                            <div class="avatar-wrap">
                                @if($teacher->image_url)
                                    <img src="{{ $teacher->image_url }}" alt="{{ $teacher->name }}">
                                @else
                                    <div style="width: 110px; height: 110px; border-radius: 50%; background: var(--olive); color: white; display: flex; align-items: center; justify-content: center; font-size: 44px; font-weight: bold;">
                                        {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="avatar-badge"><i class="fa-solid fa-chalkboard-teacher"></i></span>
                            </div>
                            <div>
                                <h3 class="profile-name">{{ $teacher->name }}</h3>
                                <span class="badge-role">Pengajar</span>
                                <ul class="info-list">
                                    <li>
                                        <i class="fa-solid fa-graduation-cap"></i>
                                        <span class="label">Spesialisasi</span>
                                        <span>:</span>
                                        <span>{{ $teacher->specialization ?? '-' }}</span>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-star"></i>
                                        <span class="label">Rating</span>
                                        <span>:</span>
                                        <span>{{ number_format($teacher->rating ?? 0, 1) }} ({{ $teacher->review_count ?? 0 }} reviews)</span>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-envelope"></i>
                                        <span class="label">Email</span>
                                        <span>:</span>
                                        <span>{{ $teacher->email ?? '-' }}</span>
                                    </li>
                                    @if($teacher->education)
                                    <li>
                                        <i class="fa-solid fa-graduation-cap"></i>
                                        <span class="label">Pendidikan</span>
                                        <span>:</span>
                                        <span>{{ $teacher->education }}</span>
                                    </li>
                                    @endif
                                    @if($teacher->experience)
                                    <li>
                                        <i class="fa-solid fa-briefcase"></i>
                                        <span class="label">Pengalaman</span>
                                        <span>:</span>
                                        <span>{{ $teacher->experience }}</span>
                                    </li>
                                    @endif
                                    <li>
                                        <i class="fa-solid fa-share-alt"></i>
                                        <span class="label">Media Sosial</span>
                                        <span>:</span>
                                        <span>
                                            @if($teacher->linkedin_url)
                                            <a href="{{ $teacher->linkedin_url }}" target="_blank" style="color: var(--olive);"><i class="fab fa-linkedin-in"></i></a>
                                            @endif
                                            @if($teacher->twitter_url)
                                            <a href="{{ $teacher->twitter_url }}" target="_blank" style="color: var(--olive); margin-left: 8px;"><i class="fab fa-twitter"></i></a>
                                            @endif
                                            @if($teacher->github_url)
                                            <a href="{{ $teacher->github_url }}" target="_blank" style="color: var(--olive); margin-left: 8px;"><i class="fab fa-github"></i></a>
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pribadi -->
                    <div class="content-card">
                        <h4><i class="fa-solid fa-user"></i> Tentang Saya</h4>
                        <p style="color: var(--muted); line-height: 1.7;">{{ $teacher->description ?? 'Pengajar berdedikasi dengan pengalaman dalam memberikan pembelajaran berkualitas untuk membantu siswa mencapai potensi terbaik mereka.' }}</p>
                    </div>

                    <div class="content-card">
                        <a href="{{ route('teacher.index') }}" class="btn-pill btn-pill-outline">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                    </div>

                    <!-- Courses Section -->
                    <div id="section-courses" style="display: none;">
                        <h4 style="margin-bottom: 24px; font-size: 20px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-book" style="color: var(--olive);"></i> Kelas oleh {{ $teacher->name }}
                        </h4>
                        <div class="row g-4" id="courseGrid">
                            @if($publishedCourses && $publishedCourses->count() > 0)
                                @foreach($publishedCourses as $course)
                                <!-- course item begin -->
                                <div class="col-lg-4 col-sm-6 course-card-item">
                                    <div class="hover rounded-1 overflow-hidden relative text-light text-center">
                                        <img src="{{ $course->cover_image ? $course->cover_image_url : asset('frontend/images/services/1.webp') }}" class="hover-scale-1-1 w-100" alt="{{ $course->name }}">
                                        <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                            <div class="mb-3">
                                                <p class="small">{{ $course->materials->count() }} materi</p>
                                            </div>
                                            <a class="btn-line" href="{{ route('mindmap.show', $course->subcategory->slug) }}">Lihat Kelas</a>
                                        </div>
                                        <img src="{{ asset('frontend/images/icons-white/1.png') }}" class="abs abs-centered w-20 z-2" alt="">
                                        <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                                        <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                                            <h3 class="hs-4 mb-3">{{ $course->name }}</h3>
                                            <p class="text-white-50 fs-14">{{ $course->category->name ?? '' }} - {{ $course->subcategory->name ?? 'Kurikulum Merdeka' }}</p>
                                        </div>
                                        <div class="gradient-edge-bottom color abs w-100 h-70 bottom-0"></div>
                                    </div>
                                </div>
                                <!-- course item end -->
                                @endforeach
                            @else
                                <div class="col-lg-12 text-center py-5">
                                    <div class="bg-white border-gray rounded-1 p-5" style="max-width: 500px; margin: 0 auto;">
                                        <div class="mb-3">
                                            <i class="fa fa-book-open fs-48 text-muted"></i>
                                        </div>
                                        <h4 class="mb-3">Belum ada kelas yang tersedia</h4>
                                        <p class="text-muted mb-0">Pengajar ini belum membuat kelas apapun saat ini.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Pagination -->
                        <div id="coursesPagination" class="text-center" style="margin-top: 30px;">
                            @if($publishedCourses && $publishedCourses->hasPages())
                            <div class="d-inline-block">
                                <nav aria-label="Page navigation example">
                                  <ul class="pagination">
                                    @if($publishedCourses->onFirstPage())
                                    <li class="page-item disabled">
                                      <span class="page-link"><i class="fa fa-chevron-left"></i></span>
                                    </li>
                                    @else
                                    <li class="page-item">
                                      <a class="page-link" href="{{ $publishedCourses->previousPageUrl() }}#courses" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fa fa-chevron-left"></i></span>
                                      </a>
                                    </li>
                                    @endif

                                    <?php
                                    $currentPage = $publishedCourses->currentPage();
                                    $lastPage = $publishedCourses->lastPage();
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($lastPage, $currentPage + 2);

                                    if ($startPage > 1) {
                                        echo '<li class="page-item"><a class="page-link" href="' . $publishedCourses->url(1) . '#courses">1</a></li>';
                                        if ($startPage > 2) {
                                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                        }
                                    }

                                    for ($i = $startPage; $i <= $endPage; $i++) {
                                        if ($i == $currentPage) {
                                            echo '<li class="page-item active" aria-current="page"><span class="page-link">' . $i . '</span></li>';
                                        } else {
                                            echo '<li class="page-item"><a class="page-link" href="' . $publishedCourses->url($i) . '#courses">' . $i . '</a></li>';
                                        }
                                    }

                                    if ($endPage < $lastPage) {
                                        if ($endPage < $lastPage - 1) {
                                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                        }
                                        echo '<li class="page-item"><a class="page-link" href="' . $publishedCourses->url($lastPage) . '#courses">' . $lastPage . '</a></li>';
                                    }
                                    ?>

                                    @if($publishedCourses->hasMorePages())
                                    <li class="page-item">
                                      <a class="page-link" href="{{ $publishedCourses->nextPageUrl() }}#courses" aria-label="Next">
                                        <span aria-hidden="true"><i class="fa fa-chevron-right"></i></span>
                                      </a>
                                    </li>
                                    @else
                                    <li class="page-item disabled">
                                      <span class="page-link"><i class="fa fa-chevron-right"></i></span>
                                    </li>
                                    @endif
                                  </ul>
                                </nav>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div id="section-reviews" style="display: none;">
                        <h4 style="margin-bottom: 24px; font-size: 20px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-star" style="color: var(--olive);"></i> Review Siswa
                        </h4>
                        
                        <div class="row g-4" id="reviewGrid">
                            @if($teacher->reviews && $teacher->reviews->count() > 0)
                                @foreach($teacher->reviews as $review)
                                <div class="col-lg-6">
                                    <div class="review-card">
                                        <div class="review-header">
                                            <div>
                                                <div class="reviewer-name">{{ $review->student_name ?? 'Siswa' }}</div>
                                                <div class="reviewer-role">{{ $review->student_role ?? 'Siswa' }}</div>
                                            </div>
                                            <div class="review-date">{{ $review->formatted_date ?? 'Baru saja' }}</div>
                                        </div>
                                        <div class="review-stars">
                                            @for($i = 0; $i < 5; $i++)
                                                @if($i < $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="review-text">"{{ $review->comment }}"</p>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <!-- Placeholder reviews for demo -->
                                <div class="col-lg-6">
                                    <div class="review-card">
                                        <div class="review-header">
                                            <div>
                                                <div class="reviewer-name">Andi Pratama</div>
                                                <div class="reviewer-role">Mahasiswa Teknik</div>
                                            </div>
                                            <div class="review-date">2 minggu yang lalu</div>
                                        </div>
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <p class="review-text">"Pengajar yang luar biasa! Beliau dapat menjelaskan konsep yang rumit dengan cara yang sangat mudah dipahami. Sangat direkomendasikan!"</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="review-card">
                                        <div class="review-header">
                                            <div>
                                                <div class="reviewer-name">Siti Rahayu</div>
                                                <div class="reviewer-role">Siswa SMA</div>
                                            </div>
                                            <div class="review-date">1 bulan yang lalu</div>
                                        </div>
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <p class="review-text">"Metode pengajaran yang sangat interaktif dan engaging. Saya yang awalnya kesulitan, sekarang justru menjadi menyukai pelajaran ini."</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="review-card">
                                        <div class="review-header">
                                            <div>
                                                <div class="reviewer-name">Budi Kurniawan</div>
                                                <div class="reviewer-role">Profesional IT</div>
                                            </div>
                                            <div class="review-date">2 bulan yang lalu</div>
                                        </div>
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <p class="review-text">"Sangat membantu dalam pekerjaan saya. Penjelasannya praktis dan langsung bisa diterapkan di dunia kerja."</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="review-card">
                                        <div class="review-header">
                                            <div>
                                                <div class="reviewer-name">Dewi Lestari</div>
                                                <div class="reviewer-role">Mahasiswa</div>
                                            </div>
                                            <div class="review-date">3 bulan yang lalu</div>
                                        </div>
                                        <div class="review-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <p class="review-text">"Tidak hanya mengajarkan teori, tapi juga bagaimana berpikir kritis. Skill yang sangat valuable untuk karir akademis saya."</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        function showSection(section) {
            // Hide all sections
            document.getElementById('section-profile').style.display = 'none';
            document.getElementById('section-courses').style.display = 'none';
            document.getElementById('section-reviews').style.display = 'none';

            // Remove active class from all links
            document.getElementById('link-profile').classList.remove('active');
            document.getElementById('link-courses').classList.remove('active');
            document.getElementById('link-reviews').classList.remove('active');

            // Show selected section and activate link
            document.getElementById('section-' + section).style.display = 'block';
            document.getElementById('link-' + section).classList.add('active');

            // Update URL hash for better navigation
            history.pushState(null, null, '#' + section);
        }

        // Handle URL hash on page load
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash.substring(1);
            if (hash && ['profile', 'courses', 'reviews'].includes(hash)) {
                showSection(hash);
                // Scroll to courses section if hash is courses
                if (hash === 'courses') {
                    setTimeout(() => {
                        const coursesSection = document.getElementById('section-courses');
                        if (coursesSection) {
                            coursesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }, 100);
                }
            }
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function() {
            const hash = window.location.hash.substring(1);
            if (hash && ['profile', 'courses', 'reviews'].includes(hash)) {
                showSection(hash);
            } else {
                showSection('profile');
            }
        });
    </script>
@endsection
