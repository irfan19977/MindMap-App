@extends('frontend.layouts.app')

@section('content')
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-left">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="no-pad bold">Riwayat <span class="label classic">Quiz</span></h1>
                        <p class="lead">{{ $quiz->title }} - {{ $quiz->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="showcase section-small">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-12">
                    <a href="{{ route('quiz.index') }}" class="btn btn-secondary mb-3">
                        <i class="fa fa-arrow-left"></i> Kembali ke Quiz
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>Riwayat Attempt</h3>
                            
                            @forelse($attempts as $attempt)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5>Attempt #{{ $loop->iteration }}</h5>
                                                <p class="text-muted">
                                                    <i class="fa fa-calendar"></i> {{ $attempt->completed_at->format('d M Y H:i') }}
                                                </p>
                                                <div class="d-flex gap-2">
                                                    <span class="badge bg-primary">Skor: {{ number_format($attempt->score, 1) }}%</span>
                                                    <span class="badge bg-info">Poin: {{ $attempt->earned_points }}/{{ $attempt->total_points }}</span>
                                                    <span class="badge {{ $attempt->status === 'passed' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $attempt->status === 'passed' ? 'Lulus' : 'Gagal' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <a href="{{ route('quiz.result', $attempt->id) }}" class="btn btn-primary">
                                                    <i class="fa fa-eye"></i> Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> Belum ada riwayat attempt untuk quiz ini.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <a href="{{ route('quiz.take', $quiz->id) }}" class="btn btn-success">
                        <i class="fa fa-play"></i> Coba Quiz Ini Lagi
                    </a>
                    <a href="{{ route('quiz.leaderboard', $quiz->id) }}" class="btn btn-info">
                        <i class="fa fa-trophy"></i> Lihat Leaderboard
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
