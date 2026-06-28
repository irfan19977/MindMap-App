@extends('backend.layouts.app')

@section('content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ isset($category) ? 'Edit Kategori Utama' : 'Tambah Kategori Utama' }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Kategori Utama</li>
                    <li class="breadcrumb-item active">{{ isset($category) ? 'Edit' : 'Tambah' }}</li>
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
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
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
                            <h5 class="card-title">{{ isset($category) ? 'Edit Kategori Utama' : 'Tambah Kategori Utama Baru' }}</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" enctype="multipart/form-data">
                                @csrf
                                @if(isset($category))
                                    @method('PUT')
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name"
                                                   value="{{ old('name') ?? $category->name ?? '' }}"
                                                   placeholder="Contoh: Matematika">
                                            @error('name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror" 
                                                    id="status" name="status">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="publish" {{ (old('status') ?? ($category->status ?? '')) == 'publish' ? 'selected' : '' }}>
                                                    Publish
                                                </option>
                                                <option value="draft" {{ (old('status') ?? ($category->status ?? '')) == 'draft' ? 'selected' : '' }}>
                                                    Draft
                                                </option>
                                                <option value="inactive" {{ (old('status') ?? ($category->status ?? '')) == 'inactive' ? 'selected' : '' }}>
                                                    Tidak Aktif
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
                                            <label for="description" class="form-label">Deskripsi Kategori</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" name="description" rows="4" 
                                                      placeholder="Jelaskan kategori ini...">{{ old('description') ?? $category->description ?? '' }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="cover_image" class="form-label">Gambar Cover</label>
                                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                                                   id="cover_image" name="cover_image" 
                                                   accept="image/*">
                                            @if(isset($category) && $category->cover_image)
                                                <div class="mt-2">
                                                    <small class="text-muted">Gambar saat ini:</small><br>
                                                    <img src="{{ asset('storage/' . $category->cover_image) }}" alt="Cover" class="img-thumbnail" style="max-width: 150px; max-height: 100px;">
                                                </div>
                                            @endif
                                            <small class="text-muted d-block mt-1">Format: JPG, PNG, WebP. Maksimal: 2MB</small>
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
                                                   {{ (old('is_featured') ?? $category->is_featured ?? 0) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">
                                                Tampilkan di Halaman Utama (Featured)
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
                                                {{ isset($category) ? 'Update Kategori' : 'Simpan Kategori' }}
                                            </button>
                                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
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

        const isEdit = {{ isset($category) ? 'true' : 'false' }};
        const actionText = isEdit ? 'update' : 'simpan';

        Swal.fire({
            title: 'Konfirmasi',
            text: `Apakah Anda yakin ingin ${actionText} kategori ini?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ' + actionText + '!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
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
