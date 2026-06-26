@extends('backend.layouts.app')

@section('content')
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Detail Quiz</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('quizzes.index') }}">Quiz</a></li>
                        <li class="breadcrumb-item">Detail</li>
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
                            <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-primary">
                                <i class="feather-edit-3 me-2"></i>
                                <span>Edit Quiz</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end --> 
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Informasi Quiz</h5>
                                <div class="mb-3">
                                    <strong>Judul:</strong>
                                    <p class="text-muted">{{ $quiz->title }}</p>
                                </div>
                                <div class="mb-3">
                                    <strong>Deskripsi:</strong>
                                    <p class="text-muted">{{ $quiz->description ?? '-' }}</p>
                                </div>
                                <div class="mb-3">
                                    <strong>Waktu:</strong>
                                    <span class="badge bg-info">
                                        <i class="feather-clock"></i> {{ $quiz->time_limit }} menit
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <strong>Passing Grade:</strong>
                                    <span class="badge {{ $quiz->passing_score >= 70 ? 'bg-success' : ($quiz->passing_score >= 50 ? 'bg-warning' : 'bg-danger') }}">
                                        <i class="feather-trophy"></i> {{ $quiz->passing_score }}%
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <strong>Status:</strong>
                                    <span class="badge {{ $quiz->status == 'publish' ? 'bg-success' : ($quiz->status == 'draft' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($quiz->status) }}
                                    </span>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <strong>Jumlah Pertanyaan:</strong>
                                    <span class="badge bg-primary">{{ $quiz->quizQuestions->count() }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Total Attempt:</strong>
                                    <span class="badge bg-info">{{ $quiz->quizAttempts->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Daftar Pertanyaan</h5>
                                @forelse($quiz->quizQuestions as $index => $question)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="mb-0">Soal {{ $index + 1 }}</h6>
                                                <span class="badge bg-primary">{{ $question->points }} poin</span>
                                            </div>
                                            <p class="mb-2">{{ $question->question }}</p>
                                            @if($question->options)
                                                <div class="mb-2">
                                                    <strong>Opsi:</strong>
                                                    <ul class="mb-0 ps-3">
                                                        @foreach($question->options as $option)
                                                            <li>{{ $option }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="d-flex gap-2">
                                                <span class="badge bg-success">Jawaban: {{ $question->correct_answer }}</span>
                                                @if($question->explanation)
                                                    <small class="text-muted">{{ $question->explanation }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info">
                                        <i class="feather-info-circle"></i> Belum ada pertanyaan untuk quiz ini.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
@endsection
