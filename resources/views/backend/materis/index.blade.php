@extends('backend.layouts.app')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ __('messages.backend_materi_title') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">{{ __('messages.backend_home') }}</a></li>
                        <li class="breadcrumb-item">{{ __('messages.backend_materi_title') }}</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                <i class="feather-arrow-left me-2"></i>
                                <span>{{ __('messages.backend_back') }}</span>
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
                                        <span>{{ __('messages.backend_draft') }}</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-warning rounded-circle d-inline-block me-3"></span>
                                        <span>{{ __('messages.backend_published') }}</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="wd-7 ht-7 bg-success rounded-circle d-inline-block me-3"></span>
                                        <span>{{ __('messages.backend_archived') }}</span>
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
                                        <span>{{ __('messages.backend_dropdown_print') }}</span>
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('materis.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>{{ __('messages.backend_add_materi') }}</span>
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
                                                <span class="d-block">{{ __('messages.backend_total_materi') }}</span>
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
                                                <i class="feather-check-circle"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="d-block">{{ __('messages.backend_published') }}</span>
                                                <span class="fs-24 fw-bolder d-block">{{ $materis->where('status', 'publish')->count() }}</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-success text-success">
                                            <i class="feather-check-circle fs-10 me-1"></i>
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
                                                <i class="feather-file-text"></i>
                                            </div>
                                            <a href="javascript:void(0);" class="fw-bold d-block">
                                                <span class="d-block">{{ __('messages.backend_draft') }}</span>
                                                <span class="fs-24 fw-bolder d-block">{{ $materis->where('status', 'draft')->count() }}</span>
                                            </a>
                                        </div>
                                        <div class="badge bg-soft-secondary text-secondary">
                                            <i class="feather-file-text fs-10 me-1"></i>
                                            <span>Draft</span>
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
                                                <span class="d-block">{{ __('messages.backend_free') }}</span>
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
                                                <th class="text-center">{{ __('messages.backend_materi_title_header') }}</th>
                                                <th class="text-center">{{ __('messages.backend_subcategory') }}</th>
                                                <th class="text-center">{{ __('messages.backend_materi_description') }}</th>
                                                <th class="text-center">{{ __('messages.backend_materi_status') }}</th>
                                                <th class="text-center">{{ __('messages.backend_materi_free') }}</th>
                                                <th class="text-end">{{ __('messages.backend_table_actions') }}</th>
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
                                                            <div>
                                                                <span class="text-truncate-1-line">{{ $materi->title }}</span>
                                                            </div>

                                                    </td>
                                                    <td>
                                                        @if($materi->subcategory)
                                                            <div>
                                                                <span class="badge bg-soft-primary text-primary">{{ $materi->subcategory->name }}</span>
                                                                @if($materi->subcategory->category)
                                                                    <br><small class="text-muted">{{ $materi->subcategory->category->name }}</small>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="text-truncate-1-line d-block" style="max-width: 200px;">
                                                            {{ Str::limit($materi->description, 50) ?? '-' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" data-select2-selector="status" data-materi-id="{{ $materi->id }}">
                                                            <option value="draft" {{ $materi->status == 'draft' ? 'selected' : '' }} data-bg="bg-secondary">{{ __('messages.backend_draft') }}</option>
                                                            <option value="publish" {{ $materi->status == 'publish' ? 'selected' : '' }} data-bg="bg-success">{{ __('messages.backend_published') }}</option>
                                                            <option value="inactive" {{ $materi->status == 'inactive' ? 'selected' : '' }} data-bg="bg-warning">{{ __('messages.backend_status_inactive') }}</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        @if($materi->is_free)
                                                            <span class="badge bg-soft-success text-success">{{ __('messages.backend_free') }}</span>
                                                        @else
                                                            <span class="badge bg-soft-warning text-warning">{{ __('messages.backend_paid') }}</span>
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
                                                                        <a class="dropdown-item" href="{{ route('materis.edit', $materi->id) }}">
                                                                            <i class="feather feather-edit-3 me-3"></i>
                                                                            <span>{{ __('messages.backend_edit') }}</span>
                                                                        </a>
                                                                    </li>
                                                                    @if($materi->file_path)
                                                                        <li>
                                                                            <a class="dropdown-item" href="{{ $materi->file_url }}" target="_blank">
                                                                                <i class="feather feather-download me-3"></i>
                                                                                <span>{{ __('messages.backend_download_file') }}</span>
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    @if($materi->video_url)
                                                                        <li>
                                                                            <a class="dropdown-item" href="{{ $materi->video_url }}" target="_blank">
                                                                                <i class="feather feather-video me-3"></i>
                                                                                <span>{{ __('messages.backend_view_video') }}</span>
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    <li>
                                                                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteMateri('{{ $materi->id }}', '{{ $materi->title }}')">
                                                                            <i class="feather feather-trash-2 me-3"></i>
                                                                            <span>{{ __('messages.backend_delete') }}</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center py-4">
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
        // Initialize DataTable for materis
        $(document).ready(function() {
            $('#materiList').DataTable({
                responsive: true,
                language: {
                    search: "{{ __('messages.backend_datatable_search') }}",
                    lengthMenu: "{{ __('messages.backend_datatable_length_menu') }}",
                    info: "{{ __('messages.backend_datatable_info') }}",
                    paginate: {
                        first: "{{ __('messages.backend_first') }}",
                        last: "{{ __('messages.backend_last') }}",
                        next: "{{ __('messages.backend_next') }}",
                        previous: "{{ __('messages.backend_previous') }}"
                    },
                    emptyTable: "{{ __('messages.backend_datatable_empty_table') }}",
                    zeroRecords: "{{ __('messages.backend_datatable_zero_records') }}"
                },
                order: [[1, 'asc']] // Sort by Judul Materi column by default
            });
        });
        
        function deleteMateri(id, title) {
            if (confirm('{{ __('messages.backend_sweetalert_confirm_text') }} ' + title + '?')) {
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
                    alert('{{ __('messages.backend_error_occurred') }}');
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
                        alert('{{ __('messages.backend_error_update_status') }}');
                    });
                });
            });
        });
    </script>
@endpush
