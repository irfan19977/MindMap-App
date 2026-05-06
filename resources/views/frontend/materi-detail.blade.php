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
          <!-- Konten Materi (Full Width) -->
          <div class="col-md-12">
            <div class="materi-container">
              <!-- Breadcrumb -->
              <nav class="breadcrumb-nav">
                <ol class="breadcrumb">
                  <li><a href="/mindmap">MindMap</a></li>
                  <li><a href="#">Front-End Development</a></li>
                  <li class="active">HTML</li>
                </ol>
              </nav>
              
              <!-- Header Materi -->
              <div class="materi-header">
                <div class="row">
                  <div class="col-md-8">
                    <h2>HTML - HyperText Markup Language</h2>
                    <div class="materi-meta">
                      <span class="level-badge beginner">Pemula</span>
                      <span class="duration"><i class="ion-ios-clock-outline"></i> 2 jam</span>
                      <span class="lessons"><i class="ion-ios-book-outline"></i> 8 materi</span>
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
                    <h3>Tentang HTML</h3>
                    <p>HTML (HyperText Markup Language) adalah bahasa markup standar yang digunakan untuk membuat halaman web. HTML mendeskripsikan struktur dan konten semantik dari halaman web secara struktur.</p>
                    
                    <h4>Apa yang akan Anda pelajari:</h4>
                    <ul class="learning-objectives">
                      <li>Struktur dasar dokumen HTML</li>
                      <li>Tag-tag HTML umum dan penggunaannya</li>
                      <li>Semantic HTML untuk aksesibilitas</li>
                      <li>Form dan input elements</li>
                      <li>HTML5 dan fitur-fitur modern</li>
                    </ul>
                    
                    <h4>Prasyarat:</h4>
                    <p>Tidak ada prasyarat khusus. Materi ini cocok untuk pemula yang ingin memulai belajar pengembangan web.</p>
                  </div>
                </div>
                
                <!-- Materi Tab -->
                <div role="tabpanel" class="tab-pane" id="materi">
                  <div class="materi-section">
                    <div class="materi-list">
                      <div class="materi-item">
                        <div class="materi-item-header">
                          <h4>1. Pengenalan HTML</h4>
                          <span class="materi-duration">15 menit</span>
                        </div>
                        <div class="materi-item-content">
                          <p>Pengenalan dasar tentang HTML, sejarah, dan peran dalam pengembangan web modern.</p>
                          <div class="materi-topics">
                            <span class="topic-tag">Apa itu HTML</span>
                            <span class="topic-tag">Sejarah HTML</span>
                            <span class="topic-tag">HTML vs HTML5</span>
                          </div>
                        </div>
                      </div>
                      
                      <div class="materi-item">
                        <div class="materi-item-header">
                          <h4>2. Struktur Dasar HTML</h4>
                          <span class="materi-duration">20 menit</span>
                        </div>
                        <div class="materi-item-content">
                          <p>Memahami struktur dasar dokumen HTML, tag-tag penting, dan organisasi konten.</p>
                          <div class="materi-topics">
                            <span class="topic-tag">DOCTYPE</span>
                            <span class="topic-tag">HTML, Head, Body</span>
                            <span class="topic-tag">Meta tags</span>
                          </div>
                        </div>
                      </div>
                      
                      <div class="materi-item">
                        <div class="materi-item-header">
                          <h4>3. Text Formatting</h4>
                          <span class="materi-duration">25 menit</span>
                        </div>
                        <div class="materi-item-content">
                          <p>Berbagai cara untuk memformat teks dalam HTML untuk meningkatkan readability.</p>
                          <div class="materi-topics">
                            <span class="topic-tag">Heading tags</span>
                            <span class="topic-tag">Paragraph</span>
                            <span class="topic-tag">Bold & Italic</span>
                          </div>
                        </div>
                      </div>
                      
                      <div class="materi-item">
                        <div class="materi-item-header">
                          <h4>4. Links dan Navigasi</h4>
                          <span class="materi-duration">20 menit</span>
                        </div>
                        <div class="materi-item-content">
                          <p>Membuat link internal dan eksternal untuk navigasi antar halaman.</p>
                          <div class="materi-topics">
                            <span class="topic-tag">Anchor tags</span>
                            <span class="topic-tag">Relative vs Absolute</span>
                            <span class="topic-tag">Navigation menus</span>
                          </div>
                        </div>
                      </div>
                      
                      <div class="materi-item">
                        <div class="materi-item-header">
                          <h4>5. Images dan Media</h4>
                          <span class="materi-duration">15 menit</span>
                        </div>
                        <div class="materi-item-content">
                          <p>Menambahkan gambar dan elemen media lainnya ke halaman web.</p>
                          <div class="materi-topics">
                            <span class="topic-tag">Img tag</span>
                            <span class="topic-tag">Alt text</span>
                            <span class="topic-tag">Responsive images</span>
                          </div>
                        </div>
                      </div>
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
                    
                    <div class="exercise-item">
                      <h4>Latihan 1: Buat Halaman Profil</h4>
                      <p>Buat halaman profil pribadi dengan struktur HTML yang baik dan semantic.</p>
                      <div class="exercise-requirements">
                        <h5>Requirements:</h5>
                        <ul>
                          <li>Gunakan semantic HTML5 tags (header, main, section, footer)</li>
                          <li>Tambahkan foto profil dengan alt text yang deskriptif</li>
                          <li>Buat navigasi dengan link internal</li>
                          <li>Gunakan heading tags dengan hierarki yang benar</li>
                        </ul>
                      </div>
                      <button class="btn btn-primary">Mulai Latihan</button>
                    </div>
                    
                    <div class="exercise-item">
                      <h4>Latihan 2: Form Kontak</h4>
                      <p>Buat form kontak lengkap dengan berbagai jenis input.</p>
                      <div class="exercise-requirements">
                        <h5>Requirements:</h5>
                        <ul>
                          <li>Input untuk nama, email, dan pesan</li>
                          <li>Gunakan label yang proper untuk aksesibilitas</li>
                          <li>Tambahkan validasi HTML5</li>
                          <li>Include submit dan reset buttons</li>
                        </ul>
                      </div>
                      <button class="btn btn-primary">Mulai Latihan</button>
                    </div>
                  </div>
                </div>
                
                <!-- Quiz Tab -->
                <div role="tabpanel" class="tab-pane" id="quiz">
                  <div class="materi-section">
                    <h3>Quiz HTML</h3>
                    
                    <div class="quiz-container">
                      <div class="quiz-question">
                        <h4>1. Apa kepanjangan dari HTML?</h4>
                        <div class="quiz-options">
                          <label class="quiz-option">
                            <input type="radio" name="q1" value="a">
                            <span>HyperText Markup Language</span>
                          </label>
                          <label class="quiz-option">
                            <input type="radio" name="q1" value="b">
                            <span>High Tech Modern Language</span>
                          </label>
                          <label class="quiz-option">
                            <input type="radio" name="q1" value="c">
                            <span>Home Tool Markup Language</span>
                          </label>
                        </div>
                      </div>
                      
                      <div class="quiz-question">
                        <h4>2. Tag mana yang digunakan untuk membuat link?</h4>
                        <div class="quiz-options">
                          <label class="quiz-option">
                            <input type="radio" name="q2" value="a">
                            <span>&lt;link&gt;</span>
                          </label>
                          <label class="quiz-option">
                            <input type="radio" name="q2" value="b">
                            <span>&lt;a&gt;</span>
                          </label>
                          <label class="quiz-option">
                            <input type="radio" name="q2" value="c">
                            <span>&lt;href&gt;</span>
                          </label>
                        </div>
                      </div>
                      
                      <button class="btn btn-success btn-lg">Submit Quiz</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Floating Chat Button -->
    <div class="floating-chat-button" id="floatingChatBtn" onclick="toggleChat()">
      <i class="ion-ios-chatboxes-outline"></i>
      <span class="chat-badge">1</span>
    </div>
    
    <!-- Floating Chatbox -->
    <div class="floating-chatbox" id="floatingChatbox">
      <div class="chatbox-header">
        <h4><i class="ion-ios-chatboxes-outline"></i> AI Assistant</h4>
        <div class="chatbox-controls">
          <div class="chatbox-status">
            <span class="status-indicator online"></span>
            <span>Online</span>
          </div>
          <button class="close-btn" onclick="toggleChat()">
            <i class="ion-ios-close-outline"></i>
          </button>
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
        
        <!-- Quick Actions -->
        <div class="quick-actions">
          <button class="btn btn-sm btn-default" onclick="askQuestion('Apa itu HTML?')">
            Apa itu HTML?
          </button>
          <button class="btn btn-sm btn-default" onclick="askQuestion('Beri contoh kode')">
            Beri contoh kode
          </button>
          <button class="btn btn-sm btn-default" onclick="askQuestion('Tips belajar')">
            Tips belajar
          </button>
        </div>
      </div>
    </div>

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
        
        /* Floating Chat Button */
        .floating-chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: #007bff;
            border-radius: 50%;
            display: flex !important;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,123,255,0.3);
            transition: all 0.3s ease;
            z-index: 9999;
            border: 3px solid white;
        }
        
        .floating-chat-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0,123,255,0.4);
        }
        
        .chat-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
        
        /* Floating Chatbox */
        .floating-chatbox {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            display: none !important;
            flex-direction: column;
            z-index: 9998;
            animation: slideUp 0.3s ease;
            visibility: hidden;
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
        }
        
        .floating-chatbox.show {
            display: flex !important;
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
            pointer-events: all;
        }
        
        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
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
        }
        
        .message {
            display: flex;
            margin-bottom: 12px;
        }
        
        .message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            flex-shrink: 0;
            font-size: 14px;
        }
        
        .message-content {
            background: white;
            padding: 10px 14px;
            border-radius: 18px;
            max-width: 70%;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            font-size: 14px;
        }
        
        .user-message {
            flex-direction: row-reverse;
        }
        
        .user-message .message-avatar {
            margin-right: 0;
            margin-left: 8px;
            background: #6c757d;
        }
        
        .user-message .message-content {
            background: #007bff;
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
        
        .quick-actions {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
        
        .quick-actions .btn {
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 15px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #6c757d;
            transition: all 0.3s ease;
        }
        
        .quick-actions .btn:hover {
            background: #e9ecef;
            color: #495057;
        }
        
        @media (max-width: 768px) {
            .materi-container {
                padding: 20px;
            }
            
            .floating-chat-button {
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
                font-size: 20px;
            }
            
            .floating-chatbox {
                width: 90%;
                right: 5%;
                left: 5%;
                height: 400px;
                bottom: 80px;
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
    </style>

    <script>
        // Ensure chatbox is hidden when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const chatbox = document.getElementById('floatingChatbox');
            const chatBtn = document.getElementById('floatingChatBtn');
            
            // Force hide chatbox
            chatbox.classList.remove('show');
            chatbox.style.display = 'none';
            
            // Ensure chat button is visible
            chatBtn.style.display = 'flex';
        });
        
        function startLearning() {
            // Switch to materi tab
            $('a[href="#materi"]').tab('show');
        }
        
        function toggleChat() {
            const chatbox = document.getElementById('floatingChatbox');
            const chatBtn = document.getElementById('floatingChatBtn');
            
            if (chatbox.classList.contains('show')) {
                chatbox.classList.remove('show');
                chatBtn.style.display = 'flex';
            } else {
                chatbox.classList.add('show');
                chatBtn.style.display = 'none';
                // Focus on input when chat opens
                setTimeout(() => {
                    document.getElementById('messageInput').focus();
                }, 300);
            }
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
            
            // Simulate AI response
            setTimeout(() => {
                const aiResponse = generateAIResponse(message);
                addMessage(aiResponse, 'ai');
            }, 1000);
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
            contentDiv.innerHTML = `<p>${text}</p>`;
            
            messageDiv.appendChild(avatarDiv);
            messageDiv.appendChild(contentDiv);
            messagesContainer.appendChild(messageDiv);
            
            // Scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
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
            
            if (!chatbox.contains(event.target) && !chatBtn.contains(event.target)) {
                if (chatbox.classList.contains('show')) {
                    toggleChat();
                }
            }
        });
    </script>
@endsection
