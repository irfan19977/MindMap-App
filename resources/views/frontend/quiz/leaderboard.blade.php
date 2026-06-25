@extends('frontend.layouts.app')

@section('content')
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-left">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="no-pad bold">Leaderboard <span class="label classic">Quiz</span></h1>
                        <p class="lead">{{ $quiz->title }} - Peringkat Peserta</p>
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

            <!-- User's Best Score -->
            @if($userBestScore > 0)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h4><i class="fa fa-trophy"></i> Skor Terbaik Anda</h4>
                                <h2>{{ number_format($userBestScore, 1) }}%</h2>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>Top 20 Peserta</h3>
                            
                            @forelse($leaderboard as $index => $entry)
                                <div class="card mb-3 {{ $index === 0 ? 'border-warning' : '' }}">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-1 text-center">
                                                @if($index === 0)
                                                    <h2 class="text-warning">🥇</h2>
                                                @elseif($index === 1)
                                                    <h2 class="text-secondary">🥈</h2>
                                                @elseif($index === 2)
                                                    <h2 class="text-danger">🥉</h2>
                                                @else
                                                    <h4 class="text-muted">#{{ $index + 1 }}</h4>
                                                @endif
                                            </div>
                                            <div class="col-md-7">
                                                <h5>{{ $entry->user->name }}</h5>
                                                <p class="text-muted mb-0">
                                                    <i class="fa fa-calendar"></i> {{ $entry->completed_at->format('d M Y H:i') }}
                                                </p>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <h3 class="text-primary">{{ number_format($entry->score, 1) }}%</h3>
                                                <span class="badge {{ $entry->status === 'passed' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $entry->status === 'passed' ? 'Lulus' : 'Gagal' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> Belum ada data leaderboard untuk quiz ini.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <a href="{{ route('quiz.take', $quiz->id) }}" class="btn btn-success">
                        <i class="fa fa-play"></i> Coba Quiz Ini
                    </a>
                    <a href="{{ route('quiz.history', $quiz->id) }}" class="btn btn-info">
                        <i class="fa fa-history"></i> Riwayat Anda
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
