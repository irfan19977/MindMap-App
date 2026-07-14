@extends('frontend.layouts.app')

@section('content')
    <style>
        .student-detail-section { padding: 60px 0; }
        .student-profile-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            padding: 30px;
        }
        .student-profile-card .avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #333;
            color: #fff;
            font-size: 60px;
            line-height: 150px;
            text-align: center;
            margin: 0 auto 20px;
            display: block;
            font-weight: bold;
        }
        .student-profile-card .role-badge {
            display: inline-block;
            background: #e8f5e9;
            color: #2e7d32;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .student-info-section { margin-bottom: 30px; }
        .student-info-section h3 {
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
            min-width: 22px;
        }
        .stat-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            padding: 25px;
            text-align: center;
            margin-bottom: 20px;
        }
        .stat-card .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }
        .stat-card .stat-label {
            color: #999;
            font-size: 14px;
            margin-top: 5px;
        }
        .stat-card i {
            font-size: 28px;
            margin-bottom: 10px;
            color: #555;
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
        .progress-bar-custom {
            background: #e9ecef;
            border-radius: 10px;
            height: 8px;
            margin-top: 10px;
            overflow: hidden;
        }
        .progress-bar-custom .progress-fill {
            background: #333;
            height: 100%;
            border-radius: 10px;
            transition: width 0.3s;
        }
    </style>

    <!-- Header Section -->
    <section class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="no-pad bold">Profil <span class="label classic">Siswa</span></h1>
                        <p class="lead">Pantau perkembangan belajar dan kelas yang sedang Anda ikuti</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 1: Detail Student -->
    <section class="student-detail-section">
        <div class="container">
            <div class="row">
                <!-- Left: Profile Card -->
                <div class="col-md-4">
                    <div class="student-profile-card text-center">
                        <div class="avatar">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
                        <h2>{{ $student->name }}</h2>
                        <span class="role-badge"><i class="fas fa-user-graduate"></i> Siswa</span>
                        <div style="margin-top: 10px;">
                            <p class="text-muted"><i class="fas fa-envelope"></i> {{ $student->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Detail Info -->
                <div class="col-md-8">
                    <div class="student-info-section">
                        <h3><i class="fas fa-user"></i> Informasi Pribadi</h3>
                        @if($student->school)
                        <div class="info-item">
                            <i class="fas fa-school text-primary"></i>
                            <div>
                                <strong>Sekolah</strong><br>
                                <span>{{ $student->school }}</span>
                            </div>
                        </div>
                        @endif
                        @if($student->grade)
                        <div class="info-item">
                            <i class="fas fa-layer-group text-info"></i>
                            <div>
                                <strong>Kelas</strong><br>
                                <span>{{ $student->grade }}</span>
                            </div>
                        </div>
                        @endif
                        @if($student->birth_date)
                        <div class="info-item">
                            <i class="fas fa-calendar-alt text-warning"></i>
                            <div>
                                <strong>Tanggal Lahir</strong><br>
                                <span>{{ $student->birth_date->format('d F Y') }}</span>
                            </div>
                        </div>
                        @endif
                        @if($student->phone)
                        <div class="info-item">
                            <i class="fas fa-phone text-success"></i>
                            <div>
                                <strong>No. Telepon</strong><br>
                                <span>{{ $student->phone }}</span>
                            </div>
                        </div>
                        @endif
                        @if($student->address)
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <div>
                                <strong>Alamat</strong><br>
                                <span>{{ $student->address }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Stats Cards -->
                    <div class="student-info-section">
                        <h3><i class="fas fa-chart-bar"></i> Statistik Belajar</h3>
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="stat-card">
                                    <i class="fas fa-book-open"></i>
                                    <div class="stat-number">{{ $student->enrolledCourses->count() }}</div>
                                    <div class="stat-label">Kelas Diikuti</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="stat-card">
                                    <i class="fas fa-check-circle"></i>
                                    <div class="stat-number">{{ $student->completedMaterialsCount }}</div>
                                    <div class="stat-label">Materi Selesai</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="stat-card">
                                    <i class="fas fa-tasks"></i>
                                    <div class="stat-number">{{ $student->quizAttemptsCount }}</div>
                                    <div class="stat-label">Quiz Dikerjakan</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="stat-card">
                                    <i class="fas fa-trophy"></i>
                                    <div class="stat-number">{{ $student->passedQuizCount }}</div>
                                    <div class="stat-label">Quiz Lulus</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Kelas yang Diikuti -->
    <section class="courses-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Kelas yang Diikuti</h2>
                    <p class="text-muted">Kelas dan materi yang sedang Anda pelajari</p>
                </div>
            </div>
            <div class="row" style="margin-top: 30px;">
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
                    <div class="col-md-3 col-sm-6">
                        <div class="course-card">
                            @if($course->cover_image)
                            <img src="{{ $course->cover_image_url }}" alt="{{ $course->name }}" class="course-thumbnail">
                            @endif
                            <h4>{{ $course->name }}</h4>
                            <p class="small text-muted">{{ $course->category->name ?? '' }} - {{ $course->subcategory->name ?? 'Kurikulum Merdeka' }}</p>
                            <div class="course-meta">
                                <span><i class="fas fa-signal"></i> {{ $course->subcategory->formatted_grade_level ?? 'Umum' }}</span>
                                <span><i class="fas fa-book"></i> {{ $completedMaterials }}/{{ $totalMaterials }} materi</span>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: {{ $progressPercent }}%;"></div>
                            </div>
                            <p class="small text-muted" style="margin-top: 5px;">{{ $progressPercent }}% selesai</p>
                            <a href="{{ route('mindmap.show', $course->subcategory->slug) }}" class="btn btn-sm btn-dark-border">Lanjutkan Belajar</a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-md-12 text-center">
                        <p class="text-muted" style="padding: 40px 0;">
                            <i class="fas fa-book-open fa-3x" style="color: #ddd; display: block; margin-bottom: 15px;"></i>
                            Anda belum mengikuti kelas apapun.<br>
                            <a href="{{ route('kelas.index') }}" class="btn btn-dark-border" style="margin-top: 15px;">Jelajahi Kelas</a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
