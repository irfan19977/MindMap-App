@extends('backend.layouts.app')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard Analitik</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Analitik</li>
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
                            <select id="periodFilter" class="form-control" style="width: auto;">
                                <option value="week">Minggu Ini</option>
                                <option value="month" selected>Bulan Ini</option>
                                <option value="year">Tahun Ini</option>
                            </select>
                            <button onclick="refreshAnalytics()" class="btn btn-primary">
                                <i class="feather-refresh-cw me-2"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end --> 
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-text avatar-xl rounded bg-primary">
                                            <i class="feather-users"></i>
                                        </div>
                                        <div>
                                            <span class="d-block text-muted">Total User</span>
                                            <span class="fs-24 fw-bolder d-block">{{ $totalUsers }}</span>
                                            <small class="text-success">
                                                <i class="feather-arrow-up"></i> +{{ $newUsersThisMonth }} bulan ini
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-text avatar-xl rounded bg-success">
                                            <i class="feather-help-circle"></i>
                                        </div>
                                        <div>
                                            <span class="d-block text-muted">Total Quiz</span>
                                            <span class="fs-24 fw-bolder d-block">{{ $totalQuizzes }}</span>
                                            <small class="text-info">
                                                <i class="feather-activity"></i> {{ $totalQuizAttempts }} attempts
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-text avatar-xl rounded bg-warning">
                                            <i class="feather-book-open"></i>
                                        </div>
                                        <div>
                                            <span class="d-block text-muted">Total Materi</span>
                                            <span class="fs-24 fw-bolder d-block">{{ $totalMaterials }}</span>
                                            <small class="text-muted">
                                                <i class="feather-folder"></i> {{ $totalCategories }} kategori
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-text avatar-xl rounded bg-danger">
                                            <i class="feather-eye"></i>
                                        </div>
                                        <div>
                                            <span class="d-block text-muted">Total Kunjungan</span>
                                            <span class="fs-24 fw-bolder d-block">{{ $totalVisits }}</span>
                                            <small class="text-success">
                                                <i class="feather-arrow-up"></i> +{{ $visitsToday }} hari ini
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Statistik Bulanan (6 Bulan Terakhir)</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="monthlyChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Performa Quiz</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="d-block text-muted">Rata-rata Skor</span>
                                    <span class="fs-32 fw-bolder text-success">{{ number_format($averageQuizScore, 1) }}%</span>
                                </div>
                                <div class="mb-3">
                                    <span class="d-block text-muted">Tingkat Kelulusan</span>
                                    <span class="fs-32 fw-bolder text-primary">{{ number_format($passRate, 1) }}%</span>
                                </div>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $passRate }}%" aria-valuenow="{{ $passRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="mb-3">
                                    <span class="d-block text-muted">Akurasi Latihan</span>
                                    <span class="fs-24 fw-bolder text-warning">{{ number_format($practiceAccuracy, 1) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quiz Performance Table -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Performa Quiz per Materi</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Judul Quiz</th>
                                                <th class="text-center">Total Attempt</th>
                                                <th class="text-center">Rata-rata Skor</th>
                                                <th class="text-center">Tingkat Kelulusan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($quizPerformance as $quiz)
                                                <tr>
                                                    <td>{{ $quiz['title'] }}</td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary">{{ $quiz['attempts'] }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge {{ $quiz['avg_score'] >= 70 ? 'bg-success' : ($quiz['avg_score'] >= 50 ? 'bg-warning' : 'bg-danger') }}">
                                                            {{ $quiz['avg_score'] }}%
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge {{ $quiz['pass_rate'] >= 70 ? 'bg-success' : ($quiz['pass_rate'] >= 50 ? 'bg-warning' : 'bg-danger') }}">
                                                            {{ $quiz['pass_rate'] }}%
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="feather-inbox fs-24 d-block mb-2"></i>
                                                            Belum ada data quiz
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Progress & Recent Activity -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Progress Pembelajaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block text-muted">Total Progress</span>
                                        <span class="fs-24 fw-bolder">{{ $totalProgress }}</span>
                                    </div>
                                    <div>
                                        <span class="d-block text-muted">Materi Selesai</span>
                                        <span class="fs-24 fw-bolder text-success">{{ $completedMaterials }}</span>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ $totalProgress > 0 ? ($completedMaterials / $totalProgress) * 100 : 0 }}%" 
                                         aria-valuenow="{{ $totalProgress > 0 ? ($completedMaterials / $totalProgress) * 100 : 0 }}" 
                                         aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    {{ $totalProgress > 0 ? number_format(($completedMaterials / $totalProgress) * 100, 1) : 0 }}% materi selesai
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Aktivitas Terbaru</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody>
                                            @forelse($recentQuizAttempts as $attempt)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <strong>{{ $attempt->user->name }}</strong>
                                                            <small class="d-block text-muted">{{ $attempt->quiz->title }}</small>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="badge {{ $attempt->status == 'passed' ? 'bg-success' : ($attempt->status == 'failed' ? 'bg-danger' : 'bg-warning') }}">
                                                            {{ ucfirst($attempt->status) }}
                                                        </span>
                                                        <small class="d-block text-muted">{{ $attempt->score }}%</small>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center py-4 text-muted">
                                                        Belum ada aktivitas
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
@endsection

@push('scripts')
    <script src="{{ asset('backend/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/theme-customizer-init.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Monthly Chart
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthLabels),
                datasets: [
                    {
                        label: 'User Baru',
                        data: @json($monthlyUsers),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Quiz Attempts',
                        data: @json($monthlyQuizAttempts),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Kunjungan',
                        data: @json($monthlyVisits),
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Refresh Analytics
        function refreshAnalytics() {
            const period = document.getElementById('periodFilter').value;
            fetch(`/analytics/data?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    // Update UI with new data
                    // You can implement this based on your needs
                    console.log('Analytics data refreshed:', data);
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
        }

        // Period filter change
        document.getElementById('periodFilter').addEventListener('change', function() {
            refreshAnalytics();
        });
    </script>
@endpush
