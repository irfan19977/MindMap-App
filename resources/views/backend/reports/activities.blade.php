@extends('backend.layouts.app')

@section('title', 'Laporan Aktivitas')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Laporan Aktivitas</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item">Aktivitas</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <a href="{{ route('reports.export', 'activities') }}" class="btn btn-primary">
                                <i class="feather-download me-2"></i>
                                <span>Export CSV</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->

            <!-- [ Main Content ] start -->
            <div class="main-content">
                <!-- Statistik -->
                <div class="row">
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-primary text-primary rounded">
                                        <i class="feather-log-in fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $stats['logins_today'] }}</div>
                                        <div class="fs-12 text-muted">Login Hari Ini</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-success text-success rounded">
                                        <i class="feather-help-circle fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $stats['quiz_today'] }}</div>
                                        <div class="fs-12 text-muted">Quiz Hari Ini</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-warning text-warning rounded">
                                        <i class="feather-book fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $stats['completed_today'] }}</div>
                                        <div class="fs-12 text-muted">Materi Selesai Hari Ini</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-info text-info rounded">
                                        <i class="feather-globe fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $stats['visits_today'] }}</div>
                                        <div class="fs-12 text-muted">Kunjungan Hari Ini</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Filter Periode</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.activities') }}">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Dari Tanggal</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Sampai Tanggal</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                                </div>
                                <div class="col-md-3 d-flex align-items-end gap-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="feather-filter me-2"></i>Filter
                                    </button>
                                    <a href="{{ route('reports.activities') }}" class="btn btn-light w-100">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="card stretch stretch-full">
                    <div class="card-header p-0">
                        <ul class="nav nav-tabs flex-wrap w-100 text-center" id="activityTab" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">
                                <a class="nav-link {{ $type == 'login' ? 'active' : '' }}" href="{{ route('reports.activities', ['type' => 'login', 'start_date' => $startDate, 'end_date' => $endDate]) }}">Login</a>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <a class="nav-link {{ $type == 'quiz' ? 'active' : '' }}" href="{{ route('reports.activities', ['type' => 'quiz', 'start_date' => $startDate, 'end_date' => $endDate]) }}">Quiz</a>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <a class="nav-link {{ $type == 'learning' ? 'active' : '' }}" href="{{ route('reports.activities', ['type' => 'learning', 'start_date' => $startDate, 'end_date' => $endDate]) }}">Pembelajaran</a>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <a class="nav-link {{ $type == 'visit' ? 'active' : '' }}" href="{{ route('reports.activities', ['type' => 'visit', 'start_date' => $startDate, 'end_date' => $endDate]) }}">Kunjungan</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            @if($type == 'login')
                                <table class="table table-hover" id="activitiesReportTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">User</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Waktu Login</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($logins as $index => $user)
                                            <tr class="single-item">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar-text avatar-sm bg-soft-primary text-primary rounded-circle">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                        <span class="fw-semibold">{{ $user->name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <span class="fs-12 text-muted">{{ $user->last_login_at?->diffForHumans() }}</span>
                                                    <div class="fs-11 text-muted">{{ $user->last_login_at?->format('d M Y H:i') }}</div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="feather-inbox fs-24 d-block mb-2"></i>
                                                        Tidak ada data login
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @elseif($type == 'quiz')
                                <table class="table table-hover" id="activitiesReportTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">User</th>
                                            <th class="text-center">Quiz</th>
                                            <th class="text-center">Skor</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($quizAttempts as $index => $attempt)
                                            <tr class="single-item">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar-text avatar-sm bg-soft-primary text-primary rounded-circle">
                                                            {{ strtoupper(substr($attempt->user->name ?? 'U', 0, 1)) }}
                                                        </div>
                                                        <span class="fw-semibold">{{ $attempt->user->name ?? '-' }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $attempt->quiz->title ?? '-' }}</td>
                                                <td>
                                                    <span class="fw-bold {{ $attempt->score >= 70 ? 'text-success' : ($attempt->score >= 50 ? 'text-warning' : 'text-danger') }}">
                                                        {{ number_format($attempt->score, 0) }}%
                                                    </span>
                                                </td>
                                                <td>
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
                                                <td colspan="6" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="feather-inbox fs-24 d-block mb-2"></i>
                                                        Tidak ada data quiz
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @elseif($type == 'learning')
                                <table class="table table-hover" id="activitiesReportTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">User</th>
                                            <th class="text-center">Materi</th>
                                            <th class="text-center">Progress</th>
                                            <th class="text-center">Selesai</th>
                                            <th class="text-center">Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($progress as $index => $item)
                                            <tr class="single-item">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar-text avatar-sm bg-soft-primary text-primary rounded-circle">
                                                            {{ strtoupper(substr($item->user->name ?? 'U', 0, 1)) }}
                                                        </div>
                                                        <span class="fw-semibold">{{ $item->user->name ?? '-' }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $item->material->title ?? '-' }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="progress flex-fill ht-3">
                                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $item->progress_percentage }}%"></div>
                                                        </div>
                                                        <span class="fs-12 fw-bold">{{ number_format($item->progress_percentage, 0) }}%</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($item->completed_at)
                                                        <span class="badge bg-soft-success text-success">Selesai</span>
                                                    @else
                                                        <span class="badge bg-soft-warning text-warning">Berlangsung</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="fs-12 text-muted">{{ $item->updated_at->diffForHumans() }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="feather-inbox fs-24 d-block mb-2"></i>
                                                        Tidak ada data pembelajaran
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @elseif($type == 'visit')
                                <table class="table table-hover" id="activitiesReportTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">User</th>
                                            <th class="text-center">IP Address</th>
                                            <th class="text-center">URL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($visits as $index => $visit)
                                            <tr class="single-item">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $visit->visited_date?->format('d M Y') }}</td>
                                                <td>{{ $visit->user?->name ?? 'Guest' }}</td>
                                                <td>{{ $visit->ip_address ?? '-' }}</td>
                                                <td>
                                                    <span class="text-truncate-1-line d-block" style="max-width:300px;">{{ $visit->url ?? '-' }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="feather-inbox fs-24 d-block mb-2"></i>
                                                        Tidak ada data kunjungan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @endif
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
        $(document).ready(function() {
            $('#activitiesReportTable').DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Tidak ada data tersedia",
                    zeroRecords: "Tidak ditemukan data yang cocok"
                },
                order: []
            });
        });
    </script>
@endpush
