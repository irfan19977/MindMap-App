@extends('frontend.layouts.app')

@section('content')
    <!-- Header-->
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
      <div class="overlay"></div>
      <div class="intro-body">
        <h1>Detail Materi</h1>
        <h4>Pelajari konsep mendalam dengan bantuan AI Assistant</h4>
      </div>
    </header>
    
    <!-- Main Content -->
    <section class="section-small" id="materi-content">
      <div class="container">
        <div class="row">
          <!-- Konten Materi (full width) -->
          <div class="col-md-12">
            <div class="materi-container">
              <!-- Breadcrumb -->
              <nav class="breadcrumb-nav">
                <ol class="breadcrumb">
                  <li><a href="/kelas">MindMap</a></li>
                  @if($material->subcategory && $material->subcategory->category)
                    <li><a href="/mindmap/{{ $material->subcategory->category->slug }}">{{ $material->subcategory->category->name }}</a></li>
                  @endif
                  @if($material->subcategory)
                    <li><a href="/mindmap/{{ $material->subcategory->slug }}">{{ $material->subcategory->name }}</a></li>
                  @endif
                  <li class="active">{{ $material->title }}</li>
                </ol>
              </nav>

              <!-- Header Materi -->
              <div class="materi-header">
                <div class="materi-header-inner">
                  <div class="materi-header-info">
                    <h2 class="materi-title">{{ $material->title }}</h2>
                    <div class="materi-meta">
                      @if($material->status == 'publish')
                        <span class="meta-badge badge-publish"><i class="ion-ios-checkmark-outline"></i> Diterbitkan</span>
                      @else
                        <span class="meta-badge badge-draft">Draft</span>
                      @endif
                      <span class="meta-item"><i class="ion-ios-pricetag-outline"></i> {{ $material->is_free ? 'Gratis' : 'Berbayar' }}</span>
                      @if($material->subcategory)
                        <span class="meta-item"><i class="ion-ios-folder-outline"></i> {{ $material->subcategory->name }}</span>
                      @endif
                    </div>
                  </div>
                  <button class="materi-start-btn" onclick="startLearning()">
                    <i class="ion-ios-play-outline"></i> Mulai Belajar
                  </button>
                </div>
              </div>
              
              <!-- Tabs Navigasi -->
              <ul class="nav nav-tabs materi-tabs" role="tablist">
                <li role="presentation" class="active">
                  <a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">Overview</a>
                </li>
                <li role="presentation">
                  <a href="#materi" aria-controls="materi" role="tab" data-toggle="tab">Materi</a>
                </li>
                <li role="presentation">
                  <a href="#contoh" aria-controls="contoh" role="tab" data-toggle="tab">Contoh Kode</a>
                </li>
                <li role="presentation">
                  <a href="#latihan" aria-controls="latihan" role="tab" data-toggle="tab">Latihan</a>
                </li>
                <li role="presentation">
                  @guest
                  <a href="{{ route('login') }}" id="quizTabLink">Quiz <span class="label label-default" style="font-size:9px;vertical-align:middle">Login</span></a>
                  @else
                  <a href="#quiz" aria-controls="quiz" role="tab" id="quizTabLink" @if(!$passedQuizAttempt) onclick="handleQuizTabClick(event)" @else data-toggle="tab" @endif>Quiz</a>
                  @endguest
                </li>
              </ul>
              
              <!-- Tab Content -->
              <div class="tab-content">
                <!-- Overview Tab -->
                <div role="tabpanel" class="tab-pane active" id="overview">
                  <div class="materi-section">
                    <h3>Tentang {{ $material->title }}</h3>
                    <p>{{ $material->description }}</p>

                    @if($material->learning_objectives)
                    <h4>Apa yang akan Anda pelajari:</h4>
                    <ul class="learning-objectives">
                      <li>{{ $material->learning_objectives }}</li>
                    </ul>
                    @endif
                  </div>
                </div>
                
                <!-- Materi Tab — split layout with AI chat -->
                <div role="tabpanel" class="tab-pane" id="materi">
                  <div class="materi-with-chat">
                    <!-- Konten Materi -->
                    <div class="materi-content-col">
                      <div class="materi-content">
                        @if($kontenMateri && is_array($kontenMateri))
                          @foreach($kontenMateri as $item)
                            @if($item['type'] == 'heading')
                              <h{{ $item['level'] ?? '2' }}>{{ $item['content'] }}</h{{ $item['level'] ?? '2' }}>
                            @elseif($item['type'] == 'paragraph')
                              <p>{{ $item['content'] }}</p>
                            @elseif($item['type'] == 'list' && is_array($item['content']))
                              <ul>
                                @foreach($item['content'] as $listItem)
                                  <li>{{ $listItem }}</li>
                                @endforeach
                              </ul>
                            @endif
                          @endforeach
                        @else
                          {!! $material->content !!}
                        @endif
                      </div>
                    </div>

                    <!-- AI Chat Sidebar -->
                    <div class="materi-chat-col">
                      <!-- Mobile chat toggle button -->
                      <button class="chat-toggle-btn" id="chatToggleBtn" onclick="toggleChat()">
                        <i class="ion-ios-chatboxes-outline"></i>
                      </button>

                      <div class="ai-chat-panel" id="sidebarChatbox">
                        <!-- Header -->
                        <div class="ai-chat-header">
                          <div class="ai-chat-header-left">
                            <div class="ai-avatar-icon">
                              <i class="ion-ios-pulse"></i>
                            </div>
                            <div>
                              <div class="ai-chat-title">Tanya AI</div>
                              <div class="ai-chat-subtitle">Asisten Belajar Cerdas</div>
                            </div>
                          </div>
                          <div class="ai-online-dot"></div>
                        </div>

                        <!-- Messages -->
                        <div class="ai-messages" id="chatMessages">
                          <div class="ai-msg-row ai-row">
                            <div class="ai-msg-bubble ai-bubble">
                              <p>Halo! 👋 Saya siap membantu kamu memahami materi <strong>{{ $material->title }}</strong>.</p>
                              <p style="margin-top:6px; margin-bottom:0;">Silakan tanyakan apa saja tentang materi ini.</p>
                            </div>
                          </div>

                          <!-- Quick question chips -->
                          <div class="ai-chips" id="aiChips">
                            @guest
                              <button class="ai-chip" onclick="askQuestion('Jelaskan materi ini secara singkat')">📖 Jelaskan singkat</button>
                            @else
                              @if(auth()->user()->user_type !== 'student' && !auth()->user()->hasRole('student'))
                                <button class="ai-chip" onclick="askQuestion('Jelaskan materi ini secara singkat')">📖 Jelaskan singkat</button>
                              @endif
                            @endguest
                            <button class="ai-chip" onclick="askQuestion('Berikan contoh penerapan materi ini')">💡 Contoh penerapan</button>
                            <button class="ai-chip" onclick="askQuestion('Apa saja poin penting yang perlu diingat?')">📌 Poin penting</button>
                          </div>
                        </div>

                        <!-- Input -->
                        <div class="ai-input-area">
                          <div class="ai-input-wrap">
                            <input type="text" id="messageInput" class="ai-input" placeholder="Tanyakan sesuatu...">
                            <button class="ai-send-btn" onclick="sendMessage()" title="Kirim (Enter)">
                              <i class="ion-ios-arrow-thin-right"></i>
                            </button>
                          </div>
                          <div class="ai-input-hint">Tekan Enter untuk mengirim</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Contoh Kode Tab -->
                <div role="tabpanel" class="tab-pane" id="contoh">
                  <div class="materi-section">
                    <h3>Contoh Kode - {{ $material->title }}</h3>

                    @php
                      $codeItems = collect($kontenMateri)->filter(fn($item) => isset($item['type']) && $item['type'] === 'code');
                    @endphp

                    @if($codeItems->count() > 0)
                      @foreach($codeItems as $index => $codeItem)
                        <div class="code-example">
                          @if(isset($codeItem['label']))
                            <h4>{{ $codeItem['label'] }}</h4>
                          @else
                            <h4>Contoh {{ $index + 1 }}</h4>
                          @endif
                          <pre><code>{{ $codeItem['content'] }}</code></pre>
                        </div>
                      @endforeach
                    @else
                      <div class="alert alert-info" style="border-radius:8px; padding:20px;">
                        <i class="ion-ios-information-outline"></i>
                        Belum ada contoh kode untuk materi ini. Buka tab <strong>Materi</strong> dan gunakan <strong>AI Assistant</strong> untuk meminta contoh kode terkait <strong>{{ $material->title }}</strong>.
                      </div>
                    @endif
                  </div>
                </div>
                
                <!-- Latihan Tab -->
                <div role="tabpanel" class="tab-pane" id="latihan">
                  <div class="tab-section">
                    <div class="tab-section-header">
                      <div class="tab-section-icon" style="background:#e8f5e9;color:#2e7d32">
                        <i class="ion-ios-compose-outline"></i>
                      </div>
                      <div>
                        <h3 class="tab-section-title">Latihan Praktik</h3>
                        <p class="tab-section-sub">Kerjakan soal latihan berikut untuk menguji pemahamanmu</p>
                      </div>
                    </div>

                    @if($material->practiceQuestions->count() > 0)
                      <div class="exercise-list">
                        @foreach($material->practiceQuestions as $index => $latihan)
                          @php $type = $latihan->question_type ?? 'essay'; @endphp
                          <div class="exercise-card" id="exercise-{{ $index }}">
                            <div class="exercise-card-num">{{ $index + 1 }}</div>
                            <div class="exercise-card-body">
                              <p class="exercise-question">{{ $latihan->question }}</p>
                              <div class="exercise-meta">
                                <span class="exercise-badge badge-type"><i class="ion-ios-pricetag-outline"></i> {{ $type }}</span>
                                @if($latihan->points)
                                  <span class="exercise-badge badge-point"><i class="ion-ios-star-outline"></i> {{ $latihan->points }} poin</span>
                                @endif
                              </div>

                              {{-- Input jawaban --}}
                              <div class="exercise-input-wrap">
                                @if($type === 'essay')
                                  <textarea class="exercise-textarea" id="ans-{{ $index }}" placeholder="Tulis jawaban kamu di sini..." rows="1" oninput="autoResize(this)"></textarea>
                                @else
                                  <input type="text" class="exercise-input" id="ans-{{ $index }}" placeholder="Tulis jawaban singkat kamu...">
                                @endif
                                <button class="exercise-check-btn" onclick="checkExercise({{ $index }}, '{{ addslashes($latihan->correct_answer ?? '') }}', '{{ addslashes($latihan->explanation ?? '') }}', '{{ addslashes($latihan->question ?? '') }}')">
                                  <i class="ion-ios-checkmark-outline"></i> Cek Jawaban
                                </button>
                              </div>

                              {{-- Feedback (hidden) --}}
                              <div class="exercise-feedback" id="feedback-{{ $index }}" style="display:none"></div>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    @else
                      <div class="tab-empty-state">
                        <i class="ion-ios-compose-outline"></i>
                        <p>Belum ada soal latihan untuk materi ini.</p>
                      </div>
                    @endif
                  </div>
                </div>
                
                <!-- Quiz Tab -->
                <div role="tabpanel" class="tab-pane" id="quiz">
                  <div class="tab-section">

                    @php $quiz = $material->quizzes()->where('status', 'publish')->with('quizQuestions')->first(); @endphp
                    @if($quiz && $quiz->quizQuestions->count() > 0)
                      {{-- Show passed result if user already passed --}}
                      @if($passedQuizAttempt)
                        <div class="quiz-info-bar">
                          <div class="quiz-info-main">
                            <div class="tab-section-icon" style="background:#dcfce7;color:#16a34a">
                              <i class="ion-ios-checkmark-outline"></i>
                            </div>
                            <div>
                              <h3 class="tab-section-title" style="margin-bottom:2px">{{ $quiz->title }}</h3>
                              <p class="tab-section-sub">Kamu sudah lulus quiz ini!</p>
                            </div>
                          </div>
                          <div class="quiz-info-stats">
                            <div class="quiz-stat">
                              <span class="quiz-stat-val">{{ round($passedQuizAttempt->score) }}%</span>
                              <span class="quiz-stat-lbl">Nilai Kamu</span>
                            </div>
                            <div class="quiz-stat">
                              <span class="quiz-stat-val">{{ $passedQuizAttempt->quizAnswers->where('is_correct', true)->count() }}/{{ $passedQuizAttempt->quizAnswers->count() }}</span>
                              <span class="quiz-stat-lbl">Benar</span>
                            </div>
                          </div>
                        </div>

                        <div class="quiz-result passed" style="display:block">
                          <div class="result-score">{{ round($passedQuizAttempt->score) }}</div>
                          <div class="result-label">🎉 Kamu sudah lulus!</div>
                          <div class="result-detail">Nilai kamu: {{ round($passedQuizAttempt->score) }}% &nbsp;·&nbsp; Selesai pada {{ $passedQuizAttempt->completed_at->format('d M Y, H:i') }}</div>
                        </div>

                        {{-- Show answers from previous attempt --}}
                        <div class="quiz-answers-review">
                          <h4 style="margin:20px 0 15px 0;color:#374151">Jawaban Kamu:</h4>
                          @foreach($passedQuizAttempt->quizAnswers as $answer)
                            @php $question = $answer->quizQuestion; @endphp
                            @if($question)
                              <div class="quiz-card" style="margin-bottom:15px">
                                <div class="quiz-card-header">
                                  <span class="quiz-num">{{ $loop->index + 1 }}</span>
                                  <p class="quiz-question-text">{{ $question->question }}</p>
                                </div>
                                @php $options = is_array($question->options) ? $question->options : json_decode($question->options, true); @endphp
                                @if($options)
                                  <div class="quiz-options">
                                    @foreach($options as $optionKey => $optionValue)
                                      <label class="quiz-option" style="pointer-events:none;opacity:1">
                                        <input type="radio" disabled 
                                          @if($answer->user_answer === $optionKey) checked @endif
                                          @if($question->correct_answer === $optionKey) style="accent-color:#16a34a" @endif
                                        >
                                        <span class="quiz-option-key" 
                                          @if($answer->user_answer === $optionKey && $answer->is_correct) style="background:#16a34a;color:#fff;border-color:#16a34a" 
                                          @elseif($answer->user_answer === $optionKey && !$answer->is_correct) style="background:#dc2626;color:#fff;border-color:#dc2626"
                                          @elseif($question->correct_answer === $optionKey) style="background:#16a34a;color:#fff;border-color:#16a34a"
                                          @endif
                                        >{{ strtoupper($optionKey) }}</span>
                                        <span class="quiz-option-text">{{ $optionValue }}</span>
                                      </label>
                                    @endforeach
                                  </div>
                                @endif
                              </div>
                            @endif
                          @endforeach
                        </div>

                      @else
                        {{-- Info bar --}}
                        <div class="quiz-info-bar">
                          <div class="quiz-info-main">
                            <div class="tab-section-icon" style="background:#e3f2fd;color:#1565c0">
                              <i class="ion-ios-help-outline"></i>
                            </div>
                            <div>
                              <h3 class="tab-section-title" style="margin-bottom:2px">{{ $quiz->title }}</h3>
                              @if($quiz->description)
                                <p class="tab-section-sub">{{ $quiz->description }}</p>
                              @endif
                            </div>
                          </div>
                          <div class="quiz-info-stats">
                            <div class="quiz-stat">
                              <span class="quiz-stat-val">{{ $quiz->quizQuestions->count() }}</span>
                              <span class="quiz-stat-lbl">Soal</span>
                            </div>
                            @if($quiz->passing_score)
                              <div class="quiz-stat">
                                <span class="quiz-stat-val">{{ $quiz->passing_score }}</span>
                                <span class="quiz-stat-lbl">Nilai Lulus</span>
                              </div>
                            @endif
                            @if($quiz->time_limit)
                              <div class="quiz-stat">
                                <span class="quiz-stat-val">{{ $quiz->time_limit }}'</span>
                                <span class="quiz-stat-lbl">Menit</span>
                              </div>
                            @endif
                          </div>
                        </div>

                        {{-- Questions --}}
                        <form id="quizForm" class="quiz-form">
                          @foreach($quiz->quizQuestions->sortBy('order_number') as $index => $question)
                            <div class="quiz-card" id="qcard-{{ $index }}" data-question-id="{{ $question->id }}">
                              <div class="quiz-card-header">
                                <span class="quiz-num">{{ $index + 1 }}</span>
                                <p class="quiz-question-text">{{ $question->question }}</p>
                              </div>
                              @php $options = is_array($question->options) ? $question->options : json_decode($question->options, true); @endphp
                              @if($options)
                                <div class="quiz-options">
                                  @foreach($options as $optionKey => $optionValue)
                                    <label class="quiz-option" for="q{{ $index }}_{{ $optionKey }}">
                                      <input type="radio" id="q{{ $index }}_{{ $optionKey }}" name="q{{ $index }}" value="{{ $optionKey }}" data-question-id="{{ $question->id }}" data-correct="{{ $question->correct_answer }}">
                                      <span class="quiz-option-key">{{ strtoupper($optionKey) }}</span>
                                      <span class="quiz-option-text">{{ $optionValue }}</span>
                                    </label>
                                  @endforeach
                                </div>
                              @endif
                            </div>
                          @endforeach

                          <div class="quiz-submit-area">
                            <button type="button" class="quiz-submit-btn" onclick="submitQuiz()">
                              <i class="ion-ios-checkmark-outline"></i> Kumpulkan Jawaban
                            </button>
                          </div>
                        </form>

                        {{-- Result panel (hidden) --}}
                        <div class="quiz-result" id="quizResult" style="display:none"></div>
                      @endif

                    @else
                      <div class="tab-empty-state">
                        <i class="ion-ios-help-outline"></i>
                        <p>Belum ada quiz untuk materi ini.</p>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Quiz Confirmation Modal -->
    <div id="quizConfirmModal" class="qmodal-overlay" style="display:none">
      <div class="qmodal-box">
        <div class="qmodal-icon">⚠️</div>
        <h3 class="qmodal-title">Siap Mengerjakan Quiz?</h3>
        <p class="qmodal-desc">
          Setelah kamu memulai, quiz <strong>tidak bisa dihentikan</strong> atau ditinggalkan.<br>
          Timer akan langsung berjalan dan kamu harus menyelesaikannya.
        </p>
        <div class="qmodal-stats">
          @if(isset($quiz) && $quiz)
            <div class="qmodal-stat"><span>{{ $quiz->quizQuestions->count() }}</span> Soal</div>
            @if($quiz->time_limit)
              <div class="qmodal-stat"><span>{{ $quiz->time_limit }}</span> Menit</div>
            @endif
            @if($quiz->passing_score)
              <div class="qmodal-stat"><span>{{ $quiz->passing_score }}</span> Nilai Lulus</div>
            @endif
          @endif
        </div>
        <div class="qmodal-actions">
          <button class="qmodal-cancel" onclick="cancelQuiz()">Batalkan</button>
          <button class="qmodal-start" onclick="startQuiz()">Mulai Sekarang</button>
        </div>
      </div>
    </div>

    <!-- Quiz Lockdown Overlay (shown during quiz) -->
    <div id="quizLockOverlay" class="quiz-lock-overlay" style="display:none">
      <div class="quiz-lock-bar">
        <div class="quiz-lock-title">
          <i class="ion-ios-locked-outline"></i>
          Mode Quiz — {{ $material->title }}
        </div>
        <div class="quiz-lock-timer" id="quizTimerDisplay">
          <i class="ion-ios-clock-outline"></i>
          <span id="timerText">--:--</span>
        </div>
      </div>
      <div class="quiz-lock-warning" id="quizWarningBanner" style="display:none">
        ⚠️ Kamu tidak bisa meninggalkan halaman ini selama quiz berlangsung!
      </div>
    </div>

    <!-- Quiz Auto-Submit Warning Modal -->
    <div id="quizAutoSubmitModal" class="qmodal-overlay" style="display:none">
      <div class="qmodal-box">
        <div class="qmodal-icon">⚠️</div>
        <h3 class="qmodal-title">Kamu Meninggalkan Halaman!</h3>
        <p class="qmodal-desc">
          Karena kamu berpindah tab atau jendela,<br>
          quiz akan <strong>dikumpulkan otomatis</strong> dalam <span id="autoSubmitCountdown">3</span> detik.
        </p>
      </div>
    </div>

    <!-- Quiz Re-enter Fullscreen Modal -->
    <div id="quizReenterModal" class="qmodal-overlay" style="display:none">
      <div class="qmodal-box">
        <div class="qmodal-icon">🚨</div>
        <h3 class="qmodal-title">Kamu Keluar dari Mode Quiz!</h3>
        <p class="qmodal-desc">
          Quiz masih berlangsung dan timer tetap berjalan.<br>
          Kembali ke fullscreen untuk melanjutkan, atau quiz akan dikumpulkan otomatis.
        </p>
        <div class="qmodal-actions" style="justify-content:center">
          <button class="qmodal-start" onclick="reenterFullscreen()">🔲 Kembali ke Fullscreen</button>
          <button class="qmodal-cancel" onclick="forceSubmitAndExit()" style="color:#dc2626;border-color:#fca5a5">Kumpulkan & Keluar</button>
        </div>
      </div>
    </div>

    <style>
        /* ============================================================
           Layout Utama
        ============================================================ */
        .materi-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .breadcrumb-nav { margin-bottom: 20px; }

        .breadcrumb {
            background: #f8f9fa;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 0;
            font-size: 13px;
        }

        .materi-header {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .materi-header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .materi-header-info { flex: 1; min-width: 0; }

        .materi-title {
            margin: 0 0 8px;
            font-size: 22px;
            font-weight: 700;
            color: #1a202c;
            line-height: 1.3;
        }

        .materi-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .meta-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }
        .badge-publish { background: #dcfce7; color: #15803d; }
        .badge-draft   { background: #fef3c7; color: #b45309; }

        .meta-item {
            font-size: 12.5px;
            color: #6b7280;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .meta-item i { font-size: 14px; }

        .materi-start-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            background: linear-gradient(135deg, #1a73e8, #1557b0);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(26,115,232,0.25);
            transition: all 0.15s;
            flex-shrink: 0;
        }
        .materi-start-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(26,115,232,0.35); }
        .materi-start-btn i { font-size: 16px; }

        /* ============================================================
           Tabs
        ============================================================ */
        .materi-tabs {
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 0;
        }
        .materi-tabs > li > a {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 12px 18px;
            font-size: 14px;
        }
        .materi-tabs > li.active > a,
        .materi-tabs > li > a:hover {
            border-bottom: 3px solid #007bff;
            color: #007bff;
            background: none;
        }

        .tab-content { padding-top: 0; }

        /* ============================================================
           Tab Materi — split layout konten + chat
        ============================================================ */
        .materi-with-chat {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            min-height: 500px;
        }

        .materi-content-col {
            flex: 1;
            min-width: 0;
            padding-top: 20px;
            padding-right: 5px;
            overflow-y: auto;
            max-height: 600px;
        }

        .materi-content-col::-webkit-scrollbar { width: 5px; }
        .materi-content-col::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 3px; }

        .materi-content h1,
        .materi-content h2 { font-size: 1.4em; margin-top: 20px; margin-bottom: 10px; color: #212529; font-weight: 700; }
        .materi-content h3 { font-size: 1.2em; margin-top: 16px; margin-bottom: 8px; color: #343a40; font-weight: 600; }
        .materi-content h4,
        .materi-content h5 { font-size: 1.05em; margin-top: 12px; margin-bottom: 6px; color: #495057; font-weight: 600; }
        .materi-content p  { line-height: 1.75; color: #495057; margin-bottom: 10px; }
        .materi-content p:empty,
        .materi-content p:has(> br:only-child) { margin-bottom: 0; height: 0; overflow: hidden; }
        .materi-content ul,
        .materi-content ol { padding-left: 22px; margin-bottom: 12px; }
        .materi-content li { line-height: 1.7; color: #495057; margin-bottom: 4px; }
        .materi-content strong,
        .materi-content b  { font-weight: 700; color: #212529; }
        .materi-content em,
        .materi-content i  { font-style: italic; }
        .materi-content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 13.5px;
        }
        .materi-content table th,
        .materi-content table td {
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            text-align: left;
            vertical-align: top;
        }
        .materi-content table th {
            background: #f1f3f5;
            font-weight: 600;
            color: #343a40;
        }
        .materi-content table tr:nth-child(even) td { background: #f8f9fa; }
        .materi-content blockquote {
            border-left: 4px solid #1a73e8;
            background: #f0f6ff;
            margin: 12px 0;
            padding: 10px 16px;
            border-radius: 0 6px 6px 0;
            color: #495057;
            font-style: italic;
        }
        .materi-content pre,
        .materi-content code {
            background: #f4f6f9;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }
        .materi-content pre  { padding: 14px; overflow-x: auto; margin-bottom: 12px; border: 1px solid #e2e8f0; }
        .materi-content code { padding: 2px 6px; }

        .materi-chat-col {
            width: 340px;
            flex-shrink: 0;
            padding-top: 20px;
        }

        /* ============================================================
           AI Chat Panel — new clean design
        ============================================================ */
        .ai-chat-panel {
            display: flex;
            flex-direction: column;
            height: 580px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            border: 1px solid #e8ecf0;
            background: #fff;
            position: sticky;
            top: 90px;
        }

        /* Header */
        .ai-chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 18px;
            background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
            flex-shrink: 0;
        }

        .ai-chat-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ai-avatar-icon {
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            flex-shrink: 0;
        }

        .ai-chat-title {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }

        .ai-chat-subtitle {
            font-size: 11px;
            color: rgba(255,255,255,0.75);
            margin-top: 1px;
        }

        .ai-online-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #4caf50;
            border: 2px solid rgba(255,255,255,0.6);
            box-shadow: 0 0 0 2px rgba(76,175,80,0.3);
            animation: pulse-dot 2s infinite;
        }

        @@keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 0 2px rgba(76,175,80,0.3); }
            50%       { box-shadow: 0 0 0 5px rgba(76,175,80,0.1); }
        }

        /* Messages area */
        .ai-messages {
            flex: 1;
            padding: 16px 14px 10px;
            overflow-y: auto;
            background: #eef2f7;
            scroll-behavior: smooth;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .ai-messages::-webkit-scrollbar { width: 4px; }
        .ai-messages::-webkit-scrollbar-thumb { background: #b0bec5; border-radius: 4px; }

        /* Message rows */
        .ai-msg-row { display: flex; }
        .ai-row     { justify-content: flex-start; }
        .user-row   { justify-content: flex-end; }

        /* Bubbles */
        .ai-msg-bubble {
            max-width: 88%;
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 13.5px;
            line-height: 1.6;
            word-wrap: break-word;
        }

        .ai-bubble {
            background: #ffffff;
            border: 1px solid #cfd8e3;
            border-bottom-left-radius: 4px;
            color: #1a202c;
            box-shadow: 0 2px 6px rgba(0,0,0,0.10);
        }

        .user-bubble {
            background: linear-gradient(135deg, #1a73e8, #1557b0);
            border-bottom-right-radius: 4px;
            color: #fff;
            box-shadow: 0 2px 6px rgba(26,115,232,0.35);
        }

        .ai-msg-bubble p  { margin: 0; }
        .ai-msg-bubble p + p { margin-top: 6px; }
        .ai-msg-bubble ul,
        .ai-msg-bubble ol { margin: 6px 0; padding-left: 18px; }
        .ai-msg-bubble li { margin: 3px 0; }
        .ai-msg-bubble h1,
        .ai-msg-bubble h2,
        .ai-msg-bubble h3 { margin: 10px 0 5px; font-weight: 700; }
        .ai-msg-bubble h1 { font-size: 1.15em; }
        .ai-msg-bubble h2 { font-size: 1.08em; }
        .ai-msg-bubble h3 { font-size: 1.02em; }
        .ai-msg-bubble strong { font-weight: 700; }
        .ai-msg-bubble em { font-style: italic; }
        .ai-msg-bubble code {
            background: rgba(0,0,0,0.07);
            padding: 1px 5px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.87em;
        }
        .user-bubble code { background: rgba(255,255,255,0.2); }
        .ai-msg-bubble pre {
            background: #f0f4f8;
            padding: 10px 12px;
            border-radius: 8px;
            overflow-x: auto;
            margin: 8px 0;
            font-size: 0.85em;
            border: 1px solid #e2e8f0;
        }
        .ai-msg-bubble pre code { background: none; padding: 0; }

        /* Quick chips */
        .ai-chips {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 4px;
        }

        .ai-chip {
            display: block;
            width: 100%;
            text-align: left;
            background: #ffffff;
            border: 1.5px solid #b8d0f8;
            border-radius: 10px;
            padding: 9px 13px;
            font-size: 12.5px;
            font-weight: 500;
            color: #1557b0;
            cursor: pointer;
            transition: all 0.15s;
            box-shadow: 0 2px 5px rgba(26,115,232,0.12);
        }
        .ai-chip:hover {
            background: #dbeafe;
            border-color: #1a73e8;
            color: #0d47a1;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(26,115,232,0.2);
        }

        /* Typing indicator */
        .ai-typing-indicator {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 10px 14px;
            background: #fff;
            border: 1px solid #cfd8e3;
            border-radius: 16px;
            border-bottom-left-radius: 4px;
            width: 60px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.10);
        }
        .ai-typing-indicator span {
            width: 6px; height: 6px;
            background: #90a4ae;
            border-radius: 50%;
            display: inline-block;
            animation: typing-bounce 1.2s infinite ease-in-out;
        }
        .ai-typing-indicator span:nth-child(1) { animation-delay: 0s; }
        .ai-typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
        .ai-typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

        @@keyframes typing-bounce {
            0%, 80%, 100% { transform: translateY(0); opacity: 0.5; }
            40%           { transform: translateY(-4px); opacity: 1; }
        }

        /* Input area */
        .ai-input-area {
            padding: 12px 14px;
            background: #fff;
            border-top: 1px solid #edf0f4;
            flex-shrink: 0;
        }

        .ai-input-wrap {
            display: flex;
            align-items: center;
            background: #f4f6f9;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .ai-input-wrap:focus-within {
            border-color: #1a73e8;
            box-shadow: 0 0 0 3px rgba(26,115,232,0.12);
        }

        .ai-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px 14px;
            font-size: 13.5px;
            color: #333;
            outline: none;
        }
        .ai-input::placeholder { color: #9aa5b4; }
        .ai-input:disabled { opacity: 0.6; }

        .ai-send-btn {
            width: 38px;
            height: 38px;
            border: none;
            background: #1a73e8;
            color: #fff;
            border-radius: 9px;
            margin: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: background 0.2s, transform 0.15s;
            flex-shrink: 0;
        }
        .ai-send-btn:hover   { background: #1557b0; transform: scale(1.05); }
        .ai-send-btn:disabled { background: #b0bec5; cursor: not-allowed; transform: none; }

        .ai-input-hint {
            font-size: 11px;
            color: #b0bec5;
            text-align: center;
            margin-top: 7px;
        }

        /* ============================================================
           Tab lain (overview, contoh, latihan, quiz) — shared
        ============================================================ */
        .materi-section { padding: 20px 0; min-height: 300px; }
        .materi-section h3 { margin-top: 0; margin-bottom: 16px; }

        .tab-section { padding: 24px 0; min-height: 300px; }

        .tab-section-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }
        .tab-section-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .tab-section-title { margin: 0 0 3px; font-size: 18px; font-weight: 700; color: #1a202c; }
        .tab-section-sub   { margin: 0; font-size: 13px; color: #718096; }

        .tab-empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #a0aec0;
        }
        .tab-empty-state i  { font-size: 48px; display: block; margin-bottom: 12px; }
        .tab-empty-state p  { font-size: 15px; }

        .learning-objectives {
            background: #f8f9fa;
            padding: 18px 20px;
            border-radius: 6px;
            border-left: 4px solid #007bff;
        }
        .learning-objectives li { margin-bottom: 8px; }

        .code-example { margin-bottom: 28px; }
        .code-example pre {
            background: #f8f9fa;
            padding: 18px;
            border-radius: 6px;
            overflow-x: auto;
            border: 1px solid #e9ecef;
        }
        .code-example code { font-family: 'Courier New', monospace; font-size: 13.5px; line-height: 1.6; }

        /* ============================================================
           Latihan
        ============================================================ */
        .exercise-list { display: flex; flex-direction: column; gap: 14px; }

        .exercise-card {
            display: flex;
            gap: 16px;
            background: #fff;
            border: 1px solid #e8ecf0;
            border-radius: 12px;
            padding: 18px 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .exercise-card-num {
            width: 32px;
            height: 32px;
            background: #e8f5e9;
            color: #2e7d32;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }
        .exercise-card-body { flex: 1; min-width: 0; }
        .exercise-question  { font-size: 14.5px; font-weight: 600; color: #1a202c; margin: 0 0 10px; line-height: 1.6; }

        .exercise-meta { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 10px; }
        .exercise-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-type  { background: #e3f2fd; color: #1565c0; }
        .badge-point { background: #fff8e1; color: #f57f17; }

        .exercise-answer {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 7px 12px;
            margin-bottom: 8px;
        }
        .answer-label { font-size: 12px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .answer-value { font-size: 13.5px; color: #15803d; font-weight: 600; }

        .exercise-explanation {
            font-size: 13px;
            color: #4b5563;
            background: #fffbeb;
            border-left: 3px solid #f59e0b;
            border-radius: 0 6px 6px 0;
            padding: 8px 12px;
            line-height: 1.6;
        }

        .exercise-input-wrap {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .exercise-textarea,
        .exercise-input {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13.5px;
            color: #1a202c;
            background: #f8fafc;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
            outline: none;
            line-height: 1.5;
        }
        .exercise-textarea {
            resize: none;
            overflow: hidden;
            min-height: 38px;
        }
        .exercise-textarea:focus,
        .exercise-input:focus {
            border-color: #2e7d32;
            box-shadow: 0 0 0 3px rgba(46,125,50,0.1);
            background: #fff;
        }

        .exercise-check-btn {
            align-self: flex-start;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 16px;
            background: #2e7d32;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            box-shadow: 0 2px 8px rgba(46,125,50,0.25);
        }
        .exercise-check-btn:hover  { background: #1b5e20; transform: translateY(-1px); }
        .exercise-check-btn:disabled { background: #9e9e9e; cursor: not-allowed; transform: none; box-shadow: none; }
        .exercise-check-btn i { font-size: 16px; }

        .exercise-feedback {
            margin-top: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            line-height: 1.6;
        }
        .exercise-feedback.correct {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #15803d;
        }
        .exercise-feedback.essay-done {
            background: #f0f6ff;
            border: 1px solid #93c5fd;
            color: #1e40af;
        }
        .exercise-feedback .feedback-answer {
            margin-top: 8px;
            padding: 8px 12px;
            background: rgba(255,255,255,0.7);
            border-radius: 7px;
            font-style: italic;
        }

        /* ============================================================
           Quiz
        ============================================================ */
        .quiz-info-bar {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            background: #f0f6ff;
            border: 1px solid #c7deff;
            border-radius: 14px;
            padding: 18px 22px;
            margin-bottom: 28px;
        }
        .quiz-info-main { display: flex; align-items: center; gap: 14px; }
        .quiz-info-stats { display: flex; gap: 20px; flex-shrink: 0; }
        .quiz-stat {
            text-align: center;
            background: #fff;
            border: 1px solid #c7deff;
            border-radius: 10px;
            padding: 8px 16px;
            min-width: 60px;
        }
        .quiz-stat-val { display: block; font-size: 20px; font-weight: 700; color: #1565c0; line-height: 1.2; }
        .quiz-stat-lbl { display: block; font-size: 11px; color: #718096; margin-top: 2px; }

        .quiz-form { display: flex; flex-direction: column; gap: 16px; }

        .quiz-card {
            background: #fff;
            border: 1.5px solid #e8ecf0;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: border-color 0.2s;
        }
        .quiz-card:has(input:checked) { border-color: #a5c8ff; }

        .quiz-card-header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 20px 14px;
            border-bottom: 1px solid #f0f4f8;
        }
        .quiz-num {
            width: 28px;
            height: 28px;
            background: #1a73e8;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .quiz-question-text { margin: 0; font-size: 14.5px; font-weight: 600; color: #1a202c; line-height: 1.65; }

        .quiz-options { padding: 12px 20px 16px; display: flex; flex-direction: column; gap: 8px; }

        .quiz-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.15s;
            background: #fafbfc;
            margin: 0;
            font-weight: normal;
        }
        .quiz-option:hover { border-color: #93c5fd; background: #eff6ff; }
        .quiz-option input[type="radio"] { display: none; }
        .quiz-option input[type="radio"]:checked ~ .quiz-option-key {
            background: #1a73e8;
            color: #fff;
            border-color: #1a73e8;
        }
        .quiz-option:has(input:checked) {
            border-color: #1a73e8;
            background: #eff6ff;
        }

        .quiz-option-key {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1.5px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            flex-shrink: 0;
            transition: all 0.15s;
            background: #fff;
        }
        .quiz-option-text { font-size: 14px; color: #374151; line-height: 1.5; }

        .quiz-submit-area { text-align: center; margin-top: 8px; }
        .quiz-submit-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 36px;
            background: linear-gradient(135deg, #1a73e8, #1557b0);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(26,115,232,0.35);
            transition: all 0.2s;
        }
        .quiz-submit-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(26,115,232,0.4); }
        .quiz-submit-btn i { font-size: 18px; }

        .quiz-result {
            margin-top: 24px;
            padding: 24px 28px;
            border-radius: 14px;
            text-align: center;
        }
        .quiz-result.passed { background: #f0fdf4; border: 2px solid #86efac; }
        .quiz-result.failed { background: #fff1f2; border: 2px solid #fca5a5; }
        .quiz-result .result-score { font-size: 48px; font-weight: 800; line-height: 1; }
        .quiz-result.passed .result-score { color: #16a34a; }
        .quiz-result.failed .result-score { color: #dc2626; }
        .quiz-result .result-label { font-size: 16px; font-weight: 600; margin: 8px 0 4px; }
        .quiz-result .result-detail { font-size: 13.5px; color: #6b7280; }

        /* ============================================================
           Quiz Confirmation Modal
        ============================================================ */
        .qmodal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(3px);
        }
        .qmodal-box {
            background: #fff;
            border-radius: 20px;
            padding: 36px 32px 28px;
            max-width: 420px;
            width: calc(100% - 32px);
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            animation: modal-in 0.25s ease;
        }
        @@keyframes modal-in {
            from { transform: scale(0.9); opacity: 0; }
            to   { transform: scale(1);   opacity: 1; }
        }
        .qmodal-icon  { font-size: 40px; margin-bottom: 12px; }
        .qmodal-title { font-size: 20px; font-weight: 700; color: #1a202c; margin: 0 0 10px; }
        .qmodal-desc  { font-size: 14px; color: #4b5563; line-height: 1.7; margin: 0 0 20px; }

        .qmodal-stats {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 24px;
        }
        .qmodal-stat {
            background: #f0f6ff;
            border: 1px solid #c7deff;
            border-radius: 10px;
            padding: 8px 18px;
            font-size: 12px;
            color: #1e40af;
        }
        .qmodal-stat span { display: block; font-size: 20px; font-weight: 800; color: #1a73e8; }

        .qmodal-actions { display: flex; gap: 12px; justify-content: center; }
        .qmodal-cancel {
            padding: 10px 24px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #fff;
            color: #64748b;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }
        .qmodal-cancel:hover { background: #f8fafc; border-color: #cbd5e1; }
        .qmodal-start {
            padding: 10px 28px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #1a73e8, #1557b0);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(26,115,232,0.35);
            transition: all 0.15s;
        }
        .qmodal-start:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(26,115,232,0.4); }

        /* ============================================================
           Quiz Lockdown Bar
        ============================================================ */
        .quiz-lock-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 99998;
            pointer-events: none;
        }
        .quiz-lock-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #0d47a1, #1a73e8);
            color: #fff;
            padding: 10px 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.2);
            pointer-events: all;
        }
        .quiz-lock-title {
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .quiz-lock-title i { font-size: 18px; }
        .quiz-lock-timer {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1px;
        }
        .quiz-lock-timer i { font-size: 20px; opacity: 0.8; }
        .quiz-lock-timer.urgent { color: #ff5252; animation: blink-timer 1s infinite; }
        @@keyframes blink-timer {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.5; }
        }

        .quiz-lock-warning {
            background: #ff5252;
            color: #fff;
            text-align: center;
            padding: 8px;
            font-size: 13px;
            font-weight: 600;
            pointer-events: none;
        }

        /* Saat quiz aktif — navbar tidak bisa diklik */
        body.quiz-active .navbar { pointer-events: none; opacity: 0.5; }
        body.quiz-active .materi-tabs > li:not(.active) > a { pointer-events: none; opacity: 0.4; }

        /* ============================================================
           Mobile toggle button
        ============================================================ */
        .chat-toggle-btn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 56px;
            height: 56px;
            background: #007bff;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 26px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.25);
            z-index: 10000;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .chat-toggle-btn:hover { background: #0056b3; transform: scale(1.08); }

        /* Quiz Answers Review */
        .quiz-answers-review {
            margin-top: 20px;
        }
        .quiz-answers-review h4 {
            font-size: 16px;
            font-weight: 600;
        }

        /* ============================================================
           Responsive
        ============================================================ */
        @@media (max-width: 992px) {
            .materi-chat-col { width: 300px; }
        }

        @@media (max-width: 768px) {
            .materi-container { padding: 18px; }

            .materi-with-chat { flex-direction: column; gap: 0; }

            .materi-content-col {
                max-height: none;
                overflow-y: visible;
                padding-right: 0;
                width: 100%;
            }

            .materi-chat-col { width: 100%; }

            .ai-chat-panel {
                position: fixed;
                bottom: 80px;
                right: 15px;
                width: calc(100% - 30px);
                max-width: 360px;
                height: 480px;
                z-index: 9999;
                display: none;
                border-radius: 14px;
                box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            }
            .ai-chat-panel.active { display: flex; }

            .chat-toggle-btn { display: flex; }

            .ai-input { font-size: 16px; }
        }
    </style>

    <script>
        // ============================================================
        // Quiz Mode — Confirmation, Lockdown & Timer
        // ============================================================
        let quizTimerInterval = null;
        let quizSecondsLeft   = 0;
        let quizActive        = false;
        let currentQuizAttempt = null;
        const QUIZ_ALREADY_PASSED = {{ $passedQuizAttempt ? 'true' : 'false' }};
        const QUIZ_TIME_LIMIT = {{ $quiz->time_limit ?? 30 }};
        const QUIZ_ID = '{{ $quiz->id ?? '' }}';
        const QUIZ_PASSING_SCORE = {{ $quiz->passing_score ?? 60 }};
        const SUBCATEGORY_SLUG = '{{ $material->subcategory ? $material->subcategory->slug : ($material->subcategory_id ? \App\Models\Subcategory::find($material->subcategory_id)?->slug : '') }}';
        console.log('SUBCATEGORY_SLUG initialized:', SUBCATEGORY_SLUG);
        console.log('QUIZ_ALREADY_PASSED:', QUIZ_ALREADY_PASSED);

        function handleQuizTabClick(e) {
            if (quizActive) return; // already in quiz, allow
            if (QUIZ_ALREADY_PASSED) {
                // Already passed, manually switch to quiz tab
                e.preventDefault();
                document.querySelectorAll('.nav-tabs a').forEach(tab => tab.classList.remove('active'));
                document.getElementById('quizTabLink').classList.add('active');
                document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
                document.getElementById('quiz').classList.add('active');
                return;
            }
            // Not passed, show confirmation modal
            e.preventDefault();
            e.stopPropagation();
            // Store the current active tab to revert if cancelled
            window.previousActiveTab = document.querySelector('.nav-tabs li.active a');
            window.previousActivePane = document.querySelector('.tab-pane.active');
            document.getElementById('quizConfirmModal').style.display = 'flex';
        }

        function cancelQuiz() {
            document.getElementById('quizConfirmModal').style.display = 'none';
            // Revert to previous tab
            if (window.previousActiveTab && window.previousActivePane) {
                document.querySelectorAll('.nav-tabs a').forEach(tab => tab.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
                window.previousActiveTab.classList.add('active');
                window.previousActivePane.classList.add('active');
            }
        }

        async function startQuiz() {
            // Hide modal
            document.getElementById('quizConfirmModal').style.display = 'none';

            try {
                // Call API to start quiz
                const response = await fetch('/api/quiz/start', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        quiz_id: QUIZ_ID
                    })
                });

                const data = await response.json();

                if (!data.success) {
                    alert('Gagal memulai quiz: ' + data.message);
                    return;
                }

                currentQuizAttempt = data.attempt;

                // Switch to quiz tab
                quizActive = true;
                $('#quizTabLink').tab('show');

                // Activate lockdown
                document.body.classList.add('quiz-active');
                document.getElementById('quizLockOverlay').style.display = 'block';

                // Enter fullscreen — hides browser tab bar
                const el = document.documentElement;
                if (el.requestFullscreen) el.requestFullscreen();
                else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
                else if (el.mozRequestFullScreen) el.mozRequestFullScreen();

                // Start timer
                quizSecondsLeft = QUIZ_TIME_LIMIT * 60;
                updateTimerDisplay();
                quizTimerInterval = setInterval(function() {
                    quizSecondsLeft--;
                    updateTimerDisplay();
                    if (quizSecondsLeft <= 60) {
                        document.getElementById('quizTimerDisplay').classList.add('urgent');
                    }
                    if (quizSecondsLeft <= 0) {
                        clearInterval(quizTimerInterval);
                        autoSubmitQuiz();
                    }
                }, 1000);

            } catch (error) {
                console.error('Error starting quiz:', error);
                if (error instanceof SyntaxError) {
                    // Likely got HTML redirect (unauthenticated)
                    alert('Kamu harus login terlebih dahulu untuk mengerjakan quiz.');
                    window.location.href = '{{ route("login") }}';
                } else {
                    alert('Terjadi kesalahan saat memulai quiz. Silakan coba lagi.');
                }
            }
        }

        function updateTimerDisplay() {
            const m = Math.floor(quizSecondsLeft / 60).toString().padStart(2, '0');
            const s = (quizSecondsLeft % 60).toString().padStart(2, '0');
            document.getElementById('timerText').textContent = m + ':' + s;
        }

        function autoSubmitQuiz() {
            showWarningBanner('⏰ Waktu habis! Quiz dikumpulkan otomatis.');
            submitQuiz();
            endQuiz();
        }

        function endQuiz() {
            // Set false FIRST before any async ops so all listeners bail early
            quizActive = false;
            clearInterval(quizTimerInterval);

            // Remove all lockdown listeners immediately
            window.removeEventListener('beforeunload', quizBeforeUnload);
            document.removeEventListener('visibilitychange', quizVisibilityChange);

            document.body.classList.remove('quiz-active');
            document.getElementById('quizLockOverlay').style.display = 'none';
            document.getElementById('quizReenterModal').style.display = 'none';
            document.getElementById('quizAutoSubmitModal').style.display = 'none';
            clearInterval(autoSubmitCountdownInterval);

            // Exit fullscreen after listeners removed so fullscreenchange won't trigger re-enter modal
            if (document.fullscreenElement || document.webkitFullscreenElement) {
                if (document.exitFullscreen) document.exitFullscreen();
                else if (document.webkitExitFullscreen) document.webkitExitFullscreen();
            }
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

        function reenterFullscreen() {
            document.getElementById('quizReenterModal').style.display = 'none';
            const el = document.documentElement;
            if (el.requestFullscreen) el.requestFullscreen();
            else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
        }

        function forceSubmitAndExit() {
            document.getElementById('quizReenterModal').style.display = 'none';
            autoSubmitQuiz();
        }

        function showWarningBanner(msg) {
            const banner = document.getElementById('quizWarningBanner');
            banner.textContent = msg;
            banner.style.display = 'block';
            setTimeout(() => { banner.style.display = 'none'; }, 4000);
        }

        // Prevent leaving page during quiz
        function quizBeforeUnload(e) {
            if (!quizActive) return;
            e.preventDefault();
            e.returnValue = 'Quiz sedang berlangsung. Yakin ingin meninggalkan halaman?';
            return e.returnValue;
        }
        window.addEventListener('beforeunload', quizBeforeUnload);

        // Detect tab switch / minimize
        let visibilitySubmitPending = false;
        let autoSubmitCountdownInterval = null;
        function quizVisibilityChange() {
            if (!quizActive || visibilitySubmitPending) return;
            if (document.hidden) {
                visibilitySubmitPending = true;
                // Show modal with countdown
                const modal = document.getElementById('quizAutoSubmitModal');
                const countdownEl = document.getElementById('autoSubmitCountdown');
                modal.style.display = 'flex';
                let secs = 3;
                countdownEl.textContent = secs;
                autoSubmitCountdownInterval = setInterval(function() {
                    secs--;
                    countdownEl.textContent = secs;
                    if (secs <= 0) {
                        clearInterval(autoSubmitCountdownInterval);
                        modal.style.display = 'none';
                        visibilitySubmitPending = false;
                        if (quizActive) autoSubmitQuiz();
                    }
                }, 3000);
            }
        }
        document.addEventListener('visibilitychange', quizVisibilityChange);

        // Block other tabs from being clicked during quiz
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.materi-tabs a').forEach(function(link) {
                if (link.id === 'quizTabLink') return;
                link.addEventListener('click', function(e) {
                    if (quizActive) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                });
            });
        });

        // Override submitQuiz to call endQuiz after done
        const _origSubmitQuiz = typeof submitQuiz === 'function' ? submitQuiz : null;

        // Auto-resize textarea as user types
        function autoResize(el) {
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 'px';
        }

        // Check exercise answer
        async function checkExercise(index, correctAnswer, explanation, question) {
            const input = document.getElementById('ans-' + index);
            const feedback = document.getElementById('feedback-' + index);
            const btn = document.querySelector('#exercise-' + index + ' .exercise-check-btn');

            if (!input || !feedback) return;

            const answer = input.value.trim();
            if (answer === '') {
                input.style.borderColor = '#f59e0b';
                input.focus();
                return;
            }

            // Disable input & button after submit
            input.disabled = true;
            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="ion-ios-loading"></i> Mengoreksi...'; }

            const isEssay = input.tagName === 'TEXTAREA';

            if (isEssay) {
                feedback.className = 'exercise-feedback essay-done';
                feedback.innerHTML = '<span style="color:#6b7280">⏳ AI sedang mengoreksi jawaban kamu...</span>';
                feedback.style.display = 'block';

                try {
                    const response = await fetch('/api/ai/grade-essay', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            question: question || '',
                            user_answer: answer,
                            correct_answer: correctAnswer || ''
                        })
                    });

                    const data = await response.json();

                    if (data.success && data.result) {
                        const r = data.result;
                        const score = r.score ?? 0;
                        const verdict = r.verdict ?? '';
                        const verdictColor = verdict === 'Benar' ? '#16a34a' : verdict === 'Sebagian Benar' ? '#d97706' : '#dc2626';
                        const verdictIcon = verdict === 'Benar' ? '✅' : verdict === 'Sebagian Benar' ? '⚠️' : '❌';

                        feedback.className = 'exercise-feedback ' + (verdict === 'Benar' ? 'correct' : 'essay-done');
                        feedback.innerHTML = `
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                                <span style="font-size:20px">${verdictIcon}</span>
                                <strong style="color:${verdictColor}">${verdict}</strong>
                                <span style="margin-left:auto;background:${verdictColor};color:#fff;padding:2px 10px;border-radius:20px;font-size:12px;font-weight:700">${score}/100</span>
                            </div>
                            <div class="feedback-answer">${r.feedback ?? ''}</div>
                            ${r.suggestion ? '<div class="feedback-answer" style="margin-top:6px"><strong>💡 Saran:</strong> ' + r.suggestion + '</div>' : ''}
                        `;
                    } else {
                        feedback.innerHTML = `<strong>📝 Jawaban tersimpan.</strong>${correctAnswer ? '<div class="feedback-answer"><strong>Kunci:</strong> ' + correctAnswer + '</div>' : ''}`;
                    }
                } catch (e) {
                    feedback.innerHTML = `<strong>📝 Jawaban tersimpan.</strong>${correctAnswer ? '<div class="feedback-answer"><strong>Kunci:</strong> ' + correctAnswer + '</div>' : ''}`;
                }

                if (btn) btn.innerHTML = '<i class="ion-ios-checkmark-outline"></i> Selesai';
            } else {
                // Short answer: bandingkan (case-insensitive)
                const isCorrect = answer.toLowerCase() === correctAnswer.toLowerCase();
                feedback.className = 'exercise-feedback ' + (isCorrect ? 'correct' : 'essay-done');
                if (isCorrect) {
                    feedback.innerHTML = `<strong>✅ Jawaban kamu benar!</strong>${explanation ? '<div class="feedback-answer">' + explanation + '</div>' : ''}`;
                } else {
                    feedback.innerHTML = `
                        <strong>❌ Belum tepat.</strong>
                        <div class="feedback-answer"><strong>Jawaban yang benar:</strong> ${correctAnswer}</div>
                        ${explanation ? '<div class="feedback-answer" style="margin-top:6px"><strong>Penjelasan:</strong> ' + explanation + '</div>' : ''}
                    `;
                }
            }

            feedback.style.display = 'block';
        }

        // Submit Quiz & show result
        async function submitQuiz() {
            const form = document.getElementById('quizForm');
            const resultPanel = document.getElementById('quizResult');
            if (!form || !resultPanel) return;

            if (!currentQuizAttempt) {
                alert('Quiz belum dimulai. Silakan mulai quiz terlebih dahulu.');
                return;
            }

            const cards = form.querySelectorAll('.quiz-card');
            const answers = [];

            cards.forEach((card, index) => {
                const selected = card.querySelector('input[type="radio"]:checked');
                const questionId = card.dataset.questionId || '';

                if (selected) {
                    answers.push({
                        quiz_question_id: questionId,
                        user_answer: selected.value
                    });
                }
            });

            try {
                const response = await fetch('/api/quiz/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        attempt_id: currentQuizAttempt.id,
                        answers: answers
                    })
                });

                const data = await response.json();

                if (!data.success) {
                    alert('Gagal submit quiz: ' + data.message);
                    return;
                }

                // Display results from backend
                const score = data.score_percentage;
                const passed = data.passed;
                const passingScore = data.passing_score;

                // Highlight correct/incorrect answers
                cards.forEach((card, index) => {
                    const selected = card.querySelector('input[type="radio"]:checked');
                    const allOptions = card.querySelectorAll('.quiz-option');

                    // Reset styles
                    allOptions.forEach(opt => {
                        opt.style.borderColor = '';
                        opt.style.background = '';
                        const key = opt.querySelector('.quiz-option-key');
                        if (key) { key.style.background = ''; key.style.color = ''; key.style.borderColor = ''; }
                    });

                    const correctAnswer = card.querySelector('input[type="radio"]')?.dataset.correct || null;

                    if (selected) {
                        const isCorrect = selected.value === correctAnswer;

                        // Highlight selected
                        const selectedLabel = selected.closest('.quiz-option');
                        if (selectedLabel) {
                            selectedLabel.style.borderColor = isCorrect ? '#16a34a' : '#dc2626';
                            selectedLabel.style.background  = isCorrect ? '#f0fdf4' : '#fff1f2';
                            const key = selectedLabel.querySelector('.quiz-option-key');
                            if (key) {
                                key.style.background   = isCorrect ? '#16a34a' : '#dc2626';
                                key.style.color        = '#fff';
                                key.style.borderColor  = isCorrect ? '#16a34a' : '#dc2626';
                            }
                        }
                    }

                    // Show correct answer if wrong or unanswered
                    if (correctAnswer && (!selected || selected.value !== correctAnswer)) {
                        allOptions.forEach(opt => {
                            const input = opt.querySelector('input[type="radio"]');
                            if (input && input.value === correctAnswer) {
                                opt.style.borderColor = '#16a34a';
                                opt.style.background  = '#f0fdf4';
                                const key = opt.querySelector('.quiz-option-key');
                                if (key) { key.style.background = '#16a34a'; key.style.color = '#fff'; key.style.borderColor = '#16a34a'; }
                            }
                        });
                    }
                });

                const total = cards.length;
                const correct = answers.filter(a => a.is_correct).length;

                resultPanel.className = 'quiz-result ' + (passed ? 'passed' : 'failed');
                resultPanel.innerHTML = `
                    <div class="result-score">${score}</div>
                    <div class="result-label">${passed ? '🎉 Selamat, kamu lulus!' : '😔 Belum lulus, coba lagi'}</div>
                    <div class="result-detail">Nilai kamu: ${score}% &nbsp;·&nbsp; Nilai lulus minimal ${passingScore}%</div>
                    ${passed && data.unlocked_next_material ? '<div class="result-detail" style="color:#16a34a;margin-top:8px">✨ Materi berikutnya telah terbuka!</div>' : ''}
                `;
                resultPanel.style.display = 'block';

                // End quiz lockdown (only if manually submitted, not auto-submit)
                if (quizActive) endQuiz();

                // If passed and saved to database, redirect to mindmap
                if (passed && data.saved) {
                    // Disable submit button
                    const submitBtn = form.querySelector('.quiz-submit-btn');
                    if (submitBtn) { submitBtn.disabled = true; submitBtn.style.opacity = '0.6'; submitBtn.style.cursor = 'default'; }

                    setTimeout(() => {
                        console.log('SUBCATEGORY_SLUG:', SUBCATEGORY_SLUG);
                        console.log('Redirecting to:', SUBCATEGORY_SLUG ? '/mindmap/' + SUBCATEGORY_SLUG : '/kelas');
                        window.location.href = SUBCATEGORY_SLUG ? '/mindmap/' + SUBCATEGORY_SLUG : '/kelas';
                    }, 3000);
                } else if (!passed) {
                    // If failed, allow retry by re-enabling submit button
                    const submitBtn = form.querySelector('.quiz-submit-btn');
                    if (submitBtn) { 
                        submitBtn.disabled = false; 
                        submitBtn.style.opacity = '1'; 
                        submitBtn.style.cursor = 'pointer';
                        submitBtn.textContent = 'Coba Lagi';
                    }

                    // Scroll to result for failed quiz
                    setTimeout(() => {
                        resultPanel.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 100);
                }

            } catch (error) {
                console.error('Error submitting quiz:', error);
                alert('Terjadi kesalahan saat submit quiz');
            }
        }

        // Toggle chat popup on mobile
        function toggleChat() {
            const chatbox = document.querySelector('.ai-chat-panel');
            if (chatbox) {
                chatbox.classList.toggle('active');
            }
        }

        // Get or create session ID
        function getSessionId() {
            let sessionId = localStorage.getItem('ai_chat_session_id');
            if (!sessionId) {
                sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                localStorage.setItem('ai_chat_session_id', sessionId);
            }
            return sessionId;
        }

        // Load chat history on page load
        function loadChatHistory() {
            const sessionId = getSessionId();

            fetch('/api/ai/history?session_id=' + sessionId)
                .then(response => response.json())
                .then(data => {
                    const history = data.history || data.messages || [];
                    if (history.length > 0) {
                        const messagesContainer = document.getElementById('chatMessages');
                        if (messagesContainer) {
                            messagesContainer.innerHTML = '';

                            history.forEach(msg => {
                                if (msg.role === 'user' || msg.role === 'assistant') {
                                    addMessage(msg.message || msg.content, msg.role === 'assistant' ? 'ai' : 'user');
                                }
                            });

                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading chat history:', error);
                });
        }

        // Load chat history when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadChatHistory();
        });
        
        function startLearning() {
            // Switch to materi tab
            $('a[href="#materi"]').tab('show');
        }

        function showTypingIndicator() {
            const messagesContainer = document.getElementById('chatMessages');
            const typingDiv = document.createElement('div');
            typingDiv.className = 'ai-msg-row ai-row';
            typingDiv.id = 'typingIndicator';
            typingDiv.innerHTML = '<div class="ai-typing-indicator"><span></span><span></span><span></span></div>';
            messagesContainer.appendChild(typingDiv);
            requestAnimationFrame(() => {
                messagesContainer.scrollTop = typingDiv.offsetTop - messagesContainer.offsetTop;
            });
        }

        function hideTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            if (indicator) indicator.remove();
        }

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const sendBtn = document.querySelector('.ai-send-btn');
            const message = input.value.trim();

            if (message === '') return;

            // Add user message
            addMessage(message, 'user');

            // Clear input and disable controls
            input.value = '';
            input.disabled = true;
            if (sendBtn) sendBtn.disabled = true;

            // Show typing indicator
            showTypingIndicator();

            // Hide quick chips after first message
            const chips = document.getElementById('aiChips');
            if (chips) chips.style.display = 'none';

            // Get material content
            const materialContentElement = document.querySelector('.materi-content');
            const materialContent = materialContentElement ? materialContentElement.innerText : '';

            // Get session ID
            const sessionId = getSessionId();

            // Send to backend API
            fetch('/api/ai/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    message: message,
                    material_content: materialContent,
                    session_id: sessionId
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                hideTypingIndicator();
                if (data.message) {
                    addMessage(data.message, 'ai');
                } else if (data.error) {
                    addMessage('Maaf, terjadi kesalahan: ' + data.error, 'ai');
                }
            })
            .catch(error => {
                hideTypingIndicator();
                const errMsg = error && error.error ? error.error : 'Maaf, terjadi kesalahan koneksi. Silakan coba lagi.';
                addMessage(errMsg, 'ai');
                console.error('Error:', error);
            })
            .finally(() => {
                input.disabled = false;
                if (sendBtn) sendBtn.disabled = false;
                input.focus();
            });
        }
        
        function askQuestion(question) {
            document.getElementById('messageInput').value = question;
            sendMessage();
        }
        
        function addMessage(text, sender) {
            const messagesContainer = document.getElementById('chatMessages');

            const rowDiv = document.createElement('div');
            rowDiv.className = sender === 'ai' ? 'ai-msg-row ai-row' : 'ai-msg-row user-row';

            const bubbleDiv = document.createElement('div');
            bubbleDiv.className = sender === 'ai' ? 'ai-msg-bubble ai-bubble' : 'ai-msg-bubble user-bubble';

            if (sender === 'ai') {
                bubbleDiv.innerHTML = parseMarkdown(text);
            } else {
                bubbleDiv.innerHTML = `<p style="margin:0">${text}</p>`;
            }

            rowDiv.appendChild(bubbleDiv);
            messagesContainer.appendChild(rowDiv);

            if (sender === 'user') {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            } else {
                // Scroll container ke posisi awal bubble AI (tidak scroll halaman)
                requestAnimationFrame(() => {
                    messagesContainer.scrollTop = rowDiv.offsetTop - messagesContainer.offsetTop;
                });
            }
        }
        
        function parseMarkdown(text) {
            // Escape HTML to prevent XSS
            let html = text
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');

            // Parse code blocks FIRST (before inline code to avoid conflict)
            html = html.replace(/```[\w]*\n?([\s\S]*?)```/g, '<pre><code>$1</code></pre>');

            // Parse headers
            html = html.replace(/^### (.*$)/gim, '<h3>$1</h3>');
            html = html.replace(/^## (.*$)/gim, '<h2>$1</h2>');
            html = html.replace(/^# (.*$)/gim, '<h1>$1</h1>');

            // Parse bold
            html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

            // Parse italic (avoid matching inside bold)
            html = html.replace(/(?<!\*)\*(?!\*)(.+?)(?<!\*)\*(?!\*)/g, '<em>$1</em>');

            // Parse inline code (after code blocks)
            html = html.replace(/`([^`]+)`/g, '<code>$1</code>');

            // Parse numbered lists (1., 2., 3., etc.)
            html = html.replace(/^\d+\.\s+(.*$)/gim, '<li>$1</li>');

            // Parse bullet points (- item)
            html = html.replace(/^[-]\s+(.*$)/gim, '<li>$1</li>');

            // Wrap consecutive list items in <ul> tags
            html = html.replace(/(<li>[\s\S]*?<\/li>)(\s*<li>[\s\S]*?<\/li>)*/g, function(match) {
                return '<ul>' + match + '</ul>';
            });
            html = html.replace(/<\/ul>\s*<ul>/g, '');

            // Parse line breaks (skip inside pre blocks)
            html = html.replace(/(?!<\/?(pre|code)[^>]*>)\n/g, '<br>');

            return html;
        }
        
        // Enter key to send message
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        
        // Close chat on mobile when clicking outside
        document.addEventListener('click', function(event) {
            const chatbox = document.querySelector('.ai-chat-panel');
            const chatToggleBtn = document.getElementById('chatToggleBtn');

            if (chatbox && chatToggleBtn && window.innerWidth <= 768) {
                if (!chatbox.contains(event.target) && !chatToggleBtn.contains(event.target)) {
                    if (chatbox.classList.contains('active')) {
                        chatbox.classList.remove('active');
                    }
                }
            }
        });
    </script>
@endsection
