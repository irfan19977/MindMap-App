@extends('backend.layouts.app')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ __('messages.backend_quiz_management') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('messages.backend_home') }}</a></li>
                        <li class="breadcrumb-item">{{ __('messages.backend_quiz_title') }}</li>
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
                            <a href="{{ route('quizzes.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>{{ __('messages.backend_add_quiz') }}</span>
                            </a>
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
                                    <table class="table table-hover" id="quizzesList">
                                        <thead>
                                            <tr>
                                                <th class="text-center">{{ __('messages.backend_quiz_title_header') }}</th>
                                                <th class="text-center">{{ __('messages.backend_quiz_description') }}</th>
                                                <th class="text-center">{{ __('messages.backend_quiz_time') }}</th>
                                                <th class="text-center">{{ __('messages.backend_quiz_passing_grade') }}</th>
                                                <th class="text-center">{{ __('messages.backend_table_status') }}</th>
                                                <th class="text-end">{{ __('messages.backend_table_actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($quizzes as $quiz)
                                                <tr class="single-item">
                                                    <td>
                                                        <a href="{{ route('quizzes.show', $quiz->id) }}" class="hstack gap-3">
                                                            <div class="avatar-text avatar-md bg-primary">
                                                                <i class="feather-help-circle"></i>
                                                            </div>
                                                            <div>
                                                                <span class="text-truncate-1-line fw-bold">{{ $quiz->title }}</span>
                                                                <small class="text-muted d-block">{{ $quiz->quizQuestions->count() }} {{ __('messages.backend_quiz_questions') }}</small>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="text-truncate-1-line d-block" style="max-width: 300px;">
                                                            {{ Str::limit($quiz->description, 100) ?? '-' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-info">
                                                            <i class="feather-clock"></i> {{ $quiz->time_limit }} {{ __('messages.backend_quiz_minutes') }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge {{ $quiz->passing_score >= 70 ? 'bg-success' : ($quiz->passing_score >= 50 ? 'bg-warning' : 'bg-danger') }}">
                                                            <i class="feather-trophy"></i> {{ $quiz->passing_score }}%
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge {{ $quiz->status == 'publish' ? 'bg-success' : ($quiz->status == 'draft' ? 'bg-warning' : 'bg-danger') }}">
                                                            {{ $quiz->status == 'publish' ? __('messages.backend_status_publish') : ($quiz->status == 'draft' ? __('messages.backend_status_draft') : __('messages.backend_status_inactive')) }}
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
                                                                        <a class="dropdown-item" href="{{ route('quizzes.show', $quiz->id) }}">
                                                                            <i class="feather feather-eye me-3"></i>
                                                                            <span>{{ __('messages.backend_quiz_view_detail') }}</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ route('quizzes.edit', $quiz->id) }}">
                                                                            <i class="feather feather-edit-3 me-3"></i>
                                                                            <span>{{ __('messages.backend_edit') }}</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteQuiz('{{ $quiz->id }}', '{{ $quiz->title }}')">
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
                                                    <td colspan="6" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="feather-inbox fs-24 d-block mb-2"></i>
                                                            {{ __('messages.backend_no_quiz_data') }}
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
    
    <script>
        // Initialize DataTable for quizzes
        $(document).ready(function() {
            $('#quizzesList').DataTable({
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
        
        function deleteQuiz(id, title) {
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
                    form.action = '/quizzes/' + id;
                    
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
