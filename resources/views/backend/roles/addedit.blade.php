@extends('backend.layouts.app')

@section('content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ isset($role) ? 'Edit Role' : 'Tambah Role' }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active">{{ isset($role) ? 'Edit' : 'Tambah' }}</li>
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
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
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
                            <h5 class="card-title">{{ isset($role) ? 'Edit Role' : 'Tambah Role Baru' }}</h5>
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
                                            <label for="name" class="form-label">Nama Role <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name"
                                                   value="{{ old('name') ?? $role->name ?? '' }}"
                                                   placeholder="Contoh: admin">
                                            @error('name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="guard_name" class="form-label">Guard Name <span class="text-danger">*</span></label>
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
                                            <label class="form-label">Permissions</label>
                                            <div class="card">
                                                <div class="card-body p-3">
                                                    <div class="row">
                                                        @foreach($permissions as $permission)
                                                            <div class="col-md-4 mb-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" 
                                                                           type="checkbox" 
                                                                           id="permission_{{ $permission->id }}" 
                                                                           name="permissions[]" 
                                                                           value="{{ $permission->id }}"
                                                                           @if(isset($rolePermissions) && in_array($permission->id, $rolePermissions)) checked @endif>
                                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                        {{ $permission->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
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
                                                {{ isset($role) ? 'Update Role' : 'Simpan Role' }}
                                            </button>
                                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                                                <i class="feather-x me-2"></i>
                                                Batal
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
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        const isEdit = {{ isset($role) ? 'true' : 'false' }};
        const actionText = isEdit ? 'update' : 'simpan';

        Swal.fire({
            title: 'Konfirmasi',
            text: `Apakah Anda yakin ingin ${actionText} role ini?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ' + actionText + '!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
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
