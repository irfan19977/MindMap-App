@extends('frontend.layouts.app')

@section('content')
<!-- Page Header-->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-title">Progress: {{ $material->title }}</h1>
                    <p class="page-description">{{ $material->subcategory?->category?->name ?? '' }} - {{ $material->subcategory?->name ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Progress Overview -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="progress-overview-card">
                    <h2>Progress Materi</h2>
                    <div class="progress-circle">
                        <div class="circular-progress" data-progress="{{ $progress->progress_percentage }}">
                            <span class="progress-value">{{ $progress->progress_percentage }}%</span>
                        </div>
                    </div>
                    <div class="progress-details">
                        <div class="detail-item">
                            <span class="label">Status:</span>
                            <span class="value">
                                @if($progress->completed_at)
                                    <span class="badge badge-success">Selesai</span>
                                @elseif($progress->progress_percentage > 0)
                                    <span class="badge badge-warning">Sedang Belajar</span>
                                @else
                                    <span class="badge badge-secondary">Belum Mulai</span>
                                @endif
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="label">Terakhir Diupdate:</span>
                            <span class="value">{{ $progress->updated_at?->format('d M Y H:i') ?? '-' }}</span>
                        </div>
                        @if($progress->completed_at)
                        <div class="detail-item">
                            <span class="label">Selesai Pada:</span>
                            <span class="value">{{ $progress->completed_at?->format('d M Y H:i') ?? '-' }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quiz Attempts for this Material -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-title">Riwayat Kuis - {{ $material->title }}</h2>
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
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <span class="label">Skor:</span>
                                    <span class="value">{{ number_format($attempt->score, 1) }}%</span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Poin:</span>
                                    <span class="value">{{ $attempt->earned_points }}/{{ $attempt->total_points }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Mulai:</span>
                                    <span class="value">{{ $attempt->started_at->format('d M Y H:i') }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Selesai:</span>
                                    <span class="value">{{ $attempt->completed_at ? $attempt->completed_at->format('d M Y H:i') : '-' }}</span>
                                </div>
                            </div>
                            @if($attempt->quiz->description)
                            <p class="quiz-description">{{ $attempt->quiz->description }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        Belum ada riwayat kuis untuk materi ini. <a href="{{ route('materi.show', $material->slug) }}" class="alert-link">Mulai kuis sekarang!</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Practice Answers for this Material -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-title">Jawaban Latihan - {{ $material->title }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @forelse($practiceAnswers as $answer)
                    <div class="practice-answer-card {{ $answer->is_correct ? 'correct' : 'incorrect' }}">
                        <div class="answer-header">
                            <h4>Pertanyaan #{{ $answer->practiceQuestion->order_number }}</h4>
                            <span class="badge {{ $answer->is_correct ? 'badge-success' : 'badge-danger' }}">
                                {{ $answer->is_correct ? 'Benar' : 'Salah' }}
                            </span>
                        </div>
                        <div class="answer-content">
                            <div class="question-text">
                                <strong>Pertanyaan:</strong>
                                <p>{{ $answer->practiceQuestion->question }}</p>
                            </div>
                            <div class="answer-text">
                                <strong>Jawaban Anda:</strong>
                                <p>{{ $answer->user_answer }}</p>
                            </div>
                            @if($answer->practiceQuestion->correct_answer)
                            <div class="correct-answer">
                                <strong>Jawaban Benar:</strong>
                                <p>{{ $answer->practiceQuestion->correct_answer }}</p>
                            </div>
                            @endif
                            @if($answer->practiceQuestion->explanation)
                            <div class="explanation">
                                <strong>Pembahasan:</strong>
                                <p>{{ $answer->practiceQuestion->explanation }}</p>
                            </div>
                            @endif
                            <p class="text-muted"><small>Dijawab pada: {{ $answer->created_at->format('d M Y H:i') }}</small></p>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        Belum ada jawaban latihan untuk materi ini. <a href="{{ route('materi.show', $material->slug) }}" class="alert-link">Mulai latihan sekarang!</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Back Button -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('layanan.progress-tracking') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali ke Dashboard Progress
                </a>
                <a href="{{ route('materi.show', $material->slug) }}" class="btn btn-primary">
                    <i class="fa fa-book"></i> Lanjut Belajar
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<style>
    .progress-overview-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        text-align: center;
    }
    .progress-circle {
        margin: 30px 0;
    }
    .circular-progress {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: conic-gradient(#007bff var(--progress), #e9ecef 0);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        position: relative;
    }
    .circular-progress::before {
        content: '';
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: white;
    }
    .progress-value {
        position: relative;
        font-size: 28px;
        font-weight: bold;
        color: #333;
    }
    .progress-details {
        margin-top: 20px;
    }
    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    .detail-item:last-child {
        border-bottom: none;
    }
    .detail-item .label {
        font-weight: 600;
        color: #666;
    }
    .detail-item .value {
        color: #333;
    }
    .quiz-attempt-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .quiz-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    .quiz-details .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }
    .quiz-description {
        color: #666;
        font-style: italic;
        margin-top: 10px;
    }
    .practice-answer-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        border-left: 5px solid;
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
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    .answer-content > div {
        margin-bottom: 15px;
    }
    .answer-content p {
        margin: 5px 0;
    }
    .correct-answer {
        color: #28a745;
    }
    .explanation {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }
    .section-title {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }
</style>
<script>
    // Set circular progress
    document.addEventListener('DOMContentLoaded', function() {
        const progressCircle = document.querySelector('.circular-progress');
        const progress = progressCircle.getAttribute('data-progress');
        progressCircle.style.setProperty('--progress', progress + '%');
    });
</script>
@endpush
