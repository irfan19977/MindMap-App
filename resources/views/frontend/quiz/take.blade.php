@extends('frontend.layouts.app')

@section('content')
<style>
    /* Mobile-specific fixes for quiz options */
    @media (max-width: 768px) {
        .option-marker {
            width: 32px !important;
            height: 32px !important;
            min-width: 32px !important;
        }

        .option-marker span {
            font-size: 13px !important;
            line-height: 1 !important;
            word-break: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .answer-indicator {
            font-size: 12px !important;
            line-height: 1 !important;
        }

        .option-item {
            padding: 10px !important;
        }

        .option-item span {
            font-size: 13px !important;
            line-height: 1.4 !important;
        }
    }

    /* General overflow fixes */
    .option-marker {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .option-marker span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    .answer-indicator {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        width: 100%;
        height: 100%;
    }
</style>

<section class="jarallax relative overflow-hidden z-1000 mt-80">
    <img src="{{ asset('frontend/images/background/1.webp') }}" class="jarallax-img" alt="">
    <div class="sw-overlay op-2"></div>
    <div class="gradient-edge-start light w-40 start-40 op-9 z-2"></div>
    <div class="abs w-40 h-100 bg-white top-0 start-0 op-9 z-2"></div>
    <div class="container relative z-2">
        <div class="row wow fadeInRight">
            <div class="col-lg-10">
                <h1 class="fs-sm-10vw mb-0">
                    {{ $quiz->title ?? 'Quiz' }}
                </h1>

                <ul class="crumb">
                    <li><a href="/">Home</a></li>
                    <li><a href="/kelas">Kelas</a></li>
                    <li><a href="/mindmap/{{ $quiz->material->subcategory->slug ?? '#' }}">{{ $quiz->material->subcategory->name ?? 'Subkategori' }}</a></li>
                    <li><a href="/materi/{{ $quiz->material->slug ?? '#' }}">{{ $quiz->material->title ?? 'Materi' }}</a></li>
                    <li class="active">Quiz</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-9 col-md-12">
                
                <!-- Quiz Container -->
                <div id="quiz-container">

                    <!-- Quiz Questions -->
                    <div id="quiz-questions">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3>Soal <span id="current-question">1</span> dari <span id="total-questions">{{ $quiz->quizQuestions->count() }}</span></h3>
                            @if($quiz->time_limit)
                            <div class="timer-display bg-color text-light rounded-1 px-3 py-2 shadow-sm">
                                <i class="ion-ios-time"></i>
                                <span id="timer" class="fw-bold">{{ $quiz->time_limit }}:00</span>
                            </div>
                            @endif
                        </div>

                        <div id="questions-container">
                            @foreach($quiz->quizQuestions as $index => $question)
                                <div class="question-card bg-light rounded-1 p-3 p-md-4 mb-4 overflow-hidden" data-question-index="{{ $index }}" data-question-id="{{ $question->id }}" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                                    <h4 class="mb-3 mb-md-4">Soal {{ $index + 1 }}</h4>
                                    <p class="fs-16 fs-md-18 mb-3 mb-md-4 text-break">{{ $question->question }}</p>

                                    @php
                                        $options = $question->options ?? [];
                                    @endphp

                                    <div class="options-container">
                                        @foreach($options as $optionIndex => $option)
                                            @php $loopIndex = $loop->index; @endphp
                                            <div class="option-item bg-white rounded-1 p-3 p-md-3 mb-3 cursor-pointer border-2 border-transparent hover:border-color transition"
                                                 data-question-index="{{ $index }}"
                                                 data-option-index="{{ $loopIndex }}">
                                                <div class="d-flex align-items-center">
                                                    <div class="option-marker rounded-circle bg-light me-2 me-md-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 35px; height: 35px; min-width: 35px;">
                                                        <span class="fw-bold fs-14 fs-md-16">{{ chr(65 + $loopIndex) }}</span>
                                                    </div>
                                                    <span class="fs-14 fs-md-16 text-break flex-grow-1">{{ $option }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <input type="hidden" name="answer-{{ $index }}" id="answer-{{ $index }}" value="">
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button id="prev-btn" class="btn-main bg-light text-dark" disabled>
                                <i class="ion-ios-arrow-back"></i> <span class="d-none d-md-inline">Sebelumnya</span><span class="d-md-none">Sebelumnya</span>
                            </button>

                            <!-- Mobile Question Navigation -->
                            <div id="mobile-question-nav" class="d-flex d-md-none align-items-center gap-2 overflow-auto" style="max-width: 200px;">
                                <!-- Mobile nav buttons will be generated by JS -->
                            </div>

                            <button id="next-btn" class="btn-main bg-color text-light">
                                <span class="d-none d-md-inline">Selanjutnya</span><span class="d-md-none">Selanjutnya</span> <i class="ion-ios-arrow-forward"></i>
                            </button>
                            <button id="submit-btn" class="btn-main bg-success text-light" style="display: none;">
                                <i class="ion-ios-checkmark"></i> Submit Quiz
                            </button>
                        </div>
                    </div>



                </div>

                <!-- Quiz Re-enter Fullscreen Modal -->
                <div id="quizReenterModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.95);z-index:9999;align-items:center;justify-content:center;">
                    <div style="background:#fff;padding:40px;border-radius:12px;max-width:500px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
                        <div style="font-size:60px;margin-bottom:20px;">⚠️</div>
                        <h3 style="margin:0 0 15px 0;color:#dc2626;">Fullscreen Dikeluarkan!</h3>
                        <p style="color:#6b7280;margin-bottom:25px;">Anda keluar dari mode fullscreen. Untuk melanjutkan quiz, silakan masuk kembali ke mode fullscreen.</p>
                        <div style="display:flex;gap:15px;justify-content:center;">
                            <button onclick="reenterFullscreen()" style="background:#7C815D;color:#fff;padding:12px 30px;border:none;border-radius:8px;cursor:pointer;font-size:16px;font-weight:600;">
                                Masuk Fullscreen
                            </button>
                            <button onclick="forceSubmitAndExit()" style="background:#dc2626;color:#fff;padding:12px 30px;border:none;border-radius:8px;cursor:pointer;font-size:16px;font-weight:600;">
                                Submit & Keluar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quiz Auto-submit Modal -->
                <div id="quizAutoSubmitModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.95);z-index:9999;align-items:center;justify-content:center;">
                    <div style="background:#fff;padding:40px;border-radius:12px;max-width:500px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
                        <div style="font-size:60px;margin-bottom:20px;">🚫</div>
                        <h3 id="modalTitle" style="margin:0 0 15px 0;color:#dc2626;">Jangan Pindah Tab!</h3>
                        <p id="modalMessage" style="color:#6b7280;margin-bottom:15px;">Anda terdeteksi meninggalkan halaman quiz. Quiz akan otomatis dikumpulkan dalam <span id="autoSubmitCountdown" style="font-weight:bold;color:#dc2626;font-size:24px;">3</span> detik.</p>
                        <p id="modalSubMessage" style="color:#f59e0b;font-size:14px;">Kembali ke halaman quiz sekarang untuk membatalkan auto-submit.</p>
                        <div id="modalButtons" style="display:flex;gap:15px;justify-content:center;margin-top:25px;">
                            <button onclick="continueQuiz()" style="background:#7C815D;color:#fff;padding:12px 30px;border:none;border-radius:8px;cursor:pointer;font-size:16px;font-weight:600;">
                                Lanjut Mengerjakan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quiz Warning Banner -->
                <div id="quizWarningBanner" style="display:none;position:fixed;top:0;left:0;width:100%;background:#dc2626;color:#fff;padding:15px;text-align:center;z-index:10000;font-weight:600;font-size:16px;"></div>

            </div>
            
            <!-- Question Navigation Sidebar -->
            <div class="col-lg-3 col-md-12">
                <div class="sticky-top" style="top: 100px;">
                    
                    <!-- Question Navigation Card -->
                    <div class="bg-white rounded-1 p-4 shadow-sm mb-4" style="border: 1px solid #e9ecef;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="fas fa-list-ol" style="color: #7C815D;"></i>
                            <h4 class="mb-0 fw-bold" style="color: #7C815D;">Navigasi Soal</h4>
                        </div>
                        <p class="text-muted small mb-3">Pilih nomor untuk berpindah soal</p>
                        
                        <div id="question-nav" class="d-flex flex-wrap gap-2 mb-4">
                            @foreach($quiz->quizQuestions as $index => $question)
                                <button class="question-nav-btn rounded-circle border-2 fw-bold"
                                        data-question-index="{{ $index }}"
                                        data-visited="false"
                                        style="width: 45px; height: 45px; min-width: 45px; font-size: 1rem; transition: all 0.3s ease; background-color: white; border-color: #dee2e6; color: #495057;">
                                    {{ $index + 1 }}
                                </button>
                            @endforeach
                        </div>
                        
                        <div class="border-top pt-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="rounded-circle" style="width: 16px; height: 16px; background-color: #7C815D;"></div>
                                <small class="text-muted">Sudah dijawab</small>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="rounded-circle border-2" style="width: 16px; height: 16px; border-color: #7C815D; background-color: #e9ecef;"></div>
                                <small class="text-muted">Sudah dikunjungi</small>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="rounded-circle border-2" style="width: 16px; height: 16px; border-color: #dee2e6; background-color: white;"></div>
                                <small class="text-muted">Belum dikunjungi</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tip Card -->
                    <div class="bg-white rounded-1 p-4 shadow-sm" style="border: 1px solid #e9ecef;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="fas fa-lightbulb" style="color: #ffc107;"></i>
                            <h4 class="mb-0 fw-bold" style="color: #7C815D;">Kerjakan dengan teliti</h4>
                        </div>
                        <p class="text-muted small mb-0">Pastikan jawaban terbaikmu sebelum melanjutkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Global functions for modal buttons
let autoSubmitCountdownInterval = null;
let visibilitySubmitPending = false;
let tabSwitchCount = 0;

function continueQuiz() {
    clearInterval(autoSubmitCountdownInterval);
    visibilitySubmitPending = false;
    document.getElementById('quizAutoSubmitModal').style.display = 'none';
}

function submitQuizFromModal() {
    clearInterval(autoSubmitCountdownInterval);
    document.getElementById('quizAutoSubmitModal').style.display = 'none';
    // Trigger submit by dispatching click on submit button
    document.getElementById('submit-btn').click();
}

function reenterFullscreen() {
    document.getElementById('quizReenterModal').style.display = 'none';
    const el = document.documentElement;
    if (el.requestFullscreen) el.requestFullscreen();
    else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
}

function forceSubmitAndExit() {
    document.getElementById('quizReenterModal').style.display = 'none';
    document.getElementById('submit-btn').click();
}

document.addEventListener('DOMContentLoaded', function() {
    const quizId = '{{ $quiz->id }}';
    const totalQuestions = {{ $quiz->quizQuestions->count() }};
    const timeLimit = {{ $quiz->time_limit ?? 0 }};
    let currentQuestion = 0;
    let answers = {};
    let quizStarted = false;
    let timerInterval;
    let timeRemaining = timeLimit * 60;
    let serverStartedAt = null;

    // Quiz lockdown variables - moved before early return
    let quizActive = false;
    let quizTimerInterval = null;
    let quizSecondsLeft = 0;

    // Elements - moved before early return
    const quizQuestions = document.getElementById('quiz-questions');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const submitBtn = document.getElementById('submit-btn');

    const currentQuestionSpan = document.getElementById('current-question');
    const totalQuestionsSpan = document.getElementById('total-questions');

    // Check if user has a completed attempt (read-only mode) and if not retrying
    const urlParams = new URLSearchParams(window.location.search);
    const isRetrying = urlParams.get('retry') === 'true';

    // Check localStorage for existing timer state (for page refresh persistence)
    const localStorageStartedAt = localStorage.getItem(`quiz_${quizId}_started_at`);
    const localStorageTimeLimit = localStorage.getItem(`quiz_${quizId}_time_limit`);

    @if(isset($currentAttempt) && $currentAttempt)
        // If there's an in-progress attempt, use its started_at time
        serverStartedAt = new Date('{{ $currentAttempt->started_at->toIso8601String() }}');
        const now = new Date();
        const elapsedSeconds = Math.floor((now - serverStartedAt) / 1000);
        const totalSeconds = {{ $timeLimit ?? 0 }} * 60;
        timeRemaining = Math.max(0, totalSeconds - elapsedSeconds);

        // Update localStorage with server data
        localStorage.setItem(`quiz_${quizId}_started_at`, '{{ $currentAttempt->started_at->toIso8601String() }}');
        localStorage.setItem(`quiz_${quizId}_time_limit`, {{ $timeLimit ?? 0 }});

        console.log('Timer restored from server attempt:', {
            startedAt: '{{ $currentAttempt->started_at->toIso8601String() }}',
            timeLimit: {{ $timeLimit ?? 0 }},
            elapsedSeconds,
            timeRemaining
        });

        // Auto-start quiz if there's an in-progress attempt
        quizStarted = true;
        quizActive = true;

        // Initialize history state manipulation for in-progress quiz
        pushHistoryState();
        window.addEventListener('popstate', handlePopState);

        updateQuestionDisplay();
        initMobileNavigation();
        if (timeRemaining > 0) {
            startTimer();
        } else {
            // Time already expired, auto-submit
            submitQuiz(true);
        }
    @elseif(!isset($completedAttempt))
        // Only restore from localStorage if there's no completed attempt and no in-progress attempt
        if (localStorageStartedAt && localStorageTimeLimit && !isRetrying) {
            // Calculate remaining time from localStorage
            serverStartedAt = new Date(localStorageStartedAt);
            const now = new Date();
            const elapsedSeconds = Math.floor((now - serverStartedAt) / 1000);
            const totalSeconds = parseInt(localStorageTimeLimit) * 60;
            timeRemaining = Math.max(0, totalSeconds - elapsedSeconds);

            console.log('Timer restored from localStorage:', {
                startedAt: localStorageStartedAt,
                timeLimit: localStorageTimeLimit,
                elapsedSeconds,
                timeRemaining
            });
        }
    @endif

    @if(isset($completedAttempt))
        if (!isRetrying) {
            console.log('Completed attempt found:', '{{ $completedAttempt->id }}');
            loadCompletedAttempt('{{ $completedAttempt->id }}');
            return; // Stop here - don't add lockdown event listeners
        }
    @endif

    function loadCompletedAttempt(attemptId) {
        console.log('Loading completed attempt for read-only mode:', attemptId);

        // Fetch attempt data first to get score
        fetch(`/api/quiz/attempt/${attemptId}`)
            .then(response => response.json())
            .then(data => {
                console.log('Completed attempt data received:', data);
                const quizAnswers = data.quizAnswers || [];
                const score = data.score || 0;
                const status = data.status || 'failed';
                const isPassed = status === 'passed';

                // Update header for read-only mode with score
                const quizHeader = document.querySelector('.d-flex.justify-content-between.align-items-center.mb-4');
                const scoreColor = isPassed ? 'text-success' : 'text-danger';
                const scoreText = isPassed ? 'Lulus' : 'Tidak Lulus';
                quizHeader.innerHTML = `
                    <div>
                        <h3 class="mb-0">Hasil Jawaban Anda</h3>
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <span class="badge ${isPassed ? 'bg-success' : 'bg-danger'} fs-14">${scoreText}</span>
                            <span class="${scoreColor} fw-bold">Skor: ${Math.round(score)}</span>
                        </div>
                    </div>
                `;

                // Hide timer
                const timerElement = document.querySelector('.timer-display');
                if (timerElement) timerElement.style.display = 'none';

                // Add action buttons for read-only mode
                const buttonContainer = document.querySelector('.d-flex.justify-content-between.mt-4');
                const buttonText = isPassed ? 'Lanjut Belajar' : 'Coba Lagi';
                const buttonIcon = isPassed ? 'ion-ios-arrow-forward' : 'ion-ios-refresh';
                buttonContainer.innerHTML = `
                    <button id="prev-btn" class="btn-main bg-light text-dark" disabled>
                        <i class="ion-ios-arrow-back"></i> <span class="d-none d-md-inline">Kembali ke Materi</span><span class="d-md-none">Sebelumnya</span>
                    </button>

                    <!-- Mobile Question Navigation -->
                    <div id="mobile-question-nav" class="d-flex d-md-none align-items-center gap-2 overflow-auto" style="max-width: 200px;">
                        <!-- Mobile nav buttons will be generated by JS -->
                    </div>

                    <button id="next-btn" class="btn-main bg-color text-light">
                        <span class="d-none d-md-inline">${buttonText}</span><span class="d-md-none">${buttonText}</span> <i class="${buttonIcon}"></i>
                    </button>
                `;

                // Process each question card for read-only mode
                document.querySelectorAll('.question-card').forEach((card, index) => {
                    const questionId = card.getAttribute('data-question-id');

                    // Find the answer for this specific question by ID
                    const questionAnswer = quizAnswers.find(answer =>
                        answer.quiz_question && answer.quiz_question.id == questionId
                    );

                    const userAnswer = questionAnswer ? questionAnswer.user_answer : null;
                    const correctAnswer = questionAnswer && questionAnswer.quiz_question ? questionAnswer.quiz_question.correct_answer : null;
                    const isCorrect = questionAnswer ? questionAnswer.is_correct : false;

                    // Disable option clicking in read-only mode
                    card.querySelectorAll('.option-item').forEach(option => {
                        option.style.cursor = 'default';
                        option.style.pointerEvents = 'none';

                        const optionIndex = parseInt(option.getAttribute('data-option-index'));
                        const optionLetter = String.fromCharCode(97 + optionIndex);

                        // Highlight user's answer with "Sudah dijawab" color
                        if (userAnswer === optionLetter) {
                            option.classList.add('border-color');
                            option.classList.remove('border-transparent');

                            // Add checkmark or cross indicator
                            const indicator = document.createElement('span');
                            indicator.className = 'answer-indicator ms-2';
                            indicator.textContent = isCorrect ? '✓' : '✗';
                            option.querySelector('.d-flex').appendChild(indicator);
                        }

                        // Highlight correct answer (if different from user's answer) with simple checkmark
                        if (correctAnswer === optionLetter && userAnswer !== optionLetter) {
                            const indicator = document.createElement('span');
                            indicator.className = 'answer-indicator ms-2 text-success';
                            indicator.textContent = '✓';
                            option.querySelector('.d-flex').appendChild(indicator);
                        }
                    });

                    // Show only first question in read-only mode
                    card.style.display = index === 0 ? 'block' : 'none';
                });

                // Initialize question display for read-only mode
                currentQuestion = 0;
                updateQuestionDisplay();
                initMobileNavigation();

                // Re-attach event listeners for navigation buttons in read-only mode
                const prevBtn = document.getElementById('prev-btn');
                const nextBtn = document.getElementById('next-btn');

                if (prevBtn) {
                    prevBtn.addEventListener('click', function() {
                        // Check if desktop mode (window width >= 768px)
                        if (window.innerWidth >= 768) {
                            // Desktop: go back to material
                            window.location.href = '/materi/{{ $quiz->material->slug ?? '#' }}';
                        } else {
                            // Mobile: go to previous question
                            if (currentQuestion > 0) {
                                currentQuestion--;
                                updateQuestionDisplay();
                            }
                        }
                    });
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', function() {
                        // Check if desktop mode (window width >= 768px)
                        if (window.innerWidth >= 768) {
                            // Desktop: if not passed, retry quiz; otherwise go to mindmap
                            if (!isPassed) {
                                window.location.href = window.location.pathname + '?retry=true';
                            } else {
                                window.location.href = '/mindmap/{{ $quiz->material->subcategory->slug ?? '#' }}';
                            }
                        } else {
                            // Mobile: go to next question
                            if (currentQuestion < totalQuestions - 1) {
                                currentQuestion++;
                                updateQuestionDisplay();
                            }
                        }
                    });
                }

                // Re-enable navigation for read-only mode and update colors based on results
                document.querySelectorAll('.question-nav-btn').forEach(btn => {
                    btn.style.pointerEvents = 'auto';
                    btn.style.cursor = 'pointer';

                    const questionIndex = parseInt(btn.getAttribute('data-question-index'));
                    const card = document.querySelector(`.question-card[data-question-index="${questionIndex}"]`);
                    const questionId = card ? card.getAttribute('data-question-id') : null;

                    // Find the answer for this question
                    const questionAnswer = quizAnswers.find(answer =>
                        answer.quiz_question && answer.quiz_question.id == questionId
                    );

                    if (questionAnswer) {
                        // Style based on correctness - use consistent olive green
                        if (questionAnswer.is_correct) {
                            btn.style.backgroundColor = '#7C815D'; // Olive green for correct
                            btn.style.color = 'white';
                            btn.style.borderColor = '#7C815D';
                        } else {
                            btn.style.backgroundColor = '#dc3545'; // Red for incorrect
                            btn.style.color = 'white';
                            btn.style.borderColor = '#dc3545';
                        }
                    } else {
                        // Unanswered
                        btn.style.backgroundColor = '#f8f9fa';
                        btn.style.color = '#495057';
                        btn.style.borderColor = '#dee2e6';
                    }

                    // Add click event listener for navigation in read-only mode
                    btn.addEventListener('click', function() {
                        const questionIndex = parseInt(this.getAttribute('data-question-index'));
                        currentQuestion = questionIndex;
                        updateQuestionDisplay();
                    });
                });

                // Disable quiz lockdown for read-only mode
                quizActive = false;
                tabSwitchCount = 0;
                visibilitySubmitPending = false;

                // Hide any visible modals
                const autoSubmitModal = document.getElementById('quizAutoSubmitModal');
                const reenterModal = document.getElementById('quizReenterModal');
                if (autoSubmitModal) autoSubmitModal.style.display = 'none';
                if (reenterModal) reenterModal.style.display = 'none';

                console.log('Quiz lockdown disabled for read-only mode');
            })
            .catch(error => {
                console.error('Error loading completed attempt:', error);
            });
    }

    // Initialize mobile navigation
    function initMobileNavigation() {
        const mobileNav = document.getElementById('mobile-question-nav');
        if (!mobileNav) {
            console.log('Mobile nav element not found');
            return;
        }

        console.log('Initializing mobile navigation, current question:', currentQuestion, 'total questions:', totalQuestions);

        mobileNav.innerHTML = '';

        // Pagination logic: show 3 numbers at a time based on current position
        const itemsPerPage = 3;
        const currentPage = Math.floor(currentQuestion / itemsPerPage);
        const startPage = currentPage * itemsPerPage;
        const endPage = Math.min(startPage + itemsPerPage - 1, totalQuestions - 1);

        console.log('Showing questions from', startPage, 'to', endPage);

        for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement('button');
            btn.className = 'mobile-nav-btn btn btn-sm rounded-circle';
            btn.style.width = '35px';
            btn.style.height = '35px';
            btn.style.minWidth = '35px';
            btn.style.padding = '0';
            btn.style.fontSize = '0.875rem';
            btn.style.fontWeight = 'bold';
            btn.textContent = i + 1;
            btn.dataset.questionIndex = i;

            if (i === currentQuestion) {
                btn.style.backgroundColor = '#7C815D';
                btn.style.color = 'white';
                btn.style.borderColor = '#7C815D';
            } else if (answers[i] !== undefined && answers[i] !== '') {
                btn.style.backgroundColor = '#7C815D';
                btn.style.color = 'white';
                btn.style.borderColor = '#7C815D';
                btn.style.opacity = '0.7';
            } else {
                btn.style.backgroundColor = '#f8f9fa';
                btn.style.color = '#495057';
                btn.style.borderColor = '#dee2e6';
            }

            btn.addEventListener('click', function() {
                currentQuestion = parseInt(this.dataset.questionIndex);
                updateQuestionDisplay();
            });

            mobileNav.appendChild(btn);
        }

        console.log('Mobile navigation initialized with', mobileNav.children.length, 'buttons');
    }

    // Start quiz automatically on page load
    fetch('/api/quiz/start', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            quiz_id: quizId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            quizStarted = true;
            quizActive = true;

            // Initialize history state manipulation when quiz starts
            pushHistoryState();
            window.addEventListener('popstate', handlePopState);

            // Store server start time and calculate remaining time
            if (data.started_at) {
                serverStartedAt = new Date(data.started_at);
                const now = new Date();
                const elapsedSeconds = Math.floor((now - serverStartedAt) / 1000);
                const totalSeconds = (data.time_limit || timeLimit) * 60;
                timeRemaining = Math.max(0, totalSeconds - elapsedSeconds);

                // Save to localStorage for persistence
                localStorage.setItem(`quiz_${quizId}_started_at`, data.started_at);
                localStorage.setItem(`quiz_${quizId}_time_limit`, data.time_limit || timeLimit);
            }

            // Remove retry parameter from URL after quiz starts
            if (isRetrying) {
                const url = new URL(window.location);
                url.searchParams.delete('retry');
                window.history.replaceState({}, '', url);
            }

            updateQuestionDisplay();
            initMobileNavigation();
            if (timeLimit > 0 && timeRemaining > 0) {
                startTimer();
            } else if (timeRemaining <= 0) {
                // Time already expired, auto-submit
                submitQuiz(true);
            }
        } else {
            console.error('Failed to start quiz:', data.message);
            alert('Gagal memulai quiz: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error starting quiz:', error);
        alert('Terjadi kesalahan saat memulai quiz');
    });

    // Option selection
    document.querySelectorAll('.option-item').forEach(option => {
        option.addEventListener('click', function() {
            const questionIndex = parseInt(this.getAttribute('data-question-index'));
            const optionIndex = parseInt(this.getAttribute('data-option-index'));
            
            // Remove selected class from all options in this question
            document.querySelectorAll(`.option-item[data-question-index="${questionIndex}"]`).forEach(opt => {
                opt.classList.remove('border-color', 'bg-color-op-1');
                opt.classList.add('border-transparent');
            });
            
            // Add selected class to clicked option
            this.classList.remove('border-transparent');
            this.classList.add('border-color', 'bg-color-op-1');
            
            // Save answer as letter (a, b, c, d) to match database format
            const answerLetter = String.fromCharCode(97 + optionIndex); // 97 = 'a'
            console.log('Answer saved:', {
                questionIndex,
                optionIndex,
                answerLetter,
                answers
            });
            answers[questionIndex] = answerLetter;
            document.getElementById(`answer-${questionIndex}`).value = answerLetter;
            
            // Update navigation button
            updateQuestionNavButton(questionIndex, true);
            initMobileNavigation();
        });
    });

    // Question navigation
    document.querySelectorAll('.question-nav-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const questionIndex = parseInt(this.getAttribute('data-question-index'));
            currentQuestion = questionIndex;
            updateQuestionDisplay();
        });
    });

    // Navigation
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            // Check if in read-only mode (has score badge)
            const isReadOnlyMode = document.querySelector('.badge.bg-success') || document.querySelector('.badge.bg-danger');

            if (isReadOnlyMode) {
                // Read-only mode: check if desktop mode
                if (window.innerWidth >= 768) {
                    // Desktop: go back to material
                    window.location.href = '/materi/{{ $quiz->material->slug ?? '#' }}';
                } else {
                    // Mobile: go to previous question
                    if (currentQuestion > 0) {
                        currentQuestion--;
                        updateQuestionDisplay();
                    }
                }
            } else {
                // Quiz mode: go to previous question
                if (currentQuestion > 0) {
                    currentQuestion--;
                    updateQuestionDisplay();
                }
            }
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            // Check if in read-only mode (has score badge)
            const isReadOnlyMode = document.querySelector('.badge.bg-success') || document.querySelector('.badge.bg-danger');

            if (isReadOnlyMode) {
                // Read-only mode: check if desktop mode
                if (window.innerWidth >= 768) {
                    // Desktop: if not passed, retry quiz; otherwise go to mindmap
                    if (!isPassed) {
                        window.location.href = window.location.pathname + '?retry=true';
                    } else {
                        window.location.href = '/mindmap/{{ $quiz->material->subcategory->slug ?? '#' }}';
                    }
                } else {
                    // Mobile: go to next question
                    if (currentQuestion < totalQuestions - 1) {
                        currentQuestion++;
                        updateQuestionDisplay();
                    }
                }
            } else {
                // Quiz mode: go to next question
                if (currentQuestion < totalQuestions - 1) {
                    currentQuestion++;
                    updateQuestionDisplay();
                }
            }
        });
    }

    if (submitBtn) {
        submitBtn.addEventListener('click', function() {
            submitQuiz();
        });
    }

    function startTimer() {
        const timerElement = document.getElementById('timer');
        if (!timerElement) return;

        // Initialize timer display with current remaining time
        const initialMinutes = Math.floor(timeRemaining / 60);
        const initialSeconds = timeRemaining % 60;
        timerElement.textContent = `${initialMinutes}:${initialSeconds.toString().padStart(2, '0')}`;

        // Change color if time is already running low
        if (timeRemaining <= 60) {
            timerElement.parentElement.classList.remove('bg-color');
            timerElement.parentElement.classList.add('bg-danger');
        }

        timerInterval = setInterval(() => {
            timeRemaining--;

            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

            // Change color when time is running low
            if (timeRemaining <= 60) {
                timerElement.parentElement.classList.remove('bg-color');
                timerElement.parentElement.classList.add('bg-danger');
            }

            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                timerElement.textContent = '0:00';
                // Auto-submit when time is up
                submitQuiz(true);
            }
        }, 1000);
    }

    function submitQuiz(isAutoSubmit = false) {
        // Read answers from hidden inputs to ensure we have the latest values
        for (let i = 0; i < totalQuestions; i++) {
            const hiddenInput = document.getElementById(`answer-${i}`);
            if (hiddenInput) {
                // Always include the answer value, even if empty
                answers[i] = hiddenInput.value || '';
            }
        }
        
        // Check if all questions are answered
        const answeredCount = Object.keys(answers).filter(key => answers[key] !== '').length;
        
        // Debug: check answers before submission
        console.log('Answers object:', answers);
        console.log('Answered count:', answeredCount);
        console.log('Total questions:', totalQuestions);
        
        const performSubmission = () => {
            // Clear timer if running
            if (timerInterval) {
                clearInterval(timerInterval);
            }

            // Remove history state manipulation when quiz is submitted
            quizActive = false;
            window.removeEventListener('popstate', handlePopState);
            window.removeEventListener('beforeunload', quizBeforeUnload);

            // Debug: log answers before sending
            console.log('Submitting answers:', answers);
            console.log('Answers as JSON:', JSON.stringify(answers));
            console.log('Quiz ID:', quizId);

            // Validate that we have answers (skip for auto-submit)
            const hasAnyAnswers = Object.values(answers).some(answer => answer !== '');
            if (!isAutoSubmit && !hasAnyAnswers) {
                console.error('No answers to submit!');
                alert('Tidak ada jawaban yang terkirim. Silakan pilih jawaban terlebih dahulu.');
                return;
            }

            // Submit quiz via API
            fetch('/api/quiz/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    quiz_id: quizId,
                    answers: answers
                })
            })
            .then(response => {
                console.log('Submit response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Quiz submit response:', data);
                if (data.success) {
                    // End quiz lockdown
                    endQuiz();

                    // Show success message with professional design
                    const score = data.score || 0;
                    const isPassed = data.status === 'passed';
                    const titleText = isPassed ? 'Selamat! Anda Lulus' : 'Teruslah Belajar';
                    const messageText = isPassed
                        ? 'Kerja bagus! Anda telah menyelesaikan quiz dengan baik.'
                        : 'Jangan menyerah! Tinjau jawaban Anda untuk belajar dari kesalahan.';

                    Swal.fire({
                        title: titleText,
                        html: `
                            <div style="text-align: center; padding: 1rem 0;">
                                <div style="
                                    font-size: 4rem;
                                    font-weight: bold;
                                    color: ${isPassed ? '#28a745' : '#dc3545'};
                                    margin: 1rem 0;
                                    line-height: 1;
                                ">
                                    ${Math.round(score)}
                                </div>
                                <p style="color: #6c757d; margin: 0; font-size: 1.1rem;">Nilai Anda</p>
                                <p style="color: #495057; margin: 1.5rem 0 0 0; font-size: 0.95rem; line-height: 1.5;">
                                    ${messageText}
                                </p>
                            </div>
                        `,
                        showConfirmButton: true,
                        confirmButtonText: 'Lihat Detail',
                        confirmButtonColor: '#7C815D',
                        customClass: {
                            popup: 'rounded-2',
                            confirmButton: 'btn-main'
                        }
                    }).then(() => {
                        // Reload the page without retry parameter to show the completed attempt in read-only mode
                        window.location.href = window.location.pathname;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Gagal mengirim jawaban',
                        confirmButtonColor: '#7C815D'
                    });
                }
            })
            .catch(error => {
                console.error('Error submitting quiz:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengirim jawaban: ' + (error.message || 'Unknown error'),
                    confirmButtonColor: '#7C815D'
                });
            });
        };

        if (isAutoSubmit) {
            // Directly submit without confirmation dialog for auto-submit scenarios
            performSubmission();
        } else if (answeredCount < totalQuestions) {
            Swal.fire({
                icon: 'question',
                title: 'Belum Selesai',
                text: `Anda baru menjawab ${answeredCount} dari ${totalQuestions} soal. Yakin ingin submit?`,
                showCancelButton: true,
                confirmButtonText: 'Ya, Submit',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#7C815D',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    performSubmission();
                }
            });
        } else {
            Swal.fire({
                icon: 'question',
                title: 'Konfirmasi Submit',
                text: 'Apakah Anda yakin ingin mengirim jawaban quiz?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Submit',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#7C815D',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    performSubmission();
                }
            });
        }
    }

    function updateQuestionNavButton(questionIndex, isAnswered) {
        const navBtn = document.querySelector(`.question-nav-btn[data-question-index="${questionIndex}"]`);
        if (navBtn) {
            if (isAnswered) {
                navBtn.style.backgroundColor = '#7C815D';
                navBtn.style.color = 'white';
                navBtn.style.borderColor = '#7C815D';
            } else if (navBtn.dataset.visited === 'true') {
                // Visited but not answered - use grey background with green border
                navBtn.style.backgroundColor = '#e9ecef';
                navBtn.style.color = '#495057';
                navBtn.style.borderColor = '#7C815D';
            } else {
                navBtn.style.backgroundColor = 'white';
                navBtn.style.color = '#495057';
                navBtn.style.borderColor = '#dee2e6';
            }
        }
    }

    function updateCurrentQuestionNav() {
        // Remove active class from all nav buttons
        document.querySelectorAll('.question-nav-btn').forEach(btn => {
            btn.classList.remove('ring-2', 'ring-offset-2', 'ring-primary');
            btn.style.boxShadow = '';
        });

        // Add active class to current question
        const currentNavBtn = document.querySelector(`.question-nav-btn[data-question-index="${currentQuestion}"]`);
        if (currentNavBtn) {
            currentNavBtn.classList.add('ring-2', 'ring-offset-2', 'ring-primary');
            currentNavBtn.style.boxShadow = '0 0 0 3px rgba(124, 129, 93, 0.3)';

            // Check if we're in read-only mode (has red or green set from completed attempt)
            const isReadOnlyMode = document.querySelector('.badge.bg-success') || document.querySelector('.badge.bg-danger');

            // Only mark as visited (without changing color) if NOT in read-only mode
            if (!isReadOnlyMode && currentNavBtn.dataset.visited === 'false' && !answers[currentQuestion]) {
                currentNavBtn.dataset.visited = 'true';
                // Don't change color in quiz mode - only change when answered
            }
        }
    }

    function updateQuestionDisplay() {
        // Hide all questions
        document.querySelectorAll('.question-card').forEach(card => {
            card.style.display = 'none';
        });

        // Show current question
        document.querySelector(`.question-card[data-question-index="${currentQuestion}"]`).style.display = 'block';

        // Update question counter
        currentQuestionSpan.textContent = currentQuestion + 1;

        // Update navigation
        updateCurrentQuestionNav();
        initMobileNavigation();

        // Check if we're in read-only mode (has score badge)
        const isReadOnlyMode = document.querySelector('.badge.bg-success') || document.querySelector('.badge.bg-danger');

        if (isReadOnlyMode) {
            // Read-only mode - simple navigation without submit button
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            const mobileNav = document.getElementById('mobile-question-nav');

            if (prevBtn) {
                prevBtn.style.display = 'inline-block';
                prevBtn.disabled = currentQuestion === 0;
            }

            if (nextBtn) {
                nextBtn.style.display = 'inline-block';
                nextBtn.disabled = currentQuestion === totalQuestions - 1;
            }

            // Ensure mobile navigation is visible in read-only mode
            if (mobileNav) {
                mobileNav.style.display = 'flex';
            }
        } else {
            // Active quiz mode
            prevBtn.disabled = currentQuestion === 0;

            if (currentQuestion === totalQuestions - 1) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'inline-block';
            } else {
                nextBtn.style.display = 'inline-block';
                nextBtn.disabled = false;
                submitBtn.style.display = 'none';
            }
        }
    }



    // Prevent leaving page during quiz
    function quizBeforeUnload(e) {
        if (!quizActive) return;
        e.preventDefault();
        e.returnValue = 'Quiz sedang berlangsung. Yakin ingin meninggalkan halaman?';
        return e.returnValue;
    }
    window.addEventListener('beforeunload', quizBeforeUnload);

    // Prevent back button navigation using History API
    function pushHistoryState() {
        if (!quizActive) return;
        history.pushState(null, null, document.URL);
    }

    // Handle popstate (back button) event
    function handlePopState(e) {
        if (!quizActive) return;
        e.preventDefault();
        e.stopPropagation();

        // Show warning modal
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Tombol kembali dinonaktifkan selama quiz. Gunakan tombol navigasi di dalam quiz.',
            confirmButtonColor: '#7C815D',
            allowOutsideClick: false
        }).then(() => {
            // Push state again to prevent going back
            pushHistoryState();
        });

        // Push state again to prevent going back
        pushHistoryState();
    }

    // Detect ESC / fullscreen exit during quiz
    document.addEventListener('fullscreenchange', handleFullscreenChange);
    document.addEventListener('webkitfullscreenchange', handleFullscreenChange);

    function handleFullscreenChange() {
        if (!quizActive) return;
        const isFullscreen = !!(document.fullscreenElement || document.webkitFullscreenElement);
        if (!isFullscreen) {
            // User exited fullscreen — show re-enter prompt
            document.getElementById('quizReenterModal').style.display = 'flex';
        }
    }

    // Detect tab switch / minimize
    function quizVisibilityChange() {
        if (!quizActive || visibilitySubmitPending) return;
        if (document.hidden) {
            tabSwitchCount++;
            visibilitySubmitPending = true;

            const modal = document.getElementById('quizAutoSubmitModal');
            const countdownEl = document.getElementById('autoSubmitCountdown');

            // Check if modal exists
            if (!modal) {
                console.error('quizAutoSubmitModal not found');
                return;
            }

            const remainingChances = 3 - tabSwitchCount;

            if (tabSwitchCount >= 3) {
                // Auto-submit after 3 chances with countdown
                modal.style.display = 'flex';
                const h3 = modal.querySelector('h3');
                const p = modal.querySelector('p');
                const subP = modal.querySelector('#modalSubMessage');
                const buttonsDiv = modal.querySelector('#modalButtons');
                if (h3) h3.textContent = 'Kesempatan Habis!';
                if (p) p.innerHTML = 'Anda telah melebihi batas pindah tab (3 kali). Quiz akan otomatis dikumpulkan dalam <span id="finalCountdown" style="font-weight:bold;color:#dc2626;font-size:24px;">3</span> detik.';
                if (subP) subP.style.display = 'none';
                if (buttonsDiv) buttonsDiv.style.display = 'none';
                
                let secs = 3;
                const finalCountdownEl = document.getElementById('finalCountdown');
                if (finalCountdownEl) finalCountdownEl.textContent = secs;
                
                autoSubmitCountdownInterval = setInterval(function() {
                    secs--;
                    if (finalCountdownEl) finalCountdownEl.textContent = secs;
                    if (secs <= 0) {
                        clearInterval(autoSubmitCountdownInterval);
                        modal.style.display = 'none';
                        submitQuiz(true);
                    }
                }, 1000);
            } else {
                // Show warning with remaining chances
                modal.style.display = 'flex';
                const h3 = modal.querySelector('h3');
                const p = modal.querySelector('p');
                if (h3) h3.textContent = 'Jangan Pindah Tab!';
                if (p) p.innerHTML = `Anda terdeteksi meninggalkan halaman quiz. Kesempatan tersisa: <strong>${remainingChances}</strong> dari 3 kali.`;
                if (countdownEl && countdownEl.parentElement) countdownEl.parentElement.style.display = 'none';
                // Removed auto-close countdown - modal stays open until user clicks "Lanjut Mengerjakan" or returns to tab
            }
        } else {
            // User returned to tab - close modal
            if (visibilitySubmitPending && tabSwitchCount < 3) {
                if (autoSubmitCountdownInterval) {
                    clearInterval(autoSubmitCountdownInterval);
                }
                visibilitySubmitPending = false;
                const modal = document.getElementById('quizAutoSubmitModal');
                if (modal) modal.style.display = 'none';
            }
        }
    }

    // Only add visibility listener if not in read-only mode
    const isReadOnlyMode = document.querySelector('.badge.bg-success') || document.querySelector('.badge.bg-danger');
    if (!isReadOnlyMode) {
        document.addEventListener('visibilitychange', quizVisibilityChange);
    }

    function endQuiz() {
        // Set false FIRST before any async ops so all listeners bail early
        quizActive = false;
        tabSwitchCount = 0;
        clearInterval(timerInterval);
        clearInterval(autoSubmitCountdownInterval);

        // Remove all lockdown listeners immediately
        window.removeEventListener('beforeunload', quizBeforeUnload);
        document.removeEventListener('visibilitychange', quizVisibilityChange);
        document.removeEventListener('fullscreenchange', handleFullscreenChange);
        document.removeEventListener('webkitfullscreenchange', handleFullscreenChange);

        document.getElementById('quizReenterModal').style.display = 'none';
        document.getElementById('quizAutoSubmitModal').style.display = 'none';

        // Clear localStorage timer data
        localStorage.removeItem(`quiz_${quizId}_started_at`);
        localStorage.removeItem(`quiz_${quizId}_time_limit`);

        // Exit fullscreen after listeners removed so fullscreenchange won't trigger re-enter modal
        if (document.fullscreenElement || document.webkitFullscreenElement) {
            if (document.exitFullscreen) document.exitFullscreen();
            else if (document.webkitExitFullscreen) document.webkitExitFullscreen();
        }
    }
});
</script>

