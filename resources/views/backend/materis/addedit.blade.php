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
                                                    <label for="pdf_file" class="form-label">Upload PDF (Opsional)</label>
                                                    <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept="application/pdf">
                                                    <small class="text-muted d-block mt-1">Upload PDF untuk otomatis convert ke konten materi. Format: PDF saja.</small>
                                                    <button type="button" class="btn btn-sm btn-primary mt-2" id="convert-pdf">
                                                        <i class="feather-file-text me-1"></i> Convert PDF ke Konten
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
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
                                        <div class="latihan-tab-header mb-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="tab-icon-box" style="background:#e8f5e9;color:#2e7d32">
                                                    <i class="feather-edit-3"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold">Soal Latihan</h6>
                                                    <small class="text-muted">Tambahkan soal latihan untuk menguji pemahaman siswa</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="latihan-container" class="latihan-container">
                                            @if(isset($materi))
                                                @foreach($materi->practiceQuestions as $index => $latihan)
                                                    <div class="soal-card latihan-item" data-index="{{ $index }}">
                                                        <div class="soal-card-header">
                                                            <div class="soal-num">{{ $index + 1 }}</div>
                                                            <span class="soal-card-label">Soal Latihan</span>
                                                            <button type="button" class="btn btn-sm btn-outline-danger remove-latihan ms-auto">
                                                                <i class="feather-trash-2"></i> Hapus
                                                            </button>
                                                        </div>
                                                        <div class="soal-card-body">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Pertanyaan <span class="text-danger">*</span></label>
                                                                <textarea class="form-control latihan-question" rows="2" placeholder="Tulis pertanyaan latihan..." required>{{ $latihan->question }}</textarea>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold">Tipe Soal</label>
                                                                    <select class="form-select latihan-type">
                                                                        <option value="essay" {{ ($latihan->type ?? 'essay') == 'essay' ? 'selected' : '' }}>Essay</option>
                                                                        <option value="short_answer" {{ ($latihan->type ?? '') == 'short_answer' ? 'selected' : '' }}>Jawaban Singkat</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-semibold">Poin</label>
                                                                    <input type="number" class="form-control latihan-points" value="{{ $latihan->points ?? 10 }}" min="1" placeholder="10">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Jawaban Benar <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control latihan-answer" value="{{ $latihan->correct_answer }}" placeholder="Kunci jawaban..." required>
                                                            </div>
                                                            <div class="mb-0">
                                                                <label class="form-label fw-semibold">Penjelasan <span class="text-muted fw-normal">(Opsional)</span></label>
                                                                <textarea class="form-control latihan-explanation" rows="2" placeholder="Penjelasan mengapa jawaban ini benar...">{{ $latihan->explanation }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-outline-success" id="add-latihan">
                                                <i class="feather-plus-circle me-1"></i> Tambah Soal Latihan
                                            </button>
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
                                                <div class="latihan-tab-header mb-3 mt-2">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="tab-icon-box" style="background:#e3f2fd;color:#1565c0">
                                                            <i class="feather-list"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-bold">Daftar Pertanyaan</h6>
                                                            <small class="text-muted">Tambahkan soal pilihan ganda untuk quiz</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="quiz-container" class="latihan-container">
                                                    @if(isset($materi) && $materi->quizzes->first())
                                                        @php
                                                            $quiz = $materi->quizzes->first();
                                                            $quizQuestions = $quiz->quizQuestions;
                                                        @endphp
                                                        @foreach($quizQuestions as $index => $quizItem)
                                                            <div class="soal-card quiz-item" data-index="{{ $index }}">
                                                                <div class="soal-card-header">
                                                                    <div class="soal-num">{{ $index + 1 }}</div>
                                                                    <span class="soal-card-label">Pertanyaan Quiz</span>
                                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-quiz ms-auto">
                                                                        <i class="feather-trash-2"></i> Hapus
                                                                    </button>
                                                                </div>
                                                                <div class="soal-card-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">Pertanyaan <span class="text-danger">*</span></label>
                                                                        <textarea class="form-control quiz-question" rows="2" placeholder="Tulis pertanyaan quiz..." required>{{ $quizItem->question }}</textarea>
                                                                    </div>
                                                                    <div class="soal-options-grid mb-3">
                                                                        <div class="soal-option-item">
                                                                            <span class="option-key">A</span>
                                                                            <input type="text" class="form-control quiz-option-a" value="{{ $quizItem->options['a'] ?? '' }}" placeholder="Pilihan A" required>
                                                                        </div>
                                                                        <div class="soal-option-item">
                                                                            <span class="option-key">B</span>
                                                                            <input type="text" class="form-control quiz-option-b" value="{{ $quizItem->options['b'] ?? '' }}" placeholder="Pilihan B" required>
                                                                        </div>
                                                                        <div class="soal-option-item">
                                                                            <span class="option-key">C</span>
                                                                            <input type="text" class="form-control quiz-option-c" value="{{ $quizItem->options['c'] ?? '' }}" placeholder="Pilihan C" required>
                                                                        </div>
                                                                        <div class="soal-option-item">
                                                                            <span class="option-key">D</span>
                                                                            <input type="text" class="form-control quiz-option-d" value="{{ $quizItem->options['d'] ?? '' }}" placeholder="Pilihan D" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="soal-answer-row">
                                                                        <label class="form-label fw-semibold mb-1">Jawaban Benar</label>
                                                                        <div class="answer-choices">
                                                                            @foreach(['a','b','c','d'] as $opt)
                                                                                <label class="answer-choice {{ $quizItem->correct_answer == $opt ? 'active' : '' }}">
                                                                                    <input type="radio" name="correct_{{ $index }}" value="{{ $opt }}" class="quiz-correct-answer" {{ $quizItem->correct_answer == $opt ? 'checked' : '' }} required>
                                                                                    {{ strtoupper($opt) }}
                                                                                </label>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="mt-3">
                                                    <button type="button" class="btn btn-outline-primary" id="add-quiz">
                                                        <i class="feather-plus-circle me-1"></i> Tambah Pertanyaan
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
    <style>
        /* Soal Card */
        .latihan-container { display: flex; flex-direction: column; gap: 14px; }
        .soal-card {
            border: 1.5px solid #e8ecf0;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .soal-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: #f8fafc;
            border-bottom: 1px solid #e8ecf0;
        }
        .soal-num {
            width: 28px; height: 28px;
            background: #1a73e8;
            color: #fff;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; flex-shrink: 0;
        }
        .soal-card-label { font-size: 13px; font-weight: 600; color: #475569; }
        .soal-card-body { padding: 16px; }

        /* Options grid */
        .soal-options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .soal-option-item { display: flex; align-items: center; gap: 8px; }
        .option-key {
            width: 30px; height: 30px;
            background: #f1f5f9; border: 1.5px solid #cbd5e1;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #475569;
            flex-shrink: 0;
        }

        /* Answer choices */
        .answer-choices { display: flex; gap: 8px; flex-wrap: wrap; }
        .answer-choice {
            display: flex; align-items: center; justify-content: center;
            width: 42px; height: 38px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700; font-size: 14px; color: #475569;
            transition: all 0.15s;
            user-select: none;
        }
        .answer-choice input[type="radio"] { display: none; }
        .answer-choice.active,
        .answer-choice:has(input:checked) {
            background: #1a73e8; color: #fff; border-color: #1a73e8;
        }
        .answer-choice:hover { border-color: #1a73e8; color: #1a73e8; }

        .tab-icon-box {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }

        #editor-container div {
            margin: 1rem 0 !important;
            line-height: 1.5 !important;
        }
        #editor-container {
            overflow: hidden !important;
        }
        #editor-container .ql-editor {
            overflow-wrap: break-word !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
            max-width: 100% !important;
        }
        #editor-container .ql-editor p {
            overflow-wrap: break-word !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
            max-width: 100% !important;
        }
    </style>
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
                <div class="soal-card latihan-item" data-index="${latihanIndex}">
                    <div class="soal-card-header">
                        <div class="soal-num">${latihanIndex}</div>
                        <span class="soal-card-label">Soal Latihan</span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-latihan ms-auto">
                            <i class="feather-trash-2"></i> Hapus
                        </button>
                    </div>
                    <div class="soal-card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pertanyaan <span class="text-danger">*</span></label>
                            <textarea class="form-control latihan-question" rows="2" placeholder="Tulis pertanyaan latihan..." required></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tipe Soal</label>
                                <select class="form-select latihan-type">
                                    <option value="essay">Essay</option>
                                    <option value="short_answer">Jawaban Singkat</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Poin</label>
                                <input type="number" class="form-control latihan-points" value="10" min="1" placeholder="10">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jawaban Benar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control latihan-answer" placeholder="Kunci jawaban..." required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Penjelasan <span class="text-muted fw-normal">(Opsional)</span></label>
                            <textarea class="form-control latihan-explanation" rows="2" placeholder="Penjelasan mengapa jawaban ini benar..."></textarea>
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
            // Answer choice active state
            if (e.target.closest('.answer-choice')) {
                const choice = e.target.closest('.answer-choice');
                const group = choice.closest('.answer-choices');
                group.querySelectorAll('.answer-choice').forEach(c => c.classList.remove('active'));
                choice.classList.add('active');
                const radio = choice.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
            }
        });

        // Quiz functionality
        let quizIndex = document.querySelectorAll('.quiz-item').length;
        
        document.getElementById('add-quiz').addEventListener('click', function() {
            quizIndex++;
            const quizHtml = `
                <div class="soal-card quiz-item" data-index="${quizIndex}">
                    <div class="soal-card-header">
                        <div class="soal-num">${quizIndex}</div>
                        <span class="soal-card-label">Pertanyaan Quiz</span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-quiz ms-auto">
                            <i class="feather-trash-2"></i> Hapus
                        </button>
                    </div>
                    <div class="soal-card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pertanyaan <span class="text-danger">*</span></label>
                            <textarea class="form-control quiz-question" rows="2" placeholder="Tulis pertanyaan quiz..." required></textarea>
                        </div>
                        <div class="soal-options-grid mb-3">
                            <div class="soal-option-item">
                                <span class="option-key">A</span>
                                <input type="text" class="form-control quiz-option-a" placeholder="Pilihan A" required>
                            </div>
                            <div class="soal-option-item">
                                <span class="option-key">B</span>
                                <input type="text" class="form-control quiz-option-b" placeholder="Pilihan B" required>
                            </div>
                            <div class="soal-option-item">
                                <span class="option-key">C</span>
                                <input type="text" class="form-control quiz-option-c" placeholder="Pilihan C" required>
                            </div>
                            <div class="soal-option-item">
                                <span class="option-key">D</span>
                                <input type="text" class="form-control quiz-option-d" placeholder="Pilihan D" required>
                            </div>
                        </div>
                        <div class="soal-answer-row">
                            <label class="form-label fw-semibold mb-1">Jawaban Benar</label>
                            <div class="answer-choices">
                                <label class="answer-choice"><input type="radio" name="correct_${quizIndex}" value="a" class="quiz-correct-answer" required> A</label>
                                <label class="answer-choice"><input type="radio" name="correct_${quizIndex}" value="b" class="quiz-correct-answer"> B</label>
                                <label class="answer-choice"><input type="radio" name="correct_${quizIndex}" value="c" class="quiz-correct-answer"> C</label>
                                <label class="answer-choice"><input type="radio" name="correct_${quizIndex}" value="d" class="quiz-correct-answer"> D</label>
                            </div>
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

        // PDF to text conversion - using server-side for reliability
        document.getElementById('convert-pdf').addEventListener('click', function() {
            const pdfInput = document.getElementById('pdf_file');
            const file = pdfInput.files[0];

            if (!file) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih file PDF terlebih dahulu!',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            const formData = new FormData();
            formData.append('pdf_file', file);

            // Get CSRF token from hidden input
            const csrfToken = document.querySelector('input[name="_token"]')?.value;

            // Show loading state
            this.innerHTML = '<i class="feather-loader me-1"></i> Converting...';
            this.disabled = true;

            fetch('{{ route("materis.convertPdf") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Server response:', data);
                    console.log('Content length:', data.text ? data.text.length : 0);
                    console.log('Content preview:', data.text ? data.text.substring(0, 200) : 'empty');

                    // Insert into Quill editor
                    if (quill) {
                        quill.setText('');
                        quill.clipboard.dangerouslyPasteHTML(data.text);
                        console.log('Content inserted into Quill');
                    } else {
                        console.error('Quill editor not found!');
                        // Fallback: try to find editor container
                        const editorContainer = document.querySelector('#editor-container');
                        if (editorContainer) {
                            editorContainer.innerHTML = data.text;
                        }
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'PDF berhasil diconvert!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengconvert PDF: ' + data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            })
            .catch(error => {
                console.error('Conversion error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan: ' + error.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            })
            .finally(() => {
                // Reset button state
                this.innerHTML = '<i class="feather-file-text me-1"></i> Convert PDF ke Konten';
                this.disabled = false;
            });
        });

        // Collect latihan and quiz data on form submit
        document.getElementById('materiForm').addEventListener('submit', function(e) {
            // Update Quill content
            var contentInput = document.getElementById('content');
            if (quill) {
                contentInput.value = quill.root.innerHTML;
            }

            // Collect latihan data (with type & points)
            const latihanDataFull = [];
            document.querySelectorAll('.latihan-item').forEach(function(item) {
                latihanDataFull.push({
                    question: item.querySelector('.latihan-question').value,
                    type: item.querySelector('.latihan-type') ? item.querySelector('.latihan-type').value : 'essay',
                    points: item.querySelector('.latihan-points') ? parseInt(item.querySelector('.latihan-points').value) || 10 : 10,
                    answer: item.querySelector('.latihan-answer').value,
                    correct_answer: item.querySelector('.latihan-answer').value,
                    explanation: item.querySelector('.latihan-explanation').value
                });
            });
            document.getElementById('latihan_data').value = JSON.stringify(latihanDataFull);

            // Collect quiz data
            const quizData = [];
            document.querySelectorAll('.quiz-item').forEach(function(item) {
                const checkedAnswer = item.querySelector('.quiz-correct-answer:checked');
                quizData.push({
                    question: item.querySelector('.quiz-question').value,
                    options: {
                        a: item.querySelector('.quiz-option-a').value,
                        b: item.querySelector('.quiz-option-b').value,
                        c: item.querySelector('.quiz-option-c').value,
                        d: item.querySelector('.quiz-option-d').value
                    },
                    correct_answer: checkedAnswer ? checkedAnswer.value : ''
                });
            });
            document.getElementById('quiz_data').value = JSON.stringify(quizData);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
