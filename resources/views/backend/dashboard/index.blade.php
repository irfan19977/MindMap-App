@extends('backend.layouts.app')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <div class="dropdown">
                                <a class="btn btn-md btn-light-brand" data-bs-toggle="dropdown">
                                    <i class="feather-calendar me-2"></i>
                                    <span>Last {{ $period }} Days</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('dashboard.index') }}?period=7" class="dropdown-item">Last 7 Days</a>
                                    <a href="{{ route('dashboard.index') }}?period=30" class="dropdown-item">Last 30 Days</a>
                                    <a href="{{ route('dashboard.index') }}?period=90" class="dropdown-item">Last 90 Days</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="btn btn-md btn-light-brand" data-bs-toggle="dropdown">
                                    <i class="feather-zap me-2"></i>
                                    <span>Aksi Cepat</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('categories.create') }}" class="dropdown-item">
                                        <i class="feather-folder-plus me-2 text-primary"></i>Tambah Kategori
                                    </a>
                                    <a href="{{ route('materis.create') }}" class="dropdown-item">
                                        <i class="feather-file-plus me-2 text-success"></i>Tambah Materi
                                    </a>
                                    <a href="{{ route('mindmap.index') }}" class="dropdown-item">
                                        <i class="feather-git-branch me-2 text-warning"></i>Kelola MindMap
                                    </a>
                                    <hr class="my-1">
                                    <a href="{{ route('learning-results.index') }}" class="dropdown-item">
                                        <i class="feather-activity me-2 text-danger"></i>Hasil Pembelajaran
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="btn btn-md btn-primary" data-bs-toggle="dropdown">
                                    <i class="feather-download me-2"></i>
                                    <span>Export</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('engagement.export', ['type' => 'users', 'format' => 'csv']) }}" class="dropdown-item">
                                        <i class="feather-users me-2"></i>Users (CSV)
                                    </a>
                                    <a href="{{ route('engagement.export', ['type' => 'categories', 'format' => 'csv']) }}" class="dropdown-item">
                                        <i class="feather-folder me-2"></i>Categories (CSV)
                                    </a>
                                    <a href="{{ route('engagement.export', ['type' => 'analytics', 'format' => 'csv']) }}" class="dropdown-item">
                                        <i class="feather-file-text me-2"></i>Analytics (CSV)
                                    </a>
                                    <a href="{{ route('engagement.export', ['type' => 'analytics', 'format' => 'json']) }}" class="dropdown-item">
                                        <i class="feather-code me-2"></i>Analytics (JSON)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <!-- Summary Stats Row -->
                <div class="row">
                    <!-- Total Users -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-primary text-primary rounded">
                                        <i class="feather-users fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $totalUsers }}</div>
                                        <h3 class="fs-13 fw-semibold text-muted">Total Pengguna</h3>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fs-12 text-muted">Siswa: {{ $totalStudents }}</span>
                                        <span class="fs-12 text-muted">Guru: {{ $totalTeachers }}</span>
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        @php $studentPercent = $totalUsers > 0 ? round(($totalStudents / $totalUsers) * 100) : 0; @endphp
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $studentPercent }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Materi -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-success text-success rounded">
                                        <i class="feather-book-open fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $totalMaterials }}</div>
                                        <h3 class="fs-13 fw-semibold text-muted">Total Materi</h3>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fs-12 text-muted">{{ $totalCategories }} Kategori</span>
                                        <span class="fs-12 text-muted">{{ $totalSubcategories }} Sub Kategori</span>
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- MindMap -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-warning text-warning rounded">
                                        <i class="feather-git-branch fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $totalMindmaps }}</div>
                                        <h3 class="fs-13 fw-semibold text-muted">Total MindMap</h3>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fs-12 text-muted">Materi aktif</span>
                                        <span class="fs-12 text-dark fw-semibold">{{ $totalMindmaps }} mindmap</span>
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Aktivitas Belajar -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-danger text-danger rounded">
                                        <i class="feather-activity fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $totalProgress }}</div>
                                        <h3 class="fs-13 fw-semibold text-muted">Aktivitas Belajar</h3>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fs-12 text-muted">Selesai: {{ $completedMaterials }}</span>
                                        @php $completionRate = $totalProgress > 0 ? round(($completedMaterials / $totalProgress) * 100) : 0; @endphp
                                        <span class="fs-12 text-dark fw-semibold">{{ $completionRate }}%</span>
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $completionRate }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Aktivitas Platform -->
                <div class="row">
                    <div class="col-xxl-8">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Aktivitas Platform</h5>
                            </div>
                            <div class="card-body custom-card-action p-0">
                                <div id="platform-activity-chart"></div>
                            </div>
                            <div class="card-footer">
                                <div class="row g-4">
                                    <div class="col-lg-4">
                                        <div class="p-3 border border-dashed rounded">
                                            <div class="fs-12 text-muted mb-1">Kunjungan Hari Ini</div>
                                            <h6 class="fw-bold text-dark">{{ $todayVisits }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="p-3 border border-dashed rounded">
                                            <div class="fs-12 text-muted mb-1">Kunjungan ({{ $period }} hari)</div>
                                            <h6 class="fw-bold text-dark">{{ $platformChart->sum('visits') }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="p-3 border border-dashed rounded">
                                            <div class="fs-12 text-muted mb-1">Pendaftaran ({{ $period }} hari)</div>
                                            <h6 class="fw-bold text-dark">{{ $platformChart->sum('registrations') }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Statistik Quiz -->
                    <div class="col-xxl-4">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Statistik Quiz</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="text-center flex-fill">
                                        <div class="fs-3 fw-bold text-primary">{{ $totalQuizAttempts }}</div>
                                        <div class="fs-12 text-muted">Total Percobaan</div>
                                    </div>
                                    <div class="text-center flex-fill">
                                        <div class="fs-3 fw-bold text-success">{{ $quizPassedCount }}</div>
                                        <div class="fs-12 text-muted">Lulus</div>
                                    </div>
                                    <div class="text-center flex-fill">
                                        <div class="fs-3 fw-bold text-warning">{{ number_format($averageScore, 1) }}%</div>
                                        <div class="fs-12 text-muted">Rata-rata Skor</div>
                                    </div>
                                </div>
                                @if($totalQuizAttempts > 0)
                                <div class="mt-3">
                                    @php $passRate = round(($quizPassedCount / $totalQuizAttempts) * 100); @endphp
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fs-12 text-muted">Tingkat Kelulusan</span>
                                        <span class="fs-12 fw-bold">{{ $passRate }}%</span>
                                    </div>
                                    <div class="progress ht-6">
                                        <div class="progress-bar bg-success" style="width: {{ $passRate }}%"></div>
                                        <div class="progress-bar bg-danger" style="width: {{ 100 - $passRate }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <span class="fs-11 text-success">Lulus ({{ $quizPassedCount }})</span>
                                        <span class="fs-11 text-danger">Gagal ({{ $totalQuizAttempts - $quizPassedCount }})</span>
                                    </div>
                                </div>
                                @else
                                <div class="text-center text-muted py-3">
                                    <i class="feather-inbox fs-3 d-block mb-2"></i>
                                    <span>Belum ada percobaan quiz</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Third Row: Recent Activity -->
                <div class="row">
                    <!-- Recent Quiz Attempts -->
                    <div class="col-xxl-8">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Aktivitas Quiz Terbaru</h5>
                            </div>
                            <div class="card-body custom-card-action p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr class="border-b">
                                                <th>Siswa</th>
                                                <th>Quiz</th>
                                                <th class="text-center">Skor</th>
                                                <th class="text-center">Status</th>
                                                <th>Waktu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentQuizAttempts as $attempt)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar-text avatar-md bg-soft-primary text-primary rounded-circle">
                                                            {{ strtoupper(substr($attempt->user->name ?? 'U', 0, 1)) }}
                                                        </div>
                                                        <span class="fw-semibold">{{ $attempt->user->name ?? '-' }}</span>
                                                    </div>
                                                </td>
                                                <td><span class="text-truncate-1-line d-block" style="max-width:200px;">{{ $attempt->quiz->title ?? '-' }}</span></td>
                                                <td class="text-center">
                                                    <span class="fw-bold {{ $attempt->score >= 70 ? 'text-success' : ($attempt->score >= 50 ? 'text-warning' : 'text-danger') }}">
                                                        {{ number_format($attempt->score, 0) }}%
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if($attempt->status == 'passed')
                                                        <span class="badge bg-soft-success text-success">Lulus</span>
                                                    @elseif($attempt->status == 'failed')
                                                        <span class="badge bg-soft-danger text-danger">Gagal</span>
                                                    @else
                                                        <span class="badge bg-soft-warning text-warning">{{ ucfirst($attempt->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="fs-12 text-muted">{{ $attempt->created_at->diffForHumans() }}</span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-muted">
                                                    <i class="feather-inbox fs-3 d-block mb-2"></i>
                                                    Belum ada aktivitas quiz
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Top Students -->
                    <div class="col-xxl-4">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Top Siswa</h5>
                            </div>
                            <div class="card-body">
                                @forelse($topStudents as $index => $stu)
                                <div class="d-flex align-items-center justify-content-between mb-3 pb-3 {{ !$loop->last ? 'border-bottom border-dashed' : '' }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-text avatar-md {{ $index == 0 ? 'bg-soft-warning text-warning' : 'bg-soft-primary text-primary' }} rounded-circle fw-bold">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <span class="fw-semibold d-block">{{ $stu->name }}</span>
                                            <span class="fs-11 text-muted">{{ $stu->email }}</span>
                                        </div>
                                    </div>
                                    <span class="badge bg-soft-success text-success">{{ $stu->completed_count }} selesai</span>
                                </div>
                                @empty
                                <div class="text-center text-muted py-3">
                                    <i class="feather-inbox fs-3 d-block mb-2"></i>
                                    <span>Belum ada data siswa</span>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- [ Main Content ] end -->
        </div>
@endsection

@push('scripts')
    @include('backend.layouts.scriptcustom')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var labels  = @json($platformChart->pluck('date'));
            var visits  = @json($platformChart->pluck('visits'));
            var registrations = @json($platformChart->pluck('registrations'));

            var el = document.querySelector('#platform-activity-chart');
            if (!el) return;

            var options = {
                chart: {
                    height: 380,
                    width: '100%',
                    stacked: false,
                    toolbar: { show: false }
                },
                stroke: {
                    width: [1, 2],
                    curve: 'smooth',
                    lineCap: 'round'
                },
                plotOptions: {
                    bar: { endingShape: 'rounded', columnWidth: '30%' }
                },
                colors: ['#3454d1', '#a2acc7'],
                series: [
                    { name: 'Kunjungan',   type: 'bar',  data: visits },
                    { name: 'Pendaftaran', type: 'line', data: registrations }
                ],
                fill: {
                    opacity: [0.85, 0.25],
                    gradient: {
                        inverseColors: false,
                        shade: 'light',
                        type: 'vertical',
                        opacityFrom: 0.5,
                        opacityTo: 0.1,
                        stops: [0, 100, 100, 100]
                    }
                },
                markers: { size: 0 },
                xaxis: {
                    categories: labels,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { fontSize: '10px', colors: '#A0ACBB' } }
                },
                yaxis: {
                    labels: {
                        formatter: function (e) { return +e; },
                        offsetX: -5,
                        offsetY: 0,
                        style: { color: '#A0ACBB' }
                    }
                },
                grid: {
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: false } }
                },
                dataLabels: { enabled: false },
                tooltip: {
                    y: { formatter: function (e) { return +e; } },
                    style: { fontSize: '12px', fontFamily: 'Inter' }
                },
                legend: { show: true, labels: { fontSize: '12px', colors: '#A0ACBB' } }
            };

            new ApexCharts(el, options).render();
        });
    </script>
@endpush