<style>
.option-item {
    cursor: pointer;
    transition: all 0.3s ease;
}

.option-item:hover {
    transform: translateX(5px);
}

.option-item.border-color {
    border-color: #7C815D !important;
    background-color: #7C815D !important;
    color: white !important;
}

/* Answer feedback styles */
.option-item.border-success {
    border-color: #28a745 !important;
    color: #155724 !important;
}

.option-item.bg-success-op-1 {
    background-color: rgba(40, 167, 69, 0.1) !important;
}

.option-item.border-danger {
    border-color: #dc3545 !important;
    color: #721c24 !important;
}

.option-item.bg-danger-op-1 {
    background-color: rgba(220, 53, 69, 0.1) !important;
}

.option-marker {
    width: 35px;
    height: 35px;
    min-width: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    font-weight: bold;
    color: #7C815D;
}

.option-item.border-color .option-marker {
    background-color: white;
    color: #7C815D;
}

/* Answer indicator styles */
.answer-indicator {
    font-size: 1.2rem;
    font-weight: bold;
}

.option-item.border-success .option-marker {
    background-color: white;
    color: #28a745;
}

.option-item.border-danger .option-marker {
    background-color: white;
    color: #dc3545;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .col-lg-9.col-md-12 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .col-lg-3.col-md-12 {
        display: none; /* Hide desktop navigation on tablet */
    }
    
    /* Show mobile navigation on tablet */
    #mobile-question-nav {
        display: flex !important;
        max-width: 250px;
    }
}

