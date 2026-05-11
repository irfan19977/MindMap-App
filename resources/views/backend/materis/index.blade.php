@extends('backend.layouts.app')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Materi</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Materi</li>
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
                            <a href="javascript:void(0);" class="btn btn-icon btn-light-brand" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                <i class="feather-bar-chart"></i>
                            </a>
                            <div class="dropdown">
                                <a class="btn btn-icon btn-light-brand" data-bs-toggle="dropdown" data-bs-offset="0, 10" data-bs-auto-close="outside">
                                    <i class="feather-filter"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-primary rounded-circle d-inline-block me-3"></span>
                                        <span>Draft</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-warning rounded-circle d-inline-block me-3"></span>
                                        <span>Published</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-success rounded-circle d-inline-block me-3"></span>
                                        <span>Archived</span>
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="btn btn-icon btn-light-brand" data-bs-toggle="dropdown" data-bs-offset="0, 10" data-bs-auto-close="outside">
                                    <i class="feather-paperclip"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="bi bi-filetype-pdf me-3"></i>
                                        <span>PDF</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="bi bi-filetype-csv me-3"></i>
                                        <span>CSV</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="bi bi-filetype-xml me-3"></i>
                                        <span>XML</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="bi bi-filetype-txt me-3"></i>
                                        <span>Text</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="bi bi-filetype-exe me-3"></i>
                                        <span>Excel</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="bi bi-printer me-3"></i>
                                        <span>Print</span>
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('materis.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Tambah Materi</span>
                            </a>
                        </div>
                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div id="collapseOne" class="accordion-collapse collapse page-header-collapse">
                <div class="accordion-body pb-2">
                    <div class="row">
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-text avatar-xl rounded">
                                                <i class="feather-book-open"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="d-block">Total Materi</span>
                                                <span class="fs-24 fw-bolder d-block">{{ $materis->count() }}</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-primary text-primary">
                                            <i class="feather-book fs-10 me-1"></i>
                                            <span>100%</span>
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
                                            <div class="avatar-text avatar-xl rounded">
                                                <i class="feather-eye"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="d-block">Total Views</span>
                                                <span class="fs-24 fw-bolder d-block">{{ $materis->sum('view_count') }}</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-success text-success">
                                            <i class="feather-arrow-up fs-10 me-1"></i>
                                            <span>Active</span>
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
                                            <div class="avatar-text avatar-xl rounded">
                                                <i class="feather-star"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="d-block">Featured</span>
                                                <span class="fs-24 fw-bolder d-block">{{ $materis->where('is_featured', true)->count() }}</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-warning text-warning">
                                            <i class="feather-star fs-10 me-1"></i>
                                            <span>Special</span>
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
                                            <div class="avatar-text avatar-xl rounded">
                                                <i class="feather-gift"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="d-block">Gratis</span>
                                                <span class="fs-24 fw-bolder d-block">{{ $materis->where('is_free', true)->count() }}</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-success text-success">
                                            <i class="feather-gift fs-10 me-1"></i>
                                            <span>Free</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="materiList">
                                        <thead>
                                            <tr>
                                                <th class="wd-30 text-center">
                                                    <div class="btn-group mb-1">
                                                        <div class="custom-control custom-checkbox ms-1">
                                                            <input type="checkbox" class="custom-control-input" id="checkAllMateri">
                                                            <label class="custom-control-label" for="checkAllMateri"></label>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th class="text-center">Judul Materi</th>
                                                <th class="text-center">Kategori</th>
                                                <th class="text-center">Tingkat Kesulitan</th>
                                                <th class="text-center">Deskripsi</th>
                                                <th class="text-center">Durasi</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Gratis</th>
                                                <th class="text-center">Views</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($materis as $materi)
                                                <tr class="single-item">
                                                    <td>
                                                        <div class="item-checkbox ms-1">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input checkbox" id="checkBox_{{ $materi->id }}">
                                                                <label class="custom-control-label" for="checkBox_{{ $materi->id }}"></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('materis.edit', $materi->id) }}" class="hstack gap-3">
                                                            @if($materi->thumbnail)
                                                                <div class="avatar-image avatar-md">
                                                                    <img src="{{ $materi->thumbnail_url }}" alt="{{ $materi->title }}" class="img-fluid">
                                                                </div>
                                                            @else
                                                                <div class="avatar-text avatar-md bg-info">
                                                                    <i class="feather-book-open"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <span class="text-truncate-1-line">{{ $materi->title }}</span>
                                                                @if($materi->is_featured)
                                                                    <span class="badge bg-warning text-dark ms-1">Featured</span>
                                                                @endif
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if($materi->category)
                                                            <div>
                                                                <span class="badge bg-soft-primary text-primary">{{ $materi->category->name }}</span>
                                                                @if($materi->parentCategory)
                                                                    <br><small class="text-muted">{{ $materi->parentCategory->name }}</small>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $materi->difficulty_level == 'beginner' ? 'success' : ($materi->difficulty_level == 'intermediate' ? 'warning' : 'danger') }} text-white">
                                                            {{ $materi->formatted_difficulty_level }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-truncate-1-line d-block" style="max-width: 200px;">
                                                            {{ Str::limit($materi->description, 50) ?? '-' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($materi->duration_minutes)
                                                            <span class="badge bg-soft-info text-info">
                                                                {{ $materi->duration_minutes }} menit
                                                            </span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <select class="form-control" data-select2-selector="status" data-materi-id="{{ $materi->id }}">
                                                            <option value="draft" {{ $materi->status == 'draft' ? 'selected' : '' }} data-bg="bg-secondary">Draft</option>
                                                            <option value="published" {{ $materi->status == 'published' ? 'selected' : '' }} data-bg="bg-success">Diterbitkan</option>
                                                            <option value="archived" {{ $materi->status == 'archived' ? 'selected' : '' }} data-bg="bg-warning">Diarsipkan</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        @if($materi->is_free)
                                                            <span class="badge bg-soft-success text-success">Gratis</span>
                                                        @else
                                                            <span class="badge bg-soft-warning text-warning">Berbayar</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-soft-info text-info">
                                                            <i class="feather-eye me-1"></i>
                                                            {{ $materi->view_count }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <div class="dropdown">
                                                                <a href="javascript:void(0)" class="avatar-text avatar-md" data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                                    <i class="feather feather-more-horizontal"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ route('materis.edit', $materi->id) }}">
                                                                            <i class="feather feather-edit-3 me-3"></i>
                                                                            <span>Edit</span>
                                                                        </a>
                                                                    </li>
                                                                    @if($materi->file_path)
                                                                        <li>
                                                                            <a class="dropdown-item" href="{{ $materi->file_url }}" target="_blank">
                                                                                <i class="feather feather-download me-3"></i>
                                                                                <span>Download File</span>
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    @if($materi->video_url)
                                                                        <li>
                                                                            <a class="dropdown-item" href="{{ $materi->video_url }}" target="_blank">
                                                                                <i class="feather feather-video me-3"></i>
                                                                                <span>Lihat Video</span>
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    <li>
                                                                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteMateri('{{ $materi->id }}', '{{ $materi->title }}')">
                                                                            <i class="feather feather-trash-2 me-3"></i>
                                                                            <span>Hapus</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="feather-inbox fs-24 d-block mb-2"></i>
                                                            Belum ada data materi
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
            </div>
            <!-- [ Main Content ] end -->
        </div>
@endsection

@push('scripts')
    @include('backend.layouts.scriptcustom')
    <script>
        // Initialize DataTable for materis
        $(document).ready(function() {
            $('#materiList').DataTable({
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
                order: [[1, 'asc']] // Sort by Judul Materi column by default
            });
        });
        
        function deleteMateri(id, title) {
            if (confirm('Apakah Anda yakin ingin menghapus materi "' + title + '"?')) {
                fetch('{{ route('materis.index') }}/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus data.');
                });
            }
        }
        
        // Handle status change
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelects = document.querySelectorAll('select[data-select2-selector="status"]');
            
            statusSelects.forEach(function(select) {
                select.addEventListener('change', function() {
                    const materiId = this.dataset.materiId;
                    const newStatus = this.value;
                    
                    fetch('{{ route('materis.updateStatus', ':id') }}'.replace(':id', materiId), {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            const toast = document.createElement('div');
                            toast.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
                            toast.style.zIndex = '9999';
                            toast.innerHTML = `
                                <i class="feather-check-circle me-2"></i>
                                ${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            `;
                            document.body.appendChild(toast);
                            
                            setTimeout(() => {
                                toast.remove();
                            }, 3000);
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memperbarui status.');
                    });
                });
            });
        });
    </script>
@endpush
