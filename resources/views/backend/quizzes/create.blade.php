@extends('backend.layouts.app')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Tambah Quiz Baru</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('quizzes.index') }}">Quiz</a></li>
                        <li class="breadcrumb-item">Tambah</li>
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
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end --> 
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <form method="POST" action="{{ route('quizzes.store') }}">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Judul Quiz <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" required placeholder="Masukkan judul quiz">
                                        @error('title')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea class="form-control" name="description" rows="3" placeholder="Masukkan deskripsi quiz">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Waktu (menit) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="time_limit" value="{{ old('time_limit', 30) }}" required min="1" placeholder="30">
                                            @error('time_limit')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Passing Grade (%) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="passing_score" value="{{ old('passing_score', 70) }}" required min="0" max="100" placeholder="70">
                                            <small class="text-muted">Nilai minimum untuk lulus quiz (0-100)</small>
                                            @error('passing_score')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex gap-2 mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="feather-save me-2"></i> Simpan Quiz
                                        </button>
                                        <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">
                                            <i class="feather-x me-2"></i> Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Informasi Passing Grade</h5>
                                <div class="alert alert-info">
                                    <i class="feather-info-circle"></i>
                                    <strong>Passing Grade</strong> adalah nilai minimum yang harus dicapai user untuk lulus quiz.
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Mudah</span>
                                        <span class="badge bg-success">50-60%</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Sedang</span>
                                        <span class="badge bg-warning">65-75%</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Sulit</span>
                                        <span class="badge bg-danger">80-90%</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
@endsection
