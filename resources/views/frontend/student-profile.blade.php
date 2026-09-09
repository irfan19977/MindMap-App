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
        
        .certificate-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .certificate-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        
        .certificate-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        
        .certificate-info {
            padding: 20px;
            text-align: center;
        }
        
        .certificate-info h5 {
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 8px;
            color: var(--text);
        }
        
        .certificate-date {
            font-size: 13px;
            color: var(--muted);
            margin: 0 0 16px;
        }
        
        .btn-download {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--olive);
            color: white;
            padding: 8px 20px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s;
        }
        
        .btn-download:hover {
            background: var(--olive-dark);
            color: white;
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
                    <a href="#" onclick="showSection('certificates'); return false;" class="sidebar-link" id="link-certificates">
                        <i class="fa-solid fa-certificate"></i> Sertifikat
                    </a>
                </div>

                <!-- Content -->
                <div class="col-lg-9">
                    
                    <!-- Profile Section -->
                    <div id="section-profile">
                    <!-- Ringkasan Profil -->
                    <div class="content-card">
                        <button onclick="openEditProfileModal()" class="btn-pill" style="position: absolute; top: 36px; right: 36px;">
                            <i class="fa-solid fa-pen"></i> Ubah Profil
                        </button>

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
                                            <a class="btn-line" href="{{ route('mindmap.show', $course->subcategory->slug) }}?class_id={{ $course->id }}">Lanjutkan Belajar</a>
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

                    <!-- Certificates Section -->
                    <div id="section-certificates" style="display: none;">
                        <h4 style="margin-bottom: 24px; font-size: 20px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-certificate" style="color: var(--olive);"></i> Sertifikat Saya
                        </h4>
                        
                        <!-- Search -->
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <div class="relative">
                                    <input type="text" id="certificateSearch" class="form-control bg-white border-gray rounded-1 px-5 py-3" placeholder="Cari sertifikat berdasarkan judul atau tanggal..." style="font-size: 16px; height: 50px;">
                                    <div class="abs" style="left: 20px; top: 50%; transform: translateY(-50%); color: #999;">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-4" id="certificateGrid">
                            <!-- Sertifikat Sementara -->
                            <div class="col-lg-4 col-sm-6 certificate-card-item">
                                <div class="certificate-card">
                                    <img src="{{ asset('frontend/images/services/1.webp') }}" class="certificate-image" alt="Sertifikat Kelas Dasar">
                                    <div class="certificate-info">
                                        <h5>Sertifikat Kelas Dasar</h5>
                                        <p class="certificate-date">20 Januari 2026</p>
                                        <a href="#" class="btn-download" target="_blank">
                                            <i class="fa-solid fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- No Results Message -->
                        <div class="row" id="noCertificateResults" style="display: none;">
                            <div class="col-lg-12 text-center py-5">
                                <div class="bg-white border-gray rounded-1 p-5" style="max-width: 500px; margin: 0 auto;">
                                    <div class="mb-3">
                                        <i class="fa fa-search-minus fs-48 text-muted"></i>
                                    </div>
                                    <h4 class="mb-3">Tidak ada sertifikat yang ditemukan</h4>
                                    <p class="text-muted mb-0">Coba kata kunci lain atau periksa ejaan pencarian Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.7);z-index:9999;align-items:center;justify-content:center;padding:20px;">
        <div style="background:#fff;padding:40px;border-radius:16px;max-width:600px;width:100%;max-height:calc(100vh - 40px);overflow-y:auto;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.3);position:relative;-webkit-overflow-scrolling:touch;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;">
                <h3 style="margin:0;color:#22231C;font-size:24px;font-weight:700;">Ubah Profil</h3>
                <button onclick="closeEditProfileModal()" style="background:none;border:none;font-size:24px;cursor:pointer;color:#8B8D7E;padding:0;">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" style="text-align:left;">
                @csrf
                @method('PUT')
                
                <!-- Avatar Upload -->
                <div style="margin-bottom:24px;text-align:center;">
                    <div style="position:relative;display:inline-block;">
                        @if($student->avatar_url)
                            <img src="{{ $student->avatar_url }}" id="avatarPreview" style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid #7C815D;" alt="Avatar">
                        @else
                            <div id="avatarPreview" style="width:100px;height:100px;border-radius:50%;background:#7C815D;color:white;display:flex;align-items:center;justify-content:center;font-size:40px;font-weight:bold;border:3px solid #7C815D;">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                        @endif
                        <label for="avatar" style="position:absolute;bottom:0;right:0;background:#7C815D;color:white;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;border:2px solid white;">
                            <i class="fa-solid fa-camera" style="font-size:14px;"></i>
                        </label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
                    </div>
                    <p style="margin-top:10px;font-size:13px;color:#8B8D7E;">Format: JPG, PNG, WEBP (Max 2MB)</p>
                </div>
                
                <!-- Form Fields -->
                <div style="margin-bottom:20px;">
                    <label style="display:block;margin-bottom:8px;font-weight:600;font-size:14px;color:#22231C;">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $student->name }}" required style="width:100%;padding:12px 16px;border:1px solid #ECECE4;border-radius:8px;font-size:15px;background:#F7F7F3;">
                </div>
                
                <div style="margin-bottom:20px;">
                    <label style="display:block;margin-bottom:8px;font-weight:600;font-size:14px;color:#22231C;">Email</label>
                    <input type="email" name="email" value="{{ $student->email }}" required style="width:100%;padding:12px 16px;border:1px solid #ECECE4;border-radius:8px;font-size:15px;background:#F7F7F3;">
                </div>
                
                <div style="margin-bottom:20px;">
                    <label style="display:block;margin-bottom:8px;font-weight:600;font-size:14px;color:#22231C;">NIS</label>
                    <input type="text" name="nis" value="{{ $student->nis ?? '' }}" style="width:100%;padding:12px 16px;border:1px solid #ECECE4;border-radius:8px;font-size:15px;background:#F7F7F3;">
                </div>
                
                <div style="margin-bottom:20px;">
                    <label style="display:block;margin-bottom:8px;font-weight:600;font-size:14px;color:#22231C;">Kelas</label>
                    <input type="text" name="grade" value="{{ $student->grade ?? '' }}" style="width:100%;padding:12px 16px;border:1px solid #ECECE4;border-radius:8px;font-size:15px;background:#F7F7F3;">
                </div>
                
                <div style="margin-bottom:20px;">
                    <label style="display:block;margin-bottom:8px;font-weight:600;font-size:14px;color:#22231C;">Sekolah</label>
                    <input type="text" name="school" value="{{ $student->school ?? '' }}" style="width:100%;padding:12px 16px;border:1px solid #ECECE4;border-radius:8px;font-size:15px;background:#F7F7F3;">
                </div>
                
                <div style="margin-bottom:20px;">
                    <label style="display:block;margin-bottom:8px;font-weight:600;font-size:14px;color:#22231C;">Jurusan</label>
                    <input type="text" name="major" value="{{ $student->major ?? '' }}" style="width:100%;padding:12px 16px;border:1px solid #ECECE4;border-radius:8px;font-size:15px;background:#F7F7F3;">
                </div>
                
                <div style="margin-bottom:20px;">
                    <label style="display:block;margin-bottom:8px;font-weight:600;font-size:14px;color:#22231C;">No. Telepon</label>
                    <input type="text" name="phone" value="{{ $student->phone ?? '' }}" style="width:100%;padding:12px 16px;border:1px solid #ECECE4;border-radius:8px;font-size:15px;background:#F7F7F3;">
                </div>
                
                <div style="margin-bottom:20px;">
                    <label style="display:block;margin-bottom:8px;font-weight:600;font-size:14px;color:#22231C;">Alamat</label>
                    <textarea name="address" rows="3" style="width:100%;padding:12px 16px;border:1px solid #ECECE4;border-radius:8px;font-size:15px;background:#F7F7F3;resize:vertical;">{{ $student->address ?? '' }}</textarea>
                </div>
                
                <div style="margin-bottom:20px;">
                    <label style="display:block;margin-bottom:8px;font-weight:600;font-size:14px;color:#22231C;">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ $student->birth_date ? $student->birth_date->format('Y-m-d') : '' }}" style="width:100%;padding:12px 16px;border:1px solid #ECECE4;border-radius:8px;font-size:15px;background:#F7F7F3;">
                </div>
                
                <div style="margin-bottom:30px;">
                    <label style="display:block;margin-bottom:8px;font-weight:600;font-size:14px;color:#22231C;">Minat Belajar</label>
                    <input type="text" name="learning_interest" value="{{ $student->learning_interest ?? '' }}" style="width:100%;padding:12px 16px;border:1px solid #ECECE4;border-radius:8px;font-size:15px;background:#F7F7F3;">
                </div>
                
                <!-- Buttons -->
                <div style="display:flex;gap:15px;justify-content:center;">
                    <button type="button" onclick="closeEditProfileModal()" style="background:white;color:#22231C;padding:12px 30px;border:1px solid #ECECE4;border-radius:8px;cursor:pointer;font-size:16px;font-weight:600;">
                        Batal
                    </button>
                    <button type="submit" style="background:#7C815D;color:white;padding:12px 30px;border:none;border-radius:8px;cursor:pointer;font-size:16px;font-weight:600;">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditProfileModal() {
            const modal = document.getElementById('editProfileModal');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'fixed';
            document.body.style.width = '100%';
            document.body.style.top = `-${window.scrollY}px`;
        }

        function closeEditProfileModal() {
            const modal = document.getElementById('editProfileModal');
            const scrollY = document.body.style.top;
            modal.style.display = 'none';
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.top = '';
            window.scrollTo(0, parseInt(scrollY || '0') * -1);
        }

        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('avatarPreview');
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        // Replace div with img
                        const img = document.createElement('img');
                        img.id = 'avatarPreview';
                        img.src = e.target.result;
                        img.style.cssText = 'width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid #7C815D;';
                        preview.parentNode.replaceChild(img, preview);
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function showSection(section) {
            // Hide all sections
            document.getElementById('section-profile').style.display = 'none';
            document.getElementById('section-classes').style.display = 'none';
            document.getElementById('section-certificates').style.display = 'none';
            
            // Remove active class from all links
            document.getElementById('link-profile').classList.remove('active');
            document.getElementById('link-classes').classList.remove('active');
            document.getElementById('link-certificates').classList.remove('active');
            
            // Show selected section and activate link
            document.getElementById('section-' + section).style.display = 'block';
            document.getElementById('link-' + section).classList.add('active');
        }

        // Certificate Search Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('certificateSearch');
            const certificateGrid = document.getElementById('certificateGrid');
            const certificateCards = certificateGrid.querySelectorAll('.certificate-card-item');
            const noResults = document.getElementById('noCertificateResults');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let visibleCount = 0;

                certificateCards.forEach(card => {
                    const title = card.querySelector('h5').textContent.toLowerCase();
                    const date = card.querySelector('.certificate-date').textContent.toLowerCase();

                    if (title.includes(searchTerm) || date.includes(searchTerm)) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0 && certificateCards.length > 0) {
                    noResults.style.display = '';
                } else {
                    noResults.style.display = 'none';
                }
            });

            // Close modal when clicking outside
            const editProfileModal = document.getElementById('editProfileModal');
            if (editProfileModal) {
                editProfileModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeEditProfileModal();
                    }
                });
            }
        });
    </script>
@endsection