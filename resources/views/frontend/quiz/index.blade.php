@extends('frontend.layouts.app')

@section('content')
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-left">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="no-pad bold">Quiz <span class="label classic">Center</span></h1>
                        <p class="lead">Uji pemahaman Anda dengan kuis interaktif dan lihat progress belajar Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="showcase section-small">
        <div class="container">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-primary">{{ $totalAttempts }}</h3>
                            <p class="text-muted">Total Quiz Diikuti</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-success">{{ $passedAttempts }}</h3>
                            <p class="text-muted">Quiz Lulus</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-info">{{ number_format($averageScore, 1) }}%</h3>
                            <p class="text-muted">Rata-rata Skor</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Aksi Cepat</h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('quiz.progress') }}" class="btn btn-primary">
                                    <i class="fa fa-chart-line"></i> Lihat Progress
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Quizzes -->
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-4">Quiz Tersedia</h2>
                    
                    @forelse($quizzes as $quiz)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4>{{ $quiz->title }}</h4>
                                        <p class="text-muted">{{ $quiz->description }}</p>
                                        <div class="d-flex gap-3">
                                            <small><i class="fa fa-book"></i> {{ $quiz->material->title ?? 'N/A' }}</small>
                                            <small><i class="fa fa-clock"></i> {{ $quiz->time_limit }} menit</small>
                                            <small><i class="fa fa-trophy"></i> Lulus: {{ $quiz->passing_score }}%</small>
                                            <small><i class="fa fa-question-circle"></i> {{ $quiz->quizQuestions->count() }} soal</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        @if($quiz->quizAttempts->count() > 0)
                                            <div class="mb-2">
                                                <span class="badge bg-{{ $quiz->quizAttempts->last()->status === 'passed' ? 'success' : 'warning' }}">
                                                    {{ $quiz->quizAttempts->last()->status === 'passed' ? 'Lulus' : 'Belum Lulus' }}
                                                </span>
                                                <span class="badge bg-info">
                                                    {{ number_format($quiz->quizAttempts->last()->score, 1) }}%
                                                </span>
                                            </div>
                                        @endif
                                        <a href="{{ route('quiz.take', $quiz->id) }}" class="btn btn-primary">
                                            <i class="fa fa-play"></i> Mulai Quiz
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Belum ada quiz yang tersedia saat ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
