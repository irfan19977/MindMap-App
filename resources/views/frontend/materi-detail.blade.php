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
          <!-- Konten Materi -->
          <div class="col-md-8">
            <div class="materi-container">
              <!-- Breadcrumb -->
              <nav class="breadcrumb-nav">
                <ol class="breadcrumb">
                  <li><a href="/mindmap">MindMap</a></li>
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
                <div class="row">
                  <div class="col-md-8">
                    <h2>{{ $material->title }}</h2>
                    <div class="materi-meta">
                      <span class="level-badge beginner">{{ $material->status == 'publish' ? 'Diterbitkan' : 'Draft' }}</span>
                      <span class="duration"><i class="ion-ios-clock-outline"></i> {{ $material->is_free ? 'Gratis' : 'Berbayar' }}</span>
                    </div>
                  </div>
                  <div class="col-md-4 text-right">
                    <button class="btn btn-primary" onclick="startLearning()">
                      <i class="ion-ios-play-outline"></i> Mulai Belajar
                    </button>
                  </div>
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
                  <a href="#quiz" aria-controls="quiz" role="tab" data-toggle="tab">Quiz</a>
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
                
                <!-- Materi Tab -->
                <div role="tabpanel" class="tab-pane" id="materi">
                  <div class="materi-section">
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
                        <p>{{ $material->content }}</p>
                      @endif
                    </div>
                  </div>
                </div>
                
                <!-- Contoh Kode Tab -->
                <div role="tabpanel" class="tab-pane" id="contoh">
                  <div class="materi-section">
                    <h3>Contoh Kode HTML</h3>
                    
                    <div class="code-example">
                      <h4>Struktur Dasar HTML</h4>
                      <pre><code>&lt;!DOCTYPE html&gt;
&lt;html lang="id"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;Halaman Web Saya&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;header&gt;
        &lt;h1&gt;Selamat Datang&lt;/h1&gt;
        &lt;nav&gt;
            &lt;ul&gt;
                &lt;li&gt;&lt;a href="#"&gt;Beranda&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a href="#"&gt;Tentang&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a href="#"&gt;Kontak&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
        &lt;/nav&gt;
    &lt;/header&gt;
    
    &lt;main&gt;
        &lt;section&gt;
            &lt;h2&gt;Konten Utama&lt;/h2&gt;
            &lt;p&gt;Ini adalah paragraf pertama saya.&lt;/p&gt;
        &lt;/section&gt;
    &lt;/main&gt;
    
    &lt;footer&gt;
        &lt;p&gt;&amp;copy; 2024 Website Saya&lt;/p&gt;
    &lt;/footer&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
                    </div>
                    
                    <div class="code-example">
                      <h4>Form HTML</h4>
                      <pre><code>&lt;form action="/submit" method="POST"&gt;
    &lt;div class="form-group"&gt;
        &lt;label for="name"&gt;Nama:&lt;/label&gt;
        &lt;input type="text" id="name" name="name" required&gt;
    &lt;/div&gt;
    
    &lt;div class="form-group"&gt;
        &lt;label for="email"&gt;Email:&lt;/label&gt;
        &lt;input type="email" id="email" name="email" required&gt;
    &lt;/div&gt;
    
    &lt;div class="form-group"&gt;
        &lt;label for="message"&gt;Pesan:&lt;/label&gt;
        &lt;textarea id="message" name="message" rows="4"&gt;&lt;/textarea&gt;
    &lt;/div&gt;
    
    &lt;button type="submit"&gt;Kirim&lt;/button&gt;
