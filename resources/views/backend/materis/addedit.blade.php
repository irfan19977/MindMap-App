@extends('backend.layouts.app')

@section('content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ isset($materi) ? 'Edit Materi' : 'Tambah Materi' }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('materis.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Materi</li>
                    <li class="breadcrumb-item active">{{ isset($materi) ? 'Edit' : 'Tambah' }}</li>
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
                        <a href="{{ route('materis.index') }}" class="btn btn-secondary">
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
                            <h5 class="card-title">{{ isset($materi) ? 'Edit Materi Pembelajaran' : 'Tambah Materi Pembelajaran Baru' }}</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ isset($materi) ? route('materis.update', $materi->id) : route('materis.store') }}" enctype="multipart/form-data" id="materiForm">
                                @csrf
                                @if(isset($materi))
                                    @method('PUT')
                                @endif
                                
                                <!-- Tabs Navigation -->
                                <ul class="nav nav-tabs mb-4" id="materiTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                                            <i class="feather-info me-2"></i>Overview
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="konten-tab" data-bs-toggle="tab" data-bs-target="#konten" type="button" role="tab">
                                            <i class="feather-book-open me-2"></i>Konten Materi
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="latihan-tab" data-bs-toggle="tab" data-bs-target="#latihan" type="button" role="tab">
                                            <i class="feather-edit-3 me-2"></i>Latihan
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="quiz-tab" data-bs-toggle="tab" data-bs-target="#quiz" type="button" role="tab">
                                            <i class="feather-help-circle me-2"></i>Quiz
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tabs Content -->
                                <div class="tab-content" id="materiTabContent">
                                    <!-- Tab 1: Overview -->
                                    <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Judul Materi <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                                           id="title" name="title" 
                                                           value="{{ old('title') ?? (isset($materi) ? $materi->title : '') }}" 
                                                           placeholder="Contoh: Pengenalan Matematika Dasar" required>
                                                    @error('title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="difficulty_level" class="form-label">Tingkat Kesulitan <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('difficulty_level') is-invalid @enderror" 
                                                            id="difficulty_level" name="difficulty_level" required>
                                                        <option value="">Pilih Tingkat</option>
                                                        <option value="beginner" {{ (old('difficulty_level') ?? (isset($materi) ? $materi->difficulty_level : '')) == 'beginner' ? 'selected' : '' }}>
                                                            Pemula
                                                        </option>
                                                        <option value="intermediate" {{ (old('difficulty_level') ?? (isset($materi) ? $materi->difficulty_level : '')) == 'intermediate' ? 'selected' : '' }}>
                                                            Menengah
                                                        </option>
                                                        <option value="advanced" {{ (old('difficulty_level') ?? (isset($materi) ? $materi->difficulty_level : '')) == 'advanced' ? 'selected' : '' }}>
                                                            Lanjutan
                                                        </option>
                                                    </select>
                                                    @error('difficulty_level')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="category_id" class="form-label">Kategori</label>
                                                    <select class="form-control @error('category_id') is-invalid @enderror" 
                                                            id="category_id" name="category_id">
                                                        <option value="">Pilih Kategori</option>
                                                        @if(isset($categories))
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}" 
                                                                        {{ (old('category_id') ?? (isset($materi) ? $materi->category_id : '')) == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                    @if($category->parent)
                                                                        ({{ $category->parent->name }})
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('category_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="duration_minutes" class="form-label">Durasi (menit)</label>
                                                    <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                                                           id="duration_minutes" name="duration_minutes" 
                                                           value="{{ old('duration_minutes') ?? (isset($materi) ? $materi->duration_minutes : '') }}" 
                                                           placeholder="Contoh: 60" min="1">
                                                    @error('duration_minutes')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-control @error('status') is-invalid @enderror" 
                                                            id="status" name="status">
                                                        <option value="draft" {{ (old('status') ?? (isset($materi) ? $materi->status : 'draft')) == 'draft' ? 'selected' : '' }}>
                                                            Draft
                                                        </option>
                                                        <option value="published" {{ (old('status') ?? (isset($materi) ? $materi->status : '')) == 'published' ? 'selected' : '' }}>
                                                            Diterbitkan
                                                        </option>
                                                        <option value="archived" {{ (old('status') ?? (isset($materi) ? $materi->status : '')) == 'archived' ? 'selected' : '' }}>
                                                            Diarsipkan
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
                                                    <label for="description" class="form-label">Deskripsi Materi</label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                                              id="description" name="description" rows="4" 
                                                              placeholder="Jelaskan materi yang akan dipelajari...">{{ old('description') ?? (isset($materi) ? $materi->description : '') }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="video_url" class="form-label">URL Video (Opsional)</label>
                                                    <input type="url" class="form-control @error('video_url') is-invalid @enderror" 
                                                           id="video_url" name="video_url" 
                                                           value="{{ old('video_url') ?? (isset($materi) ? $materi->video_url : '') }}" 
                                                           placeholder="https://youtube.com/watch?v=...">
                                                    @error('video_url')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="file_path" class="form-label">File Materi (PDF, DOC, PPT)</label>
                                                    <input type="file" class="form-control @error('file_path') is-invalid @enderror" 
                                                           id="file_path" name="file_path" 
                                                           accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
                                                    @if(isset($materi) && $materi->file_path)
                                                        <div class="mt-2">
                                                            <small class="text-muted">File saat ini:</small><br>
                                                            <a href="{{ $materi->file_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="feather-download me-1"></i>
                                                                Download File
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <small class="text-muted d-block mt-1">Format: PDF, DOC, DOCX, PPT, PPTX, TXT. Maksimal: 10MB</small>
                                                    @error('file_path')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="thumbnail" class="form-label">Thumbnail/Gambar Cover</label>
                                                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                                                           id="thumbnail" name="thumbnail" 
                                                           accept="image/*">
                                                    @if(isset($materi) && $materi->thumbnail)
                                                        <div class="mt-2">
                                                            <small class="text-muted">Thumbnail saat ini:</small><br>
                                                            <img src="{{ asset('storage/' . $materi->thumbnail) }}" alt="Thumbnail" class="img-thumbnail" style="max-width: 150px; max-height: 100px;">
                                                        </div>
                                                    @endif
                                                    <small class="text-muted d-block mt-1">Format: JPG, PNG, WebP. Maksimal: 2MB</small>
                                                    @error('thumbnail')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="tags" class="form-label">Tags</label>
                                                    <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                                                           id="tags" name="tags[]" 
                                                           value="{{ old('tags') ? implode(', ', old('tags')) : (isset($materi) && $materi->tags ? implode(', ', $materi->tags) : '') }}" 
                                                           placeholder="matematika, dasar, kelas 1">
                                                    <small class="text-muted d-block">Pisahkan tags dengan koma</small>
                                                    @error('tags')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input @error('is_featured') is-invalid @enderror" 
                                                           type="checkbox" id="is_featured" name="is_featured" value="1"
                                                           {{ (old('is_featured') ?? (isset($materi) ? $materi->is_featured : 0)) == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_featured">
                                                        Tampilkan di Halaman Utama (Featured)
                                                    </label>
                                                    @error('is_featured')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input @error('is_free') is-invalid @enderror" 
                                                           type="checkbox" id="is_free" name="is_free" value="1"
                                                           {{ (old('is_free') ?? (isset($materi) ? $materi->is_free : 1)) == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_free">
                                                        Materi Gratis
                                                    </label>
                                                    @error('is_free')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab 2: Konten Materi -->
                                    <div class="tab-pane fade" id="konten" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6>Konten Materi Pembelajaran</h6>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addKontenMateri()">
                                                <i class="feather-plus me-1"></i>Tambah Konten
                                            </button>
                                        </div>
                                        
                                        <div id="kontenMateriContainer">
                                            <!-- Konten materi akan ditambahkan di sini dengan JavaScript -->
                                        </div>
                                        
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <i class="feather-info me-1"></i>
                                                Tambahkan beberapa konten materi untuk pembelajaran yang lebih terstruktur. Setiap konten bisa memiliki teks, gambar, atau video.
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Tab 3: Latihan -->
                                    <div class="tab-pane fade" id="latihan" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6>Soal Latihan</h6>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addLatihan()">
                                                <i class="feather-plus me-1"></i>Tambah Soal
                                            </button>
                                        </div>
                                        
                                        <div id="latihanContainer">
                                            <!-- Soal latihan akan ditambahkan di sini dengan JavaScript -->
                                        </div>
                                        
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <i class="feather-info me-1"></i>
                                                Buat soal latihan untuk membantu peserta memahami materi lebih baik.
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Tab 4: Quiz -->
                                    <div class="tab-pane fade" id="quiz" role="tabpanel">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Judul Quiz</label>
                                                <input type="text" class="form-control" name="quiz_title" 
                                                       value="{{ old('quiz_title') ?? (isset($materi) && $materi->quiz_data ? json_decode($materi->quiz_data, true)['title'] ?? '' : '') }}" 
                                                       placeholder="Quiz Akhir Materi">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Durasi (menit)</label>
                                                <input type="number" class="form-control" name="quiz_duration" 
                                                       value="{{ old('quiz_duration') ?? (isset($materi) && $materi->quiz_data ? json_decode($materi->quiz_data, true)['duration'] ?? 30 : 30) }}" 
                                                       placeholder="30" min="1">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Nilai Minimum</label>
                                                <input type="number" class="form-control" name="quiz_passing_score" 
                                                       value="{{ old('quiz_passing_score') ?? (isset($materi) && $materi->quiz_data ? json_decode($materi->quiz_data, true)['passing_score'] ?? 70 : 70) }}" 
                                                       placeholder="70" min="0" max="100">
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6>Soal Quiz</h6>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addQuiz()">
                                                <i class="feather-plus me-1"></i>Tambah Soal
                                            </button>
                                        </div>
                                        
                                        <div id="quizContainer">
                                            <!-- Soal quiz akan ditambahkan di sini dengan JavaScript -->
                                        </div>
                                        
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <i class="feather-info me-1"></i>
                                                Quiz untuk menguji pemahaman peserta. Peserta harus mencapai nilai minimum untuk lulus.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="feather-save me-2"></i>
                                                {{ isset($materi) ? 'Update Materi' : 'Simpan Materi' }}
                                            </button>
                                            <a href="{{ route('materis.index') }}" class="btn btn-secondary">
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

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
    @include('backend.layouts.scriptcustom')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    
    <script>
        let kontenCount = 0;
        let latihanCount = 0;
        let quizCount = 0;

        // Initialize existing data if editing
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($materi))
                // Load existing konten materi
                const existingKonten = @json(isset($materi) && $materi->konten_materi ? json_decode($materi->konten_materi, true) : []);
                existingKonten.forEach(konten => {
                    addKontenMateri(konten);
                });

                // Load existing latihan
                const existingLatihan = @json(isset($materi) && $materi->latihan_data ? json_decode($materi->latihan_data, true) : []);
                existingLatihan.forEach(latihan => {
                    addLatihan(latihan);
                });

                // Load existing quiz
                const existingQuiz = @json(isset($materi) && $materi->quiz_data ? json_decode($materi->quiz_data, true) : []);
                if (existingQuiz.questions) {
                    existingQuiz.questions.forEach(quiz => {
                        addQuiz(quiz);
                    });
                }
            @else
                // Add default empty konten for new materi
                addKontenMateri();
            @endif

            // Initialize tags
            const tagsInput = document.getElementById('tags');
            if (tagsInput.value) {
                updateTagsInput(tagsInput.value);
            }
        });

        // Preview thumbnail
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var existingPreview = document.getElementById('imagePreview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }
                    
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

        // Konten Materi Functions
        function addKontenMateri(data = null) {
            kontenCount++;
            const container = document.getElementById('kontenMateriContainer');
            
            const kontenHtml = `
                <div class="card mb-3" id="konten-${kontenCount}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Konten ${kontenCount}</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeKonten(${kontenCount})">
                            <i class="feather-trash-2"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Judul Konten</label>
                                    <input type="text" class="form-control" name="konten_materi[${kontenCount}][title]" 
                                           value="${data ? data.title || '' : ''}" placeholder="Judul konten pembelajaran">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Isi Konten</label>
                                    <textarea class="form-control summernote-konten" name="konten_materi[${kontenCount}][content]" 
                                              rows="6" placeholder="Tuliskan konten pembelajaran...">${data ? data.content || '' : ''}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipe Konten</label>
                                    <select class="form-control" name="konten_materi[${kontenCount}][type]">
                                        <option value="text" ${data && data.type === 'text' ? 'selected' : ''}>Teks</option>
                                        <option value="video" ${data && data.type === 'video' ? 'selected' : ''}>Video</option>
                                        <option value="image" ${data && data.type === 'image' ? 'selected' : ''}>Gambar</option>
                                        <option value="document" ${data && data.type === 'document' ? 'selected' : ''}>Dokumen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Media URL (jika ada)</label>
                                    <input type="url" class="form-control" name="konten_materi[${kontenCount}][media_url]" 
                                           value="${data ? data.media_url || '' : ''}" placeholder="URL video/gambar/dokumen">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', kontenHtml);
            
            // Initialize Summernote for new content
            $('.summernote-konten').summernote({
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        }

        function removeKonten(id) {
            document.getElementById(`konten-${id}`).remove();
        }

        // Latihan Functions
        function addLatihan(data = null) {
            latihanCount++;
            const container = document.getElementById('latihanContainer');
            
            const latihanHtml = `
                <div class="card mb-3" id="latihan-${latihanCount}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Soal Latihan ${latihanCount}</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeLatihan(${latihanCount})">
                            <i class="feather-trash-2"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Pertanyaan</label>
                                    <textarea class="form-control" name="latihan[${latihanCount}][question]" 
                                              rows="3" placeholder="Tuliskan pertanyaan...">${data ? data.question || '' : ''}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jawaban Benar</label>
                                    <input type="text" class="form-control" name="latihan[${latihanCount}][correct_answer]" 
                                           value="${data ? data.correct_answer || '' : ''}" placeholder="Jawaban yang benar">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipe Soal</label>
                                    <select class="form-control" name="latihan[${latihanCount}][type]">
                                        <option value="essay" ${data && data.type === 'essay' ? 'selected' : ''}>Essay</option>
                                        <option value="short_answer" ${data && data.type === 'short_answer' ? 'selected' : ''}>Jawaban Singkat</option>
                                        <option value="multiple_choice" ${data && data.type === 'multiple_choice' ? 'selected' : ''}>Pilihan Ganda</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Pembahasan</label>
                                    <textarea class="form-control" name="latihan[${latihanCount}][explanation]" 
                                              rows="3" placeholder="Jelaskan pembahasan jawaban...">${data ? data.explanation || '' : ''}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', latihanHtml);
        }

        function removeLatihan(id) {
            document.getElementById(`latihan-${id}`).remove();
        }

        // Quiz Functions
        function addQuiz(data = null) {
            quizCount++;
            const container = document.getElementById('quizContainer');
            
            const quizHtml = `
                <div class="card mb-3" id="quiz-${quizCount}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Soal Quiz ${quizCount}</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeQuiz(${quizCount})">
                            <i class="feather-trash-2"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Pertanyaan</label>
                                    <textarea class="form-control" name="quiz[${quizCount}][question]" 
                                              rows="3" placeholder="Tuliskan pertanyaan...">${data ? data.question || '' : ''}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Pilihan A</label>
                                    <input type="text" class="form-control" name="quiz[${quizCount}][options][A]" 
                                           value="${data && data.options ? data.options.A || '' : ''}" placeholder="Pilihan A">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Pilihan B</label>
                                    <input type="text" class="form-control" name="quiz[${quizCount}][options][B]" 
                                           value="${data && data.options ? data.options.B || '' : ''}" placeholder="Pilihan B">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Pilihan C</label>
                                    <input type="text" class="form-control" name="quiz[${quizCount}][options][C]" 
                                           value="${data && data.options ? data.options.C || '' : ''}" placeholder="Pilihan C">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Pilihan D</label>
                                    <input type="text" class="form-control" name="quiz[${quizCount}][options][D]" 
                                           value="${data && data.options ? data.options.D || '' : ''}" placeholder="Pilihan D">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jawaban Benar</label>
                                    <select class="form-control" name="quiz[${quizCount}][correct_answer]">
                                        <option value="">Pilih Jawaban</option>
                                        <option value="A" ${data && data.correct_answer === 'A' ? 'selected' : ''}>A</option>
                                        <option value="B" ${data && data.correct_answer === 'B' ? 'selected' : ''}>B</option>
                                        <option value="C" ${data && data.correct_answer === 'C' ? 'selected' : ''}>C</option>
                                        <option value="D" ${data && data.correct_answer === 'D' ? 'selected' : ''}>D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Bobot Nilai</label>
                                    <input type="number" class="form-control" name="quiz[${quizCount}][points]" 
                                           value="${data ? data.points || 10 : 10}" placeholder="10" min="1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', quizHtml);
        }

        function removeQuiz(id) {
            document.getElementById(`quiz-${id}`).remove();
        }

        // Handle tags input
        function updateTagsInput(tagsValue) {
            const tagsArray = tagsValue.split(',').map(tag => tag.trim()).filter(tag => tag !== '');
            const container = document.getElementById('tags').parentNode;
            const existingInputs = container.querySelectorAll('input[name="tags[]"]');
            existingInputs.forEach(input => input.remove());
            
            tagsArray.forEach(tag => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'tags[]';
                hiddenInput.value = tag;
                container.appendChild(hiddenInput);
            });
        }

        document.getElementById('tags').addEventListener('change', function(e) {
            updateTagsInput(e.target.value);
        });

        // Form submission
        document.getElementById('materiForm').addEventListener('submit', function(e) {
            // Collect all konten materi data
            const kontenData = {};
            const latihanData = {};
            const quizData = {
                title: document.querySelector('input[name="quiz_title"]').value,
                duration: document.querySelector('input[name="quiz_duration"]').value,
                passing_score: document.querySelector('input[name="quiz_passing_score"]').value,
                questions: []
            };

            // Collect konten materi
            document.querySelectorAll('[id^="konten-"]').forEach(element => {
                const id = element.id.replace('konten-', '');
                const title = element.querySelector(`[name="konten_materi[${id}][title]"]`).value;
                const content = element.querySelector(`[name="konten_materi[${id}][content]"]`).value;
                const type = element.querySelector(`[name="konten_materi[${id}][type]"]`).value;
                const mediaUrl = element.querySelector(`[name="konten_materi[${id}][media_url]"]`).value;
                
                kontenData[id] = { title, content, type, media_url };
            });

            // Collect latihan
            document.querySelectorAll('[id^="latihan-"]').forEach(element => {
                const id = element.id.replace('latihan-', '');
                const question = element.querySelector(`[name="latihan[${id}][question]"]`).value;
                const correctAnswer = element.querySelector(`[name="latihan[${id}][correct_answer]"]`).value;
                const type = element.querySelector(`[name="latihan[${id}][type]"]`).value;
                const explanation = element.querySelector(`[name="latihan[${id}][explanation]"]`).value;
                
                latihanData[id] = { question, correct_answer: correctAnswer, type, explanation };
            });

            // Collect quiz
            document.querySelectorAll('[id^="quiz-"]').forEach(element => {
                const id = element.id.replace('quiz-', '');
                const question = element.querySelector(`[name="quiz[${id}][question]"]`).value;
                const correctAnswer = element.querySelector(`[name="quiz[${id}][correct_answer]"]`).value;
                const points = element.querySelector(`[name="quiz[${id}][points]"]`).value;
                const options = {
                    A: element.querySelector(`[name="quiz[${id}][options][A]"]`).value,
                    B: element.querySelector(`[name="quiz[${id}][options][B]"]`).value,
                    C: element.querySelector(`[name="quiz[${id}][options][C]"]`).value,
                    D: element.querySelector(`[name="quiz[${id}][options][D]"]`).value
                };
                
                quizData.questions.push({ question, correct_answer: correctAnswer, points, options });
            });

            // Add hidden fields for form submission
            const kontenInput = document.createElement('input');
            kontenInput.type = 'hidden';
            kontenInput.name = 'konten_materi_data';
            kontenInput.value = JSON.stringify(kontenData);
            this.appendChild(kontenInput);

            const latihanInput = document.createElement('input');
            latihanInput.type = 'hidden';
            latihanInput.name = 'latihan_data';
            latihanInput.value = JSON.stringify(latihanData);
            this.appendChild(latihanInput);

            const quizInput = document.createElement('input');
            quizInput.type = 'hidden';
            quizInput.name = 'quiz_data';
            quizInput.value = JSON.stringify(quizData);
            this.appendChild(quizInput);
        });
    </script>
@endpush
