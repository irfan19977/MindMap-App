@extends('backend.layouts.app')

@section('content')
<div class="nxl-content">
    <!-- [ page-header ] start -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Undangan Kolaborasi</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Kolaborasi Saya</li>
            </ul>
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

        <!-- Pending Invitations -->
        @php
            $pending = $collaborations->where('status', 'pending');
            $accepted = $collaborations->where('status', 'accepted');
            $others = $collaborations->whereNotIn('status', ['pending', 'accepted']);
        @endphp

        <!-- All Collaborations -->
        <div class="row">
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="feather-users me-2"></i>Semua Kolaborasi
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover" id="collaborationList">
                                <thead>
                                    <tr>
                                        <th>Dari</th>
                                        <th>Tipe</th>
                                        <th>Target</th>
                                        <th>Permissions</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($collaborations as $collaboration)
                                        <tr>
                                            <td>
                                                <span class="fw-semibold">{{ $collaboration->admin->name ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-soft-info text-info">{{ ucfirst($collaboration->collaboration_type) }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold">{{ $collaboration->target_name }}</span>
                                            </td>
                                            <td>
                                                @if($collaboration->permissions)
                                                    @foreach($collaboration->permissions as $perm)
                                                        <span class="badge bg-soft-primary text-primary me-1 mb-1">{{ ucfirst($perm) }}</span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-soft-{{ $collaboration->status === 'accepted' ? 'success' : ($collaboration->status === 'pending' ? 'warning' : ($collaboration->status === 'rejected' ? 'danger' : 'secondary')) }} text-{{ $collaboration->status === 'accepted' ? 'success' : ($collaboration->status === 'pending' ? 'warning' : ($collaboration->status === 'rejected' ? 'danger' : 'secondary')) }}">
                                                    {{ $collaboration->formatted_status }}
                                                </span>
                                            </td>
                                            <td>{{ $collaboration->invited_at ? $collaboration->invited_at->format('d M Y H:i') : '-' }}</td>
                                            <td class="text-end">
                                                @if($collaboration->status === 'pending')
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <form method="POST" action="{{ route('collaborations.my.accept', $collaboration->id) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="avatar-text avatar-md border-0" style="background-color: rgba(40, 199, 111, 0.15); color: #28c76f;" data-bs-toggle="tooltip" title="Terima">
                                                                <i class="feather-check"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('collaborations.my.reject', $collaboration->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menolak undangan ini?')">
                                                            @csrf
                                                            <button type="submit" class="avatar-text avatar-md border-0" style="background-color: rgba(234, 84, 85, 0.15); color: #ea5455;" data-bs-toggle="tooltip" title="Tolak">
                                                                <i class="feather-x"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @elseif($collaboration->status === 'accepted')
                                                    <span class="text-success"><i class="feather-check-circle"></i> Aktif</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
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
                order: [[5, 'desc']]
            });
        });
    </script>
@endpush
