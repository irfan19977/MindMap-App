@extends('backend.layouts.app')

@section('content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ isset($subcategory) ? __('messages.backend_edit_subcategory') : __('messages.backend_add_subcategory_form') }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('messages.backend_home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('subcategories.index') }}">{{ __('messages.backend_subcategories_title') }}</a></li>
                    <li class="breadcrumb-item active">{{ isset($subcategory) ? __('messages.backend_edit') : __('messages.backend_add') }}</li>
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
                        <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">
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
                            <h5 class="card-title">{{ isset($subcategory) ? __('messages.backend_edit_subcategory') : __('messages.backend_add_subcategory_new') }}</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ isset($subcategory) ? route('subcategories.update', $subcategory->id) : route('subcategories.store') }}" enctype="multipart/form-data">
                                @csrf
                                @if(isset($subcategory))
                                    @method('PUT')
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">{{ __('messages.backend_main_category') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('category_id') is-invalid @enderror" 
                                                    data-select2-selector="icon" id="category_id" name="category_id">
                                                <option value="">{{ __('messages.backend_select_main_category') }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ (old('category_id') ?? ($subcategory->category_id ?? '')) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">{{ __('messages.backend_subcategory_name') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name"
                                                   value="{{ old('name') ?? $subcategory->name ?? '' }}"
                                                   placeholder="{{ __('messages.backend_subcategory_name') }}">
                                            @error('name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="grade_level" class="form-label">{{ __('messages.backend_grade_level') }} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('grade_level') is-invalid @enderror" 
                                                    data-select2-selector="icon" id="grade_level" name="grade_level">
                                                <option value="">{{ __('messages.backend_select_grade_level') }}</option>
                                                <option value="sd" {{ (old('grade_level') ?? ($subcategory->grade_level ?? '')) == 'sd' ? 'selected' : '' }}>
                                                    SD
                                                </option>
                                                <option value="smp" {{ (old('grade_level') ?? ($subcategory->grade_level ?? '')) == 'smp' ? 'selected' : '' }}>
                                                    SMP
                                                </option>
                                                <option value="sma" {{ (old('grade_level') ?? ($subcategory->grade_level ?? '')) == 'sma' ? 'selected' : '' }}>
                                                    SMA
                                                </option>
                                                <option value="umum" {{ (old('grade_level') ?? ($subcategory->grade_level ?? '')) == 'umum' ? 'selected' : '' }}>
                                                    Umum
                                                </option>
                                            </select>
                                            @error('grade_level')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">{{ __('messages.backend_status_label') }}<span class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror" 
                                                    data-select2-selector="icon" id="status" name="status">
                                                <option value="">{{ __('messages.backend_select_status') }}</option>
                                                <option value="publish" {{ (old('status') ?? ($subcategory->status ?? '')) == 'publish' ? 'selected' : '' }}>
                                                    {{ __('messages.backend_status_publish') }}
                                                </option>
                                                <option value="draft" {{ (old('status') ?? ($subcategory->status ?? '')) == 'draft' ? 'selected' : '' }}>
                                                    {{ __('messages.backend_status_draft') }}
                                                </option>
                                                <option value="inactive" {{ (old('status') ?? ($subcategory->status ?? '')) == 'inactive' ? 'selected' : '' }}>
                                                    {{ __('messages.backend_status_inactive') }}
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="curriculum" class="form-label">{{ __('messages.backend_curriculum_label') }}</label>
                                            <input type="text" class="form-control @error('curriculum') is-invalid @enderror"
                                                   id="curriculum" name="curriculum"
                                                   value="{{ old('curriculum') ?? $subcategory->curriculum ?? '' }}"
                                                   placeholder="{{ __('messages.backend_curriculum_placeholder') }}">
                                            @error('curriculum')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="cover_image" class="form-label">{{ __('messages.backend_cover_image_label') }}</label>
                                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                                                   id="cover_image" name="cover_image" 
                                                   accept="image/*">
                                            @if(isset($subcategory) && $subcategory->cover_image)
                                                <div class="mt-2">
                                                    <small class="text-muted">{{ __('messages.backend_current_image') }}</small><br>
                                                    <img src="{{ asset('storage/' . $subcategory->cover_image) }}" alt="Cover" class="img-thumbnail" style="max-width: 150px; max-height: 100px;">
                                                </div>
                                            @endif
                                            <small class="text-muted d-block mt-1">{{ __('messages.backend_image_format') }}</small>
                                            @error('cover_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input @error('is_featured') is-invalid @enderror" 
                                                   type="checkbox" id="is_featured" name="is_featured" value="1"
                                                   {{ (old('is_featured') ?? $subcategory->is_featured ?? 0) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">
                                                {{ __('messages.backend_featured_label') }}
                                            </label>
                                            @error('is_featured')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="feather-save me-2"></i>
                                                {{ isset($subcategory) ? __('messages.backend_update_subcategory') : __('messages.backend_save_subcategory') }}
                                            </button>
                                            <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">
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
        // Preview cover image
        document.getElementById('cover_image').addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Remove existing preview if any
                    var existingPreview = document.getElementById('imagePreview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }
                    
                    // Create preview
                    var preview = document.createElement('img');
                    preview.id = 'imagePreview';
                    preview.className = 'img-thumbnail mt-2';
                    preview.style.maxWidth = '200px';
                    preview.style.maxHeight = '150px';
                    preview.src = e.target.result;
                    
                    e.target.parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });

    // Form submission with SweetAlert confirmation
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        const isEdit = {{ isset($subcategory) ? 'true' : 'false' }};
        const actionText = isEdit ? 'update' : 'simpan';

        Swal.fire({
            title: '{{ __('messages.backend_confirmation') }}',
            text: `{{ isset($subcategory) ? __('messages.backend_confirm_update_subcategory') : __('messages.backend_confirm_save_subcategory') }}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: '{{ __('messages.backend_cancel') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: '{{ __('messages.backend_processing') }}',
                    text: '{{ __('messages.backend_please_wait') }}',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form normally (remove event listener to prevent recursion)
                this.removeEventListener('submit', arguments.callee);
                this.submit();
            }
        });
    });
    </script>
@endpush
