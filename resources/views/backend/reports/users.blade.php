@extends('backend.layouts.app')

@section('title', 'Laporan User')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Laporan User</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item">User</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <a href="{{ route('reports.export', 'users') }}" class="btn btn-primary">
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
                                        <i class="feather-users fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $stats['total'] }}</div>
                                        <div class="fs-12 text-muted">Total User</div>
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
                                        <i class="feather-user-check fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $stats['active'] }}</div>
                                        <div class="fs-12 text-muted">Aktif (7 hari)</div>
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
                                        <i class="feather-user-plus fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $stats['new_this_month'] }}</div>
                                        <div class="fs-12 text-muted">Baru Bulan Ini</div>
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
                                        <i class="feather-shield fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $roles->count() }}</div>
                                        <div class="fs-12 text-muted">Total Role</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Filter</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.users') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Pencarian</label>
                                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Nama atau email">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Role</label>
                                    <select name="role" class="form-select">
                                        <option value="">Semua</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Dari Tanggal</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Sampai Tanggal</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-3 d-flex align-items-end gap-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="feather-filter me-2"></i>Filter
                                    </button>
                                    <a href="{{ route('reports.users') }}" class="btn btn-light w-100">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel -->
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Daftar User</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover" id="usersReportTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Login Terakhir</th>
                                        <th class="text-center">Terdaftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $index => $user)
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
                                                @foreach($user->roles as $role)
                                                    <span class="badge bg-soft-info text-info mb-1">{{ ucfirst($role->name) }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($user->last_login_at)
                                                    <span class="fs-12 text-muted">{{ $user->last_login_at->diffForHumans() }}</span>
                                                @else
                                                    <span class="fs-12 text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fs-12 text-muted">{{ $user->created_at->format('d M Y') }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="feather-inbox fs-24 d-block mb-2"></i>
                                                    Tidak ada data user
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
            <!-- [ Main Content ] end -->
        </div>
@endsection

@push('scripts')
    @include('backend.layouts.scriptcustom')
    <script>
        $(document).ready(function() {
            $('#usersReportTable').DataTable({
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
