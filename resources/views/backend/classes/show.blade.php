@extends('backend.layouts.app')

@section('content')
<div class="nxl-content">
    <!-- [ page-header ] start -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Detail Kelas</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ul>
        </div>
        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                    <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-primary">
                        <i class="feather-edit-3 me-2"></i>
                        <span>Edit Kelas</span>
                    </a>
                    <a href="{{ route('classes.index') }}" class="btn btn-secondary">
                        <i class="feather-arrow-left me-2"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- [ page-header ] end -->

    <!-- [ Main Content ] start -->
    <div class="main-content">
        <!-- First Row: Detail Kelas and Materi -->
        <div class="row">
            <div class="col-xl-4">
                <div class="card h-100" id="detailKelasCard">
                    <img src="{{ $class->cover_image_url }}" class="card-img-top" alt="{{ $class->name }}" style="max-height: 220px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ $class->name }}</h5>
                        <div class="mb-2">
                            <span class="badge bg-soft-{{ $class->status === 'publish' ? 'success' : ($class->status === 'draft' ? 'secondary' : 'warning') }} text-{{ $class->status === 'publish' ? 'success' : ($class->status === 'draft' ? 'secondary' : 'warning') }}">
                                {{ $class->formatted_status }}
                            </span>
                            @if($class->is_featured)
                                <span class="badge bg-soft-warning text-warning">Unggulan</span>
                            @endif
                        </div>
                        <p class="text-muted">{{ $class->description ?? 'Tidak ada deskripsi' }}</p>

                        <ul class="list-group list-group-flush mt-3">
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span>Kategori</span>
                                <span class="fw-semibold">{{ $class->category->name ?? '-' }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span>Sub Kategori</span>
                                <span class="fw-semibold">{{ $class->subcategory->name ?? '-' }} ({{ $class->subcategory->formatted_grade_level ?? '-' }})</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span>Guru</span>
                                <span class="fw-semibold">{{ $class->teacher->name ?? '-' }}</span>
                            </li>
                            @if($class->acceptedCollaborations && $class->acceptedCollaborations->count() > 0)
                            <li class="list-group-item px-0">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Guru Kolaborasi</span>
                                </div>
                                <div class="d-flex flex-column gap-2 mt-1">
                                    @foreach($class->acceptedCollaborations as $collab)
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="badge bg-soft-info text-info">
                                                <i class="feather-user me-1"></i>{{ $collab->teacher->user->name ?? '-' }}
                                            </span>
                                            <form method="POST" action="{{ route('collaborations.revoke', $collab->id) }}" class="d-inline revoke-collab-form" data-name="{{ $collab->teacher->user->name ?? 'guru ini' }}">
                                                @csrf
                                                <button type="submit" class="avatar-text avatar-md border-0" style="background-color: rgba(234, 84, 85, 0.15); color: #ea5455;">
                                                    <i class="feather-x"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </li>
                            @endif
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span>Kapasitas</span>
                                <span class="fw-semibold">{{ $class->capacity ?? 'Tidak terbatas' }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span>Dibuat Oleh</span>
                                <span class="fw-semibold">{{ $class->creator->name ?? '-' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card" id="materiCard" style="min-height: 100%;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Materi Kelas</h5>
                        <form method="POST" action="{{ route('classes.sync-materials', $class->id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Sync materi dari mindmap terbaru? Ini akan menambahkan materi baru dan menghapus materi yang tidak ada di mindmap.')">
                                <i class="feather-refresh-cw me-1"></i>Sync dari Mindmap
                            </button>
                        </form>
                    </div>
                    <div class="card-body p-0" style="overflow-y: auto;">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Judul Materi</th>
                                        <th>Status</th>
                                        <th>Gratis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($class->materials as $index => $material)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <a href="{{ route('materi.show', $material->slug) }}?class_id={{ $class->id }}" target="_blank" class="text-decoration-none fw-bold">
                                                    {{ $material->title }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-soft-{{ $material->status === 'publish' ? 'success' : ($material->status === 'draft' ? 'secondary' : 'warning') }} text-{{ $material->status === 'publish' ? 'success' : ($material->status === 'draft' ? 'secondary' : 'warning') }}">
                                                    {{ $material->formatted_status }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($material->is_free)
                                                    <span class="badge bg-soft-success text-success">Gratis</span>
                                                @else
                                                    <span class="badge bg-soft-warning text-warning">Berbayar</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Belum ada materi di kelas ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row: Pendaftaran Siswa (Full Width) -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="studentTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="enrollments-tab" data-bs-toggle="tab" data-bs-target="#enrollments" type="button" role="tab" aria-controls="enrollments" aria-selected="true">
                                    <i class="feather-user-plus me-2"></i>Pendaftaran Siswa
                                    <span class="badge bg-soft-warning text-warning ms-2">{{ $class->pendingEnrollments()->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="activeStudents-tab" data-bs-toggle="tab" data-bs-target="#activeStudents" type="button" role="tab" aria-controls="activeStudents" aria-selected="false">
                                    <i class="feather-users me-2"></i>Siswa dalam Kelas
                                    <span class="badge bg-soft-success text-success ms-2">{{ $class->activeEnrollments()->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="quizAttempts-tab" data-bs-toggle="tab" data-bs-target="#quizAttempts" type="button" role="tab" aria-controls="quizAttempts" aria-selected="false">
                                    <i class="feather-clipboard me-2"></i>Quiz Terbaru
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="completedStudents-tab" data-bs-toggle="tab" data-bs-target="#completedStudents" type="button" role="tab" aria-controls="completedStudents" aria-selected="false">
                                    <i class="feather-check-circle me-2"></i>Siswa Selesai
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <div class="tab-content" id="studentTabsContent">
                            <!-- Tab 1: Daftar Pendaftaran Siswa -->
                            <div class="tab-pane fade show active" id="enrollments" role="tabpanel" aria-labelledby="enrollments-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="enrollmentList">
                                        <thead>
                                            <tr>
                                                <th>Nama Siswa</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Progres</th>
                                                <th>Tanggal Daftar</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($class->pendingEnrollments as $enrollment)
                                                <tr>
                                                    <td>{{ $enrollment->student->name ?? '-' }}</td>
                                                    <td>{{ $enrollment->student->email ?? '-' }}</td>
                                                    <td>
                                                        <span class="badge bg-soft-{{ $enrollment->status === 'active' ? 'success' : ($enrollment->status === 'pending' ? 'warning' : ($enrollment->status === 'completed' ? 'info' : 'danger')) }} text-{{ $enrollment->status === 'active' ? 'success' : ($enrollment->status === 'pending' ? 'warning' : ($enrollment->status === 'completed' ? 'info' : 'danger')) }}">
                                                            {{ ucfirst($enrollment->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="progress flex-grow-1" style="height: 6px;">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                                            </div>
                                                            <span class="small">{{ $enrollment->progress_percentage }}%</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $enrollment->created_at->format('d M Y H:i') }}</td>
                                                    <td class="text-end">
                                                        @if($enrollment->status === 'pending')
                                                            <div class="d-flex gap-2 justify-content-end">
                                                                <form method="POST" action="{{ route('classes.enrollments.approve', [$class->id, $enrollment->id]) }}" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="avatar-text avatar-md border-0" style="background-color: rgba(40, 199, 111, 0.15); color: #28c76f;" data-bs-toggle="tooltip" title="Terima">
                                                                        <i class="feather-check"></i>
                                                                    </button>
                                                                </form>
                                                                <form method="POST" action="{{ route('classes.enrollments.reject', [$class->id, $enrollment->id]) }}" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="avatar-text avatar-md border-0" style="background-color: rgba(234, 84, 85, 0.15); color: #ea5455;" data-bs-toggle="tooltip" title="Tolak">
                                                                        <i class="feather-x"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @elseif($enrollment->status === 'active')
                                                            <form method="POST" action="{{ route('classes.enrollments.reject', [$class->id, $enrollment->id]) }}" class="d-inline reject-enrollment-form" data-student-name="{{ $enrollment->student->name ?? 'siswa ini' }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="avatar-text avatar-md border-0" style="background-color: rgba(234, 84, 85, 0.15); color: #ea5455;" data-bs-toggle="tooltip" title="Keluarkan">
                                                                    <i class="feather-x"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab 2: Daftar Siswa dalam Kelas -->
                            <div class="tab-pane fade" id="activeStudents" role="tabpanel" aria-labelledby="activeStudents-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="activeStudentsList">
                                        <thead>
                                            <tr>
                                                <th>Nama Siswa</th>
                                                <th>Email</th>
                                                <th>Progres</th>
                                                <th>Materi Selesai</th>
                                                <th>Tanggal Bergabung</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($class->activeEnrollments as $enrollment)
                                                <tr>
                                                    <td><a href="{{ route('classes.student.detail', [$class->id, $enrollment->student->id]) }}" class="text-primary fw-semibold text-decoration-none">{{ $enrollment->student->name ?? '-' }}</a></td>
                                                    <td>{{ $enrollment->student->email ?? '-' }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="progress flex-grow-1" style="height: 6px;">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                                            </div>
                                                            <span class="small">{{ $enrollment->progress_percentage }}%</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $enrollment->completed_materials_count ?? 0 }} / {{ $class->materials->count() }}</td>
                                                    <td>{{ $enrollment->updated_at->format('d M Y H:i') }}</td>
                                                    <td class="text-end">
                                                        <form method="POST" action="{{ route('classes.enrollments.reject', [$class->id, $enrollment->id]) }}" class="d-inline reject-enrollment-form" data-student-name="{{ $enrollment->student->name ?? 'siswa ini' }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="avatar-text avatar-md border-0" style="background-color: rgba(234, 84, 85, 0.15); color: #ea5455;" data-bs-toggle="tooltip" title="Keluarkan">
                                                                <i class="feather-x"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4 text-muted">
                                                        <i class="feather-inbox fs-3 d-block mb-2"></i>
                                                        Belum ada siswa aktif di kelas ini
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab 3: Track Siswa yang Mengerjakan Quiz -->
                            <div class="tab-pane fade" id="quizAttempts" role="tabpanel" aria-labelledby="quizAttempts-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="quizAttemptsList">
                                        <thead>
                                            <tr>
                                                <th>Siswa</th>
                                                <th>Quiz</th>
                                                <th class="text-center">Skor</th>
                                                <th class="text-center">Status</th>
                                                <th>Waktu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($classQuizAttempts ?? collect() as $attempt)
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
                                                        Belum ada aktivitas quiz di kelas ini
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab 4: Siswa yang Sudah Menyelesaikan Semua Materi -->
                            <div class="tab-pane fade" id="completedStudents" role="tabpanel" aria-labelledby="completedStudents-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="completedStudentsList">
                                        <thead>
                                            <tr>
                                                <th>Nama Siswa</th>
                                                <th>Email</th>
                                                <th>Total Materi</th>
                                                <th>Selesai</th>
                                                <th>Tanggal Selesai</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($completedStudents ?? collect() as $student)
                                                <tr>
                                                    <td>{{ $student['name'] ?? '-' }}</td>
                                                    <td>{{ $student['email'] ?? '-' }}</td>
                                                    <td>{{ $class->materials->count() }}</td>
                                                    <td>
                                                        <span class="badge bg-soft-success text-success">{{ $student['completed_count'] ?? 0 }}</span>
                                                    </td>
                                                    <td>{{ $student['completed_at'] ?? '-' }}</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Lihat Detail">
                                                            <i class="feather-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4 text-muted">
                                                        <i class="feather-inbox fs-3 d-block mb-2"></i>
                                                        Belum ada siswa yang menyelesaikan semua materi
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Match Materi card height with Detail Kelas card
            function matchHeights() {
                const detailKelasCard = document.getElementById('detailKelasCard');
                const materiCard = document.getElementById('materiCard');
                
                if (detailKelasCard && materiCard) {
                    const detailHeight = detailKelasCard.offsetHeight;
                    materiCard.style.height = detailHeight + 'px';
                }
            }
            
            // Initial height matching
            matchHeights();
            
            // Re-match on window resize
            window.addEventListener('resize', matchHeights);
            
            // Initialize DataTables
            const dataTableConfig = {
                responsive: true,
                autoWidth: false,
                deferRender: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Tidak ada data",
                    zeroRecords: "Data tidak ditemukan"
                }
            };

            // Initialize DataTables for all tabs
            $('#enrollmentList').DataTable({
                ...dataTableConfig,
                order: [[0, 'asc']]
            });

            // Initialize DataTables when tab is shown
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                const targetId = $(e.target).attr('data-bs-target');
                
                if (targetId === '#activeStudents') {
                    if (!$.fn.DataTable.isDataTable('#activeStudentsList')) {
                        $('#activeStudentsList').DataTable({
                            ...dataTableConfig,
                            order: [[0, 'asc']]
                        });
                    }
                } else if (targetId === '#quizAttempts') {
                    if (!$.fn.DataTable.isDataTable('#quizAttemptsList')) {
                        $('#quizAttemptsList').DataTable({
                            ...dataTableConfig,
                            order: [[4, 'desc']]
                        });
                    }
                } else if (targetId === '#completedStudents') {
                    if (!$.fn.DataTable.isDataTable('#completedStudentsList')) {
                        $('#completedStudentsList').DataTable({
                            ...dataTableConfig,
                            order: [[0, 'asc']]
                        });
                    }
                }
            });

            // Handle revoke collaboration confirmation with SweetAlert
            document.querySelectorAll('.revoke-collab-form').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const name = form.dataset.name;

                    Swal.fire({
                        title: 'Batalkan Kolaborasi?',
                        text: 'Yakin ingin membatalkan kolaborasi dengan "' + name + '"?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, batalkan!',
                        cancelButtonText: 'Tidak, kembali',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Handle reject enrollment confirmation with SweetAlert
            document.querySelectorAll('.reject-enrollment-form').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const studentName = form.dataset.studentName;

                    Swal.fire({
                        title: 'Keluarkan Siswa?',
                        text: 'Yakin ingin mengeluarkan "' + studentName + '" dari kelas ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, keluarkan!',
                        cancelButtonText: 'Tidak, kembali',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

        });
    </script>
@endpush
