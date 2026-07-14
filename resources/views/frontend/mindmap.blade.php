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
      <div class="container">
        <div class="row">
          @if(isset($mindmap) && $mindmap)
            <!-- MindMap exists - display it -->
            @php
              $creator = $mindmap->creator
                  ?? \App\Models\User::find($subcategory->created_by ?? $category->created_by ?? null);
              $teacher = $creator->teacher ?? null;
            @endphp
            <!-- Sidebar Kiri -->
            <div class="col-md-3">
              <div class="profile-card">
                <div class="profile-avatar-wrap">
                  <div class="profile-avatar">
                    @if($teacher && $teacher->image_url)
                      <img src="{{ asset($teacher->image_url) }}" alt="{{ $creator->name ?? 'Pembuat' }}">
                    @else
                      {{ strtoupper(substr($creator->name ?? '?', 0, 1)) }}
                    @endif
                  </div>
                  @if($teacher)
                    <span class="profile-verified"><i class="ion-ios-checkmark"></i></span>
                  @endif
                </div>

                <div class="profile-name">{{ $creator->name ?? 'Tidak diketahui' }}</div>
                <div class="profile-email">{{ $creator->email ?? '-' }}</div>

                @if($teacher)
                  <div class="profile-stats">
                    <div class="profile-stat">
                      <div class="profile-stat-value">{{ $teacher->materials()->count() }}</div>
                      <div class="profile-stat-label">Materi</div>
                    </div>
                    <div class="profile-stat">
                      <div class="profile-stat-value">{{ $teacher->published_courses->count() }}</div>
                      <div class="profile-stat-label">Kursus</div>
                    </div>
                    <div class="profile-stat">
                      <div class="profile-stat-value">{{ number_format($teacher->rating ?? 0, 1) }}</div>
                      <div class="profile-stat-label">Rating</div>
                    </div>
                  </div>
                @endif

                <div class="profile-details">
                  <div class="profile-detail-row">
                    <span class="profile-detail-icon"><i class="ion-ios-person-outline"></i></span>
                    <span class="profile-detail-label">Role</span>
                    <span class="profile-detail-value">{{ ucfirst($creator->user_type ?? 'User') }}</span>
                  </div>
                  @if($teacher && $teacher->specialization)
                    <div class="profile-detail-row">
                      <span class="profile-detail-icon"><i class="ion-ios-lightbulb-outline"></i></span>
                      <span class="profile-detail-label">Spesialisasi</span>
                      <span class="profile-detail-value">{{ $teacher->specialization }}</span>
                    </div>
                  @endif
                </div>

                @if($teacher && $teacher->slug)
                  <a href="{{ route('teacher.show', $teacher->slug) }}" class="profile-btn profile-btn-primary">
                    <i class="ion-ios-eye-outline"></i> Lihat Profil
                  </a>
                @endif
              </div>

              <!-- Class Enrollment Card -->
              @if(isset($relatedClasses) && $relatedClasses->count() > 0)
                @foreach($relatedClasses as $class)
                  <div class="profile-card" style="margin-top: 20px;">
                    <div class="profile-name" style="font-size: 16px;">
                      <i class="fa fa-users text-primary"></i> {{ $class->name }}
                    </div>
                    <div class="profile-stats" style="margin-top: 12px; margin-bottom: 12px;">
                      <div class="profile-stat">
                        <div class="profile-stat-value">{{ $class->materials->count() }}</div>
                        <div class="profile-stat-label">Materi</div>
                      </div>
                      <div class="profile-stat">
                        <div class="profile-stat-value">{{ $class->teacher->initials ?? 'G' }}</div>
                        <div class="profile-stat-label">Guru</div>
                      </div>
                    </div>

                    @auth
                      @if(isset($enrollments[$class->id]))
                        @if($enrollments[$class->id] === 'pending')
                          <button class="profile-btn profile-btn-primary" disabled>
                            <i class="fa fa-clock-o"></i> Menunggu Persetujuan
                          </button>
                        @elseif($enrollments[$class->id] === 'active' || $enrollments[$class->id] === 'completed')
                          <span class="profile-btn" style="background: #059669; color: #fff; cursor: default;">
                            <i class="fa fa-check"></i> Sudah Bergabung
                          </span>
                        @else
                          <form method="POST" action="{{ route('kelas.join', $class->slug) }}">
                            @csrf
                            <button type="submit" class="profile-btn profile-btn-primary">
                              <i class="fa fa-sign-in"></i> Gabung Kelas
                            </button>
                          </form>
                        @endif
                      @else
                        <form method="POST" action="{{ route('kelas.join', $class->slug) }}">
                          @csrf
                          <button type="submit" class="profile-btn profile-btn-primary">
                            <i class="fa fa-sign-in"></i> Gabung Kelas
                          </button>
                        </form>
                      @endif
                    @else
                      <a href="{{ route('login') }}" class="profile-btn profile-btn-primary">
                        <i class="fa fa-sign-in"></i> Login untuk Gabung
                      </a>
                    @endauth
                  </div>
                @endforeach
              @endif
            </div>

            <!-- MindMap Utama -->
            <div class="col-md-9">
              <div class="drawio-layout">
                <!-- Canvas Area -->
                <div class="drawio-canvas-area">
                  <div class="canvas-chrome">
                    <span class="canvas-chrome__hint"><i class="feather-info"></i> Scroll untuk geser · Ctrl + scroll untuk zoom</span>
                  </div>
                  <div class="canvas-viewport">
                    <div id="mindmap-canvas" class="canvas-container" style="width: 3000px; height: 3000px;">
                      <svg id="connections-svg" class="connections-layer">
                        <defs>
                          <marker id="arrow-solid" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                            <polygon points="0 0, 12 4.5, 0 9" fill="#475569"/>
                          </marker>
                          <marker id="arrow-dashed" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                            <polygon points="0 0, 12 4.5, 0 9" fill="#3b82f6"/>
                          </marker>
                          <marker id="arrow-dotted" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                            <polygon points="0 0, 12 4.5, 0 9" fill="#10b981"/>
                          </marker>
                          <marker id="arrow-thick" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                            <polygon points="0 0, 12 4.5, 0 9" fill="#7c3aed"/>
                          </marker>
                        </defs>
                      </svg>
                      <div id="mindmap-loading" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; z-index: 1000;">
                        <p>Loading mindmap...</p>
                      </div>
                    </div>
                  </div>

                  <div class="canvas-statusbar">
                    <span class="canvas-statusbar__item" id="status-tool"><i class="feather-move"></i> Pan</span>
                    <span class="canvas-statusbar__divider"></span>
                    <span class="canvas-statusbar__item" id="status-nodes">0 node</span>
                  </div>

                  <div class="zoom-controls">
                    <button type="button" onclick="zoomOut()" class="zoom-btn" title="Zoom Out">
                      <i class="feather-minus"></i>
                    </button>
                    <button type="button" onclick="resetZoom()" class="zoom-level" title="Reset view">100%</button>
                    <button type="button" onclick="zoomIn()" class="zoom-btn" title="Zoom In">
                      <i class="feather-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          @else
            <!-- Mindmap does not exist - display message -->
            <div class="col-md-12">
              <div class="alert alert-info text-center" style="padding: 60px 20px;">
                <i class="ion-ios-information-outline" style="font-size: 48px; margin-bottom: 20px;"></i>
                <h3 style="margin-bottom: 15px;">Mindmap belum dibuat</h3>
                <p style="font-size: 18px; color: #6c757d;">Mindmap untuk pelajaran ini belum tersedia saat ini.</p>
                <p style="margin-top: 20px;">
                  <a href="/kelas" class="btn btn-primary">Kembali ke Daftar Kelas</a>
                </p>
              </div>
            </div>
          @endif
        </div>
      </div>
    </section>

    <style>
    :root {
        --mm-primary: var(--bs-primary, #3454d1);
        --mm-primary-dark: #2b48bc;
        --mm-primary-light: #ebeefa;
        --mm-success: #059669;
        --mm-warning: #d97706;
        --mm-border: #e2e8f0;
        --mm-surface: #ffffff;
        --mm-muted: #64748b;
        --mm-canvas-bg: #f1f5f9;
        --mm-grid: #cbd5e1;
        --mm-shadow: 0 1px 3px rgba(15, 23, 42, 0.08);
        --mm-shadow-lg: 0 8px 24px rgba(15, 23, 42, 0.12);
        --mm-radius: 10px;
        --mm-panel-width: 236px;
    }

    /* ─── Mind Map Node — roadmap.sh style (same as editor) ─── */
    .mindmap-node {
        position: absolute;
        min-width: 150px;
        max-width: 240px;
        padding: 10px 18px;
        border-radius: 8px;
        border: 2px solid transparent;
        cursor: pointer;
        user-select: none;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        box-shadow: 3px 3px 0 rgba(0,0,0,0.25);
        transition: box-shadow 0.15s ease, filter 0.15s ease;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.3;
    }

    .mindmap-node:hover {
        filter: brightness(1.06);
        box-shadow: 4px 4px 0 rgba(0,0,0,0.3);
    }

    /* Fill colors per type */
    .mindmap-node.material  { background: #fde047; border-color: #ca8a04; color: #1a1a1a; }
    .mindmap-node.main-topic { background: #60a5fa; border-color: #1d4ed8; color: #fff; }
    .mindmap-node.sub-topic  { background: #86efac; border-color: #15803d; color: #1a1a1a; }

    .mindmap-node.completed::after {
        content: '✓';
        position: absolute;
        top: -8px;
        right: -8px;
        background: #3454d1;
        color: white;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: bold;
        border: 2px solid white;
        box-shadow: 0 2px 6px rgba(52,84,209,0.4);
    }

    .mindmap-node.locked {
        opacity: 0.5;
        filter: grayscale(0.8);
        pointer-events: none;
    }

    .mindmap-node.locked .lock-icon {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ef4444;
        color: white;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        border: 2px solid white;
    }

    .connection-line {
        stroke: #94a3b8;
        stroke-width: 2.5;
        fill: none;
        pointer-events: stroke;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .connection-line.solid-line {
        stroke: #667eea;
        stroke-width: 2.5;
        filter: drop-shadow(0 2px 4px rgba(102, 126, 234, 0.2));
    }

    .connection-line.dashed-line {
        stroke: #ef4444;
        stroke-width: 2.5;
        stroke-dasharray: 10, 6;
        filter: drop-shadow(0 2px 4px rgba(239, 68, 68, 0.2));
    }

    .connection-line.dotted-line {
        stroke: #10b981;
        stroke-width: 2.5;
        stroke-dasharray: 3, 6;
        filter: drop-shadow(0 2px 4px rgba(16, 185, 129, 0.2));
    }

    .connection-line.curved-line {
        stroke: #f59e0b;
        stroke-width: 2.5;
        fill: none;
        filter: drop-shadow(0 2px 4px rgba(245, 158, 11, 0.2));
    }

    .connection-line.thick-line {
        stroke: #8b5cf6;
        stroke-width: 5;
        filter: drop-shadow(0 2px 6px rgba(139, 92, 246, 0.3));
    }

    .connection-line.double-line {
        stroke: #ec4899;
        stroke-width: 2;
    }

    .connection-line.wavy-line {
        stroke: #06b6d4;
        stroke-width: 2;
        fill: none;
    }

    .connection-line.manual-line {
        stroke: #6b7280;
        stroke-width: 2;
        fill: none;
    }

    .connection-line.sub-topic-line {
        stroke: #3b82f6;
        stroke-width: 2;
        stroke-dasharray: 5, 5;
        opacity: 0.7;
    }

    .connection-line.hierarchy-line {
        stroke: #3b82f6;
        stroke-width: 3;
    }

    .connection-line.selected {
        stroke: #10b981 !important;
        stroke-width: 4 !important;
        filter: drop-shadow(0 0 6px rgba(16, 185, 129, 0.4));
    }

    .connection-line:hover {
        cursor: pointer;
        stroke-width: 3;
        filter: drop-shadow(0 0 3px rgba(59, 130, 246, 0.3));
    }

    .connection-line.manual-temp-line {
        stroke: #f59e0b;
        stroke-width: 2;
        stroke-dasharray: 5, 5;
        fill: none;
        animation: dash 0.5s linear infinite;
    }

    @keyframes dash {
        to {
            stroke-dashoffset: -10;
        }
    }

    .control-point {
        transition: all 0.2s ease;
    }

    .control-point:hover {
        r: 8;
        fill: #2563eb;
        stroke-width: 3;
    }

    .control-point:active {
        r: 10;
        fill: #1d4ed8;
    }

    .resize-handle {
        position: absolute;
        width: 10px;
        height: 10px;
        background: #3b82f6;
        border: 2px solid white;
        border-radius: 50%;
        cursor: pointer;
        z-index: 20;
        transition: all 0.2s ease;
    }

    .resize-handle:hover {
        /* Hover effect disabled */
    }

    .resize-handle.nw { top: -5px; left: -5px; cursor: nw-resize; }
    .resize-handle.n { top: -5px; left: 50%; transform: translateX(-50%); cursor: n-resize; }
    .resize-handle.ne { top: -5px; right: -5px; cursor: ne-resize; }
    .resize-handle.e { top: 50%; right: -5px; transform: translateY(-50%); cursor: e-resize; }
    .resize-handle.se { bottom: -5px; right: -5px; cursor: se-resize; }
    .resize-handle.s { bottom: -5px; left: 50%; transform: translateX(-50%); cursor: s-resize; }
    .resize-handle.sw { bottom: -5px; left: -5px; cursor: sw-resize; }
    .resize-handle.w { top: 50%; left: -5px; transform: translateY(-50%); cursor: w-resize; }

    .connection-anchor {
        position: absolute;
        width: 10px;
        height: 10px;
        background: rgba(59, 130, 246, 0.9);
        border: 2px solid white;
        border-radius: 50%;
        cursor: crosshair;
        z-index: 25;
        opacity: 0;
        transition: all 0.25s ease;
        pointer-events: none;
        box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
    }

    .mindmap-node:hover .connection-anchor,
    .mindmap-node.show-anchors .connection-anchor {
        /* Anchor visibility disabled */
    }

    .connection-anchor:hover {
        /* Hover effect disabled */
    }

    .connection-anchor.active {
        background: #10b981;
        animation: anchor-pulse 1s infinite;
    }

    @keyframes anchor-pulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
        }
        50% {
            box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
        }
    }

    .anchor-tl { top: -6px; left: -6px; }
    .anchor-t { top: -6px; left: 50%; transform: translateX(-50%); }
    .anchor-tr { top: -6px; right: -6px; }
    .anchor-r { top: 50%; right: -6px; transform: translateY(-50%); }
    .anchor-br { bottom: -6px; right: -6px; }
    .anchor-b { bottom: -6px; left: 50%; transform: translateX(-50%); }
    .anchor-bl { bottom: -6px; left: -6px; }
    .anchor-l { top: 50%; left: -6px; transform: translateY(-50%); }

    .temp-connection-line {
        stroke: #3b82f6;
        stroke-width: 2;
        stroke-dasharray: 5, 5;
        fill: none;
        pointer-events: none;
    }

    .canvas-container {
        position: relative;
        background-color: var(--mm-canvas-bg);
        background-image: radial-gradient(circle, var(--mm-grid) 1px, transparent 1px);
        background-size: 20px 20px;
        overflow: hidden;
        cursor: default;
        user-select: none;
        transform-origin: 0 0;
    }

    .connections-layer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 5;
    }

    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .empty-state {
        text-align: center;
        padding: 28px 16px;
    }

    .empty-state__icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 12px;
        background: #f1f5f9;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 22px;
    }

    .empty-state__title {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin: 0 0 4px;
    }

    .empty-state__hint {
        font-size: 11px;
        color: var(--mm-muted);
        margin: 0;
        line-height: 1.4;
    }

    .material-item {
        cursor: default;
        transition: none;
        border: 1px solid var(--mm-border);
        border-radius: var(--mm-radius);
        padding: 8px 10px;
        margin-bottom: 5px;
        background: var(--mm-surface);
        display: flex;
        gap: 8px;
        align-items: flex-start;
    }

    .material-item__icon {
        width: 24px;
        height: 24px;
        background: #ecfdf5;
        color: var(--mm-success);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 13px;
    }

    .material-item__body {
        flex: 1;
        min-width: 0;
    }

    .material-item__title {
        font-size: 11px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 2px;
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .material-item__meta {
        font-size: 10px;
        color: var(--mm-muted);
    }

    .material-item:hover {
        /* Hover effect disabled */
    }

    .material-item:active {
        cursor: default;
        opacity: 1;
    }

    .panel-search {
        position: relative;
        margin-bottom: 12px;
    }

    .panel-search__icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }

    .panel-search__input {
        width: 100%;
        padding: 8px 12px 8px 36px;
        border: 1px solid var(--mm-border);
        border-radius: 8px;
        font-size: 12px;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .panel-search__input:focus {
        outline: none;
        border-color: var(--mm-primary);
        box-shadow: 0 0 0 3px rgba(52, 84, 209, 0.12);
        background: #fff;
    }

    /* Editor layout */
    .drawio-layout {
        height: calc(100vh - 140px);
        min-height: 520px;
        display: flex;
        flex-direction: column;
        border: 1px solid var(--mm-border);
        border-radius: 12px;
        overflow: hidden;
        background: var(--mm-surface);
        box-shadow: var(--mm-shadow);
    }

    .drawio-toolbar {
        height: 48px;
        background: linear-gradient(180deg, #fafbfc 0%, #f1f5f9 100%);
        border-bottom: 1px solid var(--mm-border);
        display: flex;
        align-items: center;
        padding: 0 14px;
        flex-shrink: 0;
    }

    .drawio-toolbar .btn.active {
        background: var(--mm-primary);
        border-color: var(--mm-primary);
        color: #fff;
    }

    .toolbar-section {
        display: flex;
        align-items: center;
    }

    .toolbar-divider {
        width: 1px;
        height: 30px;
        background: #dee2e6;
        margin: 0 10px;
    }

    .drawio-workspace {
        flex: 1;
        display: flex;
        overflow: hidden;
    }

    .drawio-left-panel {
        width: var(--mm-panel-width);
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #fafbfc;
        border-right: 1px solid var(--mm-border);
    }

    .drawio-canvas-area {
        flex: 1;
        position: relative;
        background: #e2e8f0;
        overflow: hidden;
        min-width: 0;
    }

    .panel-section {
        border-bottom: 1px solid var(--mm-border);
    }

    .drawio-left-panel .panel-section--flex {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        border-bottom: none;
    }

    .panel-body--materials {
        flex: 1;
        overflow: hidden;
        padding: 8px 10px 10px;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    .panel-header {
        padding: 10px 12px;
        border-bottom: 1px solid var(--mm-border);
        background: var(--mm-surface);
    }

    .panel-header--accent { border-left: 3px solid var(--mm-primary); }

    .panel-header__row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .panel-header h6 {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }

    .panel-subtitle {
        font-size: 11px;
        color: var(--mm-muted);
        margin-top: 4px;
        line-height: 1.35;
    }

    .panel-badge {
        font-size: 10px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 999px;
        background: var(--mm-primary-light);
        color: var(--mm-primary);
    }

    .panel-badge--success {
        background: #ecfdf5;
        color: var(--mm-success);
    }

    .panel-body {
        padding: 14px 16px;
    }

    .materials-list {
        flex: 1;
        overflow-y: auto;
        min-height: 120px;
    }

    .canvas-chrome {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 20;
        padding: 8px 12px;
        background: linear-gradient(180deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0) 100%);
        pointer-events: none;
    }

    .canvas-chrome__hint {
        font-size: 11px;
        color: var(--mm-muted);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .canvas-viewport {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 32px;
        overflow: auto;
        pointer-events: auto;
    }

    .canvas-statusbar {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 32px;
        background: rgba(255, 255, 255, 0.96);
        border-top: 1px solid var(--mm-border);
        display: flex;
        align-items: center;
        padding: 0 14px;
        gap: 10px;
        font-size: 11px;
        color: var(--mm-muted);
        z-index: 15;
    }

    .canvas-statusbar__item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .canvas-statusbar__divider {
        width: 1px;
        height: 14px;
        background: var(--mm-border);
    }

    .zoom-controls {
        position: absolute;
        bottom: 44px;
        right: 14px;
        z-index: 20;
        display: flex;
        align-items: center;
        background: var(--mm-surface);
        border: 1px solid var(--mm-border);
        border-radius: 10px;
        padding: 4px;
        box-shadow: var(--mm-shadow-lg);
        gap: 2px;
    }

    .zoom-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: transparent;
        border-radius: 8px;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.15s;
    }

    .zoom-btn:hover {
        /* Hover effect disabled */
    }

    .zoom-level {
        min-width: 52px;
        height: 32px;
        border: none;
        background: #f8fafc;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        transition: background 0.15s;
    }

    .zoom-level:hover {
        /* Hover effect disabled */
    }

    /* Keyboard shortcut styling */
    kbd {
        background: #f3f4f6;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        padding: 2px 6px;
        font-size: 11px;
        font-family: monospace;
        box-shadow: 0 1px 0 rgba(0,0,0,0.1);
    }

    /* Sidebar styling */
    .info-box {
        background: #fff;
        border: 1px solid var(--mm-border);
        border-radius: var(--mm-radius);
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: var(--mm-shadow);
    }

    .info-box h5 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-box h5 i {
        color: var(--mm-primary);
    }

    .checklist, .roadmap-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .checklist li, .roadmap-list li {
        padding: 8px 0;
        font-size: 14px;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #f1f5f9;
    }

    .checklist li:last-child, .roadmap-list li:last-child {
        border-bottom: none;
    }

    .checklist li i, .roadmap-list li i {
        color: var(--mm-success);
        font-size: 16px;
        flex-shrink: 0;
    }

    .roadmap-list li i {
        color: var(--mm-primary);
    }

    .btn-block {
        width: 100%;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--mm-primary) 0%, var(--mm-primary-dark) 100%);
        border: none;
        color: #fff;
        box-shadow: 0 4px 12px rgba(52, 84, 209, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--mm-primary-dark) 0%, #1e3a8a 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(52, 84, 209, 0.4);
    }

    .btn-dark-border {
        background: #fff;
        border: 2px solid #334155;
        color: #334155;
        font-weight: 600;
    }

    .btn-dark-border:hover {
        background: #334155;
        color: #fff;
    }

    .tip-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 1px solid #f59e0b;
    }

    .tip-box p {
        font-size: 14px;
        color: #92400e;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .tip-box strong {
        color: #78350f;
    }

    .profile-card {
        background: #fff;
        border: 1px solid var(--mm-border);
        border-radius: 16px;
        padding: 28px 20px;
        margin-bottom: 20px;
        box-shadow: var(--mm-shadow);
        text-align: center;
    }

    .profile-avatar-wrap {
        position: relative;
        display: inline-block;
        margin-bottom: 16px;
    }

    .profile-avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--mm-primary) 0%, var(--mm-primary-dark) 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: 700;
        overflow: hidden;
        border: 4px solid #f1f5f9;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-verified {
        position: absolute;
        bottom: 6px;
        right: 6px;
        width: 26px;
        height: 26px;
        background: #10b981;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        border: 2px solid #fff;
    }

    .profile-name {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .profile-email {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 18px;
    }

    .profile-stats {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .profile-stat {
        flex: 1;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        padding: 12px 6px;
        min-width: 0;
    }

    .profile-stat-value {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .profile-stat-label {
        font-size: 11px;
        color: #64748b;
    }

    .profile-details {
        text-align: left;
        margin-bottom: 20px;
        border-top: 1px solid #f1f5f9;
        padding-top: 16px;
    }

    .profile-detail-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        font-size: 13px;
    }

    .profile-detail-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #f1f5f9;
        color: var(--mm-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .profile-detail-label {
        flex: 1;
        color: #64748b;
    }

    .profile-detail-value {
        font-weight: 600;
        color: #1e293b;
        text-align: right;
    }

    .profile-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .profile-btn-primary {
        background: linear-gradient(135deg, var(--mm-primary) 0%, var(--mm-primary-dark) 100%);
        color: #fff;
        border: none;
        box-shadow: 0 4px 12px rgba(52, 84, 209, 0.3);
    }

    .profile-btn-primary:hover {
        background: linear-gradient(135deg, var(--mm-primary-dark) 0%, #1e3a8a 100%);
        transform: translateY(-2px);
        color: #fff;
        text-decoration: none;
    }

    .roadmap-desc {
        font-size: 14px;
        color: #475569;
        line-height: 1.6;
        margin: 0;
    }
    </style>

    @if(isset($mindmap) && $mindmap)
    <script>
    let selectedNode = null;
    let selectedConnection = null;
    let nodeIdCounter = 1;
    let connections = [];
    let nodes = [];
    let isDragging = false;
    let draggedNode = null;
    let dragOffset = { x: 0, y: 0 };
    let userCompletedMaterials = [];
    let lockedNodes = new Set();

    // Draw.io features
    let currentTool = 'pan';
    let zoomLevel = 1;
    let panOffset = { x: 0, y: 0 };
    let isPanning = false;
    let panStart = { x: 0, y: 0 };

    // Grid and canvas settings (draw.io style)
    const GRID_SIZE = 10;
    let gridEnabled = true;
    let spacePressed = false;

    // Read-only mode - disable editing
    const READ_ONLY = true;

    // Initialize canvas
    document.addEventListener('DOMContentLoaded', function() {
        initializeCanvas();
    });

    function initializeCanvas() {
        const canvas = document.getElementById('mindmap-canvas');
        const canvasArea = document.querySelector('.drawio-canvas-area');
        const canvasViewport = document.querySelector('.canvas-viewport');
        
        // Mouse events for dragging nodes (disabled in read-only mode)
        if (!READ_ONLY) {
            canvas.addEventListener('mousedown', handleMouseDown);
            document.addEventListener('mousemove', handleMouseMove);
            document.addEventListener('mouseup', handleMouseUp);
        }
        
        // Prevent context menu on canvas
        canvas.addEventListener('contextmenu', e => e.preventDefault());
        
        // Mouse wheel for zoom (Ctrl + scroll)
        canvasViewport.addEventListener('wheel', handleWheel, { passive: false });
        
        // Initialize line style selection
        setTool('pan');
        updateNodeCount();

        // Fetch user progress for locking system
        fetchUserProgress().then(() => {
            // Load mindmap data after fetching progress
            const mindmapData = @json($mindmap->structure);
            if (mindmapData && mindmapData.nodes && mindmapData.connections) {
                renderMindmap(mindmapData);
                
                // Auto-center the mindmap after rendering
                setTimeout(() => autoCenterMindmap(), 100);
            }
        });
    }

    async function fetchUserProgress() {
        try {
            const response = await fetch('/api/user-progress');
            const data = await response.json();
            userCompletedMaterials = data.completed_materials || [];
        } catch (error) {
            console.error('Error fetching user progress:', error);
            userCompletedMaterials = [];
        }
    }

    function determineLockedNodes(structure) {
        lockedNodes.clear();
        
        if (!structure.connections || !structure.nodes) {
            return;
        }

        // Build a map of node dependencies
        const nodeDependencies = new Map();
        
        structure.connections.forEach(conn => {
            const fromNode = structure.nodes.find(n => n.id === conn.from);
            const toNode = structure.nodes.find(n => n.id === conn.to);
            
            if (fromNode && toNode && fromNode.materialId) {
                if (!nodeDependencies.has(conn.to)) {
                    nodeDependencies.set(conn.to, []);
                }
                nodeDependencies.get(conn.to).push(fromNode.materialId);
            }
        });

        // Determine which nodes should be locked
        structure.nodes.forEach(node => {
            if (node.materialId && nodeDependencies.has(node.id)) {
                const prerequisites = nodeDependencies.get(node.id);
                const allPrerequisitesCompleted = prerequisites.every(prereqId => 
                    userCompletedMaterials.includes(prereqId)
                );
                
                if (!allPrerequisitesCompleted) {
                    lockedNodes.add(node.id);
                }
            }
        });
    }

    function renderMindmap(structure) {
        const canvas = document.getElementById('mindmap-canvas');
        const loadingIndicator = document.getElementById('mindmap-loading');
        
        // Remove loading indicator
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }

        // Determine which nodes should be locked
        determineLockedNodes(structure);

        if (structure.nodes) {
            structure.nodes.forEach(nodeData => {
                const node = document.createElement('div');
                let nodeClass = `mindmap-node ${nodeData.type || 'material'}`;
                
                // Add locked class if node is locked
                if (lockedNodes.has(nodeData.id)) {
                    nodeClass += ' locked';
                }
                
                // Add completed class if material is completed
                if (nodeData.materialId && userCompletedMaterials.includes(nodeData.materialId)) {
                    nodeClass += ' completed';
                }
                
                node.className = nodeClass;
                node.id = nodeData.id;
                node.style.left = nodeData.x + 'px';
                node.style.top = nodeData.y + 'px';

                node.innerHTML = `
                    <span class="node-label">${nodeData.title}</span>
                    ${lockedNodes.has(nodeData.id) ? '<i class="feather-lock lock-icon"></i>' : ''}
                `;

                // Add 8 connection anchor points (only in edit mode)
                if (!READ_ONLY) {
                    const anchorPositions = ['tl', 't', 'tr', 'r', 'br', 'b', 'bl', 'l'];
                    anchorPositions.forEach(pos => {
                        const anchor = document.createElement('div');
                        anchor.className = `connection-anchor anchor-${pos}`;
                        anchor.dataset.anchor = pos;
                        anchor.dataset.nodeId = nodeData.id;
                        node.appendChild(anchor);
                    });
                }

                // Add click listener (disabled in read-only mode)
                if (!READ_ONLY) {
                    node.addEventListener('click', function(e) {
                        e.stopPropagation();
                        selectNode(nodeData.id);
                    });

                    // Add drag functionality
                    node.addEventListener('mousedown', function(e) {
                        if (e.target.classList.contains('connection-anchor')) return;
                        e.stopPropagation();
                        handleMouseDown(e);
                    });
                } else {
                    // In read-only mode, make nodes clickable to navigate to material detail
                    node.addEventListener('click', function(e) {
                        e.stopPropagation();
                        
                        // Check if node is locked
                        if (lockedNodes.has(nodeData.id)) {
                            e.preventDefault();
                            alert('Materi ini terkunci. Selesaikan materi sebelumnya terlebih dahulu untuk membuka materi ini.');
                            return;
                        }
                        
                        if (nodeData.materialSlug) {
                            window.location.href = '/materi/' + nodeData.materialSlug;
                        } else if (nodeData.materialId) {
                            // If slug is not available, try to get it via AJAX
                            fetch(`/api/materials/${nodeData.materialId}/slug`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.slug) {
                                        window.location.href = '/materi/' + data.slug;
                                    }
                                })
                                .catch(error => console.error('Error fetching material slug:', error));
                        }
                    });

                    // Add cursor pointer to indicate clickable (unless locked)
                    if (!lockedNodes.has(nodeData.id)) {
                        node.style.cursor = 'pointer';
                    } else {
                        node.style.cursor = 'not-allowed';
                    }
                }

                canvas.appendChild(node);

                nodes.push({
                    id: nodeData.id,
                    materialId: nodeData.materialId,
                    title: nodeData.title,
                    x: nodeData.x,
                    y: nodeData.y,
                    type: nodeData.type || 'material',
                    completed: nodeData.completed || false,
                    style: nodeData.style || {}
                });
            });
        }

        if (structure.connections) {
            structure.connections.forEach(connData => {
                connections.push(connData);
            });
            updateConnections();
        }

        updateNodeCount();
    }

    function filterMaterials(query) {
        const q = (query || '').trim().toLowerCase();
        document.querySelectorAll('.material-item').forEach(item => {
            const text = item.querySelector('.material-item__title')?.textContent.toLowerCase() || '';
            const match = !q || text.includes(q);
            item.style.display = match ? '' : 'none';
        });
    }

    function updateNodeCount() {
        const el = document.getElementById('status-nodes');
        if (el) {
            const count = document.querySelectorAll('.mindmap-node:not(.root)').length;
            el.textContent = count + ' node';
        }
    }

    function autoCenterMindmap() {
        if (nodes.length === 0) return;

        const canvasViewport = document.querySelector('.canvas-viewport');
        const viewportWidth = canvasViewport.clientWidth;
        const viewportHeight = canvasViewport.clientHeight;

        // Calculate bounding box of all nodes
        let minX = Infinity, maxX = -Infinity, minY = Infinity, maxY = -Infinity;
        nodes.forEach(node => {
            const nodeEl = document.getElementById(node.id);
            if (nodeEl) {
                const width = nodeEl.offsetWidth;
                const height = nodeEl.offsetHeight;
                minX = Math.min(minX, node.x);
                maxX = Math.max(maxX, node.x + width);
                minY = Math.min(minY, node.y);
                maxY = Math.max(maxY, node.y + height);
            }
        });

        // Calculate mindmap dimensions
        const mindmapWidth = maxX - minX;
        const mindmapHeight = maxY - minY;

        // Center horizontally
        const scrollLeft = minX + (mindmapWidth / 2) - (viewportWidth / 2);

        // Scroll to show top with padding (not center vertically to avoid cutoff)
        const topPadding = 100; // Add 100px padding at top
        const scrollTop = minY - topPadding;

        canvasViewport.scrollLeft = scrollLeft;
        canvasViewport.scrollTop = scrollTop;
    }

    function updateToolStatus(tool) {
        const el = document.getElementById('status-tool');
        if (!el) return;
        const icons = { select: 'feather-mouse-pointer', pan: 'feather-move' };
        const labels = { select: 'Select', pan: 'Pan' };
        el.innerHTML = `<i class="${icons[tool] || 'feather-tool'}"></i> ${labels[tool] || tool}`;
    }

    function handleWheel(e) {
        if (e.ctrlKey || e.metaKey) {
            e.preventDefault();
            const delta = e.deltaY > 0 ? 0.99 : 1.01;
            zoomLevel = Math.max(0.1, Math.min(5, zoomLevel * delta));
            updateZoom();
        }
        // Allow normal scrolling for panning
    }

    function handleMouseDown(e) {
        if (READ_ONLY) return;
        
        const node = e.target.closest('.mindmap-node');
        
        if (node) {
            if (e.button === 0) {
                e.preventDefault();
                isDragging = true;
                draggedNode = node;
                
                const nodeStyle = window.getComputedStyle(node);
                const currentLeft = parseInt(nodeStyle.left) || 0;
                const currentTop = parseInt(nodeStyle.top) || 0;
                
                const canvasRect = document.getElementById('mindmap-canvas').getBoundingClientRect();
                dragOffset.x = e.clientX - canvasRect.left - currentLeft;
                dragOffset.y = e.clientY - canvasRect.top - currentTop;
                
                draggedNode.style.zIndex = 1000;
                draggedNode.style.cursor = 'grabbing';
            }
        } else {
            if (e.button === 0 && (spacePressed || currentTool === 'pan')) {
                e.preventDefault();
                startPan(e);
            }
        }
    }

    function handleMouseMove(e) {
        if (isPanning) {
            doPan(e);
            return;
        }
        
        if (READ_ONLY) return;
        
        if (isDragging && draggedNode) {
            const canvasRect = document.getElementById('mindmap-canvas').getBoundingClientRect();
            
            let x = e.clientX - canvasRect.left - dragOffset.x;
            let y = e.clientY - canvasRect.top - dragOffset.y;
            
            x = snapToGrid(x);
            y = snapToGrid(y);
            
            const minBound = 0;
            const maxX = canvasRect.width - draggedNode.offsetWidth;
            const maxY = canvasRect.height - draggedNode.offsetHeight;
            
            const constrainedX = Math.max(minBound, Math.min(x, maxX));
            const constrainedY = Math.max(minBound, Math.min(y, maxY));
            
            draggedNode.style.left = constrainedX + 'px';
            draggedNode.style.top = constrainedY + 'px';
            
            const nodeData = nodes.find(n => n.id === draggedNode.id);
            if (nodeData) {
                nodeData.x = constrainedX;
                nodeData.y = constrainedY;
            }
            
            updateConnections();
        }
    }

    function handleMouseUp(e) {
        if (READ_ONLY) return;
        
        if (draggedNode) {
            draggedNode.style.zIndex = 10;
            draggedNode.style.cursor = 'move';
        }
        
        if (isPanning) {
            endPan();
        }
        
        isDragging = false;
        draggedNode = null;
    }

    function snapToGrid(value) {
        if (!gridEnabled) return value;
        return Math.round(value / GRID_SIZE) * GRID_SIZE;
    }

    function startPan(e) {
        const isPanTool = currentTool === 'pan';
        const isSpacebarPan = spacePressed;
        const isMiddleMouse = e.button === 1;
        
        if (isPanTool || isSpacebarPan || isMiddleMouse) {
            isPanning = true;
            panStart = { 
                x: e.clientX - panOffset.x * zoomLevel, 
                y: e.clientY - panOffset.y * zoomLevel 
            };
            document.getElementById('mindmap-canvas').style.cursor = 'grabbing';
            e.preventDefault();
        }
    }

    function doPan(e) {
        if (isPanning) {
            panOffset.x = (e.clientX - panStart.x) / zoomLevel;
            panOffset.y = (e.clientY - panStart.y) / zoomLevel;
            updateZoom();
        }
    }

    function endPan() {
        if (isPanning) {
            isPanning = false;
            const canvas = document.getElementById('mindmap-canvas');
            
            if (currentTool === 'pan') {
                canvas.style.cursor = 'grab';
            } else if (spacePressed) {
                canvas.style.cursor = 'grab';
            } else {
                canvas.style.cursor = 'default';
            }
        }
    }

    function setTool(tool) {
        if (READ_ONLY && tool !== 'pan') return;
        
        currentTool = tool;
        
        document.querySelectorAll('.drawio-toolbar [data-tool]').forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-tool') === tool);
        });

        const canvas = document.getElementById('mindmap-canvas');
        switch(tool) {
            case 'select':
                canvas.style.cursor = 'default';
                break;
            case 'pan':
                canvas.style.cursor = 'grab';
                break;
            default:
                canvas.style.cursor = 'default';
                break;
        }
        
        updateToolStatus(tool);
    }

    function zoomIn() {
        zoomLevel = Math.min(zoomLevel * 1.1, 3);
        updateZoom();
    }

    function zoomOut() {
        zoomLevel = Math.max(zoomLevel / 1.1, 0.5);
        updateZoom();
    }

    function resetZoom() {
        zoomLevel = 1;
        updateZoom();
    }

    function updateZoom() {
        const canvas = document.getElementById('mindmap-canvas');
        
        // Use CSS zoom for scaling (works better with scrollbars)
        canvas.style.zoom = zoomLevel;
        
        // Update grid background size
        const scaledGridSize = 20 * zoomLevel;
        canvas.style.backgroundSize = `${scaledGridSize}px ${scaledGridSize}px`;
        
        // Update zoom level display
        document.querySelector('.zoom-level').textContent = Math.round(zoomLevel * 100) + '%';
        
        updateConnections();
    }

    function selectNode(nodeId) {
        if (READ_ONLY) return;
        
        const node = document.getElementById(nodeId);
        if (!node) return;
        
        if (selectedNode === nodeId) {
            node.classList.remove('selected');
            selectedNode = null;
        } else {
            document.querySelectorAll('.mindmap-node').forEach(n => {
                n.classList.remove('selected');
            });
            
            node.classList.add('selected');
            selectedNode = nodeId;
        }
    }

    // ─── Same anchor system as index.blade.php ───
    function getNodeAnchorXY(nodeId, anchor) {
        const nodeData = nodes.find(n => n.id === nodeId);
        const el = document.getElementById(nodeId);
        if (!nodeData || !el) return null;
        const w = el.offsetWidth, h = el.offsetHeight;
        const map = {
            r: { x: nodeData.x + w,     y: nodeData.y + h / 2 },
            l: { x: nodeData.x,          y: nodeData.y + h / 2 },
            b: { x: nodeData.x + w / 2,  y: nodeData.y + h     },
            t: { x: nodeData.x + w / 2,  y: nodeData.y         }
        };
        return map[anchor] || map['r'];
    }

    function getBestAnchors(fromId, toId) {
        const fn = nodes.find(n => n.id === fromId);
        const tn = nodes.find(n => n.id === toId);
        const fe = document.getElementById(fromId);
        const te = document.getElementById(toId);
        if (!fn || !tn || !fe || !te) return { from: 'r', to: 'l' };
        const fcx = fn.x + fe.offsetWidth / 2;
        const fcy = fn.y + fe.offsetHeight / 2;
        const tcx = tn.x + te.offsetWidth / 2;
        const tcy = tn.y + te.offsetHeight / 2;
        const dx = tcx - fcx, dy = tcy - fcy;
        if (Math.abs(dx) >= Math.abs(dy)) {
            return dx >= 0 ? { from: 'r', to: 'l' } : { from: 'l', to: 'r' };
        } else {
            return dy >= 0 ? { from: 'b', to: 't' } : { from: 't', to: 'b' };
        }
    }

    function updateConnections() {
        const svg = document.getElementById('connections-svg');
        if (!svg) return;
        svg.querySelectorAll('.conn-path, .conn-hit').forEach(el => el.remove());

        const styleColor  = { solid:'#475569', dashed:'#3b82f6', dotted:'#10b981', thick:'#7c3aed' };
        const styleDash   = { dashed:'8 4', dotted:'2 5' };
        const styleWidth  = { thick: 4 };
        const styleMarker = { dashed:'arrow-dashed', dotted:'arrow-dotted', thick:'arrow-thick' };

        connections.forEach(conn => {
            const anchors = getBestAnchors(conn.from, conn.to);
            const p1 = getNodeAnchorXY(conn.from, anchors.from);
            const p2 = getNodeAnchorXY(conn.to,   anchors.to);
            if (!p1 || !p2) return;

            const style    = conn.style || 'solid';
            const lineType = conn.lineType || 'straight';
            const stroke   = styleColor[style] || '#475569';
            const sw       = styleWidth[style] || 2;
            const marker   = styleMarker[style] || 'arrow-solid';

            let d;
            if (lineType === 'curved') {
                const tension = Math.max(60, Math.abs(p2.x - p1.x) * 0.5, Math.abs(p2.y - p1.y) * 0.5);
                const anchorDir = { r:[1,0], l:[-1,0], b:[0,1], t:[0,-1] };
                const d1 = anchorDir[anchors.from] || [1,0];
                const d2 = anchorDir[anchors.to]   || [-1,0];
                d = `M ${p1.x} ${p1.y} C ${p1.x+d1[0]*tension} ${p1.y+d1[1]*tension}, ${p2.x+d2[0]*tension} ${p2.y+d2[1]*tension}, ${p2.x} ${p2.y}`;
            } else {
                d = `M ${p1.x} ${p1.y} L ${p2.x} ${p2.y}`;
            }

            const hit = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            hit.setAttribute('d', d);
            hit.setAttribute('class', 'conn-hit');
            hit.setAttribute('fill', 'none');
            hit.setAttribute('stroke', 'transparent');
            hit.setAttribute('stroke-width', '14');
            hit.style.pointerEvents = 'stroke';
            svg.appendChild(hit);

            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('d', d);
            path.setAttribute('class', 'conn-path');
            path.setAttribute('fill', 'none');
            path.setAttribute('stroke', stroke);
            path.setAttribute('stroke-width', sw);
            if (styleDash[style]) path.setAttribute('stroke-dasharray', styleDash[style]);
            path.setAttribute('marker-end', `url(#${marker})`);
            path.style.pointerEvents = 'none';
            svg.appendChild(path);
        });
    }

    function createSolidLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'solid-line', 'arrowhead-solid');
    }

    function createDashedLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'dashed-line', 'arrowhead-dashed');
    }

    function createDottedLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'dotted-line', 'arrowhead-dotted');
    }

    function createCurvedLine(x1, y1, x2, y2) {
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        const midX = (x1 + x2) / 2;
        const midY = (y1 + y2) / 2;
        const deltaX = Math.abs(x2 - x1);
        const deltaY = Math.abs(y2 - y1);
        let d;
        if (deltaX > deltaY) {
            d = `M ${x1} ${y1} L ${midX} ${y1} Q ${midX} ${midY - 20} ${midX} ${midY} L ${x2} ${midY} L ${x2} ${y2}`;
        } else {
            d = `M ${x1} ${y1} L ${x1} ${midY} Q ${midX - 20} ${midY} ${midX} ${midY} L ${midX} ${y2} L ${x2} ${y2}`;
        }
        path.setAttribute('d', d);
        path.setAttribute('class', 'connection-line curved-line');
        path.setAttribute('marker-end', 'url(#arrowhead-solid)');
        return path;
    }

    function createThickLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'thick-line', 'arrowhead-solid');
    }

    function createDoubleLine(x1, y1, x2, y2) {
        const group = document.createElementNS('http://www.w3.org/2000/svg', 'g');
        const path1 = createOrthogonalLine(x1, y1 - 2, x2, y2 - 2, 'double-line', 'arrowhead-solid');
        const path2 = createOrthogonalLine(x1, y1 + 2, x2, y2 + 2, 'double-line', null);
        group.appendChild(path1);
        group.appendChild(path2);
        return group;
    }

    function createWavyLine(x1, y1, x2, y2) {
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        const midX = (x1 + x2) / 2;
        const midY = (y1 + y2) / 2;
        const deltaX = Math.abs(x2 - x1);
        const deltaY = Math.abs(y2 - y1);
        let d;
        if (deltaX > deltaY) {
            d = `M ${x1} ${y1} Q ${x1 + 20} ${y1 - 5} ${x1 + 40} ${y1} T ${x1 + 80} ${y1} L ${midX} ${y1} Q ${midX + 10} ${midY - 5} ${midX} ${midY} T ${midX + 40} ${midY} L ${x2} ${midY} Q ${x2 - 10} ${midY + 5} ${x2} ${y2}`;
        } else {
            d = `M ${x1} ${y1} Q ${x1 - 5} ${y1 + 20} ${x1} ${y1 + 40} T ${x1} ${y1 + 80} L ${x1} ${midY} Q ${x1 - 5} ${midY + 10} ${x1} ${midY} T ${x1} ${midY + 40} L ${x1} ${y2} Q ${x1 + 5} ${y2 - 10} ${x2} ${y2}`;
        }
        path.setAttribute('d', d);
        path.setAttribute('class', 'connection-line wavy-line');
        path.setAttribute('marker-end', 'url(#arrowhead-solid)');
        return path;
    }

    function createSubTopicLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'sub-topic-line', 'arrowhead-default');
    }

    function createHierarchyLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'hierarchy-line', 'arrowhead-default');
    }

    function createOrthogonalLine(x1, y1, x2, y2, lineClass, arrowMarker = 'arrowhead-default') {
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        const GRID_SIZE = 20;
        let midX = (x1 + x2) / 2;
        let midY = (y1 + y2) / 2;
        midX = Math.round(midX / GRID_SIZE) * GRID_SIZE;
        midY = Math.round(midY / GRID_SIZE) * GRID_SIZE;
        const deltaX = Math.abs(x2 - x1);
        const deltaY = Math.abs(y2 - y1);
        let pathData;
        if (deltaX > deltaY) {
            pathData = `M ${x1} ${y1} L ${midX} ${y1} L ${midX} ${y2} L ${x2} ${y2}`;
        } else {
            pathData = `M ${x1} ${y1} L ${x1} ${midY} L ${x2} ${midY} L ${x2} ${y2}`;
        }
        path.setAttribute('d', pathData);
        path.setAttribute('class', `connection-line ${lineClass}`);
        path.style.fill = 'none';
        if (arrowMarker) {
            path.setAttribute('marker-end', `url(#${arrowMarker})`);
        }
        return path;
    }

    function createManualPath(x1, y1, x2, y2, pathPoints, connection) {
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        const GRID_SIZE = 20;
        let pathData = `M ${x1} ${y1}`;
        pathPoints.forEach(point => {
            const snappedX = Math.round(point.x / GRID_SIZE) * GRID_SIZE;
            const snappedY = Math.round(point.y / GRID_SIZE) * GRID_SIZE;
            pathData += ` L ${snappedX} ${snappedY}`;
        });
        pathData += ` L ${x2} ${y2}`;
        path.setAttribute('d', pathData);
        path.setAttribute('class', 'connection-line manual-line');
        path.style.stroke = '#6b7280';
        path.style.strokeWidth = '2';
        path.style.fill = 'none';
        path.setAttribute('marker-end', 'url(#arrowhead-default)');
        return path;
    }
    </script>
    @endif
@endsection
