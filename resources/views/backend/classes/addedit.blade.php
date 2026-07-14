@extends('backend.layouts.app')

@section('content')
<div class="nxl-content">
    <!-- [ page-header ] start -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">{{ isset($class) ? 'Edit Kelas' : 'Tambah Kelas' }}</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
                <li class="breadcrumb-item active">{{ isset($class) ? 'Edit' : 'Tambah' }}</li>
            </ul>
        </div>
        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                    <a href="{{ route('classes.index') }}" class="btn btn-secondary">
                        <i class="feather-arrow-left me-2"></i>
                        <span>Kembali</span>
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
                    <div class="card-header">
                        <h5 class="card-title">{{ isset($class) ? 'Edit Kelas' : 'Tambah Kelas Baru' }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ isset($class) ? route('classes.update', $class->id) : route('classes.store') }}" enctype="multipart/form-data" id="classForm">
                            @csrf
                            @if(isset($class))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $class->name ?? '') }}" placeholder="Contoh: Matematika SMP Kelas 7 Semester 1" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="draft" {{ (old('status', $class->status ?? 'draft') == 'draft') ? 'selected' : '' }}>Draft</option>
                                            <option value="publish" {{ (old('status', $class->status ?? '') == 'publish') ? 'selected' : '' }}>Diterbitkan</option>
                                            <option value="inactive" {{ (old('status', $class->status ?? '') == 'inactive') ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ (old('category_id', $class->category_id ?? '') == $category->id) ? 'selected' : '' }}>
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
                                        <label for="subcategory_id" class="form-label">Sub Kategori <span class="text-danger">*</span></label>
                                        <select class="form-control @error('subcategory_id') is-invalid @enderror" id="subcategory_id" name="subcategory_id" required>
                                            <option value="">Pilih Sub Kategori</option>
                                            @foreach($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}"
                                                    data-category-id="{{ $subcategory->category_id }}"
                                                    {{ (old('subcategory_id', $class->subcategory_id ?? '') == $subcategory->id) ? 'selected' : '' }}>
                                                    {{ $subcategory->name }} ({{ $subcategory->formatted_grade_level }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('subcategory_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="teacher_id" class="form-label">Guru</label>
                                        <select class="form-control @error('teacher_id') is-invalid @enderror" id="teacher_id" name="teacher_id">
                                            <option value="">Pilih Guru</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" {{ (old('teacher_id', $class->teacher_id ?? '') == $teacher->id) ? 'selected' : '' }}>
                                                    {{ $teacher->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('teacher_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="capacity" class="form-label">Kapasitas Siswa</label>
                                        <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity', $class->capacity ?? '') }}" placeholder="Kosongkan untuk tidak terbatas" min="0">
                                        @error('capacity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="cover_image" class="form-label">Cover Kelas</label>
                                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" accept="image/*">
                                        @if(isset($class) && $class->cover_image)
                                            <div class="mt-2">
                                                <img src="{{ $class->cover_image_url }}" alt="Cover" class="rounded" style="max-height: 150px; object-fit: cover;">
                                            </div>
                                        @endif
                                        @error('cover_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Jelaskan kelas ini...">{{ old('description', $class->description ?? '') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input @error('is_featured') is-invalid @enderror" type="checkbox" id="is_featured" name="is_featured" value="1" {{ (old('is_featured', $class->is_featured ?? false)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">Kelas Unggulan</label>
                                        @error('is_featured')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="fw-bold mb-3">Materi Kelas (Otomatis dari Mindmap)</h6>
                                    <p class="text-muted small mb-3">Materi akan diambil secara otomatis dari mindmap yang sudah tersusun untuk sub kategori yang dipilih.</p>
                                    <div id="materials-loading" class="text-muted small d-none">
                                        <i class="feather-loader spin me-2"></i> Memuat materi...
                                    </div>
                                    <div id="materials-container" class="row g-2">
                                        <div class="col-12" id="empty-materials">
                                            <div class="text-muted py-3">
                                                <i class="feather-inbox me-2"></i> Pilih sub kategori untuk melihat materi dari mindmap.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 d-flex justify-content-end gap-2">
                                <a href="{{ route('classes.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">{{ isset($class) ? 'Simpan Perubahan' : 'Simpan Kelas' }}</button>
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
    <script src="{{ asset('backend/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/select2-active.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/theme-customizer-init.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize select2
            $('#category_id, #subcategory_id, #teacher_id, #status').select2();

            // Filter subcategory by category
            const categorySelect = document.getElementById('category_id');
            const subcategorySelect = document.getElementById('subcategory_id');
            const subcategoryOptions = Array.from(subcategorySelect.options);

            function filterSubcategories() {
                const categoryId = categorySelect.value;
                subcategorySelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';

                subcategoryOptions.forEach(option => {
                    if (!categoryId || option.dataset.categoryId === categoryId) {
                        subcategorySelect.appendChild(option.cloneNode(true));
                    }
                });

                // Restore selected value
                const selectedValue = '{{ old('subcategory_id', $class->subcategory_id ?? '') }}';
                if (selectedValue) {
                    subcategorySelect.value = selectedValue;
                }

                $(subcategorySelect).trigger('change');
            }

            categorySelect.addEventListener('change', filterSubcategories);
            filterSubcategories();

            // Load materials when subcategory changes
            subcategorySelect.addEventListener('change', function() {
                const subcategoryId = this.value;
                if (!subcategoryId) {
                    document.getElementById('materials-container').innerHTML = `
                        <div class="col-12" id="empty-materials">
                            <div class="text-muted py-3">
                                <i class="feather-inbox me-2"></i> Pilih sub kategori terlebih dahulu.
                            </div>
                        </div>
                    `;
                    return;
                }

                document.getElementById('materials-loading').classList.remove('d-none');

                fetch('{{ route('classes.materials') }}?subcategory_id=' + subcategoryId, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('materials-loading').classList.add('d-none');
                    const container = document.getElementById('materials-container');

                    if (data.length === 0) {
                        container.innerHTML = `
                            <div class="col-12" id="empty-materials">
                                <div class="text-muted py-3">
                                    <i class="feather-inbox me-2"></i> Belum ada mindmap/materi di sub kategori ini.
                                </div>
                            </div>
                        `;
                        return;
                    }

                    let html = '<div class="col-12"><ul class="list-group">';
                    data.forEach(function(material, index) {
                        html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><span class="badge bg-secondary me-2">${index + 1}</span>${material.title}</span>
                                <i class="feather-check-circle text-success"></i>
                            </li>
                        `;
                    });
                    html += '</ul></div>';

                    container.innerHTML = html;
                })
                .catch(error => {
                    document.getElementById('materials-loading').classList.add('d-none');
                    console.error('Error:', error);
                });
            });

            // Trigger load on edit mode if subcategory already selected
            @if(isset($class) && $class->subcategory_id)
                subcategorySelect.dispatchEvent(new Event('change'));
            @endif
        });
    </script>
@endpush
