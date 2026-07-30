@extends('backend.layouts.app')

@section('content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ isset($role) ? __('messages.backend_edit_role') : __('messages.backend_add_role_form') }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('messages.backend_home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('messages.backend_roles_title') }}</a></li>
                    <li class="breadcrumb-item active">{{ isset($role) ? __('messages.backend_edit') : __('messages.backend_add') }}</li>
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
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>{{ __('messages.backend_back') }}</span>
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
                        <div class="card-header">
                            <h5 class="card-title">{{ isset($role) ? __('messages.backend_edit_role') : __('messages.backend_add_role_new') }}</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}">
                                @csrf
                                @if(isset($role))
                                    @method('PUT')
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">{{ __('messages.backend_role_name_label') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name"
                                                   value="{{ old('name') ?? $role->name ?? '' }}"
                                                   placeholder="{{ __('messages.backend_role_name_placeholder') }}">
                                            @error('name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="guard_name" class="form-label">{{ __('messages.backend_guard_name_label') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('guard_name') is-invalid @enderror" 
                                                    id="guard_name" name="guard_name">
                                                <option value="web" {{ (old('guard_name') ?? ($role->guard_name ?? '')) == 'web' ? 'selected' : '' }}>
                                                    Web
                                                </option>
                                                <option value="api" {{ (old('guard_name') ?? ($role->guard_name ?? '')) == 'api' ? 'selected' : '' }}>
                                                    API
                                                </option>
                                            </select>
                                            @error('guard_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('messages.backend_role_permissions') }}</label>
                                            <div class="card">
                                                <div class="card-body p-3">
                                                    @foreach($menus as $menu)
                                                        @php
                                                            $categoryPermissions = $groupedPermissions[$menu->name] ?? collect();
                                                        @endphp
                                                        @if($categoryPermissions->count() > 0)
                                                        <div class="mb-4">
                                                            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                                                <div class="form-check form-switch me-3">
                                                                    <input class="form-check-input category-toggle" 
                                                                           type="checkbox" 
                                                                           id="category_{{ $menu->id }}" 
                                                                           data-category="{{ $menu->id }}"
                                                                           @if(isset($rolePermissions) && $categoryPermissions->every(function($p) use ($rolePermissions) { return in_array($p->id, $rolePermissions); })) checked @endif>
                                                                    <label class="form-check-label" for="category_{{ $menu->id }}"></label>
                                                                </div>
                                                                <h6 class="mb-0 fw-semibold">
                                                                    <i class="{{ $menu->icon }} me-2"></i>{{ $menu->name }}
                                                                </h6>
                                                            </div>
                                                            <div class="row">
                                                                @foreach($categoryPermissions as $permission)
                                                                    <div class="col-md-4 mb-2">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input permission-checkbox" 
                                                                                   type="checkbox" 
                                                                                   id="permission_{{ $permission->id }}" 
                                                                                   name="permissions[]" 
                                                                                   value="{{ $permission->id }}"
                                                                                   data-category="{{ $menu->id }}"
                                                                                   @if(isset($rolePermissions) && in_array($permission->id, $rolePermissions)) checked @endif>
                                                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                                {{ $permission->name }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            @error('permissions')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="feather-save me-2"></i>
                                                {{ isset($role) ? __('messages.backend_update_role') : __('messages.backend_save_role') }}
                                            </button>
                                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                                                <i class="feather-x me-2"></i>
                                                {{ __('messages.backend_cancel') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection

@push('scripts')
    @include('backend.layouts.scriptcustom-minimal')
    
    <script>
    // Category toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Handle category toggle clicks
        document.querySelectorAll('.category-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                const category = this.dataset.category;
                const isChecked = this.checked;
                
                // Check/uncheck all permissions in this category
                document.querySelectorAll(`.permission-checkbox[data-category="${category}"]`).forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                });
            });
        });
        
        // Handle individual permission checkbox changes
        document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const category = this.dataset.category;
                const categoryToggle = document.querySelector(`.category-toggle[data-category="${category}"]`);
                const allCheckboxes = document.querySelectorAll(`.permission-checkbox[data-category="${category}"]`);
                const checkedCount = document.querySelectorAll(`.permission-checkbox[data-category="${category}"]:checked`).length;
                
                // Update category toggle state
                categoryToggle.checked = checkedCount === allCheckboxes.length;
                categoryToggle.indeterminate = checkedCount > 0 && checkedCount < allCheckboxes.length;
            });
        });
        
        // Initialize indeterminate states
        document.querySelectorAll('.category-toggle').forEach(function(toggle) {
            const category = toggle.dataset.category;
            const allCheckboxes = document.querySelectorAll(`.permission-checkbox[data-category="${category}"]`);
            const checkedCount = document.querySelectorAll(`.permission-checkbox[data-category="${category}"]:checked`).length;
            
            if (checkedCount > 0 && checkedCount < allCheckboxes.length) {
                toggle.indeterminate = true;
            }
        });
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        const isEdit = {{ isset($role) ? 'true' : 'false' }};
        const actionText = isEdit ? 'update' : 'simpan';

        Swal.fire({
            title: '{{ __('messages.backend_confirmation') }}',
            text: `{{ isset($role) ? __('messages.backend_confirm_update_role') : __('messages.backend_confirm_save_role') }}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: '{{ __('messages.backend_cancel') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: '{{ __('messages.backend_processing') }}',
                    text: '{{ __('messages.backend_please_wait') }}',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                this.removeEventListener('submit', arguments.callee);
                this.submit();
            }
        });
    });
    </script>
@endpush
