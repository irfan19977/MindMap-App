@extends('frontend.layouts.app')

@section('content')
<style>
    /* Ensure page can scroll properly */
    main {
        overflow: visible !important;
        height: auto !important;
        min-height: auto !important;
    }
    body {
        overflow: auto !important;
        height: auto !important;
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
                            {{ $material->title ?? 'Materi' }}
                        </h1>

                        <ul class="crumb">
                            <li><a href="/">Home</a></li>
                            <li><a href="/kelas">Kelas</a></li>
                            <li><a href="/mindmap/{{ $material->subcategory->slug ?? '#' }}">{{ $material->subcategory->name ?? 'Subkategori' }}</a></li>
                            <li class="active">{{ $material->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row g-5">

                    <!-- Sidebar -->
                    <div class="col-lg-3">

                        <a href="#overview" class="sidebar-link bg-color text-light d-block p-3 px-4 rounded-10px mb-3 relative active" data-tab="overview">
                            <h5 class="mb-0">Overview</h5>
                        </a>

                        <a href="#detail-materi" class="sidebar-link bg-light d-block p-3 px-4 rounded-10px mb-3" data-tab="detail-materi">
                            <h5 class="mb-0">Detail Materi</h5>
                        </a>

                        <a href="#latihan" class="sidebar-link bg-light d-block p-3 px-4 rounded-10px mb-3" data-tab="latihan">
                            <h5 class="mb-0">Latihan</h5>
                        </a>

                        <a href="#quiz" class="sidebar-link bg-light d-block p-3 px-4 rounded-10px mb-3" data-tab="quiz">
                            <h5 class="mb-0">Quiz</h5>
                        </a>

                    </div>

                    <!-- Content -->
                    <div class="col-lg-9">

                        <!-- Overview Tab Content -->
                        <div id="overview" class="tab-content" style="display: block;">
                            <div class="row g-4 gx-5 align-items-center">
                                <div class="col-lg-12">
                                    <div class="subtitle wow fadeInUp">
                                        Tentang {{ $material->title ?? 'Materi' }}
                                    </div>

                                    <h2 class="fs-40">
                                        {{ $material->title ?? 'Materi' }}
                                    </h2>

                                    <p>
                                        {{ $material->description ?? 'Deskripsi materi belum tersedia.' }}
                                    </p>

                                    @if($material->learning_objectives)
                                    <div class="bg-light rounded-1 p-40 mb-5 wow fadeInUp">
                                        <h4>Apa yang akan Anda pelajari:</h4>
                                        <p>{{ $material->learning_objectives }}</p>
                                    </div>
                                    @endif

                                    @if($material->subcategory)
                                    <div class="bg-light rounded-1 p-40 mb-5 wow fadeInUp">
                                        <h4>Informasi Materi:</h4>
                                        <ul>
                                            @if($material->subcategory->category)
                                            <li><strong>Kategori:</strong> {{ $material->subcategory->category->name }}</li>
                                            @endif
                                            <li><strong>Subkategori:</strong> {{ $material->subcategory->name }}</li>
                                            <li><strong>Status:</strong> {{ $material->status == 'publish' ? 'Diterbitkan' : 'Draft' }}</li>
                                            <li><strong>Tipe:</strong> {{ $material->is_free ? 'Gratis' : 'Berbayar' }}</li>
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Detail Materi Tab Content -->
                        <div id="detail-materi" class="tab-content" style="display: none;">
                            <!-- Materi Content from Database -->
                            <div class="materi-content mb-5" id="material-content" data-material-title="{{ $material->title ?? '' }}" data-material-description="{{ $material->description ?? '' }}" data-material-content="{!! $material->content ?? '' !!}">
                                @if($kontenMateri && is_array($kontenMateri))
                                    @foreach($kontenMateri as $item)
                                        @if($item['type'] == 'heading')
                                            <h{{ $item['level'] ?? '2' }} class="wow fadeInUp">{{ $item['content'] }}</h{{ $item['level'] ?? '2' }}>
                                        @elseif($item['type'] == 'paragraph')
                                            <p class="wow fadeInUp">{{ $item['content'] }}</p>
                                        @elseif($item['type'] == 'list' && is_array($item['content']))
                                            <ul class="wow fadeInUp">
                                                @foreach($item['content'] as $listItem)
                                                    <li>{{ $listItem }}</li>
                                                @endforeach
                                            </ul>
                                        @elseif($item['type'] == 'code')
                                            <div class="bg-light rounded-1 p-4 mb-4 wow fadeInUp">
                                                <h4>Contoh Kode:</h4>
                                                <pre><code>{{ $item['content'] }}</code></pre>
                                            </div>
                                        @elseif($item['type'] == 'image')
                                            <div class="text-center mb-4 wow fadeInUp">
                                                <img src="{{ $item['content'] }}" class="img-fluid rounded-20px" alt="">
                                            </div>
                                        @endif
                                    @endforeach
                                    <!-- Store kontenMateri as JSON for JavaScript -->
                                    <script>
                                        window.kontenMateri = @json($kontenMateri);
                                        window.gradeLevel = '{{ $gradeLevel ?? 'SD' }}';
                                    </script>
                                @else
                                    <div class="bg-light rounded-1 p-40 mb-5 wow fadeInUp">
                                        <p>{!! $material->content !!}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="spacer-double"></div>

                            <!-- Features -->
                            <div class="row g-4">

                                <div class="col-lg-6 wow fadeInUp">
                                    <div class="relative">
                                        <i class="fa-solid fa-book bg-color-op-2 id-color fs-32 pt-4 w-80px h-80px text-center absolute rounded-1"></i>
                                        <div class="ps-100">
                                            <h4>Materi Lengkap</h4>
                                            <p class="mb-0">
                                                Akses materi pembelajaran yang lengkap dan terstruktur untuk memaksimalkan pemahaman Anda.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="relative">
                                        <i class="fa-solid fa-laptop-code bg-color-op-2 id-color fs-32 pt-4 w-80px h-80px text-center absolute rounded-1"></i>
                                        <div class="ps-100">
                                            <h4>Contoh Praktis</h4>
                                            <p class="mb-0">
                                                Dapatkan contoh-contoh praktis yang dapat membantu Anda menerapkan konsep yang dipelajari.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 wow fadeInUp" data-wow-delay=".4s">
                                    <div class="relative">
                                        <i class="fa-solid fa-clipboard-check bg-color-op-2 id-color fs-32 pt-4 w-80px h-80px text-center absolute rounded-1"></i>
                                        <div class="ps-100">
                                            <h4>Latihan Interaktif</h4>
                                            <p class="mb-0">
                                                Kerjakan latihan interaktif untuk menguji pemahaman Anda tentang materi yang telah dipelajari.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 wow fadeInUp" data-wow-delay=".6s">
                                    <div class="relative">
                                        <i class="fa-solid fa-trophy bg-color-op-2 id-color fs-32 pt-4 w-80px h-80px text-center absolute rounded-1"></i>
                                        <div class="ps-100">
                                            <h4>Quiz Evaluasi</h4>
                                            <p class="mb-0">
                                                Ikuti quiz evaluasi untuk mengukur sejauh mana pemahaman Anda terhadap materi ini.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="spacer-double"></div>

                            <!-- CTA -->
                            <div class="bg-color text-light rounded-1 p-40 relative overflow-hidden wow fadeInUp">

                                <div class="row align-items-center">

                                    <div class="col-lg-8">
                                        <h4 class="mb-2">
                                            Siap untuk Menguji Pemahaman Anda?
                                        </h4>

                                        <p class="mb-0">
                                            Kerjakan latihan dan quiz untuk mengukur pemahaman Anda tentang materi ini.
                                        </p>
                                    </div>

                                    <div class="col-lg-4 text-lg-end">
                                        <a href="#latihan" class="btn-main bg-white text-dark sidebar-link" data-tab="latihan">
                                            Mulai Latihan
                                        </a>
                                    </div>

                                </div>

                            </div>

                            <!-- AI Assistant Component - Only in Detail Materi tab -->
                            @include('frontend.partials._ai_assistant')

                        </div>

                        <!-- Latihan Tab Content -->
                        <div id="latihan" class="tab-content" style="display: none;">
                            <div class="row g-4 gx-5 align-items-center">
                                <div class="col-lg-12">
                                    <div class="subtitle wow fadeInUp">
                                        Latihan Praktik
                                    </div>

                                    <h2 class="fs-40">
                                        Latihan {{ $material->title ?? 'Materi' }}
                                    </h2>

                                    <p>
                                        Kerjakan soal latihan berikut untuk menguji pemahaman Anda tentang materi yang telah dipelajari.
                                    </p>

                                    @if($material->practiceQuestions->count() > 0)
                                        <div class="exercise-list">
                                            @foreach($material->practiceQuestions as $index => $latihan)
                                                @php
                                                    $type = $latihan->question_type ?? 'essay';
                                                    $existingAnswer = $practiceAnswers[$latihan->id] ?? null;
                                                    $isAnswered = !is_null($existingAnswer);
                                                @endphp
                                                <div class="bg-light rounded-1 p-40 mb-4">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <h4>Soal {{ $index + 1 }}</h4>
                                                        @if($latihan->points)
                                                        <span style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 20px; font-size: 14px; font-weight: bold;">
                                                            🏆 {{ $latihan->points }} Poin
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <p>{{ $latihan->question }}</p>

                                                    {{-- Show existing answer if already answered --}}
                                                    @if($isAnswered)
                                                        <div class="exercise-answer" style="margin-top: 15px;">
                                                            <span class="answer-label" style="font-weight: bold;">Jawaban Kamu:</span>
                                                            <div class="answer-value" style="background-color: #ffffff; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
                                                                {{ $existingAnswer->user_answer }}
                                                            </div>
                                                            <div class="points-earned" style="margin-top: 5px; font-weight: bold; color: #28a745;">
                                                                🏆 Poin: {{ $existingAnswer->points_earned ?? 0 }} / {{ $latihan->points ?? 10 }}
                                                            </div>
                                                        </div>
                                                        @if($existingAnswer->is_correct)
                                                            <div class="exercise-feedback correct" style="display:block; background-color: #ffffff; border: 2px solid #28a745; padding: 15px; border-radius: 8px; margin-top: 10px;">
                                                                <strong style="color: #28a745;">✅ Jawaban kamu benar!</strong>
                                                                @if($latihan->explanation)
                                                                    <div class="feedback-answer" style="margin-top: 10px;">{{ $latihan->explanation }}</div>
                                                                @endif
                                                            </div>
                                                        @elseif($type === 'essay')
                                                            <div class="exercise-feedback essay-done" style="display:block; background-color: #ffffff; border: 2px solid #6c757d; padding: 15px; border-radius: 8px; margin-top: 10px;">
                                                                <strong style="color: #6c757d;">📝 Jawaban sudah dikumpulkan.</strong>
                                                                @if($latihan->correct_answer)
                                                                    <div class="feedback-answer" style="margin-top: 10px;"><strong>Kunci:</strong> {{ $latihan->correct_answer }}</div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="exercise-feedback essay-done" style="display:block; background-color: #ffffff; border: 2px solid #dc3545; padding: 15px; border-radius: 8px; margin-top: 10px;">
                                                                <strong style="color: #dc3545;">❌ Jawaban sudah dikumpulkan.</strong>
                                                                <div class="feedback-answer" style="margin-top: 10px;"><strong>Jawaban yang benar:</strong> {{ $latihan->correct_answer }}</div>
                                                                @if($latihan->explanation)
                                                                    <div class="feedback-answer" style="margin-top: 10px;"><strong>Penjelasan:</strong> {{ $latihan->explanation }}</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @else
                                                        {{-- Input jawaban --}}
                                                        <div class="exercise-input-wrap" style="margin-top: 15px;">
                                                            @if($type === 'essay')
                                                                <textarea class="exercise-textarea" id="ans-{{ $index }}" placeholder="Tulis jawaban kamu di sini..." rows="3" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; background-color: #ffffff; resize: vertical;"></textarea>
                                                            @else
                                                                <input type="text" class="exercise-input" id="ans-{{ $index }}" placeholder="Tulis jawaban singkat kamu..." style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; background-color: #ffffff;">
                                                            @endif
                                                            <button class="btn-main fx-slide exercise-check-btn" onclick="checkExercise({{ $index }}, '{{ addslashes($latihan->correct_answer ?? '') }}', '{{ addslashes($latihan->explanation ?? '') }}', '{{ addslashes($latihan->question ?? '') }}', '{{ $latihan->id }}', {{ $latihan->points ?? 10 }}, '{{ $type }}')" style="margin-top: 10px;">
                                                                <span><i class="ion-ios-checkmark-outline"></i> Cek Jawaban</span>
                                                            </button>
                                                        </div>

                                                        {{-- Feedback (hidden) --}}
                                                        <div class="exercise-feedback" id="feedback-{{ $index }}" style="display:none; margin-top: 10px; padding: 15px; border-radius: 8px; background-color: #ffffff;"></div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="bg-light rounded-1 p-40 mb-4">
                                            <p>Belum ada soal latihan untuk materi ini.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Quiz Tab Content -->
                        <div id="quiz" class="tab-content" style="display: none;">
                            <div class="row g-4 gx-5 align-items-center">
                                <div class="col-lg-12">
                                    <div class="subtitle wow fadeInUp">
                                        Quiz Evaluasi
                                    </div>

                                    <h2 class="fs-40">
                                        Quiz {{ $material->title ?? 'Materi' }}
                                    </h2>

                                    <p>
                                        Ikuti quiz evaluasi untuk mengukur sejauh mana pemahaman Anda terhadap materi ini.
                                    </p>

                                    @php $quiz = $material->quizzes()->where('status', 'publish')->with('quizQuestions')->first(); @endphp
                                    @if($quiz && $quiz->quizQuestions->count() > 0)
                                        @if($completedQuizAttempt)
                                            @php
                                                $isPassed = $completedQuizAttempt->status === 'passed';
                                                $scoreColor = $isPassed ? '#28a745' : '#dc3545';
                                                $bgColor = $isPassed ? '#dcfce7' : '#fee2e2';
                                                $message = $isPassed ? '🎉 Kamu sudah lulus quiz ini!' : '📝 Kamu sudah mengerjakan quiz ini';
                                                $icon = $isPassed ? 'ion-ios-eye-outline' : 'ion-ios-refresh-outline';
                                                $buttonText = $isPassed ? 'Lihat Hasil' : 'Coba Lagi';
                                            @endphp
                                            <div class="bg-light rounded-1 p-40 mb-4" style="background-color: {{ $bgColor }};">
                                                <h4>{{ $message }}</h4>
                                                <p>Nilai kamu: {{ round($completedQuizAttempt->score) }}%</p>
                                                <button onclick="startQuizWithFullscreen('{{ $quiz->id }}')" class="btn-main bg-color text-light">
                                                    <span><i class="{{ $icon }}"></i> {{ $buttonText }}</span>
                                                </button>
                                            </div>
                                        @else
                                            <div class="bg-light rounded-1 p-40 mb-4">
                                                <h4>Quiz tersedia</h4>
                                                <p>Ada {{ $quiz->quizQuestions->count() }} soal untuk dikerjakan.</p>
                                                <button onclick="startQuizWithFullscreen('{{ $quiz->id }}')" class="btn-main bg-color text-light">
                                                    <span><i class="ion-ios-play-outline"></i> Mulai Quiz</span>
                                                </button>
                                            </div>
                                        @endif
                                    @else
                                        <div class="bg-light rounded-1 p-40 mb-4">
                                            <p>Belum ada quiz untuk materi ini.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <script>
        // Store login status from server
        const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

        // Start quiz with fullscreen
        async function startQuizWithFullscreen(quizId) {
            try {
                // Navigate to quiz in same tab instead of opening new tab
                window.location.href = '/quiz/take/' + quizId;
            } catch (error) {
                console.error('Error:', error);
                // Fallback: navigate to quiz
                window.location.href = '/quiz/take/' + quizId;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Handle sidebar link clicks
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            const tabContents = document.querySelectorAll('.tab-content');

            function switchTab(tabId) {
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.style.display = 'none';
                });

                // Remove active class from all sidebar links
                sidebarLinks.forEach(link => {
                    link.classList.remove('active', 'bg-color', 'text-light');
                    link.classList.add('bg-light');
                    // Remove arrow icon from non-active links
                    const arrow = link.querySelector('.icofont-long-arrow-right');
                    if (arrow) {
                        arrow.remove();
                    }
                });

                // Show selected tab content
                const selectedTab = document.getElementById(tabId);
                if (selectedTab) {
                    selectedTab.style.display = 'block';
                }

                // Add active class to selected sidebar link
                const activeLink = document.querySelector(`.sidebar-link[data-tab="${tabId}"]`);
                if (activeLink) {
                    activeLink.classList.add('active', 'bg-color', 'text-light');
                    activeLink.classList.remove('bg-light');


                }

                // Show/hide AI assistant based on active tab
                const aiAssistantToggle = document.getElementById('ai-assistant-toggle');
                const aiAssistantChat = document.getElementById('ai-assistant-chat');
                if (aiAssistantToggle && aiAssistantChat) {
                    if (tabId === 'detail-materi') {
                        aiAssistantToggle.classList.add('visible');
                    } else {
                        aiAssistantToggle.classList.remove('visible');
                        aiAssistantChat.classList.remove('active');
                    }
                }

                // Update URL hash without page jump
                history.pushState(null, null, `#${tabId}`);
            }

            // Add click event listeners to sidebar links
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabId = this.getAttribute('data-tab');
                    switchTab(tabId);
                });
            });

            // Check URL hash on page load
            const hash = window.location.hash.substring(1);
            if (hash && document.getElementById(hash)) {
                switchTab(hash);
            } else {
                // Default to overview tab
                switchTab('overview');
            }

            // Initially hide AI assistant if not on detail-materi tab
            const aiAssistantToggle = document.getElementById('ai-assistant-toggle');
            const aiAssistantChat = document.getElementById('ai-assistant-chat');
            if (aiAssistantToggle && aiAssistantChat) {
                const currentHash = window.location.hash.substring(1) || 'overview';
                if (currentHash !== 'detail-materi') {
                    aiAssistantToggle.classList.remove('visible');
                    aiAssistantChat.classList.remove('active');
                } else {
                    aiAssistantToggle.classList.add('visible');
                }
            }

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function() {
                const hash = window.location.hash.substring(1);
                if (hash && document.getElementById(hash)) {
                    switchTab(hash);
                } else {
                    switchTab('overview');
                }
            });
        });

        // Function to grade essay using AI
        async function gradeWithAI(index, question, userAnswer, correctAnswer, explanation, questionId, questionPoints) {
            const inputElement = document.getElementById('ans-' + index);
            const feedbackElement = document.getElementById('feedback-' + index);

            // Show loading state
            feedbackElement.style.display = 'block';
            feedbackElement.style.backgroundColor = '#f3f4f6';
            feedbackElement.style.border = '2px solid #ddd';
            feedbackElement.innerHTML = '<strong>🤖 Sedang menilai jawaban dengan AI...</strong>';

            try {
                const response = await fetch('/api/ai/grade-essay', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        question: question,
                        user_answer: userAnswer,
                        correct_answer: correctAnswer,
                        max_points: questionPoints || 10,
                        level: window.gradeLevel || 'SD'
                    })
                });

                if (!response.ok) {
                    throw new Error('AI grading failed');
                }

                const data = await response.json();

                if (data.success && data.result) {
                    const result = data.result;
                    const isCorrect = result.verdict === 'Benar' || result.verdict === 'Sebagian Benar';
                    const pointsEarned = result.score || 0;

                    // Show AI feedback
                    feedbackElement.style.display = 'block';

                    if (isCorrect) {
                        feedbackElement.style.backgroundColor = '#ffffff';
                        feedbackElement.style.border = '2px solid #28a745';
                        feedbackElement.innerHTML = '<strong style="color: #28a745;">✅ ' + result.verdict + '!</strong>';
                    } else {
                        feedbackElement.style.backgroundColor = '#ffffff';
                        feedbackElement.style.border = '2px solid #dc3545';
                        feedbackElement.innerHTML = '<strong style="color: #dc3545;">❌ ' + result.verdict + '</strong>';
                    }

                    if (result.feedback) {
                        feedbackElement.innerHTML += '<div class="feedback-answer" style="margin-top: 10px;">' + result.feedback + '</div>';
                    }

                    if (result.suggestion) {
                        feedbackElement.innerHTML += '<div class="feedback-answer" style="margin-top: 10px;"><strong>Saran:</strong> ' + result.suggestion + '</div>';
                    }

                    // Add points display below the input
                    const pointsDiv = document.createElement('div');
                    pointsDiv.className = 'points-earned';
                    pointsDiv.style.marginTop = '5px';
                    pointsDiv.style.fontWeight = 'bold';
                    pointsDiv.style.color = '#28a745';
                    pointsDiv.innerHTML = '🏆 Poin: ' + pointsEarned + ' / ' + (questionPoints || 10);
                    inputElement.parentNode.insertBefore(pointsDiv, inputElement.nextSibling);

                    // Save to server
                    fetch('/api/practice/save', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            practice_question_id: questionId,
                            user_answer: userAnswer,
                            is_correct: isCorrect,
                            points_earned: pointsEarned,
                            max_points: questionPoints || 10
                        })
                    }).then(response => response.json())
                      .then(data => {
                          if (!data.success) {
                              console.log('Failed to save answer:', data.message);
                          }
                      });

                    // Disable input and button
                    inputElement.disabled = true;
                    inputElement.style.backgroundColor = '#ffffff';
                    inputElement.style.cursor = 'not-allowed';

                    const checkBtn = document.querySelector('button[onclick*="checkExercise(' + index + '"]');
                    if (checkBtn) {
                        checkBtn.disabled = true;
                        checkBtn.style.opacity = '0.5';
                        checkBtn.style.cursor = 'not-allowed';
                    }
                } else {
                    throw new Error(data.error || 'AI grading failed');
                }
            } catch (error) {
                console.error('AI grading error:', error);
                feedbackElement.style.backgroundColor = '#fee2e2';
                feedbackElement.style.border = '2px solid #dc3545';
                feedbackElement.innerHTML = '<strong style="color: #dc3545;">❌ Gagal menilai dengan AI. Coba lagi nanti.</strong>';
            }
        }

        // Function to check exercise answer
        function checkExercise(index, correctAnswer, explanation, question, questionId, questionPoints, questionType) {
            const inputElement = document.getElementById('ans-' + index);
            const feedbackElement = document.getElementById('feedback-' + index);
            const userAnswer = inputElement.value.trim();

            if (!userAnswer) {
                alert('Silakan jawab soal terlebih dahulu!');
                return;
            }

            // Check if user is logged in
            if (!isLoggedIn) {
                if (confirm('Anda harus login terlebih dahulu untuk menyimpan jawaban dan mendapatkan poin. Apakah Anda ingin login sekarang?')) {
                    window.location.href = '/login?intended=' + encodeURIComponent(window.location.href);
                }
                return;
            }

            // For essay questions, use AI grading
            if (questionType === 'essay' || !correctAnswer || correctAnswer.includes('materi')) {
                // Use AI grading for essay questions
                gradeWithAI(index, question, userAnswer, correctAnswer, explanation, questionId, questionPoints);
                return;
            }

            // For non-essay questions with specific answers, use string comparison
            const isCorrect = userAnswer.toLowerCase() === correctAnswer.toLowerCase();
            const pointsEarned = isCorrect ? (questionPoints || 10) : 0;

            // Send answer to server
            fetch('/api/practice/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    practice_question_id: questionId,
                    user_answer: userAnswer,
                    is_correct: isCorrect,
                    points_earned: pointsEarned,
                    max_points: questionPoints || 10
                })
            })
            .then(response => {
                if (response.status === 401) {
                    // User not logged in (double check)
                    alert('Anda harus login terlebih dahulu untuk menyimpan jawaban dan mendapatkan poin.');
                    window.location.href = '/login?intended=' + encodeURIComponent(window.location.href);
                    throw new Error('Unauthorized');
                }
                if (!response.ok) {
                    throw new Error('Server error: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show feedback
                    feedbackElement.style.display = 'block';

                    if (userAnswer.toLowerCase() === correctAnswer.toLowerCase()) {
                        feedbackElement.style.backgroundColor = '#ffffff';
                        feedbackElement.style.border = '2px solid #28a745';
                        feedbackElement.innerHTML = '<strong style="color: #28a745;">✅ Jawaban kamu benar!</strong>';
                        if (explanation) {
                            feedbackElement.innerHTML += '<div class="feedback-answer" style="margin-top: 10px;">' + explanation + '</div>';
                        }
                    } else {
                        feedbackElement.style.backgroundColor = '#ffffff';
                        feedbackElement.style.border = '2px solid #dc3545';
                        feedbackElement.innerHTML = '<strong style="color: #dc3545;">❌ Jawaban salah.</strong>';
                        feedbackElement.innerHTML += '<div class="feedback-answer" style="margin-top: 10px;"><strong>Jawaban yang benar:</strong> ' + correctAnswer + '</div>';
                        if (explanation) {
                            feedbackElement.innerHTML += '<div class="feedback-answer" style="margin-top: 10px;"><strong>Penjelasan:</strong> ' + explanation + '</div>';
                        }
                    }

                    // Add points display below the input
                    const pointsDiv = document.createElement('div');
                    pointsDiv.className = 'points-earned';
                    pointsDiv.style.marginTop = '5px';
                    pointsDiv.style.fontWeight = 'bold';
                    pointsDiv.style.color = '#28a745';
                    pointsDiv.innerHTML = '🏆 Poin: ' + pointsEarned + ' / ' + (questionPoints || 10);
                    inputElement.parentNode.insertBefore(pointsDiv, inputElement.nextSibling);

                    // Keep input white but disabled
                    inputElement.disabled = true;
                    inputElement.style.backgroundColor = '#ffffff';
                    inputElement.style.cursor = 'not-allowed';

                    const checkBtn = document.querySelector('button[onclick*="checkExercise(' + index + '"]');
                    if (checkBtn) {
                        checkBtn.disabled = true;
                        checkBtn.style.opacity = '0.5';
                        checkBtn.style.cursor = 'not-allowed';
                    }
                } else {
                    // Handle specific error messages
                    if (data.message && data.message.includes('sudah menjawab')) {
                        // User already answered, show the existing answer
                        alert(data.message);
                        // Reload the page to show the existing answer
                        location.reload();
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan saat menyimpan jawaban.');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
        }

        // Auto resize textarea
        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }
        </script>

@endsection