@media (max-width: 768px) {
    .question-card {
        padding: 1rem !important;
        margin: 0.5rem !important;
    }
    
    .option-item {
        padding: 0.75rem !important;
    }
    
    .option-marker {
        width: 30px;
        height: 30px;
        min-width: 30px;
        font-size: 0.875rem;
    }
    
    h3 {
        font-size: 1.25rem;
    }
    
    h4 {
        font-size: 1.1rem;
    }
    
    .btn-main {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    
    /* Fix container overflow on mobile */
    .container {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .col-lg-9.col-md-12,
    .col-lg-3.col-md-12 {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }
}

/* Text overflow prevention */
.text-break {
    word-wrap: break-word;
    word-break: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
}

/* Timer styling */
.timer-display {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.1rem;
}

.timer-display i {
    font-size: 1.2rem;
}

.timer-display.bg-danger {
    background-color: #dc3545 !important;
}

/* Question Navigation Styling */
.question-nav-btn {
    background-color: white;
    border: 2px solid #dee2e6;
    color: #495057;
    transition: all 0.3s ease;
}

.question-nav-btn:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.question-nav-btn.ring-2 {
    border-color: #7C815D !important;
    box-shadow: 0 0 0 3px rgba(124, 129, 93, 0.3) !important;
}

/* Card styling improvements */
.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

/* Mobile-specific improvements */
@media (max-width: 576px) {
    .timer-display {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem !important;
    }
    
    .timer-display i {
        font-size: 1rem;
    }
    /* Keep buttons side-by-side on mobile, just smaller */
    .d-flex.justify-content-between.mt-4 {
        flex-direction: row;
        gap: 0.75rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .btn-main {
        width: auto;
        flex: 1;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        white-space: nowrap;
        text-align: center;
    }
    
    /* Mobile navigation adjustments */
    #mobile-question-nav {
        max-width: 150px !important;
        gap: 0.25rem !important;
    }
    
    .mobile-nav-btn {
        width: 30px !important;
        height: 30px !important;
        min-width: 30px !important;
        font-size: 0.75rem !important;
    }
    
    /* Additional mobile fixes */
    .question-card {
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    
    .options-container {
        width: 100% !important;
    }
    
    .option-item {
        width: 100% !important;
        max-width: 100% !important;
    }
    
    /* Align quiz elements with title on mobile */
    .d-flex.justify-content-between.align-items-center.mb-4 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    /* Timer mobile adjustments */
    .timer-display {
        flex-shrink: 0;
    }
    
    /* Question navigation mobile adjustments */
    .col-lg-3.col-md-12 {
        display: none; /* Hide navigation on mobile */
    }
    
    .col-lg-9.col-md-12 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    #questions-container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    /* Ensure quiz section container has proper padding */
    section > .container {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    /* Grid layout for mobile */
    .row.g-5 {
        gap: 1rem !important;
    }
    
    .col-lg-9.col-md-12,
    .col-lg-3.col-md-12 {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }
    
    /* SweetAlert mobile positioning */
    .swal2-popup {
        margin-top: 5vh !important;
        margin-bottom: auto !important;
    }

    .swal2-container {
        padding: 1rem !important;
        align-items: flex-start !important;
    }
}

.timer-display.urgent {
    background-color: #dc3545 !important;
    animation: pulse 1s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}
</style>
@endsection