@extends('frontend.layouts.app')

@section('title', 'MindMap - Visualisasi Pembelajaran')

@section('content')
    <!-- Header-->
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
      <div class="overlay"></div>
      <div class="intro-body">
        <h1>MindMap Pembelajaran</h1>
        <h4>Visualisasikan alur pembelajaran interaktif</h4><a class="page-scroll" href="#mindmap-content"><span class="mouse"><span><i class="icon ion-ios-arrow-down"></i></span></span></a>
      </div>
    </header>
    
    <!-- MindMap Content Section-->
    <section class="section-small" id="mindmap-content">
      <div class="container-fluid">
        <div class="row">
          <!-- Sidebar Kiri -->
          <div class="col-md-3">
            <div class="info-box">
              <h5><i class="ion-ios-checkmark-outline"></i> Personal Recommendation</h5>
              <ul class="checklist">
                <li><i class="ion-ios-checkmark"></i> Alternative Option</li>
                <li><i class="ion-ios-checkmark"></i> Order not strict on roadmap</li>
              </ul>
            </div>
            
            <button class="btn btn-primary btn-block">
              <i class="ion-ios-arrow-thin-right"></i> Visit Beginner Friendly Version
            </button>
            
            <div class="info-box">
              <h5><i class="ion-ios-link-outline"></i> Related Roadmaps</h5>
              <ul class="roadmap-list">
                <li><i class="ion-ios-checkmark"></i> JavaScript Roadmap</li>
                <li><i class="ion-ios-checkmark"></i> React Roadmap</li>
                <li><i class="ion-ios-checkmark"></i> TypeScript Roadmap</li>
                <li><i class="ion-ios-checkmark"></i> Node.js Roadmap</li>
              </ul>
            </div>
            
            <div class="info-box tip-box">
              <p><strong>HTML, CSS, and JavaScript</strong> are the backbone of web development. Make sure you practice by building a lot of projects.</p>
              <button class="btn btn-dark-border btn-sm">
                <i class="ion-ios-lightbulb-outline"></i> Beginner Project Ideas
              </button>
            </div>
          </div>
          
          <!-- MindMap Utama -->
          <div class="col-md-9">
            <div class="mindmap-container">
              <!-- Node Utama: Front-end -->
              <div class="mindmap-node main-node" style="top: 50px; left: 50%;">
                <div class="node-content">
                  <h3>Front-end</h3>
                </div>
              </div>
              
              <!-- Node Internet -->
              <div class="mindmap-node" style="top: 150px; left: 50%;">
                <div class="node-content">
                  <h4>Internet</h4>
                </div>
              </div>
              
              <!-- Pertanyaan-pertanyaan -->
              <div class="mindmap-node question-node" style="top: 250px; left: 20%;">
                <div class="node-content">
                  <p>How does the internet work?</p>
                </div>
              </div>
              
              <div class="mindmap-node question-node" style="top: 250px; left: 40%;">
                <div class="node-content">
                  <p>What is HTTP?</p>
                </div>
              </div>
              
              <div class="mindmap-node question-node" style="top: 250px; left: 60%;">
                <div class="node-content">
                  <p>What is Domain Name?</p>
                </div>
              </div>
              
              <div class="mindmap-node question-node" style="top: 250px; left: 80%;">
                <div class="node-content">
                  <p>What is hosting?</p>
                </div>
              </div>
              
              <!-- HTML Node -->
              <a href="/materi/html" class="mindmap-node html-node" style="top: 350px; left: 30%;">
                <div class="node-content">
                  <h4>HTML</h4>
                </div>
              </a>
              
              <!-- CSS Node -->
              <a href="/materi/css" class="mindmap-node css-node" style="top: 350px; left: 50%;">
                <div class="node-content">
                  <h4>CSS</h4>
                </div>
              </a>
              
              <!-- JavaScript Node -->
              <a href="/materi/javascript" class="mindmap-node js-node" style="top: 350px; left: 70%;">
                <div class="node-content">
                  <h4>JavaScript</h4>
                </div>
              </a>
              
              <!-- DNS dan Browser -->
              <div class="mindmap-node question-node" style="top: 450px; left: 35%;">
                <div class="node-content">
                  <p>DNS and how it works?</p>
                </div>
              </div>
              
              <div class="mindmap-node question-node" style="top: 450px; left: 65%;">
                <div class="node-content">
                  <p>Browsers and how they work?</p>
                </div>
              </div>
              
              <!-- Garis Penghubung (SVG) -->
              <svg class="mindmap-svg" width="100%" height="100%">
                <!-- Front-end ke Internet -->
                <line x1="50%" y1="90px" x2="50%" y2="150px" stroke="#6c757d" stroke-width="2"/>
                
                <!-- Internet ke pertanyaan horizontal -->
                <line x1="20%" y1="220px" x2="80%" y2="220px" stroke="#6c757d" stroke-width="2"/>
                
                <!-- Internet ke pertanyaan vertikal -->
                <line x1="20%" y1="220px" x2="20%" y2="250px" stroke="#6c757d" stroke-width="2"/>
                <line x1="40%" y1="220px" x2="40%" y2="250px" stroke="#6c757d" stroke-width="2"/>
                <line x1="60%" y1="220px" x2="60%" y2="250px" stroke="#6c757d" stroke-width="2"/>
                <line x1="80%" y1="220px" x2="80%" y2="250px" stroke="#6c757d" stroke-width="2"/>
                
                <!-- Pertanyaan ke HTML/CSS/JS -->
                <line x1="30%" y1="290px" x2="30%" y2="350px" stroke="#6c757d" stroke-width="2"/>
                <line x1="50%" y1="290px" x2="50%" y2="350px" stroke="#6c757d" stroke-width="2"/>
                <line x1="70%" y1="290px" x2="70%" y2="350px" stroke="#6c757d" stroke-width="2"/>
                
                <!-- HTML/CSS/JS ke DNS/Browser -->
                <line x1="35%" y1="390px" x2="35%" y2="450px" stroke="#6c757d" stroke-width="2"/>
                <line x1="65%" y1="390px" x2="65%" y2="450px" stroke="#6c757d" stroke-width="2"/>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- How to Use Section-->
    <section class="bg-gray" id="how-to-use">
      <div class="container">
        <h2 class="text-center">Cara Menggunakan MindMap Pembelajaran</h2>
        <div class="row">
          <div class="col-lg-8 col-lg-offset-2">
            <div class="row">
              <div class="col-md-6">
                <div class="step-item">
                  <h4><span class="step-number">1</span> Mulai dari Dasar</h4>
                  <p>Pahami konsep Internet dan cara kerjanya sebagai fondasi pembelajaran</p>
                </div>
                <div class="step-item">
                  <h4><span class="step-number">2</span> Pelajari HTML</h4>
                  <p>Kuasai struktur dasar halaman web dan semantic HTML</p>
                </div>
                <div class="step-item">
                  <h4><span class="step-number">3</span> Kuasai CSS</h4>
                  <p>Belajar styling, layout, dan desain responsif</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="step-item">
                  <h4><span class="step-number">4</span> JavaScript Fundamental</h4>
                  <p>Pelajari pemrograman JavaScript dan DOM manipulation</p>
                </div>
                <div class="step-item">
                  <h4><span class="step-number">5</span> Praktik Projek</h4>
                  <p>Bangun projek nyata untuk mengasah kemampuan</p>
                </div>
                <div class="step-item">
                  <h4><span class="step-number">6</span> Lanjut ke Framework</h4>
                  <p>Eksplorasi React, Vue, atau framework modern lainnya</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section-->
    <section class="section-small bg-gray2">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <h2 class="no-pad">Mulai Belajar Front-End</h2>
          </div>
          <div class="col-md-4 col-md-offset-1">
            <p class="no-pad">Ikuti roadmap front-end development dan menjadi developer web profesional!</p>
          </div>
          <div class="col-md-2 col-md-offset-1">
            <a class="btn btn-lg btn-dark" href="#start-learning">Mulai Belajar</a>
          </div>
        </div>
      </div>
    </section>

    <style>
        .mindmap-container {
            position: relative;
            min-height: 500px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            overflow: hidden;
        }
        
        .mindmap-node {
            position: absolute;
            background: white;
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transform: translateX(-50%);
            transition: all 0.3s ease;
            z-index: 10;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        
        .mindmap-node:hover {
            transform: translateX(-50%) scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            text-decoration: none;
            color: inherit;
        }
        
        .main-node {
            background: #007bff;
            color: white;
            border-color: #0056b3;
            font-weight: bold;
        }
        
        .html-node {
            background: #e34c26;
            color: white;
            border-color: #d23315;
        }
        
        .css-node {
            background: #1572b6;
            color: white;
            border-color: #0e5a8a;
        }
        
        .js-node {
            background: #f7df1e;
            color: black;
            border-color: #d4c41a;
        }
        
        .question-node {
            background: #28a745;
            color: white;
            border-color: #1e7e34;
            font-size: 14px;
        }
        
        .node-content h3, .node-content h4 {
            margin: 0;
            font-size: 16px;
        }
        
        .node-content p {
            margin: 0;
            font-size: 13px;
        }
        
        .connection-line {
            position: absolute;
            background: #6c757d;
            transform: translateX(-50%);
            z-index: 1;
            border: none;
        }
        
        .connection-line.horizontal {
            transform: translateY(-50%);
        }
        
        /* Alternative approach using SVG for better lines */
        .mindmap-svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }
        
        .info-box {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .info-box h5 {
            margin-bottom: 15px;
            color: #333;
        }
        
        .checklist, .roadmap-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .checklist li, .roadmap-list li {
            padding: 5px 0;
            color: #28a745;
        }
        
        .checklist i, .roadmap-list i {
            margin-right: 8px;
        }
        
        .tip-box {
            background: #e3f2fd;
            border-color: #2196f3;
        }
        
        .tip-box p {
            margin-bottom: 15px;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .step-item {
            margin-bottom: 30px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .step-number {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            background: #007bff;
            color: white;
            border-radius: 50%;
            margin-right: 10px;
            font-weight: bold;
        }
        
        @media (max-width: 768px) {
            .mindmap-container {
                min-height: 600px;
            }
            
            .mindmap-node {
                font-size: 12px;
                padding: 10px;
            }
            
            .question-node {
                font-size: 11px;
            }
        }
    </style>
@endsection
