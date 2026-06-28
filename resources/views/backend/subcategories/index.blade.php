@extends('backend.layouts.app')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Sub Kategori</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Sub Kategori</li>
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
                            <a href="{{ route('subcategories.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Tambah Sub Kategori</span>
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
            <!-- [ page-header ] end --> 
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="subcategoriesList">
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
                                                <th class="text-center">Nama Sub Kategori</th>
                                                <th class="text-center">Kategori Utama</th>
                                                <th class="text-center">Jenjang</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($subcategories as $subcategory)
                                                <tr class="single-item">
                                                    <td>
                                                        <div class="item-checkbox ms-1">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input checkbox" id="checkBox_{{ $subcategory->id }}">
                                                                <label class="custom-control-label" for="checkBox_{{ $subcategory->id }}"></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('subcategories.edit', $subcategory->id) }}" class="hstack gap-3">
                                                            @if($subcategory->cover_image)
                                                                <div class="avatar-image avatar-md">
                                                                    <img src="{{ $subcategory->cover_image_url }}" alt="{{ $subcategory->name }}" class="img-fluid">
                                                                </div>
                                                            @else
                                                                <div class="avatar-text avatar-md bg-primary">
                                                                    <i class="feather-layers"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <span class="text-truncate-1-line">{{ $subcategory->name }}</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-soft-primary text-primary">{{ $subcategory->category->name ?? '-' }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-soft-info text-info">{{ $subcategory->formatted_grade_level }}</span>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" data-select2-selector="status" data-subcategory-id="{{ $subcategory->id }}">
                                                            <option value="publish" {{ $subcategory->status == 'publish' ? 'selected' : '' }} data-bg="bg-success">Publish</option>
                                                            <option value="draft" {{ $subcategory->status == 'draft' ? 'selected' : '' }} data-bg="bg-warning">Draft</option>
                                                            <option value="inactive" {{ $subcategory->status == 'inactive' ? 'selected' : '' }} data-bg="bg-danger">Tidak Aktif</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <div class="dropdown">
                                                                <a href="javascript:void(0)" class="avatar-text avatar-md" data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                                    <i class="feather feather-more-horizontal"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ route('subcategories.edit', $subcategory->id) }}">
                                                                            <i class="feather feather-edit-3 me-3"></i>
                                                                            <span>Edit</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteSubcategory('{{ $subcategory->id }}', '{{ $subcategory->name }}')">
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
                                                    <td colspan="6" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="feather-inbox fs-24 d-block mb-2"></i>
                                                            Belum ada data sub kategori
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
    <script src="{{ asset('backend/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/select2-active.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/dataTables.bs5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/theme-customizer-init.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-cancel {
            background-color: #d33 !important;
        }
    </style>

    <script>
        // Initialize DataTable for subcategories
        $(document).ready(function() {
            $('#subcategoriesList').DataTable({
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
                order: [] // Use backend ordering (created_at desc)
            });
        });
        
        function deleteSubcategory(id, name) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda tidak akan dapat mengembalikan data ini!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/subcategories/' + id;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);
                    
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
        
        // Handle status change
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelects = document.querySelectorAll('select[data-select2-selector="status"]');
            
            statusSelects.forEach(function(select) {
                select.addEventListener('change', function() {
                    const subcategoryId = this.dataset.subcategoryId;
                    const newStatus = this.value;
                    
                    console.log('Update status for subcategory ' + subcategoryId + ' to ' + newStatus);
                });
            });
        });
    </script>
@endpush
