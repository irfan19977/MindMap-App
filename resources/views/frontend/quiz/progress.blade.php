@extends('frontend.layouts.app')

@section('content')
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-left">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="no-pad bold">Progress <span class="label classic">Belajar</span></h1>
                        <p class="lead">Pantau perkembangan dan evaluasi nilai quiz Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="showcase section-small">
        <div class="container">
            <!-- Overall Statistics -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h3 class="mb-3">Statistik Keseluruhan</h3>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-primary">{{ $totalAttempts }}</h4>
                            <small class="text-muted">Total Quiz</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-success">{{ $passedAttempts }}</h4>
                            <small class="text-muted">Lulus</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-danger">{{ $failedAttempts }}</h4>
                            <small class="text-muted">Gagal</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-info">{{ number_format($averageScore, 1) }}%</h4>
                            <small class="text-muted">Rata-rata</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-warning">{{ number_format($bestScore, 1) }}%</h4>
                            <small class="text-muted">Skor Terbaik</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-secondary">{{ $totalPointsEarned }}/{{ $totalPointsPossible }}</h4>
                            <small class="text-muted">Total Poin</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quiz Progress by Quiz -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Progress per Quiz</h4>
                            @forelse($quizProgress as $progress)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>{{ $progress['quiz']->title }}</h5>
                                                <p class="text-muted">{{ $progress['quiz']->description }}</p>
                                                <div class="d-flex gap-2">
                                                    <span class="badge bg-info">{{ $progress['attempts'] }} attempt(s)</span>
                                                    <span class="badge bg-warning">Best: {{ number_format($progress['best_score'], 1) }}%</span>
                                                    @if($progress['passed'])
                                                        <span class="badge bg-success">Lulus</span>
                                                    @else
                                                        <span class="badge bg-danger">Belum Lulus</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <div class="mb-2">
                                                    <small class="text-muted">Terakhir: {{ $progress['last_attempt']->completed_at->format('d M Y') }}</small>
                                                </div>
                                                <a href="{{ route('quiz.take', $progress['quiz']->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-play"></i> Coba Lagi
                                                </a>
                                                <a href="{{ route('quiz.history', $progress['quiz']->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fa fa-history"></i> Riwayat
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> Belum ada data progress quiz.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Attempts -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Attempt Terbaru</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Quiz</th>
                                            <th>Tanggal</th>
                                            <th>Skor</th>
                                            <th>Status</th>
                                            <th>Poin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attempts->take(10) as $attempt)
                                            <tr>
                                                <td>{{ $attempt->quiz->title }}</td>
                                                <td>{{ $attempt->completed_at->format('d M Y H:i') }}</td>
                                                <td>{{ number_format($attempt->score, 1) }}%</td>
                                                <td>
                                                    <span class="badge {{ $attempt->status === 'passed' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $attempt->status === 'passed' ? 'Lulus' : 'Gagal' }}
                                                    </span>
                                                </td>
                                                <td>{{ $attempt->earned_points }}/{{ $attempt->total_points }}</td>
                                                <td>
                                                    <a href="{{ route('quiz.result', $attempt->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fa fa-eye"></i> Detail
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
            </div>

            <!-- Action Buttons -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="{{ route('quiz.index') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> Kembali ke Quiz
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