&lt;/form&gt;</code></pre>
                    </div>
                  </div>
                </div>
                
                <!-- Latihan Tab -->
                <div role="tabpanel" class="tab-pane" id="latihan">
                  <div class="materi-section">
                    <h3>Latihan Praktik</h3>

                    @if($material->latihan_data && is_array($material->latihan_data))
                      @foreach($material->latihan_data as $index => $latihan)
                        <div class="exercise-item">
                          <h4>Latihan {{ $index + 1 }}: {{ $latihan['question'] ?? 'Soal Latihan' }}</h4>
                          @if(isset($latihan['type']))
                            <p>Tipe: {{ $latihan['type'] }}</p>
                          @endif
                          @if(isset($latihan['points']))
                            <p>Poin: {{ $latihan['points'] }}</p>
                          @endif
                          @if(isset($latihan['correct_answer']))
                            <p>Jawaban Benar: {{ $latihan['correct_answer'] }}</p>
                          @endif
                          @if(isset($latihan['explanation']))
                            <p>Penjelasan: {{ $latihan['explanation'] }}</p>
                          @endif
                        </div>
                      @endforeach
                    @else
                      <p>Belum ada latihan untuk materi ini.</p>
                    @endif
                  </div>
                </div>
                
                <!-- Quiz Tab -->
                <div role="tabpanel" class="tab-pane" id="quiz">
                  <div class="materi-section">
                    <h3>Quiz {{ $material->title }}</h3>

                    @if($material->quiz_data && is_array($material->quiz_data))
                      @if(isset($material->quiz_data['title']))
                        <h4>{{ $material->quiz_data['title'] }}</h4>
                      @endif
                      @if(isset($material->quiz_data['description']))
                        <p>{{ $material->quiz_data['description'] }}</p>
                      @endif
                      @if(isset($material->quiz_data['passing_score']))
                        <p>Nilai Lulus Minimal: {{ $material->quiz_data['passing_score'] }}</p>
                      @endif
                      @if(isset($material->quiz_data['time_limit']))
                        <p>Batas Waktu: {{ $material->quiz_data['time_limit'] }} menit</p>
                      @endif

                      <div class="quiz-container">
                        @if(isset($material->quiz_data['questions']) && is_array($material->quiz_data['questions']))
                          @foreach($material->quiz_data['questions'] as $index => $question)
                            <div class="quiz-question">
                              <h4>{{ $index + 1 }}. {{ $question['question'] ?? 'Pertanyaan' }}</h4>
                              @if(isset($question['options']) && is_array($question['options']))
                                <div class="quiz-options">
                                  @foreach($question['options'] as $optionKey => $optionValue)
                                    <label class="quiz-option">
                                      <input type="radio" name="q{{ $index }}" value="{{ $optionKey }}">
                                      <span>{{ $optionValue }}</span>
                                    </label>
                                  @endforeach
                                </div>
                              @endif
                            </div>
                          @endforeach
                        @endif
                        <button class="btn btn-success btn-lg">Submit Quiz</button>
                      </div>
                    @else
                      <p>Belum ada quiz untuk materi ini.</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Sidebar AI -->
          <div class="col-md-4">
            <!-- Mobile chat toggle button -->
            <button class="chat-toggle-btn" onclick="toggleChat()">
                <i class="ion-ios-chatboxes-outline"></i>
            </button>

            <div class="sidebar-chatbox">
              <div class="chatbox-header">
                <h4><i class="ion-ios-chatboxes-outline"></i> AI Assistant</h4>
                <div class="chatbox-controls">
                  <div class="chatbox-status">
                    <span class="status-indicator online"></span>
                    <span>Online</span>
                  </div>
                </div>
              </div>

              <div class="chatbox-messages" id="chatMessages">
                <div class="message ai-message">
                  <div class="message-avatar">
                    <i class="ion-ios-robot-outline"></i>
                  </div>
                  <div class="message-content">
                    <p>Halo! Saya AI Assistant Anda. Saya siap membantu Anda memahami materi HTML. Ada yang bisa saya bantu?</p>
                  </div>
                </div>
              </div>

              <div class="chatbox-input">
                <div class="input-group">
                  <input type="text" id="messageInput" class="form-control" placeholder="Ketik pertanyaan Anda...">
                  <span class="input-group-btn">
                    <button class="btn btn-primary" onclick="sendMessage()" title="Kirim (Enter)">
                      →
                    </button>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <style>
        .materi-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        
        .breadcrumb-nav {
            margin-bottom: 30px;
        }
        
        .breadcrumb {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .materi-header {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .materi-meta {
            margin-top: 10px;
        }
        
        .materi-meta span {
            margin-right: 20px;
            color: #6c757d;
        }
        
        .level-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .level-badge.beginner {
            background: #28a745;
            color: white;
        }
        
        .materi-tabs {
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 30px;
        }
        
        .materi-tabs > li > a {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 15px 20px;
        }
        
        .materi-tabs > li.active > a {
            border-bottom: 3px solid #007bff;
            color: #007bff;
            background: none;
        }
        
        .materi-section {
            min-height: 400px;
        }
        
        .learning-objectives {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        
        .learning-objectives li {
            margin-bottom: 10px;
        }
        
        .materi-item {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        
        .materi-item:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .materi-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .materi-duration {
            color: #6c757d;
            font-size: 14px;
        }
        
        .materi-topics {
            margin-top: 10px;
        }
        
        .topic-tag {
            display: inline-block;
            background: #e9ecef;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 12px;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        
        .code-example {
            margin-bottom: 30px;
        }
        
        .code-example pre {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            overflow-x: auto;
            border: 1px solid #e9ecef;
        }
        
        .code-example code {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .exercise-item {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .exercise-requirements {
            background: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        
        .quiz-question {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .quiz-options {
            margin-top: 15px;
        }
        
        .quiz-option {
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .quiz-option:hover {
            background: #e9ecef;
        }
        
        .quiz-option input {
            margin-right: 10px;
        }
        
        /* Sidebar Chatbox */
        .sidebar-chatbox {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            height: calc(100vh - 120px);
            position: sticky;
            top: 100px;
        }
        
        .chatbox-header {
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
            border-radius: 10px 10px 0 0;
        }
        
        .chatbox-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .chatbox-status {
            display: flex;
            align-items: center;
            font-size: 12px;
            color: #6c757d;
        }
        
        .close-btn {
            background: none;
            border: none;
            color: #6c757d;
            font-size: 18px;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .close-btn:hover {
            background: #e9ecef;
            color: #495057;
        }
        
        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 5px;
        }
        
        .status-indicator.online {
            background: #28a745;
        }
        
        .chatbox-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background: #f8f9fa;
            scroll-behavior: smooth;
        }
        
        .message {
            display: flex;
            margin-bottom: 8px;
        }

        .message-avatar {
            display: none; /* Hide avatar like WhatsApp */
        }

        .message-content {
            background: white;
            padding: 8px 12px;
            border-radius: 8px;
            max-width: 75%;
            box-shadow: 0 1px 0.5px rgba(0,0,0,0.13);
            font-size: 14.2px;
            line-height: 19px;
            position: relative;
            word-wrap: break-word;
        }

        .message-content p {
            margin: 0;
            padding: 0;
        }

        .message-content ul, .message-content ol {
            margin: 8px 0;
            padding-left: 20px;
        }

        .message-content li {
            margin: 4px 0;
            line-height: 1.5;
        }

        .message-content h1, .message-content h2, .message-content h3 {
            margin: 12px 0 8px 0;
            font-weight: 600;
        }

        .message-content h1 {
            font-size: 1.3em;
        }

        .message-content h2 {
            font-size: 1.2em;
        }

        .message-content h3 {
            font-size: 1.1em;
        }

        .message-content strong {
            font-weight: 600;
        }

        .message-content em {
            font-style: italic;
        }

        .message-content code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }

        .message-content pre {
            background: #f4f4f4;
            padding: 12px;
            border-radius: 6px;
            overflow-x: auto;
            margin: 8px 0;
        }

        .message-content pre code {
            background: none;
            padding: 0;
        }

        /* AI message (received) - left side with white */
        .ai-message {
            justify-content: flex-start;
        }

        .ai-message .message-content {
            background: white;
            border-top-left-radius: 0;
        }

        /* User message (sent) - right side with blue */
        .user-message {
            justify-content: flex-end;
        }

        .user-message .message-content {
            background: #007bff;
            border-top-right-radius: 0;
            color: white;
        }
        
        .chatbox-input {
            padding: 15px;
            border-top: 1px solid #e9ecef;
            background: white;
            border-radius: 0 0 10px 10px;
        }
        
        .chatbox-input .input-group {
            display: flex;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .chatbox-input .form-control {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 20px 0 0 20px;
            padding: 8px 15px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        
        .chatbox-input .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
        }
        
        .chatbox-input .input-group-btn {
            display: flex;
        }
        
        .chatbox-input .input-group-btn .btn {
            border-radius: 0 20px 20px 0;
            border-left: none;
            background: #007bff;
            color: white;
            border: 1px solid #007bff;
            padding: 8px 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 45px;
            transition: background-color 0.3s ease;
        }
        
        .chatbox-input .input-group-btn .btn:hover {
            background: #0056b3;
            border-color: #0056b3;
        }

        @media (max-width: 768px) {
            .materi-container {
                padding: 20px;
            }

            .sidebar-chatbox {
                position: fixed;
                bottom: 80px;
                right: 20px;
                width: 90%;
                max-width: 350px;
                height: 500px;
                max-height: 70vh;
                z-index: 9999;
                display: none;
                border-radius: 15px;
                box-shadow: 0 5px 25px rgba(0,0,0,0.3);
            }

            .sidebar-chatbox.active {
                display: flex;
            }

            .chatbox-input .form-control {
                padding: 10px 15px;
                font-size: 16px; /* Prevent zoom on iOS */
            }

            .chatbox-input .input-group-btn .btn {
                padding: 10px 15px;
                min-width: 50px;
            }

            .materi-item-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .materi-duration {
                margin-top: 5px;
            }
        }

        /* Chat toggle button for mobile */
        .chat-toggle-btn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: #007bff;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            z-index: 10000;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }

        .chat-toggle-btn:hover {
            background: #0056b3;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .chat-toggle-btn {
                display: flex;
            }
        }
    </style>

    <script>
        // Toggle chat popup on mobile
        function toggleChat() {
            const chatbox = document.querySelector('.sidebar-chatbox');
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
                    if (data.history && data.history.length > 0) {
                        const messagesContainer = document.getElementById('chatMessages');
                        if (messagesContainer) {
                            messagesContainer.innerHTML = ''; // Clear default message

                            data.history.forEach(msg => {
                                if (msg.role === 'user' || msg.role === 'assistant') {
                                    addMessage(msg.message, msg.role === 'assistant' ? 'ai' : 'user');
                                }
                            });

                            // Scroll to bottom
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

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();

            if (message === '') return;

            // Add user message
            addMessage(message, 'user');

            // Clear input
            input.value = '';

            // Hide badge after first message
            const badge = document.querySelector('.chat-badge');
            if (badge) {
                badge.style.display = 'none';
            }

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
            .then(response => response.json())
            .then(data => {
                console.log('AI Response:', data);
                if (data.message) {
                    addMessage(data.message, 'ai');
                } else if (data.error) {
                    addMessage('Maaf, terjadi kesalahan: ' + data.error, 'ai');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                addMessage('Maaf, terjadi kesalahan koneksi. Silakan coba lagi.', 'ai');
            });
        }
        
        function askQuestion(question) {
            document.getElementById('messageInput').value = question;
            sendMessage();
        }
        
        function addMessage(text, sender) {
            const messagesContainer = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}-message`;
            
            const avatarDiv = document.createElement('div');
            avatarDiv.className = 'message-avatar';
            avatarDiv.innerHTML = sender === 'ai' ? '<i class="ion-ios-robot-outline"></i>' : '<i class="ion-ios-person-outline"></i>';
            
            const contentDiv = document.createElement('div');
            contentDiv.className = 'message-content';
            
            // Parse markdown for AI messages
            if (sender === 'ai') {
                contentDiv.innerHTML = parseMarkdown(text);
            } else {
                contentDiv.innerHTML = `<p>${text}</p>`;
            }
            
            messageDiv.appendChild(avatarDiv);
            messageDiv.appendChild(contentDiv);
            messagesContainer.appendChild(messageDiv);

            // Smart scroll behavior - only scroll within chat container
            if (sender === 'user') {
                // Scroll ke pertanyaan user agar terlihat di tengah container
                const containerHeight = messagesContainer.clientHeight;
                const messageOffsetTop = messageDiv.offsetTop;
                const messageHeight = messageDiv.offsetHeight;

                // Hitung posisi scroll agar pesan user di tengah container
                const scrollPosition = messageOffsetTop - (containerHeight / 2) + (messageHeight / 2);
                messagesContainer.scrollTo({
                    top: scrollPosition,
                    behavior: 'smooth'
                });
            } else {
                // Scroll ke awal respon AI agar user mulai membaca dari awal
                // Hanya scroll dalam container, bukan seluruh halaman
                messagesContainer.scrollTo({
                    top: messageDiv.offsetTop,
                    behavior: 'smooth'
                });
            }
        }
        
        function parseMarkdown(text) {
            // Escape HTML to prevent XSS
            let html = text
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
            
            // Parse headers
            html = html.replace(/^### (.*$)/gim, '<h3>$1</h3>');
            html = html.replace(/^## (.*$)/gim, '<h2>$1</h2>');
            html = html.replace(/^# (.*$)/gim, '<h1>$1</h1>');
            
            // Parse bold
            html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            
            // Parse italic
            html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
            
            // Parse code (inline)
            html = html.replace(/`(.*?)`/g, '<code>$1</code>');
            
            // Parse code blocks
            html = html.replace(/```([\s\S]*?)```/g, '<pre><code>$1</code></pre>');
            
            // Parse numbered lists (1., 2., 3., etc.)
            html = html.replace(/^\d+\.\s+(.*$)/gim, '<li>$1</li>');
            
            // Parse bullet points (- or *)
            html = html.replace(/^[-*]\s+(.*$)/gim, '<li>$1</li>');
            
            // Wrap list items in ul/ol tags
            html = html.replace(/(<li>.*<\/li>)/g, '<ul>$1</ul>');
            html = html.replace(/<\/ul>\s*<ul>/g, '');
            
            // Parse line breaks
            html = html.replace(/\n/g, '<br>');
            
            return html;
        }
        
        function generateAIResponse(message) {
            const responses = {
                'apa itu html': 'HTML (HyperText Markup Language) adalah bahasa markup standar yang digunakan untuk membuat halaman web. HTML menggunakan tag untuk mendeskripsikan struktur dan konten halaman web.',
                'beri contoh kode': 'Tentu! Berikut contoh struktur HTML dasar:\n\n<!DOCTYPE html>\n<html>\n<head>\n    <title>Halaman Saya</title>\n</head>\n<body>\n    <h1>Selamat Datang</h1>\n    <p>Ini adalah paragraf.</p>\n</body>\n</html>',
                'tips belajar': 'Beberapa tips belajar HTML:\n1. Praktik langsung dengan code editor\n2. Pelajari semantic HTML5\n3. Validasi kode HTML Anda\n4. Lihat source code website lain\n5. Gunakan developer tools browser'
            };
            
            const lowerMessage = message.toLowerCase();
            
            for (const [key, value] of Object.entries(responses)) {
                if (lowerMessage.includes(key)) {
                    return value;
                }
            }
            
            return 'Pertanyaan yang bagus! Untuk materi HTML, saya sarankan Anda mulai dengan memahami struktur dasar dokumen HTML. Ada topik spesifik yang ingin Anda pelajari lebih dalam?';
        }
        
        // Enter key to send message
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        
        // Close chat when clicking outside
        document.addEventListener('click', function(event) {
            const chatbox = document.getElementById('floatingChatbox');
            const chatBtn = document.getElementById('floatingChatBtn');

            if (chatbox && chatBtn) {
                if (!chatbox.contains(event.target) && !chatBtn.contains(event.target)) {
                    if (chatbox.classList.contains('show')) {
                        toggleChat();
                    }
                }
            }
        });
    </script>
@endsection
