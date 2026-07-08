@extends('backend.layouts.app')

@section('title', 'Laporan MindMap')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Laporan MindMap</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item">MindMap</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <a href="{{ route('reports.export', 'mindmaps') }}" class="btn btn-primary">
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
                                        <i class="feather-git-branch fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $stats['total'] }}</div>
                                        <div class="fs-12 text-muted">Total MindMap</div>
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
                                        <i class="feather-check-circle fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $stats['publish'] }}</div>
                                        <div class="fs-12 text-muted">Dipublikasikan</div>
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
                                        <i class="feather-edit fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $stats['draft'] }}</div>
                                        <div class="fs-12 text-muted">Draft</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-text avatar-lg bg-soft-danger text-danger rounded">
                                        <i class="feather-x-circle fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $stats['inactive'] }}</div>
                                        <div class="fs-12 text-muted">Tidak Aktif</div>
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
                        <form method="GET" action="{{ route('reports.mindmaps') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Pencarian</label>
                                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Judul mindmap">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">Semua</option>
                                        <option value="publish" {{ request('status') == 'publish' ? 'selected' : '' }}>Dipublikasikan</option>
                                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
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
                                    <a href="{{ route('reports.mindmaps') }}" class="btn btn-light w-100">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel -->
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Daftar MindMap</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover" id="mindmapsReportTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Judul</th>
                                        <th class="text-center">Referensi</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Pembuat</th>
                                        <th class="text-center">Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($mindmaps as $index => $mindmap)
                                        <tr class="single-item">
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <span class="fw-semibold text-truncate-1-line d-block" style="max-width:250px;">{{ $mindmap->title }}</span>
                                            </td>
                                            <td>
                                                @if($mindmap->category)
                                                    <span class="badge bg-soft-primary text-primary">Kategori: {{ $mindmap->category->name }}</span>
                                                @elseif($mindmap->subcategory)
                                                    <span class="badge bg-soft-info text-info">Sub: {{ $mindmap->subcategory->name }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($mindmap->status == 'publish')
                                                    <span class="badge bg-soft-success text-success">Dipublikasikan</span>
                                                @elseif($mindmap->status == 'draft')
                                                    <span class="badge bg-soft-warning text-warning">Draft</span>
                                                @else
                                                    <span class="badge bg-soft-danger text-danger">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>{{ $mindmap->creator?->name ?? '-' }}</td>
                                            <td>
                                                <span class="fs-12 text-muted">{{ $mindmap->created_at->format('d M Y') }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="feather-inbox fs-24 d-block mb-2"></i>
                                                    Tidak ada data mindmap
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
            $('#mindmapsReportTable').DataTable({
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
