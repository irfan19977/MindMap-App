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
        
        .student-profile-section {
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
        
        .pw-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }
        
        .pw-row p {
            color: var(--muted);
            margin: 6px 0 0;
            font-size: 14.5px;
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
        
        .course-card {
            background: white;
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
        
        @media (max-width: 900px) {
            .profile-top {
                flex-direction: column;
                text-align: center;
            }
            .info-grid {
                grid-template-columns: 1fr;
            }
            .pw-row {
                flex-direction: column;
                align-items: flex-start;
            }
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
                    <h1 class="fs-sm-10vw mb-0">Profil Saya</h1>
                    <ul class="crumb">
                        <li><a href="/">Home</a></li>
                        <li><a href="#">Akun Saya</a></li>
                        <li class="active">Profil</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="student-profile-section">
        <div class="container">
            <div class="row">
                
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="sidebar-card">
                        @if($student->avatar_url)
                            <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}">
                        @else
                            <div style="width: 70px; height: 70px; border-radius: 50%; background: var(--olive); color: white; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; margin: 0 auto 12px;">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                        @endif
                        <h5>{{ $student->name }}</h5>
                        <span>Siswa</span>
                    </div>

                    <a href="#" onclick="showSection('profile'); return false;" class="sidebar-link active" id="link-profile">
                        <i class="fa-solid fa-user"></i> Profil Saya
                    </a>
                    <a href="#" onclick="showSection('classes'); return false;" class="sidebar-link" id="link-classes">
                        <i class="fa-solid fa-book"></i> Kelas Saya
                    </a>
                    <a href="/nilai-quiz" class="sidebar-link">
                        <i class="fa-solid fa-clipboard-list"></i> Nilai & Quiz
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="fa-solid fa-gear"></i> Pengaturan
                    </a>
                </div>

                <!-- Content -->
                <div class="col-lg-9">
                    
                    <!-- Profile Section -->
                    <div id="section-profile">
                    <!-- Ringkasan Profil -->
                    <div class="content-card">
                        <a href="{{ route('student.profile.edit') }}" class="btn-pill" style="position: absolute; top: 36px; right: 36px;">
                            <i class="fa-solid fa-pen"></i> Ubah Profil
                        </a>

                        <div class="profile-top">
                            <div class="avatar-wrap">
                                @if($student->avatar_url)
                                    <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}">
                                @else
                                    <div style="width: 110px; height: 110px; border-radius: 50%; background: var(--olive); color: white; display: flex; align-items: center; justify-content: center; font-size: 44px; font-weight: bold;">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="avatar-badge"><i class="fa-solid fa-camera"></i></span>
                            </div>
                            <div>
                                <h3 class="profile-name">{{ $student->name }}</h3>
                                <span class="badge-role">Siswa</span>
                                <ul class="info-list">
                                    <li>
                                        <i class="fa-solid fa-id-card"></i>
                                        <span class="label">NIS</span>
                                        <span>:</span>
                                        <span>{{ $student->nis ?? '-' }}</span>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-chalkboard"></i>
                                        <span class="label">Kelas</span>
                                        <span>:</span>
                                        <span>{{ $student->grade ?? '-' }}</span>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-envelope"></i>
                                        <span class="label">Email</span>
                                        <span>:</span>
                                        <span>{{ $student->email }}</span>
                                    </li>
                                    @if($student->birth_date)
                                    <li>
                                        <i class="fa-solid fa-cake-candles"></i>
                                        <span class="label">Tanggal Lahir</span>
                                        <span>:</span>
                                        <span>{{ $student->birth_date->format('d F Y') }}</span>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pribadi -->
                    <div class="content-card">
                        <h4><i class="fa-solid fa-user"></i> Informasi Pribadi</h4>
                        <div class="info-grid">
                            <div>
                                <div class="info-row">
                                    <span class="label">Nama Lengkap</span>
                                    <span class="sep">:</span>
                                    <span>{{ $student->name }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="label">Email</span>
                                    <span class="sep">:</span>
                                    <span>{{ $student->email }}</span>
                                </div>
                                @if($student->school)
                                <div class="info-row">
                                    <span class="label">Sekolah</span>
                                    <span class="sep">:</span>
                                    <span>{{ $student->school }}</span>
                                </div>
                                @endif
                                @if($student->grade)
                                <div class="info-row">
                                    <span class="label">Kelas</span>
                                    <span class="sep">:</span>
                                    <span>{{ $student->grade }}</span>
                                </div>
                                @endif
                            </div>
                            <div>
                                @if($student->major)
                                <div class="info-row">
                                    <span class="label">Jurusan</span>
                                    <span class="sep">:</span>
                                    <span>{{ $student->major }}</span>
                                </div>
                                @endif
                                @if($student->learning_interest)
                                <div class="info-row">
                                    <span class="label">Minat Belajar</span>
                                    <span class="sep">:</span>
                                    <span>{{ $student->learning_interest }}</span>
                                </div>
                                @endif
                                @if($student->birth_date)
                                <div class="info-row">
                                    <span class="label">Tanggal Lahir</span>
                                    <span class="sep">:</span>
                                    <span>{{ $student->birth_date->format('d F Y') }}</span>
                                </div>
                                @endif
                                @if($student->phone)
                                <div class="info-row">
                                    <span class="label">No. Telepon</span>
                                    <span class="sep">:</span>
                                    <span>{{ $student->phone }}</span>
                                </div>
                                @endif
                                @if($student->address)
                                <div class="info-row">
                                    <span class="label">Alamat</span>
                                    <span class="sep">:</span>
                                    <span>{{ $student->address }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Ubah Password -->
                    <div class="content-card">
                        <div class="pw-row">
                            <div>
                                <h4><i class="fa-solid fa-lock"></i> Ubah Password</h4>
                                <p>Jika Anda ingin mengganti password, silakan klik tombol di samping ini.</p>
                            </div>
                            <a href="#" class="btn-pill"><i class="fa-solid fa-lock"></i> Ganti Password</a>
                        </div>
                    </div>
                    </div>

                    <!-- Classes Section -->
                    <div id="section-classes" style="display: none;">
                        <h4 style="margin-bottom: 24px; font-size: 20px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-book" style="color: var(--olive);"></i> Kelas Saya
                        </h4>
                        <div class="row g-4" id="courseGrid">
                            @if($student->enrolledCourses->count() > 0)
                                @foreach($student->enrolledCourses as $course)
                                @php
                                    $totalMaterials = $course->materials->count();
                                    $courseMaterialIds = $course->materials->pluck('id')->toArray();

                                    $completedByProgress = \App\Models\UserProgress::where('user_id', $student->user_id)
                                        ->whereIn('material_id', $courseMaterialIds)
                                        ->whereNotNull('completed_at')
                                        ->pluck('material_id')
                                        ->unique()
                                        ->toArray();

                                    $passedMaterialIds = \App\Models\QuizAttempt::where('user_id', $student->user_id)
                                        ->where('status', 'passed')
                                        ->whereHas('quiz', function ($q) use ($courseMaterialIds) {
                                            $q->whereIn('material_id', $courseMaterialIds);
                                        })
                                        ->with('quiz:id,material_id')
                                        ->get()
                                        ->pluck('quiz.material_id')
                                        ->filter()
                                        ->unique()
                                        ->toArray();

                                    $completedMaterials = count(array_unique(array_merge($completedByProgress, $passedMaterialIds)));
                                    $progressPercent = $totalMaterials > 0 ? round(($completedMaterials / $totalMaterials) * 100) : 0;
                                @endphp
                                <!-- course item begin -->
                                <div class="col-lg-4 col-sm-6 course-card-item">
                                    <div class="hover rounded-1 overflow-hidden relative text-light text-center">
                                        <img src="{{ $course->cover_image ? $course->cover_image_url : asset('frontend/images/services/1.webp') }}" class="hover-scale-1-1 w-100" alt="{{ $course->name }}">
                                        <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                            <div class="mb-3">
                                                <div style="background: rgba(255,255,255,0.3); border-radius: 10px; height: 8px; overflow: hidden; margin: 10px 0;">
                                                    <div style="width: {{ $progressPercent }}%; background: white; height: 100%;"></div>
                                                </div>
                                                <p class="small">{{ $completedMaterials }}/{{ $totalMaterials }} materi • {{ $progressPercent }}% selesai</p>
                                            </div>
                                            <a class="btn-line" href="{{ route('mindmap.show', $course->subcategory->slug) }}">Lanjutkan Belajar</a>
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
                                        <h4 class="mb-3">Belum ada kelas yang diikuti</h4>
                                        <p class="text-muted mb-0">Anda belum mengikuti kelas apapun. Jelajahi kelas yang tersedia untuk mulai belajar.</p>
                                        <a href="{{ route('kelas.index') }}" class="btn-pill" style="margin-top: 15px;">Jelajahi Kelas</a>
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
            document.getElementById('section-classes').style.display = 'none';
            
            // Remove active class from all links
            document.getElementById('link-profile').classList.remove('active');
            document.getElementById('link-classes').classList.remove('active');
            
            // Show selected section and activate link
            document.getElementById('section-' + section).style.display = 'block';
            document.getElementById('link-' + section).classList.add('active');
        }
    </script>
@endsection