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
                                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                                            <i class="feather-info me-2"></i>Informasi Dasar
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
                                    <!-- Tab 1: Informasi Dasar -->
                                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12">
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
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="category_filter" class="form-label">Kategori</label>
                                                    <select class="form-control" data-select2-selector="icon" id="category_filter">
                                                        <option value="">Semua Kategori</option>
                                                        @if(isset($categories))
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}" 
                                                                        data-subcategories="{{ json_encode($category->subcategories ?? []) }}">
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="subcategory_id" class="form-label">Subkategori <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('subcategory_id') is-invalid @enderror" 
                                                            data-select2-selector="icon" id="subcategory_id" name="subcategory_id" required>
                                                        <option value="">Pilih Subkategori</option>
                                                        @if(isset($subcategories))
                                                            @foreach($subcategories as $subcategory)
                                                                <option value="{{ $subcategory->id }}" 
                                                                        data-category-id="{{ $subcategory->category_id }}"
                                                                        {{ (old('subcategory_id') ?? (isset($materi) ? $materi->subcategory_id : '')) == $subcategory->id ? 'selected' : '' }}>
                                                                    {{ $subcategory->name }}
                                                                    @if($subcategory->category)
                                                                        ({{ $subcategory->category->name }})
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        @endif
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
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-control @error('status') is-invalid @enderror" 
                                                            data-select2-selector="icon" id="status" name="status">
                                                        <option value="draft" {{ (old('status') ?? (isset($materi) ? $materi->status : 'draft')) == 'draft' ? 'selected' : '' }}>
                                                            Draft
                                                        </option>
                                                        <option value="publish" {{ (old('status') ?? (isset($materi) ? $materi->status : '')) == 'publish' ? 'selected' : '' }}>
                                                            Diterbitkan
                                                        </option>
                                                        <option value="inactive" {{ (old('status') ?? (isset($materi) ? $materi->status : '')) == 'inactive' ? 'selected' : '' }}>
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
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="learning_objectives" class="form-label">Tujuan Pembelajaran</label>
                                                    <textarea class="form-control @error('learning_objectives') is-invalid @enderror" 
                                                              id="learning_objectives" name="learning_objectives" rows="3" 
                                                              placeholder="Apa yang akan dipelajari dari materi ini...">{{ old('learning_objectives') ?? (isset($materi) ? $materi->learning_objectives : '') }}</textarea>
                                                    @error('learning_objectives')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="content" class="form-label">Konten Materi</label>
                                                    <div id="editor-container" style="height: 400px; border: 1px solid #ced4da; border-radius: 0.375rem;"></div>
                                                    <input type="hidden" id="content" name="content" value="{{ old('content') ?? (isset($materi) ? $materi->content : '') }}">
                                                    @error('content')
                                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab 3: Latihan -->
                                    <div class="tab-pane fade" id="latihan" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Latihan Soal</label>
                                                    <div id="latihan-container">
                                                        @if(isset($materi))
                                                            @foreach($materi->practiceQuestions as $index => $latihan)
                                                                <div class="card mb-3 latihan-item" data-index="{{ $index }}">
                                                                    <div class="card-body">
                                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                                            <h6 class="card-title mb-0">Soal #{{ $index + 1 }}</h6>
                                                                            <button type="button" class="btn btn-sm btn-danger remove-latihan">
                                                                                <i class="feather-trash-2"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="mb-2">
                                                                            <label class="form-label">Pertanyaan</label>
                                                                            <textarea class="form-control latihan-question" rows="2" required>{{ $latihan->question }}</textarea>
                                                                        </div>
                                                                        <div class="mb-2">
                                                                            <label class="form-label">Jawaban Benar</label>
                                                                            <input type="text" class="form-control latihan-answer" value="{{ $latihan->correct_answer }}" required>
                                                                        </div>
                                                                        <div class="mb-0">
                                                                            <label class="form-label">Penjelasan (Opsional)</label>
                                                                            <textarea class="form-control latihan-explanation" rows="2">{{ $latihan->explanation }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-primary mt-2" id="add-latihan">
                                                        <i class="feather-plus me-1"></i> Tambah Soal
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab 4: Quiz -->
                                    <div class="tab-pane fade" id="quiz" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- Quiz Header -->
                                                <div class="card mb-4" style="background-color: #f5f9fd; border: 1px solid #dbeafe; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);">
                                                    <div class="card-body p-4">
                                                        <!-- Header dengan Ikon Kombinasi -->
                                                        <div class="d-flex align-items-center mb-4 pb-2" style="border-bottom: 1px solid #f1f5f9;">
                                                            <div class="position-relative me-3" style="width: 32px; height: 32px;">
                                                                <i class="feather-clock" style="color: #2563eb; font-size: 24px; position: absolute; left: 0; top: 0;"></i>
                                                                <i class="feather-settings" style="color: #2563eb; font-size: 14px; position: absolute; right: -2px; bottom: -2px; background: #fff; border-radius: 50%; padding: 1px;"></i>
                                                            </div>
                                                            <h5 class="card-title mb-0" style="font-weight: 700; font-size: 16px; letter-spacing: 0.5px; color: #1e293b;">PENGATURAN QUIZ</h5>
                                                        </div>

                                                        <!-- Baris 1: Judul Quiz & Status Quiz -->
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">Judul Quiz</label>
                                                                <input type="text" class="form-control" name="quiz_title" value="{{ isset($materi) && $materi->quizzes->first() ? $materi->quizzes->first()->title : '' }}" placeholder="test Quiz" style="border-color: #cbd5e1; border-radius: 6px; padding: 10px 12px;">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">Status Quiz</label>
                                                                <select class="form-select" name="quiz_status" style="border-color: #cbd5e1; border-radius: 6px; padding: 8px 12px; font-size: 14px;">
                                                                    <option value="draft" {{ isset($materi) && $materi->quizzes->first() && $materi->quizzes->first()->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                                                    <option value="publish" {{ isset($materi) && $materi->quizzes->first() && $materi->quizzes->first()->status == 'publish' ? 'selected' : '' }}>Publish</option>
                                                                    <option value="inactive" {{ isset($materi) && $materi->quizzes->first() && $materi->quizzes->first()->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Baris 2: Nilai Lulus Minimal & Batas Waktu -->
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">Nilai Lulus Minimal</label>
                                                                <input type="number" class="form-control" name="quiz_passing_score" value="{{ isset($materi) && $materi->quizzes->first() ? $materi->quizzes->first()->passing_score : 60 }}" min="0" max="100" style="border-color: #cbd5e1; border-radius: 6px; padding: 10px 12px;">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">Batas Waktu (menit)</label>
                                                                <input type="number" class="form-control" name="quiz_time_limit" value="{{ isset($materi) && $materi->quizzes->first() ? $materi->quizzes->first()->time_limit : '' }}" placeholder="Opsional" style="border-color: #cbd5e1; border-radius: 6px; padding: 10px 12px;">
                                                            </div>
                                                        </div>

                                                        <!-- Baris 3: Deskripsi Quiz -->
                                                        <div class="mb-0">
                                                            <label class="form-label" style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">Deskripsi Quiz (Opsional)</label>
                                                            <textarea class="form-control" name="quiz_description" rows="3" placeholder="Sebutkan deskripsi quiz..." style="border-color: #cbd5e1; border-radius: 6px; padding: 10px 12px;">{{ isset($materi) && $materi->quizzes->first() ? $materi->quizzes->first()->description : '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Quiz Questions -->
                                                <div class="mb-3">
                                                    <label class="form-label">Pertanyaan Quiz</label>
                                                    <div id="quiz-container" style="background-color: #fff; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                                                        @if(isset($materi) && $materi->quizzes->first())
                                                            @php
                                                                $quiz = $materi->quizzes->first();
                                                                $quizQuestions = $quiz->quizQuestions;
                                                            @endphp
                                                            @foreach($quizQuestions as $index => $quizItem)
                                                                <div class="card mb-3 quiz-item" data-index="{{ $index }}">
                                                                    <div class="card-body">
                                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                                            <h6 class="card-title mb-0">Pertanyaan #{{ $index + 1 }}</h6>
                                                                            <button type="button" class="btn btn-sm btn-danger remove-quiz">
                                                                                <i class="feather-trash-2"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="mb-2">
                                                                            <label class="form-label">Pertanyaan</label>
                                                                            <textarea class="form-control quiz-question" rows="2" required>{{ $quizItem->question }}</textarea>
                                                                        </div>
                                                                        <div class="row mb-2">
                                                                            <div class="col-md-6">
                                                <label class="form-label">Pilihan A</label>
                                                <input type="text" class="form-control quiz-option-a" value="{{ $quizItem->options['a'] ?? '' }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Pilihan B</label>
                                                <input type="text" class="form-control quiz-option-b" value="{{ $quizItem->options['b'] ?? '' }}" required>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">Pilihan C</label>
                                                <input type="text" class="form-control quiz-option-c" value="{{ $quizItem->options['c'] ?? '' }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Pilihan D</label>
                                                <input type="text" class="form-control quiz-option-d" value="{{ $quizItem->options['d'] ?? '' }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label">Jawaban Benar</label>
                                            <select class="form-control quiz-correct-answer" required>
                                                <option value="">Pilih Jawaban</option>
                                                <option value="a" {{ $quizItem->correct_answer == 'a' ? 'selected' : '' }}>A</option>
                                                <option value="b" {{ $quizItem->correct_answer == 'b' ? 'selected' : '' }}>B</option>
                                                <option value="c" {{ $quizItem->correct_answer == 'c' ? 'selected' : '' }}>C</option>
                                                <option value="d" {{ $quizItem->correct_answer == 'd' ? 'selected' : '' }}>D</option>
                                            </select>
                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-primary mt-2" id="add-quiz">
                                                        <i class="feather-plus me-1"></i> Tambah Pertanyaan
                                                    </button>
                                                </div>
                                            </div>
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

                                <!-- Hidden inputs for latihan and quiz data -->
                                <input type="hidden" id="latihan_data" name="latihan_data">
                                <input type="hidden" id="quiz_data" name="quiz_data">
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
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/css/quill.min.css') }}">
@endpush

@push('scripts')
    @include('backend.layouts.scriptcustom-minimal')
    <script src="{{ asset('backend/assets/vendors/js/quill.min.js') }}"></script>
    
    <script>
        // Initialize Quill Editor
        var quill;
        var contentInput = document.getElementById('content');
        
        document.addEventListener('DOMContentLoaded', function() {
            quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: 'Tuliskan konten materi pembelajaran secara lengkap...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['link', 'image', 'video'],
                        ['clean'],
                        ['code-block']
                    ]
                }
            });

            // Load existing content if editing
            if (contentInput.value) {
                quill.root.innerHTML = contentInput.value;
            }
        });

        // Initialize existing data if editing
        document.addEventListener('DOMContentLoaded', function() {
            // Filter subcategories based on selected category
            const categoryFilter = document.getElementById('category_filter');
            const subcategorySelect = document.getElementById('subcategory_id');
            
            if (categoryFilter && subcategorySelect) {
                categoryFilter.addEventListener('change', function() {
                    const selectedCategoryId = this.value;
                    const options = subcategorySelect.querySelectorAll('option');
                    
                    options.forEach(option => {
                        if (option.value === '') {
                            option.style.display = 'block';
                            return;
                        }
                        
                        const optionCategoryId = option.getAttribute('data-category-id');
                        if (selectedCategoryId === '' || optionCategoryId === selectedCategoryId) {
                            option.style.display = 'block';
                        } else {
                            option.style.display = 'none';
                        }
                    });
                    
                    // Reset subcategory selection if it's no longer visible
                    const selectedOption = subcategorySelect.querySelector('option:checked');
                    if (selectedOption && selectedOption.value !== '' && selectedOption.style.display === 'none') {
                        subcategorySelect.value = '';
                    }
                });
                
                // Initialize filter based on currently selected subcategory
                if (subcategorySelect.value) {
                    const selectedOption = subcategorySelect.querySelector('option:checked');
                    if (selectedOption) {
                        const categoryId = selectedOption.getAttribute('data-category-id');
                        categoryFilter.value = categoryId;
                        categoryFilter.dispatchEvent(new Event('change'));
                    }
                }
            }
        });

        // Latihan functionality
        let latihanIndex = document.querySelectorAll('.latihan-item').length;
        
        document.getElementById('add-latihan').addEventListener('click', function() {
            latihanIndex++;
            const latihanHtml = `
                <div class="card mb-3 latihan-item" data-index="${latihanIndex}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="card-title mb-0">Soal #${latihanIndex}</h6>
                            <button type="button" class="btn btn-sm btn-danger remove-latihan">
                                <i class="feather-trash-2"></i>
                            </button>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Pertanyaan</label>
                            <textarea class="form-control latihan-question" rows="2" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Jawaban Benar</label>
                            <input type="text" class="form-control latihan-answer" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Penjelasan (Opsional)</label>
                            <textarea class="form-control latihan-explanation" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('latihan-container').insertAdjacentHTML('beforeend', latihanHtml);
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-latihan')) {
                e.target.closest('.latihan-item').remove();
            }
        });

        // Quiz functionality
        let quizIndex = document.querySelectorAll('.quiz-item').length;
        
        document.getElementById('add-quiz').addEventListener('click', function() {
            quizIndex++;
            const quizHtml = `
                <div class="card mb-3 quiz-item" data-index="${quizIndex}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="card-title mb-0">Pertanyaan #${quizIndex}</h6>
                            <button type="button" class="btn btn-sm btn-danger remove-quiz">
                                <i class="feather-trash-2"></i>
                            </button>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Pertanyaan</label>
                            <textarea class="form-control quiz-question" rows="2" required></textarea>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label">Pilihan A</label>
                                <input type="text" class="form-control quiz-option-a" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pilihan B</label>
                                <input type="text" class="form-control quiz-option-b" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label">Pilihan C</label>
                                <input type="text" class="form-control quiz-option-c" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pilihan D</label>
                                <input type="text" class="form-control quiz-option-d" required>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Jawaban Benar</label>
                            <select class="form-control quiz-correct-answer" required>
                                <option value="">Pilih Jawaban</option>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('quiz-container').insertAdjacentHTML('beforeend', quizHtml);
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-quiz')) {
                e.target.closest('.quiz-item').remove();
            }
        });

        // Collect latihan and quiz data on form submit
        document.getElementById('materiForm').addEventListener('submit', function(e) {
            // Update Quill content
            var contentInput = document.getElementById('content');
            if (quill) {
                contentInput.value = quill.root.innerHTML;
            }

            // Collect latihan data
            const latihanData = [];
            document.querySelectorAll('.latihan-item').forEach(function(item) {
                latihanData.push({
                    question: item.querySelector('.latihan-question').value,
                    answer: item.querySelector('.latihan-answer').value,
                    explanation: item.querySelector('.latihan-explanation').value
                });
            });
            document.getElementById('latihan_data').value = JSON.stringify(latihanData);

            // Collect quiz data
            const quizData = [];
            document.querySelectorAll('.quiz-item').forEach(function(item) {
                quizData.push({
                    question: item.querySelector('.quiz-question').value,
                    options: {
                        a: item.querySelector('.quiz-option-a').value,
                        b: item.querySelector('.quiz-option-b').value,
                        c: item.querySelector('.quiz-option-c').value,
                        d: item.querySelector('.quiz-option-d').value
                    },
                    correct_answer: item.querySelector('.quiz-correct-answer').value
                });
            });
            document.getElementById('quiz_data').value = JSON.stringify(quizData);
        });
    </script>
@endpush
