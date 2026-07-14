@extends('backend.layouts.app')

@section('content')
<div class="nxl-content">
    <!-- [ page-header ] start -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Kolaborasi Kelas</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
                <li class="breadcrumb-item active">Kolaborasi</li>
            </ul>
        </div>
        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
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
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="feather-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="feather-alert-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Class Info -->
            <div class="col-xl-4">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $courseClass->cover_image_url }}" alt="{{ $courseClass->name }}" class="avatar-text avatar-xl rounded" style="object-fit: cover;">
                            <div>
                                <h6 class="mb-1">{{ $courseClass->name }}</h6>
                                <small class="text-muted">{{ $courseClass->slug }}</small>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span>Kategori</span>
                                <span class="badge bg-soft-primary text-primary">{{ $courseClass->category->name ?? '-' }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span>Jenjang</span>
                                <span class="badge bg-soft-info text-info">{{ $courseClass->subcategory->formatted_grade_level ?? '-' }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span>Guru</span>
                                <span class="fw-semibold">{{ $courseClass->teacher->name ?? '-' }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span>Status</span>
                                <span class="badge bg-soft-{{ $courseClass->status === 'publish' ? 'success' : ($courseClass->status === 'draft' ? 'secondary' : 'warning') }} text-{{ $courseClass->status === 'publish' ? 'success' : ($courseClass->status === 'draft' ? 'secondary' : 'warning') }}">
                                    {{ $courseClass->formatted_status }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Invite Form -->
            <div class="col-xl-8">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="feather-user-plus me-2"></i>Undang Guru Kolaborasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('collaborations.quickInvite') }}" id="collaborationForm">
                            @csrf
                            <input type="hidden" name="class_id" value="{{ $courseClass->id }}">

                            <div class="mb-3">
                                <label for="teacher_id" class="form-label">Pilih Guru <span class="text-danger">*</span></label>
                                <select class="form-control" id="teacher_id" name="teacher_id" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->user->name ?? $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan (Opsional)</label>
                                <textarea class="form-control" id="message" name="message" rows="3" placeholder="Tambahkan pesan untuk guru..."></textarea>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather-send me-2"></i>Kirim Undangan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Collaboration List -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="feather-users me-2"></i>Daftar Kolaborasi
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover" id="collaborationList">
                                <thead>
                                    <tr>
                                        <th>Guru</th>
                                        <th>Status</th>
                                        <th>Tanggal Undangan</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($collaborations as $collaboration)
                                        <tr>
                                            <td>
                                                <span class="fw-semibold">{{ $collaboration->teacher->user->name ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-soft-{{ $collaboration->status === 'accepted' ? 'success' : ($collaboration->status === 'pending' ? 'warning' : ($collaboration->status === 'rejected' ? 'danger' : 'secondary')) }} text-{{ $collaboration->status === 'accepted' ? 'success' : ($collaboration->status === 'pending' ? 'warning' : ($collaboration->status === 'rejected' ? 'danger' : 'secondary')) }}">
                                                    {{ $collaboration->formatted_status ?? ucfirst($collaboration->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $collaboration->invited_at ? \Carbon\Carbon::parse($collaboration->invited_at)->format('d M Y H:i') : '-' }}</td>
                                            <td class="text-end">
                                                @if($collaboration->status === 'pending' || $collaboration->status === 'accepted')
                                                    <form method="POST" action="{{ route('collaborations.revoke', $collaboration->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan kolaborasi ini?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="feather-x me-1"></i> Batalkan
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                <i class="feather-users fs-24 d-block mb-2"></i>
                                                Belum ada kolaborasi untuk kelas ini
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
    <script src="{{ asset('backend/assets/vendors/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/dataTables.bs5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/theme-customizer-init.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#collaborationList').DataTable({
                responsive: true,
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
                },
                order: [[2, 'desc']]
            });

        });
    </script>
@endpush
