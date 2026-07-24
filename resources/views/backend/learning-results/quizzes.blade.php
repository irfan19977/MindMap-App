@extends('backend.layouts.app')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Hasil Quiz</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Hasil Pembelajaran</li>
                        <li class="breadcrumb-item">Hasil Quiz</li>
                    </ul>
                </div>
            </div>
            <!-- [ page-header ] end -->

            <!-- [ Main Content ] start -->
            <div class="main-content">
                <!-- Quiz Summary Cards -->
                <div class="row">
                    @foreach($quizzes as $quiz)
                    <div class="col-xxl-4 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $quiz->title }}</h6>
                                        <small class="text-muted">{{ $quiz->quiz_attempts_count }} percobaan</small>
                                    </div>
                                    <span class="badge {{ $quiz->status == 'publish' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($quiz->status) }}
                                    </span>
                                </div>
                                <div class="d-flex gap-3">
                                    <div class="text-center flex-fill">
                                        <h5 class="text-success mb-0">{{ $quiz->passed_count }}</h5>
                                        <small class="text-muted">Lulus</small>
                                    </div>
                                    <div class="text-center flex-fill">
                                        <h5 class="text-danger mb-0">{{ $quiz->failed_count }}</h5>
                                        <small class="text-muted">Gagal</small>
                                    </div>
                                    <div class="text-center flex-fill">
                                        <h5 class="text-primary mb-0">{{ number_format($quiz->avg_score, 1) }}%</h5>
                                        <small class="text-muted">Rata-rata</small>
                                    </div>
                                </div>
                                @if($quiz->quiz_attempts_count > 0)
                                <div class="progress mt-3" style="height: 6px;">
                                    @php
                                        $passRate = round(($quiz->passed_count / $quiz->quiz_attempts_count) * 100);
                                    @endphp
                                    <div class="progress-bar bg-success" style="width: {{ $passRate }}%"></div>
                                    <div class="progress-bar bg-danger" style="width: {{ 100 - $passRate }}%"></div>
                                </div>
                                <small class="text-muted">{{ $passRate }}% tingkat kelulusan</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Detail Attempts Table -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Riwayat Pengerjaan Quiz</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="quizResultsTable">
                                        <thead>
                                            <tr>
                                                <th>Siswa</th>
                                                <th>Quiz</th>
                                                <th class="text-center">Skor</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Waktu Mulai</th>
                                                <th class="text-center">Waktu Selesai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($attempts as $attempt)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="avatar-text avatar-md bg-soft-primary text-primary rounded-circle">
                                                                {{ strtoupper(substr($attempt->user->name ?? 'U', 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <span class="fw-bold d-block">{{ $attempt->user->name ?? '-' }}</span>
                                                                <small class="text-muted">{{ $attempt->user->email ?? '-' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-semibold">{{ $attempt->quiz->title ?? '-' }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="fw-bold fs-5 {{ $attempt->score >= 70 ? 'text-success' : ($attempt->score >= 50 ? 'text-warning' : 'text-danger') }}">
                                                            {{ number_format($attempt->score, 1) }}%
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        @if($attempt->status == 'passed')
                                                            <span class="badge bg-success"><i class="feather-check me-1"></i>Lulus</span>
                                                        @elseif($attempt->status == 'failed')
                                                            <span class="badge bg-danger"><i class="feather-x me-1"></i>Gagal</span>
                                                        @else
                                                            <span class="badge bg-warning"><i class="feather-clock me-1"></i>{{ ucfirst($attempt->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <small>{{ $attempt->started_at ? $attempt->started_at->format('d M Y H:i') : '-' }}</small>
                                                    </td>
                                                    <td class="text-center">
                                                        <small>{{ $attempt->completed_at ? $attempt->completed_at->format('d M Y H:i') : '-' }}</small>
                                                    </td>
                                                </tr>
                                            @empty
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
    <script src="{{ asset('backend/assets/vendors/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/dataTables.bs5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/theme-customizer-init.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#quizResultsTable').DataTable({
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
                order: [[4, 'desc']]
            });
        });
    </script>
@endpush
