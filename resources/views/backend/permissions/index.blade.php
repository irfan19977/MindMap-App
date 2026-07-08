@extends('backend.layouts.app')

@section('content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ __('messages.backend_permissions_title') }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('messages.backend_home') }}</a></li>
                    <li class="breadcrumb-item">{{ __('messages.backend_permissions_title') }}</li>
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
                        <a href="{{ route('permissions.create') }}" class="btn btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>{{ __('messages.backend_add_permission') }}</span>
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
                                <table class="table table-hover" id="permissionsList">
                                    <thead>
                                        <tr>
                                            <th class="text-center">{{ __('messages.backend_table_no') }}</th>
                                            <th class="text-center">{{ __('messages.backend_permission_name') }}</th>
                                            <th class="text-center">{{ __('messages.backend_role_guard') }}</th>
                                            <th class="text-center">{{ __('messages.backend_permission_roles') }}</th>
                                            <th class="text-end">{{ __('messages.backend_table_actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($permissions as $index => $permission)
                                            <tr class="single-item">
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    <span class="fw-bold">{{ $permission->name }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-soft-primary text-primary">{{ $permission->guard_name }}</span>
                                                </td>
                                                <td>
                                                    @if($permission->roles->count() > 0)
                                                        <div class="d-flex flex-wrap gap-1">
                                                            @foreach($permission->roles->take(3) as $role)
                                                                <span class="badge bg-soft-info text-info">{{ $role->name }}</span>
                                                            @endforeach
                                                            @if($permission->roles->count() > 3)
                                                                <span class="badge bg-soft-secondary text-secondary">+{{ $permission->roles->count() - 3 }}</span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
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
                                                                    <a class="dropdown-item" href="{{ route('permissions.edit', $permission->id) }}">
                                                                        <i class="feather feather-edit-3 me-3"></i>
                                                                        <span>{{ __('messages.backend_edit') }}</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="deletePermission('{{ $permission->id }}', '{{ $permission->name }}')">
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
                                                <td colspan="5" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="feather-inbox fs-24 d-block mb-2"></i>
                                                        {{ __('messages.backend_no_permission_data') }}
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
        $(document).ready(function() {
            $('#permissionsList').DataTable({
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
                order: []
            });
        });
        
        function deletePermission(id, name) {
            Swal.fire({
                title: '{{ __('messages.backend_sweetalert_confirm_title') }}',
                text: '{{ __('messages.backend_sweetalert_confirm_text') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __('messages.backend_sweetalert_confirm_button') }}',
                cancelButtonText: '{{ __('messages.backend_sweetalert_cancel_button') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/permissions/' + id;
                    
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
    </script>
@endpush
