@extends('frontend.layouts.app')

@section('content')
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-left">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="no-pad bold">Hasil Quiz</h1>
                        <p class="lead">Evaluasi dan analisis performa quiz Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="showcase section-small">
        <div class="container">
            <!-- Result Summary -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>{{ $attempt->quiz->title }}</h3>
                                    <p class="text-muted">Selesai pada: {{ $attempt->completed_at->format('d M Y H:i') }}</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    @if($attempt->status === 'passed')
                                        <h2 class="text-success">
                                            <i class="fa fa-check-circle"></i> Lulus
                                        </h2>
                                    @else
                                        <h2 class="text-danger">
                                            <i class="fa fa-times-circle"></i> Belum Lulus
                                        </h2>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Score Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-primary">{{ number_format($attempt->score, 1) }}%</h3>
                            <p class="text-muted">Skor Akhir</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-success">{{ $correctAnswers }}/{{ $totalQuestions }}</h3>
                            <p class="text-muted">Jawaban Benar</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-info">{{ number_format($accuracy, 1) }}%</h3>
                            <p class="text-muted">Akurasi</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-warning">{{ $attempt->earned_points }}/{{ $attempt->total_points }}</h3>
                            <p class="text-muted">Poin Diperoleh</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Answers -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Detail Jawaban</h4>
                            @foreach($attempt->quizAnswers as $answer)
                                <div class="card mb-3 {{ $answer->is_correct ? 'border-success' : 'border-danger' }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5>{{ $answer->quizQuestion->question }}</h5>
                                            <span class="badge {{ $answer->is_correct ? 'bg-success' : 'bg-danger' }}">
                                                {{ $answer->is_correct ? 'Benar' : 'Salah' }}
                                            </span>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Jawaban Anda:</strong> {{ $answer->user_answer }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Jawaban Benar:</strong> {{ $answer->quizQuestion->correct_answer }}</p>
                                            </div>
                                        </div>
                                        @if($answer->quizQuestion->explanation)
                                            <div class="mt-2">
                                                <p class="text-muted"><strong>Penjelasan:</strong> {{ $answer->quizQuestion->explanation }}</p>
                                            </div>
                                        @endif
                                        <div class="mt-2">
                                            <span class="badge bg-info">+{{ $answer->points_earned }} poin</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Previous Attempts -->
            @if($previousAttempts->count() > 0)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4>Attempt Sebelumnya</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Skor</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($previousAttempts as $prevAttempt)
                                            <tr>
                                                <td>{{ $prevAttempt->completed_at->format('d M Y H:i') }}</td>
                                                <td>{{ number_format($prevAttempt->score, 1) }}%</td>
                                                <td>
                                                    <span class="badge {{ $prevAttempt->status === 'passed' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $prevAttempt->status === 'passed' ? 'Lulus' : 'Belum Lulus' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('quiz.result', $prevAttempt->id) }}" class="btn btn-sm btn-info">
                                                        Lihat Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="{{ route('quiz.index') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> Kembali ke Quiz
                    </a>
                    <a href="{{ route('quiz.history', $attempt->quiz_id) }}" class="btn btn-info">
                        <i class="fa fa-history"></i> Riwayat Quiz
                    </a>
                    <a href="{{ route('quiz.progress') }}" class="btn btn-success">
                        <i class="fa fa-chart-line"></i> Progress Belajar
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
