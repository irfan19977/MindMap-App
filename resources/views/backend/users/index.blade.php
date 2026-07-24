@extends('backend.layouts.app')

@section('content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ __('messages.backend_users') }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('messages.backend_home') }}</a></li>
                    <li class="breadcrumb-item">{{ __('messages.backend_users') }}</li>
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
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>{{ __('messages.backend_add_user') }}</span>
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
                                <table class="table table-hover" id="usersList">
                                    <thead>
                                        <tr>
                                            <th class="text-center">{{ __('messages.backend_table_no') }}</th>
                                            <th class="text-center">{{ __('messages.backend_table_name') }}</th>
                                            <th class="text-center">{{ __('messages.backend_table_email') }}</th>
                                            <th class="text-center">{{ __('messages.backend_table_user_type') }}</th>
                                            <th class="text-center">{{ __('messages.backend_table_status') }}</th>
                                            <th class="text-end">{{ __('messages.backend_table_actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $index => $user)
                                            <tr class="single-item">
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar-text avatar-md bg-primary rounded">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <span class="fw-bold d-block">{{ $user->name }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>{{ $user->email }}</span>
                                                </td>
                                                <td class="text-center">
                                                    @if($user->user_type === 'admin')
                                                        <span class="badge bg-soft-danger text-danger">{{ __('messages.backend_admin') }}</span>
                                                    @elseif($user->user_type === 'teacher')
                                                        <span class="badge bg-soft-primary text-primary">{{ __('messages.backend_teacher') }}</span>
                                                    @else
                                                        <span class="badge bg-soft-success text-success">{{ __('messages.backend_student') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($user->is_active)
                                                        <span class="badge bg-soft-success text-success">
                                                            <i class="feather-check-circle me-1"></i>{{ __('messages.backend_active') }}
                                                        </span>
                                                    @elseif($user->user_type === 'teacher' && $user->teacher_verification_status === 'rejected')
                                                        <span class="badge bg-soft-danger text-danger">
                                                            <i class="feather-x-circle me-1"></i>Ditolak
                                                        </span>
                                                    @elseif($user->user_type === 'teacher')
                                                        <span class="badge bg-soft-warning text-warning">
                                                            <i class="feather-clock me-1"></i>Menunggu Verifikasi
                                                        </span>
                                                    @else
                                                        <span class="badge bg-soft-secondary text-secondary">
                                                            <i class="feather-x-circle me-1"></i>{{ __('messages.backend_inactive') }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <div class="dropdown">
                                                            <a href="javascript:void(0)" class="avatar-text avatar-md" data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                                <i class="feather feather-more-horizontal"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                @if(auth()->user()->hasRole('admin') && $user->user_type === 'teacher' && ! $user->is_active && $user->teacher_verification_status !== 'rejected')
                                                                    <li>
                                                                        <form method="POST" action="{{ route('users.approve-teacher', $user) }}" class="teacher-verification-form" data-action="approve" data-name="{{ $user->name }}">
                                                                            @csrf
                                                                            <button type="submit" class="dropdown-item text-success">
                                                                                <i class="feather feather-check me-3"></i>
                                                                                <span>Approve</span>
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                    <li>
                                                                        <form method="POST" action="{{ route('users.reject-teacher', $user) }}" class="teacher-verification-form" data-action="reject" data-name="{{ $user->name }}">
                                                                            @csrf
                                                                            <button type="submit" class="dropdown-item text-danger">
                                                                                <i class="feather feather-x me-3"></i>
                                                                                <span>Reject</span>
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                    <li><hr class="dropdown-divider"></li>
                                                                @endif
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">
                                                                        <i class="feather feather-edit-3 me-3"></i>
                                                                        <span>{{ __('messages.backend_edit') }}</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="deleteUser('{{ $user->id }}', '{{ $user->name }}')">
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
            $('#usersList').DataTable({
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
        
        document.querySelectorAll('.teacher-verification-form').forEach((form) => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const isApprove = this.dataset.action === 'approve';
                const name = this.dataset.name;

                Swal.fire({
                    title: isApprove ? 'Setujui pengajar?' : 'Tolak pengajar?',
                    text: isApprove ? `Aktifkan akses mengajar untuk ${name}?` : `Tolak pendaftaran pengajar untuk ${name}?`,
                    icon: isApprove ? 'question' : 'warning',
                    showCancelButton: true,
                    confirmButtonColor: isApprove ? '#198754' : '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: isApprove ? 'Ya, approve' : 'Ya, reject',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        function deleteUser(id, name) {
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
                    form.action = '/users/' + id;
                    
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
