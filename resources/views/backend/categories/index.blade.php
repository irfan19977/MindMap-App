@extends('backend.layouts.app')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Kelas</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Kelas</li>
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
                                        <span>New</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-warning rounded-circle d-inline-block me-3"></span>
                                        <span>Working</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-success rounded-circle d-inline-block me-3"></span>
                                        <span>Qualified</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-danger rounded-circle d-inline-block me-3"></span>
                                        <span>Declined</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-teal rounded-circle d-inline-block me-3"></span>
                                        <span>Customer</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-indigo rounded-circle d-inline-block me-3"></span>
                                        <span>Contacted</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-warning rounded-circle d-inline-block me-3"></span>
                                        <span>Pending</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-success rounded-circle d-inline-block me-3"></span>
                                        <span>Approved</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-teal rounded-circle d-inline-block me-3"></span>
                                        <span>In Progress</span>
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
                            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Tambah Kelas</span>
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
                                                <i class="feather-users"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="d-block">Total Leads</span>
                                                <span class="fs-24 fw-bolder d-block">26,595</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-success text-success">
                                            <i class="feather-arrow-up fs-10 me-1"></i>
                                            <span>36.85%</span>
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
                                                <i class="feather-user-check"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="d-block">Active Leads</span>
                                                <span class="fs-24 fw-bolder d-block">2,245</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-danger text-danger">
                                            <i class="feather-arrow-down fs-10 me-1"></i>
                                            <span>24.56%</span>
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
                                                <i class="feather-user-plus"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="d-block">New Leads</span>
                                                <span class="fs-24 fw-bolder d-block">1,254</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-success text-success">
                                            <i class="feather-arrow-up fs-10 me-1"></i>
                                            <span>33.29%</span>
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
                                                <i class="feather-user-minus"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="d-block">Inactive Leads</span>
                                                <span class="fs-24 fw-bolder d-block">4,586</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-danger text-danger">
                                            <i class="feather-arrow-down fs-10 me-1"></i>
                                            <span>42.47%</span>
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
                                    <table class="table table-hover" id="categoriesList">
                                        <thead>
                                            <tr>
                                                <th class="wd-30 text-center">
                                                    <div class="btn-group mb-1">
                                                        <div class="custom-control custom-checkbox ms-1">
                                                            <input type="checkbox" class="custom-control-input" id="checkAllLead">
                                                            <label class="custom-control-label" for="checkAllLead"></label>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th class="text-center">Nama Kelas</th>
                                                <th class="text-center">Level</th>
                                                <th class="text-center">Kategory</th>
                                                <th class="text-center">Deskripsi</th>
                                                <th class="text-center">Kurikulum</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Gratis</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($categories as $category)
                                                <tr class="single-item">
                                                    <td>
                                                        <div class="item-checkbox ms-1">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input checkbox" id="checkBox_{{ $category->id }}">
                                                                <label class="custom-control-label" for="checkBox_{{ $category->id }}"></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('categories.edit', $category->id) }}" class="hstack gap-3">
                                                            @if($category->cover_image)
                                                                <div class="avatar-image avatar-md">
                                                                    <img src="{{ $category->cover_image_url }}" alt="{{ $category->name }}" class="img-fluid">
                                                                </div>
                                                            @else
                                                                <div class="avatar-text avatar-md bg-primary">
                                                                    <i class="feather-book"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <span class="text-truncate-1-line">{{ $category->name }}</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-soft-primary text-primary">{{ $category->formatted_grade_level }}</span>
                                                    </td>
                                                    <td>
                                                        @if($category->parent)
                                                            <a href="javascript:void(0);" class="text-muted">{{ $category->parent->name }}</a>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="text-truncate-1-line d-block" style="max-width: 200px;">
                                                            {{ Str::limit($category->description, 50) ?? '-' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="text-truncate-2-line" style="max-width: 150px; max-height: 40px; overflow: hidden;">
                                                            @if($category->curriculum)
                                                                {!! Str::limit(strip_tags($category->curriculum), 50) !!}
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" data-select2-selector="status" data-category-id="{{ $category->id }}">
                                                            <option value="active" {{ $category->status == 'active' ? 'selected' : '' }} data-bg="bg-success">Aktif</option>
                                                            <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }} data-bg="bg-danger">Tidak Aktif</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        @if($category->is_free)
                                                            <span class="badge bg-soft-success text-success">Gratis</span>
                                                        @else
                                                            <span class="badge bg-soft-warning text-warning">Berbayar</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <div class="dropdown">
                                                                <a href="javascript:void(0)" class="avatar-text avatar-md" data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                                    <i class="feather feather-more-horizontal"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ route('categories.edit', $category->id) }}">
                                                                            <i class="feather feather-edit-3 me-3"></i>
                                                                            <span>Edit</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteCategory('{{ $category->id }}', '{{ $category->name }}')">
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
                                                    <td colspan="9" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="feather-inbox fs-24 d-block mb-2"></i>
                                                            Belum ada data kelas
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
        // Initialize DataTable for categories
        $(document).ready(function() {
            $('#categoriesList').DataTable({
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
                order: [[1, 'asc']] // Sort by Nama Kelas column by default
            });
        });
        
        function deleteCategory(id, name) {
            if (confirm('Apakah Anda yakin ingin menghapus kelas "' + name + '"?')) {
                // You can implement the actual delete functionality here
                // For now, just show an alert
                alert('Delete functionality will be implemented in the controller.');
                
                // Uncomment below when you implement the destroy method in controller
                // fetch('/categories/' + id, {
                //     method: 'DELETE',
                //     headers: {
                //         'X-CSRF-TOKEN': '{{ csrf_token() }}',
                //         'Content-Type': 'application/json',
                //     },
                // })
                // .then(response => response.json())
                // .then(data => {
                //     if (data.success) {
                //         location.reload();
                //     } else {
                //         alert('Error: ' + data.message);
                //     }
                // })
                // .catch(error => {
                //     console.error('Error:', error);
                //     alert('Terjadi kesalahan saat menghapus data.');
                // });
            }
        }
        
        // Handle status change
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelects = document.querySelectorAll('select[data-select2-selector="status"]');
            
            statusSelects.forEach(function(select) {
                select.addEventListener('change', function() {
                    const categoryId = this.dataset.categoryId;
                    const newStatus = this.value;
                    
                    // You can implement AJAX status update here
                    console.log('Update status for category ' + categoryId + ' to ' + newStatus);
                });
            });
        });
    </script>
@endpush