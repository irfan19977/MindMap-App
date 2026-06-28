@extends('frontend.layouts.app')

@section('content')
<!-- Page Header-->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-title">Progress Pembelajaran Saya</h1>
                    <p class="page-description">Pantau perkembangan belajar Anda</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Overall Progress -->
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $stats['overall_progress'] }}%</h3>
                        <p>Progress Total</p>
                    </div>
                </div>
            </div>
            
            <!-- Completed Materials -->
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $stats['completed_materials'] }}/{{ $stats['total_materials'] }}</h3>
                        <p>Materi Selesai</p>
                    </div>
                </div>
            </div>
            
            <!-- Quiz Performance -->
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ number_format($stats['average_score'], 1) }}</h3>
                        <p>Rata-rata Skor Kuis</p>
                    </div>
                </div>
            </div>
            
            <!-- Practice Accuracy -->
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa fa-bullseye"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $stats['practice_accuracy'] }}%</h3>
                        <p>Akurasi Latihan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Progress Charts Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-title">Statistik Grafik</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h3>Progress per Kategori</h3>
                    <canvas id="categoryProgressChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h3>Skor Kuis dari Waktu ke Waktu</h3>
                    <canvas id="quizScoreChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Material Progress Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-title">Progress Materi</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Materi</th>
                                <th>Kategori</th>
                                <th>Progress</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($progress as $item)
                                @if($item->material)
                                <tr>
                                    <td>{{ $item->material->title }}</td>
                                    <td>{{ $item->material->subcategory?->category?->name ?? '-' }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" 
                                                style="width: {{ $item->progress_percentage }}%"
                                                aria-valuenow="{{ $item->progress_percentage }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                                {{ $item->progress_percentage }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->completed_at)
                                            <span class="badge badge-success">Selesai</span>
                                        @elseif($item->progress_percentage > 0)
                                            <span class="badge badge-warning">Sedang Belajar</span>
                                        @else
                                            <span class="badge badge-secondary">Belum Mulai</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->updated_at?->format('d M Y') ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('layanan.progress-tracking.material', $item->material_id) }}" 
                                           class="btn btn-sm btn-info">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        Belum ada progress materi. Mulai belajar sekarang!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quiz Attempts Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-title">Riwayat Kuis</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @forelse($quizAttempts as $attempt)
                    <div class="quiz-attempt-card">
                        <div class="quiz-header">
                            <h4>{{ $attempt->quiz->title }}</h4>
                            <span class="badge {{ $attempt->status == 'passed' ? 'badge-success' : 'badge-danger' }}">
                                {{ $attempt->status == 'passed' ? 'Lulus' : 'Gagal' }}
                            </span>
                        </div>
                        <div class="quiz-details">
                            <p><strong>Skor:</strong> {{ number_format($attempt->score, 1) }}%</p>
                            <p><strong>Poin:</strong> {{ $attempt->earned_points }}/{{ $attempt->total_points }}</p>
                            <p><strong>Waktu:</strong> {{ $attempt->completed_at ? $attempt->completed_at->format('d M Y H:i') : '-' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Belum ada riwayat kuis.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Practice Answers Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-title">Jawaban Latihan Terbaru</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @forelse($practiceAnswers as $answer)
                    <div class="practice-answer-card {{ $answer->is_correct ? 'correct' : 'incorrect' }}">
                        <div class="answer-header">
                            <h4>{{ $answer->practiceQuestion->material->title }}</h4>
                            <span class="badge {{ $answer->is_correct ? 'badge-success' : 'badge-danger' }}">
                                {{ $answer->is_correct ? 'Benar' : 'Salah' }}
                            </span>
                        </div>
                        <div class="answer-content">
                            <p><strong>Pertanyaan:</strong> {{ Str::limit($answer->practiceQuestion->question, 100) }}</p>
                            <p><strong>Jawaban Anda:</strong> {{ Str::limit($answer->user_answer, 100) }}</p>
                            <p class="text-muted"><small>{{ $answer->created_at->format('d M Y H:i') }}</small></p>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Belum ada jawaban latihan.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Load progress data
    fetch('{{ route("layanan.progress-tracking.data") }}')
        .then(response => response.json())
        .then(data => {
            // Category Progress Chart
            const categoryCtx = document.getElementById('categoryProgressChart').getContext('2d');
            const categoryLabels = Object.keys(data.progress_by_category);
            const completedData = categoryLabels.map(label => data.progress_by_category[label].completed);
            const inProgressData = categoryLabels.map(label => data.progress_by_category[label].in_progress);
            
            new Chart(categoryCtx, {
                type: 'bar',
                data: {
                    labels: categoryLabels,
                    datasets: [
                        {
                            label: 'Selesai',
                            data: completedData,
                            backgroundColor: 'rgba(40, 167, 69, 0.8)',
                        },
                        {
                            label: 'Sedang Belajar',
                            data: inProgressData,
                            backgroundColor: 'rgba(255, 193, 7, 0.8)',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Quiz Score Chart
            const quizCtx = document.getElementById('quizScoreChart').getContext('2d');
            new Chart(quizCtx, {
                type: 'line',
                data: {
                    labels: data.quiz_scores.map(item => item.date),
                    datasets: [{
                        label: 'Skor Kuis',
                        data: data.quiz_scores.map(item => item.score),
                        borderColor: 'rgba(23, 162, 184, 1)',
                        backgroundColor: 'rgba(23, 162, 184, 0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        });
</script>
<style>
    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
        margin-bottom: 20px;
    }
    .stat-icon {
        font-size: 30px;
        color: #007bff;
        margin-bottom: 10px;
    }
    .stat-content h3 {
        font-size: 28px;
        font-weight: bold;
        margin: 0;
    }
    .stat-content p {
        margin: 5px 0 0;
        color: #666;
    }
    .chart-container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .quiz-attempt-card {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 15px;
    }
    .quiz-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .practice-answer-card {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        border-left: 4px solid;
    }
    .practice-answer-card.correct {
        border-left-color: #28a745;
    }
    .practice-answer-card.incorrect {
        border-left-color: #dc3545;
    }
    .answer-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .section-title {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }
</style>
@endpush
