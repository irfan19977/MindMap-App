@extends('backend.layouts.app')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Tracking Siswa</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Hasil Pembelajaran</li>
                        <li class="breadcrumb-item">Tracking Siswa</li>
                    </ul>
                </div>
            </div>
            <!-- [ page-header ] end -->

            <!-- [ Main Content ] start -->
            <div class="main-content">
                <!-- Summary Cards -->
                <div class="row">
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-text avatar-lg bg-soft-primary text-primary rounded">
                                            <i class="feather-users fs-4"></i>
                                        </div>
                                        <div>
                                            <h3 class="fw-bold mb-0">{{ $totalStudents }}</h3>
                                            <span class="fs-12 text-muted">Total Siswa</span>
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
                                        <div class="avatar-text avatar-lg bg-soft-info text-info rounded">
                                            <i class="feather-edit-3 fs-4"></i>
                                        </div>
                                        <div>
                                            <h3 class="fw-bold mb-0">{{ $totalAttempts }}</h3>
                                            <span class="fs-12 text-muted">Total Percobaan Quiz</span>
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
                                        <div class="avatar-text avatar-lg bg-soft-success text-success rounded">
                                            <i class="feather-check-circle fs-4"></i>
                                        </div>
                                        <div>
                                            <h3 class="fw-bold mb-0">{{ $totalPassed }}</h3>
                                            <span class="fs-12 text-muted">Quiz Lulus</span>
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
                                        <div class="avatar-text avatar-lg bg-soft-warning text-warning rounded">
                                            <i class="feather-trending-up fs-4"></i>
                                        </div>
                                        <div>
                                            <h3 class="fw-bold mb-0">{{ number_format($averageScore, 1) }}%</h3>
                                            <span class="fs-12 text-muted">Rata-rata Skor</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Student Table -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Progress Belajar Siswa</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="studentTrackingTable">
                                        <thead>
                                            <tr>
                                                <th>Siswa</th>
                                                <th class="text-center">Materi Diakses</th>
                                                <th class="text-center">Materi Selesai</th>
                                                <th class="text-center">Quiz Dikerjakan</th>
                                                <th class="text-center">Quiz Lulus</th>
                                                <th class="text-center">Rata-rata Skor</th>
                                                <th class="text-center">Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($students as $student)
                                                @php
                                                    $progressPercent = $student->total_materials > 0
                                                        ? round(($student->completed_materials / $student->total_materials) * 100)
                                                        : 0;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="avatar-text avatar-md bg-soft-primary text-primary rounded-circle">
                                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <span class="fw-bold d-block">{{ $student->name }}</span>
                                                                <small class="text-muted">{{ $student->email }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-soft-info text-info">{{ $student->total_materials }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-soft-success text-success">{{ $student->completed_materials }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-soft-primary text-primary">{{ $student->quiz_attempts_count }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-soft-success text-success">{{ $student->quiz_passed_count }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="fw-bold {{ $student->average_score >= 70 ? 'text-success' : ($student->average_score >= 50 ? 'text-warning' : 'text-danger') }}">
                                                            {{ number_format($student->average_score, 1) }}%
                                                        </span>
                                                    </td>
                                                    <td class="text-center" style="min-width: 150px;">
                                                        <div class="progress" style="height: 8px;">
                                                            <div class="progress-bar {{ $progressPercent >= 70 ? 'bg-success' : ($progressPercent >= 40 ? 'bg-warning' : 'bg-danger') }}"
                                                                 role="progressbar"
                                                                 style="width: {{ $progressPercent }}%"
                                                                 aria-valuenow="{{ $progressPercent }}"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">{{ $progressPercent }}%</small>
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
            $('#studentTrackingTable').DataTable({
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
                order: [[5, 'desc']]
            });
        });
    </script>
@endpush
