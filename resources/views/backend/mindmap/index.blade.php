@extends('backend.layouts.app')

@section('content')
<div class="nxl-content">
    <!-- [ page-header ] start -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Mind Map Creator</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item">Mind Map</li>
            </ul>
        </div>
        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex d-md-none">
                    <a href="javascript:void(0)" class="page-header-right-close-toggle">
                        <i class="feather-arrow-left me-2"></i>
                        <span>Back</span>
                    </a>
                </div>
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                    <button id="save-mindmap-btn" class="btn btn-primary">
                        <i class="feather-save me-2"></i>Simpan Mind Map
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- [ page-header ] end -->

    <!-- [ Main Content ] start -->
    <div class="main-content">
        <div class="drawio-layout">
            <!-- Toolbar -->
            <div class="drawio-toolbar">
                <div class="toolbar-section">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-tool="select" onclick="setTool('select')" title="Select (V)">
                            <i class="feather-mouse-pointer"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-tool="pan" onclick="setTool('pan')" title="Pan (Space + drag)">
                            <i class="feather-move"></i>
                        </button>
                    </div>
                    
                    <div class="toolbar-divider"></div>
                    
                    <div class="btn-group me-2">
                        <button class="btn btn-sm btn-outline-warning" onclick="zoomIn()" title="Zoom In">
                            <i class="feather-zoom-in"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-warning" onclick="zoomOut()" title="Zoom Out">
                            <i class="feather-zoom-out"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-warning" onclick="resetZoom()" title="Reset Zoom">
                            <i class="feather-maximize-2"></i>
                        </button>
                    </div>
                </div>
                
                <div class="toolbar-section ms-auto">
                    <div class="btn-group">
                        <button onclick="clearCanvas()" class="btn btn-sm btn-outline-danger" title="Clear Canvas">
                            <i class="feather-trash-2"></i>
                        </button>
                        <button onclick="saveMindmap()" class="btn btn-sm btn-primary" title="Save">
                            <i class="feather-save"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="drawio-workspace">
                <!-- Left Panel - Categories -->
                <div class="drawio-left-panel custom-scrollbar">
                    <div class="panel-section panel-section--flex">
                        <div class="panel-header panel-header--accent">
                            <div class="panel-header__row">
                                <h6 class="mb-0"><i class="feather-layers me-2"></i>Kategori</h6>
                                <span class="panel-badge">{{ $categories->count() }}</span>
                            </div>
                            <p class="panel-subtitle mb-0">Pilih kategori untuk memuat materi</p>
                        </div>
                        <div class="panel-body panel-body--categories">
                            <div class="panel-search">
                                <i class="feather-search panel-search__icon"></i>
                                <input type="text" id="category-search" class="panel-search__input" placeholder="Cari kategori..." oninput="filterCategories(this.value)">
                            </div>
                            <div id="selected-category-label" class="selected-category-chip d-none">
                                <i class="feather-check-circle"></i>
                                <span id="selected-category-text"></span>
                            </div>
                            <div class="category-list custom-scrollbar" id="category-list">
                                @foreach($categories as $category)
                                    <div class="category-group mb-3" data-category-group="{{ $category->id }}">
                                        <button 
                                            onclick="toggleCategory('{{ $category->id }}', '{{ $category->name }}')"
                                            class="category-btn w-full text-start d-flex align-items-center"
                                            data-category-id="{{ $category->id }}">
                                            <span class="category-icon">
                                                <i class="feather-folder"></i>
                                            </span>
                                            <span class="category-text">{{ $category->name }}</span>
                                            @if($category->subcategories->count() > 0)
                                                <span class="category-arrow ms-auto">
                                                    <i class="feather-chevron-down"></i>
                                                </span>
                                            @endif
                                        </button>

                                        @if($category->subcategories->count() > 0)
                                            <div class="category-children" id="category-children-{{ $category->id }}">
                                                @foreach($category->subcategories as $child)
                                                    <button 
                                                        onclick="selectCategory('{{ $child->id }}', '{{ $category->name }} > {{ $child->name }}')"
                                                        class="category-btn category-child w-full text-start d-flex align-items-center"
                                                        data-category-id="{{ $child->id }}">
                                                        <span class="category-icon child-icon">
                                                            <i class="feather-folder"></i>
                                                        </span>
                                                        <span class="category-text">{{ $child->name }}</span>
                                                    </button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Canvas Area -->
                <div class="drawio-canvas-area">
                    <div class="canvas-chrome">
                        <span class="canvas-chrome__hint"><i class="feather-info"></i> Seret dari titik node untuk menghubungkan · Space + drag untuk geser · Ctrl + scroll untuk zoom</span>
                    </div>
                    <div class="canvas-viewport">
                        <div id="mindmap-canvas" class="canvas-container" style="width: 3000px; height: 3000px;">
                            <svg id="connections-svg" style="position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;overflow:visible;z-index:5;">
                                <defs>
                                    <marker id="arrow-solid" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                                        <polygon points="0 0, 12 4.5, 0 9" fill="#475569"/>
                                    </marker>
                                    <marker id="arrow-dashed" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                                        <polygon points="0 0, 12 4.5, 0 9" fill="#3b82f6"/>
                                    </marker>
                                    <marker id="arrow-preview" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                                        <polygon points="0 0, 12 4.5, 0 9" fill="#6366f1"/>
                                    </marker>
                                    <marker id="arrow-dotted" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                                        <polygon points="0 0, 12 4.5, 0 9" fill="#10b981"/>
                                    </marker>
                                    <marker id="arrow-thick" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                                        <polygon points="0 0, 12 4.5, 0 9" fill="#7c3aed"/>
                                    </marker>
                                    <marker id="arrow-selected" markerUnits="userSpaceOnUse" markerWidth="12" markerHeight="9" refX="11" refY="4.5" orient="auto">
                                        <polygon points="0 0, 12 4.5, 0 9" fill="#f59e0b"/>
                                    </marker>
                                </defs>
                            </svg>
                            <!-- Separate overlay for handles, above nodes -->
                            <svg id="handles-svg" style="position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;overflow:visible;z-index:100;"></svg>

                            <input type="hidden" id="connection-style" value="solid">
                            <input type="hidden" id="connection-line-type" value="straight">
                        </div>
                    </div>

                    <div class="canvas-statusbar">
                        <span class="canvas-statusbar__item" id="status-tool"><i class="feather-move"></i> Pan</span>
                        <span class="canvas-statusbar__divider"></span>
                        <span class="canvas-statusbar__item" id="status-line-style">Garis: Dashed</span>
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

                <!-- Right Panel - Materi & Garis Koneksi (tabs) -->
                <div class="drawio-right-panel">
                    <div class="mm-panel-tabs" role="tablist">
                        <button type="button" class="mm-panel-tab active" role="tab" aria-selected="true" data-tab="materials" onclick="switchRightPanelTab('materials')">
                            <i class="feather-book-open"></i>
                            <span>Materi</span>
                            <span id="materials-count" class="mm-panel-tab__badge">0</span>
                        </button>
                        <button type="button" class="mm-panel-tab" role="tab" aria-selected="false" data-tab="connections" onclick="switchRightPanelTab('connections')">
                            <i class="feather-git-branch"></i>
                            <span>Garis</span>
                        </button>
                    </div>

                    <div class="mm-panel-tab-content custom-scrollbar">
                        <div class="mm-tab-pane active" id="tab-materials" role="tabpanel">
                            <div class="mm-tab-pane__header">
                                <p class="mm-tab-pane__hint mb-0">Seret materi ke canvas untuk menambah node</p>
                            </div>
                            <div class="panel-body panel-body--materials">
                                <div id="materials-list" class="materials-list custom-scrollbar">
                                    <div class="empty-state">
                                        <div class="empty-state__icon"><i class="feather-inbox"></i></div>
                                        <p class="empty-state__title">Belum ada materi</p>
                                        <p class="empty-state__hint">Pilih kategori di panel kiri untuk memuat daftar materi</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mm-tab-pane" id="tab-connections" role="tabpanel">
                            <div class="mm-tab-pane__header">
                                <p class="mm-tab-pane__hint mb-0">Klik garis untuk memilih, lalu pilih gaya garis untuk mengubahnya</p>
                            </div>
                            <div class="panel-body panel-body--connections">
                            <div class="connection-hint" id="connection-hint">
                                <i class="feather-mouse-pointer"></i>
                                <span>Pilih gaya garis, seret dari titik node sumber ke titik node tujuan</span>
                            </div>

                            <p class="line-group-label">Tipe Garis</p>
                            <div class="line-style-grid line-style-grid--single">
                                <div class="line-style-item" data-line-type="curved" onclick="setLineType('curved')" title="Garis Melengkung">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <path d="M5 15 Q20 5 35 15" stroke="#3b82f6" stroke-width="2" fill="none"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Melengkung</span>
                                </div>
                                <div class="line-style-item selected" data-line-type="straight" onclick="setLineType('straight')" title="Garis Lurus">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#3b82f6" stroke-width="2"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Lurus</span>
                                </div>
                            </div>

                            <input type="hidden" id="connection-line-type" value="straight">

                            <p class="line-group-label">Gaya Garis</p>
                            <div class="line-style-grid">
                                <div class="line-style-item selected" data-line-style="solid" onclick="setLineStyle('solid')" title="Garis Solid">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#3b82f6" stroke-width="2"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Solid</span>
                                </div>
                                <div class="line-style-item" data-line-style="dashed" onclick="setLineStyle('dashed')" title="Garis Putus-putus">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#ef4444" stroke-width="2" stroke-dasharray="8,4"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Dashed</span>
                                </div>
                                <div class="line-style-item" data-line-style="dotted" onclick="setLineStyle('dotted')" title="Garis Titik-titik">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#10b981" stroke-width="2" stroke-dasharray="2,4"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Dotted</span>
                                </div>
                                <div class="line-style-item" data-line-style="curved" onclick="setLineStyle('curved')" title="Garis Melengkung">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <path d="M5 15 Q20 5 35 15" stroke="#f59e0b" stroke-width="2" fill="none"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Curved</span>
                                </div>
                            </div>

                            <p class="line-group-label">Lanjutan</p>
                            <div class="line-style-grid">
                                <div class="line-style-item" data-line-style="thick" onclick="setLineStyle('thick')" title="Garis Tebal">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#8b5cf6" stroke-width="4"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Thick</span>
                                </div>
                                <div class="line-style-item" data-line-style="double" onclick="setLineStyle('double')" title="Garis Ganda">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="13" x2="35" y2="13" stroke="#ec4899" stroke-width="2"/>
                                            <line x1="5" y1="17" x2="35" y2="17" stroke="#ec4899" stroke-width="2"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Double</span>
                                </div>
                                <div class="line-style-item" data-line-style="wavy" onclick="setLineStyle('wavy')" title="Garis Bergelombang">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <path d="M5 15 Q10 10 15 15 T25 15 T35 15" stroke="#06b6d4" stroke-width="2" fill="none"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Wavy</span>
                                </div>
                                <div class="line-style-item" data-line-style="manual" onclick="setLineStyle('manual')" title="Manual Path">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <path d="M5 15 L10 10 L20 20 L30 8 L35 15" stroke="#6b7280" stroke-width="2" fill="none"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Manual</span>
                                </div>
                            </div>

                            <p class="line-group-label">Mind map</p>
                            <div class="line-style-grid line-style-grid--single">
                                <div class="line-style-item" data-line-style="sub-topic" onclick="setLineStyle('sub-topic')" title="Sub Topic (Dotted)">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#3b82f6" stroke-width="2" stroke-dasharray="5,5" opacity="0.7"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Sub Topic</span>
                                </div>
                                <div class="line-style-item" data-line-style="hierarchy" onclick="setLineStyle('hierarchy')" title="Hierarchy (Thick)">
                                    <div class="line-preview">
                                        <svg width="40" height="30">
                                            <line x1="5" y1="15" x2="35" y2="15" stroke="#3b82f6" stroke-width="3"/>
                                        </svg>
                                    </div>
                                    <span class="line-label">Hierarchy</span>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
</div>

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


    .completion-toggle {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 11px;
        color: #64748b;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 15;
    }

    .completion-toggle:hover {
        /* Hover effect disabled */
    }

    .completion-toggle.completed {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
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


    /* Selected connection styling */
    .jtk-connector.selected {
        stroke: #10b981 !important;
        stroke-width: 4 !important;
        filter: drop-shadow(0 0 6px rgba(16, 185, 129, 0.4));
    }

    #mindmap-canvas {
        position: relative;
        transform-origin: 0 0;
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


    /* Temporary connection line */
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


    .btn-xs {
        padding: 2px 6px;
        font-size: 10px;
        line-height: 1.2;
        border-radius: 3px;
    }

    .category-btn {
        background: var(--mm-surface);
        border: 1px solid var(--mm-border);
        border-radius: var(--mm-radius);
        padding: 8px 10px;
        margin-bottom: 5px;
        transition: all 0.18s ease;
        font-size: 12px;
        font-weight: 500;
        color: #334155;
        box-shadow: var(--mm-shadow);
        width: 100%;
    }

    .category-btn:hover {
        /* Hover effect disabled */
    }

    .category-btn.active {
        background: linear-gradient(135deg, var(--mm-primary) 0%, var(--mm-primary-dark) 100%);
        color: #fff !important;
        border-color: var(--mm-primary-dark) !important;
        box-shadow: 0 4px 14px rgba(52, 84, 209, 0.28);
    }

    .category-group.is-hidden {
        display: none;
    }

    .category-icon {
        width: 26px;
        height: 26px;
        background: var(--mm-primary-light);
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--mm-primary);
        margin-right: 8px;
        flex-shrink: 0;
        transition: all 0.18s ease;
        font-size: 13px;
    }

    .category-btn:hover .category-icon {
        background: var(--mm-primary);
        color: #fff;
    }

    .category-btn.active .category-icon {
        background: rgba(255, 255, 255, 0.22);
        color: #fff;
    }

    .category-text {
        flex: 1;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .category-arrow {
        color: #6b7280;
        transition: transform 0.2s ease;
    }

    .category-children {
        margin-left: 8px;
        margin-top: 4px;
        padding-left: 8px;
        border-left: 2px solid var(--mm-border);
        display: none;
    }

    .category-children.show {
        display: block;
        animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .category-child {
        padding: 7px 10px;
        font-size: 11px;
    }

    .category-child .category-icon {
        width: 28px;
        height: 28px;
        margin-right: 10px;
    }

    .child-icon {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        color: #10b981;
    }

    .category-btn:hover .child-icon {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .category-btn.active .child-icon {
        background: rgba(255,255,255,0.2);
        color: white;
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

    .selected-category-chip {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 10px;
        margin-bottom: 10px;
        background: var(--mm-primary-light);
        border: 1px solid #c7d2fe;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 500;
        color: var(--mm-primary-dark);
    }

    .selected-category-chip i {
        flex-shrink: 0;
        font-size: 14px;
    }

    .btn.w-full {
        width: 100%;
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

    .drawio-left-panel,
    .drawio-right-panel {
        width: var(--mm-panel-width);
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #fafbfc;
    }

    .drawio-left-panel {
        border-right: 1px solid var(--mm-border);
    }

    .drawio-right-panel {
        border-left: 1px solid var(--mm-border);
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

    .panel-body--categories {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        overflow: hidden;
        padding: 10px 12px;
    }

    .panel-header {
        padding: 10px 12px;
        border-bottom: 1px solid var(--mm-border);
        background: var(--mm-surface);
    }

    .panel-header--accent { border-left: 3px solid var(--mm-primary); }
    .panel-header--materials { border-left: 3px solid var(--mm-success); }
    .panel-header--connection { border-left: 3px solid #0ea5e9; }

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

    .panel-body--connections {
        padding: 12px 16px 16px;
        overflow-y: auto;
        flex: 1;
        min-height: 0;
    }

    .panel-body--materials {
        flex: 1;
        overflow: hidden;
        padding: 8px 10px 10px;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    .category-list {
        flex: 1;
        overflow-y: auto;
        min-height: 0;
    }

    /* Right panel tabs */
    .mm-panel-tabs {
        display: flex;
        flex-shrink: 0;
        border-bottom: 1px solid var(--mm-border);
        background: var(--mm-surface);
    }

    .mm-panel-tab {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 10px 8px;
        border: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
        background: transparent;
        font-size: 11px;
        font-weight: 600;
        color: var(--mm-muted);
        cursor: pointer;
        transition: color 0.18s ease, background 0.18s ease, border-color 0.18s ease;
    }

    .mm-panel-tab i {
        font-size: 14px;
    }

    .mm-panel-tab:hover {
        /* Hover effect disabled */
    }

    .mm-panel-tab.active {
        color: var(--mm-primary);
        border-bottom-color: var(--mm-primary);
        background: var(--mm-primary-light);
    }

    .mm-panel-tab__badge {
        font-size: 10px;
        font-weight: 600;
        padding: 1px 6px;
        border-radius: 999px;
        background: #ecfdf5;
        color: var(--mm-success);
        line-height: 1.4;
    }

    .mm-panel-tab.active .mm-panel-tab__badge {
        background: rgba(255, 255, 255, 0.95);
        color: var(--mm-primary);
    }

    .mm-panel-tab-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        overflow: hidden;
    }

    .mm-tab-pane {
        display: none;
        flex-direction: column;
        flex: 1;
        min-height: 0;
        overflow: hidden;
    }

    .mm-tab-pane.active {
        display: flex;
    }

    .mm-tab-pane__header {
        flex-shrink: 0;
        padding: 8px 12px;
        background: #fafbfc;
        border-bottom: 1px solid var(--mm-border);
    }

    .mm-tab-pane__hint {
        font-size: 11px;
        color: var(--mm-muted);
        line-height: 1.35;
    }

    .line-group-label {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #94a3b8;
        margin: 12px 0 8px;
    }

    .line-group-label:first-of-type {
        margin-top: 0;
    }

    .line-style-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }

    .line-style-grid--single {
        grid-template-columns: repeat(2, 1fr);
    }

    .line-style-item {
        border: 1px solid var(--mm-border);
        border-radius: 8px;
        padding: 8px 6px;
        cursor: pointer;
        transition: all 0.18s ease;
        text-align: center;
        background: var(--mm-surface);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .line-style-item:hover {
        /* Hover effect disabled */
    }

    .line-style-item.selected {
        border-color: var(--mm-primary);
        background: var(--mm-primary-light);
        box-shadow: 0 0 0 2px rgba(52, 84, 209, 0.2);
    }

    .line-preview {
        background: #f8fafc;
        border-radius: 6px;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .line-label {
        font-size: 10px;
        font-weight: 500;
        color: var(--mm-muted);
    }

    .connection-hint {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 12px;
        margin-bottom: 14px;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 8px;
        font-size: 11px;
        color: #0369a1;
        line-height: 1.4;
    }

    .connection-hint i {
        flex-shrink: 0;
        margin-top: 1px;
        font-size: 14px;
    }

    .connection-hint.is-active {
        background: #ecfdf5;
        border-color: #6ee7b7;
        color: #047857;
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
        overflow: hidden;
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

    /* ─── Mind Map Node — roadmap.sh style ─── */
    .mindmap-node {
        position: absolute;
        min-width: 150px;
        max-width: 240px;
        padding: 10px 18px;
        border-radius: 8px;
        border: 2px solid transparent;
        cursor: move;
        user-select: none;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        box-shadow: 3px 3px 0 rgba(0,0,0,0.25);
        transition: box-shadow 0.15s ease, transform 0.1s ease, filter 0.15s ease;
    }

    .mindmap-node:hover {
        filter: brightness(1.06);
        box-shadow: 4px 4px 0 rgba(0,0,0,0.3);
    }

    .mindmap-node.selected {
        box-shadow: 0 0 0 3px #fff, 0 0 0 5px var(--mm-primary), 3px 3px 0 rgba(0,0,0,0.25);
    }

    /* Fill colors per type */
    .mindmap-node.material  { background: #fde047; border-color: #ca8a04; color: #1a1a1a; }
    .mindmap-node.main-topic { background: #60a5fa; border-color: #1d4ed8; color: #fff; }
    .mindmap-node.sub-topic  { background: #86efac; border-color: #15803d; color: #1a1a1a; }

    .node-label {
        font-size: 12px;
        font-weight: 700;
        line-height: 1.3;
        word-break: break-word;
        pointer-events: none;
    }

    /* Connection anchors on each side */
    .connection-anchor {
        position: absolute;
        width: 12px;
        height: 12px;
        background: #fff;
        border: 2px solid #64748b;
        border-radius: 50%;
        cursor: crosshair;
        z-index: 15;
        opacity: 0;
        transition: opacity 0.15s ease, background 0.15s ease, border-color 0.15s ease;
    }

    .mindmap-node:hover .connection-anchor,
    .mindmap-node.selected .connection-anchor {
        opacity: 1;
    }

    .endpoint-drag-active .connection-anchor {
        opacity: 1 !important;
        background: #fef3c7;
        border-color: #f59e0b;
    }

    .mindmap-node.endpoint-drag-hover {
        outline: 2px dashed #f59e0b;
        outline-offset: 2px;
    }

    .connection-anchor:hover {
        background: var(--mm-primary);
        border-color: var(--mm-primary);
        opacity: 1 !important;
        transform: scale(1.3);
    }

    .anchor-t  { top: -6px;  left: 50%;  transform: translateX(-50%); }
    .anchor-b  { bottom: -6px; left: 50%; transform: translateX(-50%); }
    .anchor-l  { left: -6px; top: 50%;   transform: translateY(-50%); }
    .anchor-r  { right: -6px; top: 50%;  transform: translateY(-50%); }
    .anchor-t:hover  { transform: translateX(-50%) scale(1.3); }
    .anchor-b:hover  { transform: translateX(-50%) scale(1.3); }
    .anchor-l:hover  { transform: translateY(-50%) scale(1.3); }
    .anchor-r:hover  { transform: translateY(-50%) scale(1.3); }

</style>

<script>
    // UI State
    let selectedCategory = null;
    let nodeIdCounter = 1;
    let selectedNode = null;
    let selectedConnection = null;
    let selectedNodeForConnection = null;
    let connectionMode = false;
    let manualDrawingMode = false;
    let isRestoringConnections = false;
    const GRID_SIZE = 20;

    // Data storage for manual coordinate system
    let nodes = [];
    let connections = [];

    // Zoom and Pan state
    let zoomLevel = 1;
    let panOffset = { x: 0, y: 0 };
    let isPanning = false;
    let panStart = { x: 0, y: 0 };
    let currentTool = 'select';
    let spacePressed = false;

    // Node dragging state
    let isDraggingNode = false;
    let draggedNode = null;
    let dragOffset = { x: 0, y: 0 };

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Mindmap initialized');

        // Initialize drag and drop
        initializeDragDrop();

        // Setup zoom and pan event listeners
        const canvasArea = document.querySelector('.drawio-canvas-area');
        const canvasViewport = document.querySelector('.canvas-viewport');

        // Wheel: Ctrl+scroll = zoom around cursor, plain scroll = pan canvas
        canvasViewport.addEventListener('wheel', function(e) {
            e.preventDefault();
            if (e.ctrlKey) {
                const rect = canvasViewport.getBoundingClientRect();
                const mx = e.clientX - rect.left;
                const my = e.clientY - rect.top;
                if (e.deltaY < 0) {
                    zoomAroundPoint(zoomLevel * 1.1, mx, my);
                } else {
                    zoomAroundPoint(zoomLevel / 1.1, mx, my);
                }
            } else {
                // Plain scroll pans the canvas
                panOffset.x -= e.deltaX;
                panOffset.y -= e.deltaY;
                updateZoom();
            }
        }, { passive: false });

        // Mouse events for panning
        canvasViewport.addEventListener('mousedown', startPan);
        document.addEventListener('mousemove', doPan);
        document.addEventListener('mouseup', endPan);

        // Mouse events for node dragging
        document.addEventListener('mousemove', function(e) {
            if (isDraggingNode && draggedNode) {
                e.preventDefault();
                
                const canvas = document.getElementById('mindmap-canvas');
                const canvasRect = canvas.getBoundingClientRect();
                
                // Calculate new position relative to canvas, accounting for zoom
                const x = (e.clientX - canvasRect.left - dragOffset.x) / zoomLevel;
                const y = (e.clientY - canvasRect.top - dragOffset.y) / zoomLevel;
                
                // Snap to grid
                const snappedX = snapToGrid(x);
                const snappedY = snapToGrid(y);
                
                // Update node position
                draggedNode.style.left = snappedX + 'px';
                draggedNode.style.top = snappedY + 'px';
                
                // Update node data
                const nodeData = nodes.find(n => n.id === draggedNode.id);
                if (nodeData) {
                    nodeData.x = snappedX;
                    nodeData.y = snappedY;
                }
                
                // Update connections
                updateConnections();
            }
        });

        document.addEventListener('mouseup', function(e) {
            if (isDraggingNode && draggedNode) {
                draggedNode.style.cursor = 'move';
                isDraggingNode = false;
                draggedNode = null;
            }
        });

        // Keyboard events for spacebar panning
        // Delete key: remove selected connection or node
        document.addEventListener('keydown', function(e) {
            if (e.code === 'Space' && !e.target.matches('input, textarea')) {
                e.preventDefault();
                spacePressed = true;
                canvasViewport.style.cursor = 'grab';
            }
            if ((e.key === 'Delete' || e.key === 'Backspace') && !e.target.matches('input, textarea')) {
                if (selectedConnectionId) {
                    deleteConnection(selectedConnectionId);
                } else if (selectedNode && selectedNode !== 'root-node') {
                    const node = document.getElementById(selectedNode);
                    if (node) removeNode(node);
                }
            }
        });

        document.addEventListener('keyup', function(e) {
            if (e.code === 'Space') {
                spacePressed = false;
                canvasViewport.style.cursor = '';
            }
        });
    });


    // ============================================
    // UI FUNCTIONS (Category & Materials)
    // ============================================

    function snapToGrid(value) {
        return Math.round(value / GRID_SIZE) * GRID_SIZE;
    }

    function filterCategories(query) {
        const q = (query || '').trim().toLowerCase();
        document.querySelectorAll('.category-group').forEach(group => {
            const buttons = group.querySelectorAll('.category-btn');
            let visible = false;
            buttons.forEach(btn => {
                const text = btn.querySelector('.category-text')?.textContent.toLowerCase() || '';
                const match = !q || text.includes(q);
                btn.style.display = match ? '' : 'none';
                if (match) visible = true;
            });
            group.classList.toggle('is-hidden', !visible);
        });
    }

    function updateCategoryChip(name) {
        const chip = document.getElementById('selected-category-label');
        const text = document.getElementById('selected-category-text');
        if (!chip || !text) return;
        if (name) {
            text.textContent = name;
            chip.classList.remove('d-none');
        } else {
            chip.classList.add('d-none');
        }
    }

    function toggleCategory(categoryId, categoryName) {
        selectedCategory = categoryId;
        updateCategoryChip(categoryName);

        // Update UI - remove active class from all buttons
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Add active class to selected button
        document.querySelector(`[data-category-id="${categoryId}"]`).classList.add('active');

        // Hide all category children first
        document.querySelectorAll('.category-children').forEach(children => {
            children.classList.remove('show');
        });

        // Reset all arrows
        document.querySelectorAll('.category-arrow').forEach(arrow => {
            arrow.style.transform = 'rotate(0deg)';
        });

        // Show children of the selected category
        const childrenContainer = document.getElementById(`category-children-${categoryId}`);
        if (childrenContainer) {
            childrenContainer.classList.add('show');
            // Rotate the arrow
            const arrow = document.querySelector(`[data-category-id="${categoryId}"] .category-arrow`);
            if (arrow) {
                arrow.style.transform = 'rotate(180deg)';
            }
        }

        // Clear canvas and materials when parent category is selected
        resetCanvas();
        document.getElementById('materials-list').innerHTML = `
            <div class="empty-state">
                <div class="empty-state__icon"><i class="feather-inbox"></i></div>
                <p class="empty-state__title">Belum ada materi</p>
                <p class="empty-state__hint">Pilih subkategori untuk memuat daftar materi</p>
            </div>
        `;
        document.getElementById('materials-count').textContent = '0';
    }

    function selectCategory(categoryId, categoryName) {
        selectedCategory = categoryId;
        updateCategoryChip(categoryName);

        // Update UI - remove active class from all buttons
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Add active class to selected button
        document.querySelector(`[data-category-id="${categoryId}"]`).classList.add('active');

        // Hide all category children first
        document.querySelectorAll('.category-children').forEach(children => {
            children.classList.remove('show');
        });

        // Reset all arrows
        document.querySelectorAll('.category-arrow').forEach(arrow => {
            arrow.style.transform = 'rotate(0deg)';
        });

        // Show children of the selected category's parent if it's a child category
        const selectedBtn = document.querySelector(`[data-category-id="${categoryId}"]`);
        const parentGroup = selectedBtn.closest('.category-group');
        const childrenContainer = parentGroup.querySelector('.category-children');

        if (childrenContainer) {
            childrenContainer.classList.add('show');
            // Rotate the arrow
            const arrow = parentGroup.querySelector('.category-arrow');
            if (arrow) {
                arrow.style.transform = 'rotate(180deg)';
            }
        }

        // Load materials
        switchRightPanelTab('materials');
        loadMaterials(categoryId);

        // Load mindmap data from database
        loadMindmapData(categoryId);
    }

    function switchRightPanelTab(tabName) {
        document.querySelectorAll('.mm-panel-tab').forEach(tab => {
            const isActive = tab.dataset.tab === tabName;
            tab.classList.toggle('active', isActive);
            tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });
        document.querySelectorAll('.mm-tab-pane').forEach(pane => {
            pane.classList.toggle('active', pane.id === `tab-${tabName}`);
        });
    }

    function loadMaterials(categoryId) {
        fetch(`/mindmap-creator/materials?category_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                displayMaterials(data.materials);
            })
            .catch(error => {
                console.error('Error loading materials:', error);
            });
    }

    function resetCanvas() {
        // Remove all nodes from canvas
        const canvas = document.getElementById('mindmap-canvas');
        if (canvas) {
            canvas.querySelectorAll('.mindmap-node').forEach(node => node.remove());
        }

        // Clear SVG connections
        const svg = document.getElementById('connections-svg');
        if (svg) svg.querySelectorAll('.conn-path, .conn-hit').forEach(el => el.remove());
        const hSvg = document.getElementById('handles-svg');
        if (hSvg) hSvg.innerHTML = '';

        // Clear arrays
        nodes.length = 0;
        connections.length = 0;
        selectedNode = null;
        selectedConnection = null;
        selectedNodeForConnection = null;
    }

    // ============================================
    // MANUAL COORDINATE SYSTEM - TO BE IMPLEMENTED
    // ============================================

    // TODO: Implement manual node positioning
    function createNode(x, y, title, type = 'material') {
        console.log('Create node at:', { x, y, title, type });
        // Your implementation here
    }

    function createConnection(fromId, toId, fromAnchor, toAnchor, style = 'solid') {
        console.log('=== CREATE CONNECTION ===');
        console.log('From:', fromId, 'To:', toId, 'Style:', style);
        // TODO: Implement custom connection drawing
    }

    // TODO: Implement save/load functionality
    function saveMindmap() {
        console.log('Save mindmap:', { nodes, connections });
        // Your implementation here
    }

    function filterCategories(query) {
        const q = (query || '').trim().toLowerCase();
        document.querySelectorAll('.category-group').forEach(group => {
            const buttons = group.querySelectorAll('.category-btn');
            let visible = false;
            buttons.forEach(btn => {
                const text = btn.querySelector('.category-text')?.textContent.toLowerCase() || '';
                const match = !q || text.includes(q);
                btn.style.display = match ? '' : 'none';
                if (match) visible = true;
            });
            group.classList.toggle('is-hidden', !visible);
        });
    }

    function updateCategoryChip(name) {
        const chip = document.getElementById('selected-category-label');
        const text = document.getElementById('selected-category-text');
        if (!chip || !text) return;
        if (name) {
            text.textContent = name;
            chip.classList.remove('d-none');
        } else {
            chip.classList.add('d-none');
        }
    }

    function updateNodeCount() {
        const el = document.getElementById('status-nodes');
        if (el) {
            const count = document.querySelectorAll('.mindmap-node:not(.root)').length;
            el.textContent = count + ' node';
        }
    }

    function updateLineStyleStatus(style) {
        const el = document.getElementById('status-line-style');
        if (el) {
            const labels = {
                solid: 'Solid', dashed: 'Dashed', dotted: 'Dotted', curved: 'Curved',
                thick: 'Thick', double: 'Double', wavy: 'Wavy', manual: 'Manual',
                'sub-topic': 'Sub Topic', hierarchy: 'Hierarchy'
            };
            el.textContent = 'Garis: ' + (labels[style] || style);
        }
    }

    function updateToolStatus(tool) {
        const el = document.getElementById('status-tool');
        if (!el) return;
        const icons = { select: 'feather-mouse-pointer', pan: 'feather-move' };
        const labels = { select: 'Select', pan: 'Pan' };
        el.innerHTML = `<i class="${icons[tool] || 'feather-tool'}"></i> ${labels[tool] || tool}`;
    }

    function loadMindmapData(categoryId) {
        console.log('Loading mindmap for category:', categoryId);
        fetch(`/mindmap-creator/load?reference_id=${categoryId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Load response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Load response data:', data);
            if (data.success && data.data && data.data.structure) {
                console.log('Rendering mindmap structure:', data.data.structure);
                renderMindmap(data.data.structure);
            } else {
                console.log('No mindmap data found or invalid structure');
                // Clear canvas when no mindmap exists for this category
                resetCanvas();
            }
        })
        .catch(error => {
            console.error('Error loading mindmap:', error);
        });
    }

    function renderMindmap(structure) {
        // Clear existing nodes and connections
        resetCanvas();

        const canvas = document.getElementById('mindmap-canvas');
        if (!canvas) {
            console.error('Canvas element not found');
            return;
        }

        if (structure.nodes) {
            structure.nodes.forEach(nodeData => {
                // Create node element
                const node = document.createElement('div');
                node.className = `mindmap-node ${nodeData.type || 'material'}`;
                node.id = nodeData.id;
                node.style.left = nodeData.x + 'px';
                node.style.top = nodeData.y + 'px';

                // Choose icon based on node type
                let icon = 'feather-book-open';
                if (nodeData.type === 'main-topic') icon = 'feather-layers';
                else if (nodeData.type === 'sub-topic') icon = 'feather-file-text';

                node.innerHTML = `
                    <span class="node-label">${nodeData.title}</span>
                    <div class="connection-anchor anchor-t" data-anchor="t" data-node-id="${nodeData.id}"></div>
                    <div class="connection-anchor anchor-b" data-anchor="b" data-node-id="${nodeData.id}"></div>
                    <div class="connection-anchor anchor-l" data-anchor="l" data-node-id="${nodeData.id}"></div>
                    <div class="connection-anchor anchor-r" data-anchor="r" data-node-id="${nodeData.id}"></div>
                `;

                // Add click listener
                node.addEventListener('click', function(e) {
                    e.stopPropagation();
                    selectNode(nodeData.id);
                });

                // Add connection drag functionality - Shift + drag to create connections
                node.addEventListener('mousedown', function(e) {
                    if (e.target.classList.contains('connection-anchor')) return; // handled by anchor
                    if (e.button === 0 && e.shiftKey) { // Left click + Shift
                        e.stopPropagation(); // Prevent event bubbling to canvas
                        handleAnchorMouseDown(e, nodeData.id, 'auto');
                    } else if (e.button === 0) { // Regular left click for node selection and dragging
                        e.stopPropagation(); // Prevent event bubbling to canvas
                        selectNode(nodeData.id);
                        
                        // Start dragging the node
                        isDraggingNode = true;
                        draggedNode = node;
                        const rect = node.getBoundingClientRect();
                        dragOffset.x = e.clientX - rect.left;
                        dragOffset.y = e.clientY - rect.top;
                        node.style.cursor = 'grabbing';
                    }
                });

                // Wire anchor dots to connection drawing
                node.querySelectorAll('.connection-anchor').forEach(anchor => {
                    anchor.addEventListener('mousedown', function(e) {
                        e.stopPropagation();
                        e.preventDefault();
                        handleAnchorMouseDown(e, nodeData.id, anchor.dataset.anchor);
                    });
                    anchor.addEventListener('mouseup', function(e) {
                        e.stopPropagation();
                        if (connEndpointDrag) {
                            commitConnEndpointDrag(nodeData.id, anchor.dataset.anchor);
                        } else {
                            commitAnchorConnection(nodeData.id, anchor.dataset.anchor);
                        }
                    });
                });

                canvas.appendChild(node);

                // Add to nodes array
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

        // Restore connections
        if (structure.connections) {
            console.log('=== RESTORING CONNECTIONS ===');
            console.log('Total connections in structure:', structure.connections.length);
            
            structure.connections.forEach(connData => {
                // Check if connection already exists in connections array to prevent duplicates
                const alreadyInArray = connections.some(c => 
                    c.from === connData.from && c.to === connData.to && c.id === connData.id
                );
                
                if (alreadyInArray) {
                    console.log('Connection already in array, skipping:', connData);
                    return;
                }
                
                // Add to connections array for data tracking
                connections.push(connData);
                console.log('Connection data added:', connData);
            });
            
            console.log('=== RESTORATION COMPLETE ===');
            console.log('Final connections array length:', connections.length);
        }

        updateNodeCount();
        refreshMaterialsList();

        // Wait two frames so the browser finishes layout and nodes have valid offsetWidth/Height
        requestAnimationFrame(() => requestAnimationFrame(() => updateConnections()));
    }

    function resetCanvas() {
        // Remove all nodes from canvas
        const canvas = document.getElementById('mindmap-canvas');
        if (canvas) {
            canvas.querySelectorAll('.mindmap-node').forEach(node => node.remove());
        }

        // Clear SVG connections
        const svg = document.getElementById('connections-svg');
        if (svg) svg.querySelectorAll('.conn-path, .conn-hit').forEach(el => el.remove());
        const hSvg2 = document.getElementById('handles-svg');
        if (hSvg2) hSvg2.innerHTML = '';

        // Remove legacy connection lines
        document.querySelectorAll('.connection-line').forEach(line => line.remove());

        // Clear arrays
        nodes.length = 0;
        connections.length = 0;
        selectedNode = null;
        selectedConnection = null;
        selectedNodeForConnection = null;
    }

    function switchRightPanelTab(tabName) {
        document.querySelectorAll('.mm-panel-tab').forEach(tab => {
            const isActive = tab.dataset.tab === tabName;
            tab.classList.toggle('active', isActive);
            tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });
        document.querySelectorAll('.mm-tab-pane').forEach(pane => {
            pane.classList.toggle('active', pane.id === `tab-${tabName}`);
        });
    }

    function loadMaterials(categoryId) {
        fetch(`/mindmap-creator/materials?category_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                displayMaterials(data.materials);
            })
            .catch(error => {
                console.error('Error loading materials:', error);
            });
    }

    function displayMaterials(materials) {
        const container = document.getElementById('materials-list');
        const countEl = document.getElementById('materials-count');

        // Get material IDs that are already on the canvas
        const canvasMaterialIds = nodes
            .filter(node => node.materialId && node.type === 'material')
            .map(node => node.materialId);

        // Filter out materials that are already on the canvas
        const availableMaterials = materials.filter(material => !canvasMaterialIds.includes(material.id));

        if (countEl) countEl.textContent = availableMaterials.length;

        if (availableMaterials.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state__icon"><i class="feather-check-circle"></i></div>
                    <p class="empty-state__title">Semua materi sudah ditambahkan</p>
                    <p class="empty-state__hint">Semua materi dari kategori ini sudah ada di canvas</p>
                </div>`;
            return;
        }

        container.innerHTML = availableMaterials.map(material => `
            <div class="material-item"
                draggable="true"
                ondragstart="startDrag(event, '${material.id}', '${material.title.replace(/'/g, "\\'")}', '${(material.description || '').replace(/'/g, "\\'")}', 'material')">
                <span class="material-item__icon"><i class="feather-file-text"></i></span>
                <div class="material-item__body">
                    <p class="material-item__title">${material.title}</p>
                    <span class="material-item__meta">${material.difficulty_level || '-'} · ${material.duration || '-'}</span>
                </div>
            </div>
        `).join('');
    }

    function refreshMaterialsList() {
        if (!selectedCategory) return;
        loadMaterials(selectedCategory);
    }

    function startDrag(e, materialId, title, description, nodeType = 'material') {
        console.log('=== DRAG START ===');
        console.log('Event type:', e.type);
        console.log('Target:', e.target);
        console.log('Material data:', { materialId, title, description, nodeType });
        
        try {
            e.dataTransfer.setData('materialId', materialId);
            e.dataTransfer.setData('title', title);
            e.dataTransfer.setData('description', description);
            e.dataTransfer.setData('nodeType', nodeType);
            console.log('Data set successfully');
        } catch (error) {
            console.error('Error setting drag data:', error);
        }
    }

    // Allow dropping on canvas
    function initializeDragDrop() {
        const canvas = document.getElementById('mindmap-canvas');
        const viewport = document.querySelector('.canvas-viewport');
        const dropTargets = [viewport, canvas]; // Try both
        
        dropTargets.forEach(target => {
            if (!target) return;
            
            target.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Drag over:', this.className);
            });

            target.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('=== DROP EVENT ===');
                console.log('Drop triggered on:', this.id || this.className);
                console.log('Drop coordinates:', { clientX: e.clientX, clientY: e.clientY });
                
                const materialId = e.dataTransfer.getData('materialId');
                const title = e.dataTransfer.getData('title');
                const description = e.dataTransfer.getData('description');
                const nodeType = e.dataTransfer.getData('nodeType') || 'material';
                
                console.log('Retrieved data:', { materialId, title, description, nodeType });
                
                if (materialId && materialId !== '') {
                    // Get canvas rect for coordinate calculation
                    const canvasRect = canvas.getBoundingClientRect();
                    
                    // Calculate position relative to the transformed canvas
                    // e.clientX/Y is screen coordinates
                    // We need to convert to canvas coordinates considering zoom and pan
                    let x = (e.clientX - canvasRect.left) / zoomLevel - 60;
                    let y = (e.clientY - canvasRect.top) / zoomLevel - 20;
                    
                    // Snap to grid for precise alignment
                    x = snapToGrid(x);
                    y = snapToGrid(y);
                    
                    console.log('Canvas rect:', canvasRect);
                    console.log('Zoom level:', zoomLevel);
                    console.log('Calculated position:', { x, y });
                    
                    addMaterialNode(materialId, title, description, x, y, nodeType);
                } else {
                    console.warn('No materialId found in drop data');
                }
            });
        });
    }

    function addCustomNode(title, nodeType) {
        // Add node at viewport center, accounting for pan and zoom
        const canvasArea = document.querySelector('.drawio-canvas-area');
        const viewportCenterX = canvasArea.clientWidth / 2;
        const viewportCenterY = canvasArea.clientHeight / 2;
        
        // Convert viewport coordinates to canvas coordinates
        const x = (viewportCenterX - panOffset.x) / zoomLevel - 60;
        const y = (viewportCenterY - panOffset.y) / zoomLevel - 20;
        
        addMaterialNode('custom-' + Date.now(), title, '', x, y, nodeType);
    }

    function toggleNodeCompletion(nodeId, event) {
        event.stopPropagation();
        
        const node = document.getElementById(nodeId);
        const nodeData = nodes.find(n => n.id === nodeId);
        const toggle = node.querySelector('.completion-toggle');
        
        if (nodeData && toggle) {
            nodeData.completed = !nodeData.completed;
            
            if (nodeData.completed) {
                node.classList.add('completed');
                toggle.classList.add('completed');
            } else {
                node.classList.remove('completed');
                toggle.classList.remove('completed');
            }
            
            console.log('Node completion toggled:', nodeId, nodeData.completed);
        }
    }

    function addMaterialNode(materialId, title, description, x, y, nodeType = 'material') {
        console.log('Adding material node:', { materialId, title, x, y, nodeType });

        const nodeId = 'node-' + nodeIdCounter++;
        const node = document.createElement('div');
        node.className = `mindmap-node ${nodeType}`;
        node.id = nodeId;
        node.style.left = x + 'px';
        node.style.top = y + 'px';

        // Choose icon based on node type
        let icon = 'feather-book-open';
        if (nodeType === 'main-topic') icon = 'feather-layers';
        else if (nodeType === 'sub-topic') icon = 'feather-file-text';

        node.innerHTML = `
            <span class="node-label">${title}</span>
            <div class="connection-anchor anchor-t" data-anchor="t" data-node-id="${nodeId}"></div>
            <div class="connection-anchor anchor-b" data-anchor="b" data-node-id="${nodeId}"></div>
            <div class="connection-anchor anchor-l" data-anchor="l" data-node-id="${nodeId}"></div>
            <div class="connection-anchor anchor-r" data-anchor="r" data-node-id="${nodeId}"></div>
        `;

        node.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent event bubbling
            selectNode(nodeId);
        });

        // Add connection drag functionality - Shift + drag to create connections
        node.addEventListener('mousedown', function(e) {
            if (e.target.classList.contains('connection-anchor')) return; // handled by anchor
            if (e.button === 0 && e.shiftKey) { // Left click + Shift
                e.stopPropagation(); // Prevent event bubbling to canvas
                handleAnchorMouseDown(e, nodeId, 'auto');
            } else if (e.button === 0) { // Regular left click for node selection and dragging
                e.stopPropagation(); // Prevent event bubbling to canvas
                selectNode(nodeId);
                
                // Start dragging the node
                isDraggingNode = true;
                draggedNode = node;
                const rect = node.getBoundingClientRect();
                dragOffset.x = e.clientX - rect.left;
                dragOffset.y = e.clientY - rect.top;
                node.style.cursor = 'grabbing';
            }
        });

        // Wire anchor dots to connection drawing
        node.querySelectorAll('.connection-anchor').forEach(anchor => {
            anchor.addEventListener('mousedown', function(e) {
                e.stopPropagation();
                e.preventDefault();
                handleAnchorMouseDown(e, nodeId, anchor.dataset.anchor);
            });
            anchor.addEventListener('mouseup', function(e) {
                e.stopPropagation();
                if (connEndpointDrag) {
                    commitConnEndpointDrag(nodeId, anchor.dataset.anchor);
                } else {
                    commitAnchorConnection(nodeId, anchor.dataset.anchor);
                }
            });
        });
        
        const canvas = document.getElementById('mindmap-canvas');
        if (!canvas) {
            console.error('Canvas not found!');
            return;
        }

        canvas.appendChild(node);

        updateNodeCount();

        nodes.push({
            id: nodeId,
            materialId: materialId,
            title: title,
            description: description,
            x: x,
            y: y,
            type: nodeType,
            completed: false
        });

        console.log('Nodes array updated:', nodes);
        
        // Refresh materials list to remove the added material from sidebar
        refreshMaterialsList();
        
        // No auto-connection - user will connect manually
    }

    function toggleConnectionMode() {
        connectionMode = !connectionMode;
        const btn = document.getElementById('connection-mode-btn');
        
        if (connectionMode) {
            if (btn) {
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-primary');
                btn.innerHTML = '<i class="feather-link me-1"></i>Mode Koneksi Aktif';
            }
            document.getElementById('mindmap-canvas').style.cursor = 'crosshair';
            console.log('Connection mode activated');
        } else {
            if (btn) {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
                btn.innerHTML = '<i class="feather-link me-1"></i>Mode Koneksi';
            }
            document.getElementById('mindmap-canvas').style.cursor = 'default';
            selectedNodeForConnection = null;
        }

        const style = document.getElementById('connection-style')?.value || 'solid';
        updateLineStyleStatus(style);
        const hint = document.getElementById('connection-hint');
        if (hint) hint.classList.toggle('is-active', connectionMode || manualDrawingMode);
        
        document.querySelectorAll('.mindmap-node').forEach(node => {
            node.classList.remove('selected', 'connection-source');
        });
    }

    function toggleManualDrawingMode() {
        manualDrawingMode = !manualDrawingMode;
        const btn = document.getElementById('manual-drawing-btn');
        
        if (manualDrawingMode) {
            // Disable connection mode if active
            if (connectionMode) {
                toggleConnectionMode();
            }
            
            if (btn) {
                btn.classList.remove('btn-outline-warning');
                btn.classList.add('btn-warning');
                btn.innerHTML = '<i class="feather-edit-3 me-1"></i>Mode Gambar Aktif';
            }
            document.getElementById('mindmap-canvas').style.cursor = 'crosshair';
            console.log('Manual drawing mode activated');
        } else {
            if (btn) {
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-outline-warning');
                btn.innerHTML = '<i class="feather-edit-3 me-1"></i>Mode Gambar Manual';
            }
            document.getElementById('mindmap-canvas').style.cursor = 'default';
            cancelCurrentDrawing();
            console.log('Manual drawing mode deactivated');
        }
    }

    let selectedConnectionId = null;

    function selectConnection(connectionId) {
        clearAllSelections();
        selectedConnectionId = connectionId;
        updateConnections();
    }

    function deleteConnection(connectionId) {
        connections = connections.filter(c => c.id !== connectionId);
        selectedConnectionId = null;
        updateConnections();
    }


    function setupAnchorPointDrag(anchorElement, connectionId, anchorType, nodeId) {
        let isDragging = false;
        let startX, startY;
        
        anchorElement.addEventListener('mousedown', function(e) {
            e.stopPropagation();
            e.preventDefault();
            
            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;
            
            console.log('Started dragging anchor:', anchorType, 'for connection:', connectionId);
            
            // Start a new connection from the anchor point
            if (anchorType === 'source') {
                handleAnchorMouseDown(e, nodeId, 'auto');
            } else {
                // For target anchor, we need to handle differently
                // Start from the source node instead
                const connection = connections.find(c => c.id === connectionId);
                if (connection) {
                    handleAnchorMouseDown(e, connection.from, 'auto');
                }
            }
        });
    }

    function clearAllSelections() {
        // Clear node selections
        document.querySelectorAll('.mindmap-node').forEach(n => {
            n.classList.remove('selected', 'connection-source');
            removeResizeHandles(n);
        });

        // Clear connection selections
        document.querySelectorAll('.connection-line').forEach(line => {
            line.classList.remove('selected');
        });

        // Clear selection variables
        selectedNode = null;
        selectedConnection = null;
        selectedNodeForConnection = null;
        selectedConnectionId = null;
        updateConnections();
    }

    function addResizeHandles(node) {
        // Remove existing handles if any
        removeResizeHandles(node);

        const positions = ['nw', 'n', 'ne', 'e', 'se', 's', 'sw', 'w'];

        positions.forEach(pos => {
            const handle = document.createElement('div');
            handle.className = `resize-handle ${pos}`;
            handle.dataset.position = pos;
            handle.dataset.nodeId = node.id;

            // Prevent node drag when clicking handle
            handle.addEventListener('mousedown', (e) => {
                e.stopPropagation();
                startResize(e, node, pos);
            });

            node.appendChild(handle);
        });
    }

    function removeResizeHandles(node) {
        const handles = node.querySelectorAll('.resize-handle');
        handles.forEach(handle => handle.remove());
    }

    let isResizing = false;
    let resizeDirection = null;
    let resizeStartX = 0;
    let resizeStartY = 0;
    let resizeStartWidth = 0;
    let resizeStartHeight = 0;
    let resizeStartLeft = 0;
    let resizeStartTop = 0;
    let resizeNode = null;

    function startResize(e, node, direction) {
        isResizing = true;
        resizeDirection = direction;
        resizeNode = node;
        resizeStartX = e.clientX;
        resizeStartY = e.clientY;
        resizeStartWidth = node.offsetWidth;
        resizeStartHeight = node.offsetHeight;
        resizeStartLeft = node.offsetLeft;
        resizeStartTop = node.offsetTop;

        document.addEventListener('mousemove', handleResize);
        document.addEventListener('mouseup', stopResize);
    }

    function handleResize(e) {
        if (!isResizing || !resizeNode) return;

        const deltaX = e.clientX - resizeStartX;
        const deltaY = e.clientY - resizeStartY;

        const canvas = document.getElementById('mindmap-canvas');
        const rect = canvas.getBoundingClientRect();
        const zoom = zoomLevel;

        // Adjust for zoom
        const adjustedDeltaX = deltaX / zoom;
        const adjustedDeltaY = deltaY / zoom;

        let newWidth = resizeStartWidth;
        let newHeight = resizeStartHeight;
        let newLeft = resizeStartLeft;
        let newTop = resizeStartTop;

        // Handle resize based on direction
        if (resizeDirection.includes('e')) {
            newWidth = resizeStartWidth + adjustedDeltaX;
        }
        if (resizeDirection.includes('w')) {
            newWidth = resizeStartWidth - adjustedDeltaX;
            newLeft = resizeStartLeft + adjustedDeltaX;
        }
        if (resizeDirection.includes('s')) {
            newHeight = resizeStartHeight + adjustedDeltaY;
        }
        if (resizeDirection.includes('n')) {
            newHeight = resizeStartHeight - adjustedDeltaY;
            newTop = resizeStartTop + adjustedDeltaY;
        }

        // Minimum size constraints
        newWidth = Math.max(100, newWidth);
        newHeight = Math.max(40, newHeight);

        // Apply changes
        resizeNode.style.width = newWidth + 'px';
        resizeNode.style.height = newHeight + 'px';
        resizeNode.style.left = newLeft + 'px';
        resizeNode.style.top = newTop + 'px';

        // Update node data
        const nodeData = nodes.find(n => n.id === resizeNode.id);
        if (nodeData) {
            nodeData.x = newLeft;
            nodeData.y = newTop;
        }

        // Update connections
        updateConnections();
    }

    function stopResize() {
        isResizing = false;
        resizeNode = null;
        document.removeEventListener('mousemove', handleResize);
        document.removeEventListener('mouseup', stopResize);
    }

    // ─── Anchor drag-to-connect state ───
    let anchorDragActive = false;
    let anchorDragFromNode = null;
    let anchorDragFromAnchor = null;
    let anchorPreviewLine = null;

    function handleAnchorMouseDown(e, nodeId, anchorPos) {
        e.stopPropagation();
        e.preventDefault();
        anchorDragActive   = true;
        anchorDragFromNode  = nodeId;
        anchorDragFromAnchor = anchorPos;

        // Highlight source node
        document.querySelectorAll('.connection-source').forEach(n => n.classList.remove('connection-source'));
        const node = document.getElementById(nodeId);
        if (node) node.classList.add('connection-source');

        // Create preview line
        const svg = document.getElementById('connections-svg');
        if (!svg) return;
        anchorPreviewLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
        anchorPreviewLine.setAttribute('id', 'anchor-preview-line');
        anchorPreviewLine.setAttribute('stroke', '#6366f1');
        anchorPreviewLine.setAttribute('stroke-width', '2');
        anchorPreviewLine.setAttribute('stroke-dasharray', '6 3');
        anchorPreviewLine.setAttribute('marker-end', 'url(#arrow-preview)');
        anchorPreviewLine.style.pointerEvents = 'none';
        const start = getNodeAnchorXY(nodeId, anchorPos);
        if (start) {
            anchorPreviewLine.setAttribute('x1', start.x);
            anchorPreviewLine.setAttribute('y1', start.y);
            anchorPreviewLine.setAttribute('x2', start.x);
            anchorPreviewLine.setAttribute('y2', start.y);
        }
        svg.appendChild(anchorPreviewLine);
    }

    // Update preview line on mousemove
    document.addEventListener('mousemove', function(e) {
        const canvas = document.getElementById('mindmap-canvas');
        if (!canvas) return;
        const rect = canvas.getBoundingClientRect();
        const cx = (e.clientX - rect.left) / zoomLevel;
        const cy = (e.clientY - rect.top)  / zoomLevel;

        if (anchorDragActive && anchorPreviewLine) {
            anchorPreviewLine.setAttribute('x2', cx);
            anchorPreviewLine.setAttribute('y2', cy);
        }
        if (connEndpointDrag) {
            connEndpointDrag.previewLine.setAttribute('x2', cx);
            connEndpointDrag.previewLine.setAttribute('y2', cy);
            // Highlight node under cursor
            document.querySelectorAll('.endpoint-drag-hover').forEach(el => el.classList.remove('endpoint-drag-hover'));
            const els = document.elementsFromPoint(e.clientX, e.clientY);
            for (const el of els) {
                if (el.classList && el.classList.contains('mindmap-node')) {
                    el.classList.add('endpoint-drag-hover');
                    break;
                }
            }
        }
    });

    // Cancel drag on mouseup if not on an anchor/node
    document.addEventListener('mouseup', function(e) {
        if (anchorDragActive) {
            setTimeout(() => { if (anchorDragActive) cancelAnchorDrag(); }, 50);
        }
        if (connEndpointDrag) {
            // Use elementsFromPoint to detect anchor/node under cursor
            // (handles-svg sits on top and blocks normal mouseup on anchors)
            const els = document.elementsFromPoint(e.clientX, e.clientY);
            let committed = false;

            // Try anchor first
            for (const el of els) {
                if (el.classList && el.classList.contains('connection-anchor')) {
                    const nodeId = el.dataset.nodeId;
                    const anchor = el.dataset.anchor;
                    if (nodeId) {
                        commitConnEndpointDrag(nodeId, anchor);
                        committed = true;
                        break;
                    }
                }
            }

            // Try node body if no anchor found
            if (!committed) {
                for (const el of els) {
                    if (el.classList && el.classList.contains('mindmap-node') && el.id) {
                        commitConnEndpointDrag(el.id, null);
                        committed = true;
                        break;
                    }
                }
            }

            if (!committed) cancelConnEndpointDrag();
        }
    });

    function cancelAnchorDrag() {
        anchorDragActive = false;
        anchorDragFromNode = null;
        anchorDragFromAnchor = null;
        if (anchorPreviewLine) { anchorPreviewLine.remove(); anchorPreviewLine = null; }
        document.querySelectorAll('.connection-source').forEach(n => n.classList.remove('connection-source'));
    }

    function commitAnchorConnection(toNodeId, toAnchor) {
        if (!anchorDragActive || !anchorDragFromNode || anchorDragFromNode === toNodeId) {
            cancelAnchorDrag();
            return;
        }
        const style    = document.getElementById('connection-style')?.value || 'solid';
        const lineType = document.getElementById('connection-line-type')?.value || 'straight';
        // Prevent duplicate
        const exists = connections.some(c =>
            (c.from === anchorDragFromNode && c.to === toNodeId) ||
            (c.from === toNodeId && c.to === anchorDragFromNode)
        );
        if (!exists) {
            connections.push({
                id: 'conn-' + Date.now(),
                from: anchorDragFromNode,
                fromAnchor: anchorDragFromAnchor,
                to: toNodeId,
                toAnchor: toAnchor,
                style: style,
                lineType: lineType
            });
            updateConnections();
        }
        cancelAnchorDrag();
    }

    function selectNode(nodeId) {
        console.log('=== SELECT NODE ===');
        console.log('Node ID:', nodeId);
        console.log('Connection mode:', connectionMode);
        console.log('Manual drawing mode:', manualDrawingMode);
        console.log('Selected node for connection:', selectedNodeForConnection);
        
        const node = document.getElementById(nodeId);
        if (!node) {
            console.error('Node not found:', nodeId);
            return;
        }
        
        if (manualDrawingMode) {
            console.log('In manual drawing mode');
            // Manual drawing mode logic
            if (!drawingStartNode) {
                // Start drawing from this node
                drawingStartNode = nodeId;
                currentDrawingPath = [];
                node.classList.add('connection-source');
                console.log('Started drawing from node:', nodeId);
            } else if (drawingStartNode !== nodeId) {
                // End drawing at this node
                finishManualDrawing(nodeId);
                console.log('Finished drawing to node:', nodeId);
            } else {
                // Clicking the same node - cancel drawing
                cancelCurrentDrawing();
                console.log('Drawing cancelled');
            }
        } else if (connectionMode) {
            console.log('In connection mode');
            // Connection mode logic
            if (!selectedNodeForConnection) {
                // First node selection
                selectedNodeForConnection = nodeId;
                node.classList.add('connection-source');
                console.log('First node selected for connection:', nodeId);
            } else if (selectedNodeForConnection !== nodeId) {
                // Second node selection - create connection
                const selectedStyle = document.getElementById('connection-style').value;
                console.log('Creating connection with style:', selectedStyle);
                isManualConnection = true;
                connectNodes(selectedNodeForConnection, nodeId, selectedStyle);
                isManualConnection = false;
                
                // Clear selections
                document.getElementById(selectedNodeForConnection).classList.remove('connection-source');
                node.classList.remove('connection-source');
                selectedNodeForConnection = null;
                
                // Auto-deactivate connection mode after successful connection
                connectionMode = false;
                const btn = document.getElementById('connection-mode-btn');
                if (btn) {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outline-primary');
                    btn.innerHTML = '<i class="feather-link me-1"></i>Mode Koneksi';
                }
                document.getElementById('mindmap-canvas').style.cursor = 'default';
                
                console.log('Connection created between nodes with style:', selectedStyle);
                console.log('Connection mode auto-deactivated');
            } else {
                // Clicking the same node - deselect
                node.classList.remove('connection-source');
                selectedNodeForConnection = null;
                isManualConnection = false;
                console.log('Connection selection cancelled');
            }
        } else {
            console.log('In normal mode');
            // Check if clicking the same node - toggle selection
            if (selectedNode === nodeId) {
                // Deselect the node
                node.classList.remove('selected');
                removeResizeHandles(node);
                selectedNode = null;
            } else {
                // Clear all selections first
                clearAllSelections();

                // Select the node
                node.classList.add('selected');
                selectedNode = nodeId;

                // Add resize handles - disabled
                // addResizeHandles(node);
            }
        }
    }

    // Double-click to edit node text
    document.addEventListener('dblclick', function(e) {
        const node = e.target.closest('.mindmap-node');
        if (node && !connectionMode && !manualDrawingMode) {
            const nodeId = node.id;
            const label = node.querySelector('.node-label');
            if (label) {
                enableInlineEdit(nodeId, label);
            }
        }
    });

    function enableInlineEdit(nodeId, labelElement) {
        const currentText = labelElement.textContent;
        const node = document.getElementById(nodeId);

        // Create input element
        const input = document.createElement('input');
        input.type = 'text';
        input.value = currentText;
        input.className = 'inline-edit-input';

        // Copy styles from label
        const computedStyle = window.getComputedStyle(labelElement);
        input.style.fontSize = computedStyle.fontSize;
        input.style.fontWeight = computedStyle.fontWeight;
        input.style.color = computedStyle.color;
        input.style.textAlign = computedStyle.textAlign;
        input.style.background = 'transparent';
        input.style.border = 'none';
        input.style.outline = 'none';
        input.style.width = '100%';
        input.style.minWidth = '100px';

        // Replace label with input
        labelElement.style.display = 'none';
        labelElement.parentNode.insertBefore(input, labelElement);
        input.focus();
        input.select();

        // Save on blur or Enter key
        function saveEdit() {
            const newText = input.value.trim() || currentText;
            labelElement.textContent = newText;
            labelElement.style.display = '';
            input.remove();

            // Update node data
            const nodeData = nodes.find(n => n.id === nodeId);
            if (nodeData) {
                nodeData.title = newText;
            }

            // Update connections if node size changed
            updateConnections();
        }

        input.addEventListener('blur', saveEdit);
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                input.blur();
            } else if (e.key === 'Escape') {
                input.value = currentText;
                input.blur();
            }
        });
    }

    function handleCanvasClick(e) {
        if (!manualDrawingMode || !drawingStartNode) return;
        
        // Don't process if clicking on a node
        if (e.target.classList.contains('mindmap-node')) return;
        
        // TODO: Implement coordinate calculation for manual drawing
        const x = 0;
        const y = 0;
        
        addDrawingPoint(x, y);
    }

    function addDrawingPoint(x, y) {
        currentDrawingPath.push({ x, y });
        console.log('Added drawing point:', { x, y });
        updateTempConnectionLine();
    }

    function updateTempConnectionLine() {
        const svg = document.getElementById('connections-svg');
        
        // Remove existing temp line
        if (tempConnectionLine) {
            tempConnectionLine.remove();
        }
        
        if (currentDrawingPath.length === 0) return;
        
        const startNode = document.getElementById(drawingStartNode);
        if (!startNode) return;
        
        // TODO: Implement coordinate calculation for temp connection line
        const startX = 0;
        const startY = 0;
        
        // Create path from node to all points
        let pathData = `M ${startX} ${startY}`;
        currentDrawingPath.forEach(point => {
            pathData += ` L ${point.x} ${point.y}`;
        });
        
        tempConnectionLine = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        tempConnectionLine.setAttribute('d', pathData);
        tempConnectionLine.setAttribute('class', 'connection-line manual-temp-line');
        tempConnectionLine.style.stroke = '#f59e0b';
        tempConnectionLine.style.strokeWidth = '2';
        tempConnectionLine.style.strokeDasharray = '5, 5';
        tempConnectionLine.style.fill = 'none';
        tempConnectionLine.style.pointerEvents = 'none';
        
        svg.appendChild(tempConnectionLine);
    }

    function finishManualDrawing(endNodeId) {
        if (!drawingStartNode || currentDrawingPath.length === 0) {
            console.log('No drawing path to finish');
            return;
        }
        
        // Check if connection already exists (prevent duplicates)
        const existingConnection = connections.find(conn => 
            (conn.from === drawingStartNode && conn.to === endNodeId) || 
            (conn.from === endNodeId && conn.to === drawingStartNode)
        );
        
        if (existingConnection) {
            console.log('Connection already exists between these nodes');
            cancelCurrentDrawing();
            return;
        }
        
        // Create connection with manual path
        const selectedStyle = document.getElementById('connection-style').value;
        const connection = {
            from: drawingStartNode,
            to: endNodeId,
            style: selectedStyle === 'manual' ? 'manual' : selectedStyle,
            path: currentDrawingPath,
            id: `conn-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`
        };
        
        connections.push(connection);
        updateConnections();
        
        // Auto-deactivate manual drawing mode after successful connection
        manualDrawingMode = false;
        const btn = document.getElementById('manual-drawing-btn');
        if (btn) {
            btn.classList.remove('btn-warning');
            btn.classList.add('btn-outline-warning');
            btn.innerHTML = '<i class="feather-edit-3 me-1"></i>Mode Gambar Manual';
        }
        document.getElementById('mindmap-canvas').style.cursor = 'default';
        
        // Clean up
        cancelCurrentDrawing();
        
        console.log('Manual connection created:', connection);
        console.log('Manual drawing mode auto-deactivated');
    }

    function cancelCurrentDrawing() {
        // Clear temp line
        if (tempConnectionLine) {
            tempConnectionLine.remove();
            tempConnectionLine = null;
        }
        
        // Clear selections
        document.querySelectorAll('.mindmap-node').forEach(node => {
            node.classList.remove('connection-source');
        });
        
        // Reset variables
        drawingStartNode = null;
        currentDrawingPath = [];
        
        console.log('Current drawing cancelled');
    }

    // Draw.io Tool Functions
    function setTool(tool) {
        // Disable any active connection modes first
        if (connectionMode && tool !== 'connector') {
            toggleConnectionMode();
        }
        if (manualDrawingMode && tool !== 'manual-connector') {
            toggleManualDrawingMode();
        }
        
        currentTool = tool;
        
        document.querySelectorAll('.drawio-toolbar [data-tool]').forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-tool') === tool);
        });

        // Update cursor
        const canvas = document.getElementById('mindmap-canvas');
        switch(tool) {
            case 'select':
                canvas.style.cursor = 'default';
                // Cancel any pending drawing/connection
                cancelCurrentDrawing();
                clearAllSelections();
                break;
            case 'pan':
                canvas.style.cursor = 'grab';
                // Cancel any pending drawing/connection
                cancelCurrentDrawing();
                clearAllSelections();
                break;
            default:
                canvas.style.cursor = 'default';
                break;
        }
        
        updateToolStatus(tool);
    }

    function setLineType(lineType) {
        document.getElementById('connection-line-type').value = lineType;

        document.querySelectorAll('[data-line-type]').forEach(item => {
            item.classList.remove('selected');
        });

        const selectedItem = document.querySelector(`[data-line-type="${lineType}"]`);
        if (selectedItem) {
            selectedItem.classList.add('selected');
        }

        // Update selected connection's lineType immediately
        if (selectedConnectionId) {
            const conn = connections.find(c => c.id === selectedConnectionId);
            if (conn) {
                conn.lineType = lineType;
                updateConnections();
            }
        }

        console.log('Line type set to:', lineType);
    }

    function setLineStyle(style) {
        document.getElementById('connection-style').value = style;

        document.querySelectorAll('[data-line-style]').forEach(item => {
            item.classList.remove('selected');
        });

        const selectedItem = document.querySelector(`[data-line-style="${style}"]`);
        if (selectedItem) {
            selectedItem.classList.add('selected');
        }

        updateLineStyleStatus(style);

        // TODO: Implement line style update

        if (style === 'manual') {
            if (!manualDrawingMode) toggleManualDrawingMode();
            if (connectionMode) toggleConnectionMode();
        } else {
            if (!connectionMode) toggleConnectionMode();
            if (manualDrawingMode) toggleManualDrawingMode();
        }

        const hint = document.getElementById('connection-hint');
        if (hint) hint.classList.toggle('is-active', connectionMode || manualDrawingMode);
    }

    // Zoom/Pan system
    // Transform applied as: translate(panOffset.x px, panOffset.y px) scale(zoomLevel)
    // with transform-origin: 0 0
    // Screen coords: screenX = canvasX * zoom + panOffset.x
    //                screenY = canvasY * zoom + panOffset.y

    function zoomAroundPoint(newZoom, focalX, focalY) {
        // focalX/Y: pixels from top-left of canvas-area (viewport coords)
        newZoom = Math.min(Math.max(newZoom, 0.1), 5);
        // Keep the canvas point under focal fixed:
        // canvasX = (focalX - panOffset.x) / oldZoom  →  after zoom: focalX = canvasX * newZoom + newPanX
        panOffset.x = focalX - ((focalX - panOffset.x) / zoomLevel) * newZoom;
        panOffset.y = focalY - ((focalY - panOffset.y) / zoomLevel) * newZoom;
        zoomLevel = newZoom;
        updateZoom();
    }

    function zoomIn(focalX, focalY) {
        const vp = document.querySelector('.canvas-viewport');
        const cx = focalX !== undefined ? focalX : vp.clientWidth / 2;
        const cy = focalY !== undefined ? focalY : vp.clientHeight / 2;
        zoomAroundPoint(zoomLevel * 1.2, cx, cy);
    }

    function zoomOut(focalX, focalY) {
        const vp = document.querySelector('.canvas-viewport');
        const cx = focalX !== undefined ? focalX : vp.clientWidth / 2;
        const cy = focalY !== undefined ? focalY : vp.clientHeight / 2;
        zoomAroundPoint(zoomLevel / 1.2, cx, cy);
    }

    function resetZoom() {
        zoomLevel = 1;
        panOffset.x = 0;
        panOffset.y = 0;
        updateZoom();
    }

    function updateZoom() {
        const canvas = document.getElementById('mindmap-canvas');
        
        // Apply transform: translate first, then scale (transform-origin: 0 0)
        canvas.style.transform = `translate(${panOffset.x}px, ${panOffset.y}px) scale(${zoomLevel})`;
        
        // Scale the grid background
        const scaledGridSize = 20 * zoomLevel;
        canvas.style.backgroundSize = `${scaledGridSize}px ${scaledGridSize}px`;
        
        // Update zoom level display
        document.querySelector('.zoom-level').textContent = Math.round(zoomLevel * 100) + '%';
        
        // Update connections
        updateConnections();
    }

    // Pan Functions (draw.io style)
    function startPan(e) {
        // Allow panning with pan tool, spacebar, or middle mouse button
        const isPanTool = currentTool === 'pan';
        const isSpacebarPan = spacePressed;
        const isMiddleMouse = e.button === 1;
        
        if (isPanTool || isSpacebarPan || isMiddleMouse) {
            isPanning = true;
            panStart = { 
                x: e.clientX - panOffset.x,
                y: e.clientY - panOffset.y
            };
            document.getElementById('mindmap-canvas').style.cursor = 'grabbing';
            e.preventDefault();
        }
    }

    function doPan(e) {
        if (isPanning) {
            panOffset.x = e.clientX - panStart.x;
            panOffset.y = e.clientY - panStart.y;
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

    // Properties Panel Functions
    function updateSelectedElement() {
        if (!selectedNode) return;
        
        const node = document.getElementById(selectedNode);
        if (!node) return;
        
        const fillColor = document.getElementById('fill-color').value;
        const borderColor = document.getElementById('border-color').value;
        const borderWidth = document.getElementById('border-width').value;
        const opacity = document.getElementById('opacity').value / 100;
        
        node.style.backgroundColor = fillColor;
        node.style.borderColor = borderColor;
        node.style.borderWidth = borderWidth + 'px';
        node.style.opacity = opacity;
        
        // Update node data
        const nodeData = nodes.find(n => n.id === selectedNode);
        if (nodeData) {
            nodeData.fillColor = fillColor;
            nodeData.borderColor = borderColor;
            nodeData.borderWidth = borderWidth;
            nodeData.opacity = opacity;
        }
    }

    function updateConnectionPropertiesPanel(connectionId) {
        const connection = connections.find(c => c.id === connectionId);
        if (!connection) return;
        
        const fromNode = nodes.find(n => n.id === connection.from);
        const toNode = nodes.find(n => n.id === connection.to);
        
        const panel = document.getElementById('properties-panel');
        panel.innerHTML = `
            <div class="mb-3">
                <label class="form-label">Connection ID</label>
                <input type="text" class="form-control form-control-sm" value="${connection.id}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Style</label>
                <input type="text" class="form-control form-control-sm" value="${connection.style || 'solid'}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">From</label>
                <input type="text" class="form-control form-control-sm" value="${fromNode ? fromNode.title : connection.from}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">To</label>
                <input type="text" class="form-control form-control-sm" value="${toNode ? toNode.title : connection.to}" readonly>
            </div>
            <div class="mb-3">
                <button class="btn btn-sm btn-outline-danger" onclick="deleteConnection('${connectionId}')">
                    <i class="feather-trash-2 me-1"></i>Delete Connection
                </button>
            </div>
        `;
    }

    function deleteSelectedElement() {
        if (selectedNode) {
            // Delete selected node
            const node = document.getElementById(selectedNode);
            if (node && node.id !== 'root-node') {
                if (confirm('Are you sure you want to delete this node and all its connections?')) {
                    removeNode(node);
                }
            }
        } else if (selectedConnection) {
            // Delete selected connection
            if (confirm('Are you sure you want to delete this connection?')) {
                deleteConnection(selectedConnection);
            }
        }
    }

    function deleteConnection(connectionId) {
        // Remove anchor points for this connection
        removeConnectionAnchorPoints(connectionId);
        
        connections = connections.filter(c => c.id !== connectionId);
        updateConnections();
        
        // Clear selection and reset properties panel
        clearAllSelections();
        document.getElementById('properties-panel').innerHTML = '<p class="text-muted">Select an element to edit properties</p>';
    }

    function updatePropertiesPanel(nodeId) {
        const nodeData = nodes.find(n => n.id === nodeId);
        if (!nodeData) return;
        
        const panel = document.getElementById('properties-panel');
        const isRootNode = nodeId === 'root-node';
        
        panel.innerHTML = `
            <div class="mb-3">
                <label class="form-label">ID</label>
                <input type="text" class="form-control form-control-sm" value="${nodeData.id}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" class="form-control form-control-sm" value="${nodeData.type || 'node'}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control form-control-sm" value="${nodeData.title || ''}" onchange="updateNodeTitle('${nodeId}', this.value)">
            </div>
            <div class="mb-3">
                <label class="form-label">Position</label>
                <div class="row">
                    <div class="col-6">
                        <input type="number" class="form-control form-control-sm" value="${Math.round(nodeData.x)}" onchange="updateNodePosition('${nodeId}', 'x', this.value)">
                    </div>
                    <div class="col-6">
                        <input type="number" class="form-control form-control-sm" value="${Math.round(nodeData.y)}" onchange="updateNodePosition('${nodeId}', 'y', this.value)">
                    </div>
                </div>
            </div>
            ${!isRootNode ? `
            <div class="mb-3">
                <button class="btn btn-sm btn-outline-danger" onclick="deleteSelectedElement()">
                    <i class="feather-trash-2 me-1"></i>Delete Node
                </button>
            </div>
            ` : ''}
        `;
        
        // Update format controls
        if (nodeData.fillColor) document.getElementById('fill-color').value = nodeData.fillColor;
        if (nodeData.borderColor) document.getElementById('border-color').value = nodeData.borderColor;
        if (nodeData.borderWidth) document.getElementById('border-width').value = nodeData.borderWidth;
        if (nodeData.opacity) document.getElementById('opacity').value = nodeData.opacity * 100;
    }

    function updateNodeTitle(nodeId, title) {
        const node = document.getElementById(nodeId);
        const nodeData = nodes.find(n => n.id === nodeId);
        
        if (node && nodeData) {
            nodeData.title = title;
            node.querySelector('span').textContent = title;
        }
    }

    function updateNodePosition(nodeId, axis, value) {
        const node = document.getElementById(nodeId);
        const nodeData = nodes.find(n => n.id === nodeId);
        
        if (node && nodeData) {
            const numValue = parseFloat(value);
            nodeData[axis] = numValue;
            node.style[axis === 'x' ? 'left' : 'top'] = numValue + 'px';
            updateConnections();
        }
    }

    function connectNodes(fromId, toId, style = 'solid') {
        // Check if connection already exists (prevent duplicates)
        const existingConnection = connections.find(conn => 
            (conn.from === fromId && conn.to === toId) || 
            (conn.from === toId && conn.to === fromId)
        );
        
        if (existingConnection) {
            console.log('Connection already exists between these nodes');
            // Optional: Update the style if different
            if (existingConnection.style !== style) {
                existingConnection.style = style;
                updateConnections();
            }
            return;
        }
        
        connections.push({ 
            from: fromId, 
            to: toId, 
            style: style,
            id: `conn-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`
        });
        updateConnections();
    }

    function connectNodesWithAnchors(fromId, fromAnchor, toId, toAnchor, style = 'solid') {
        // Check if connection already exists (prevent duplicates)
        const existingConnection = connections.find(conn =>
            (conn.from === fromId && conn.to === toId) ||
            (conn.from === toId && conn.to === fromId)
        );

        if (existingConnection) {
            console.log('Connection already exists between these nodes');
            // Optional: Update the style if different
            if (existingConnection.style !== style) {
                existingConnection.style = style;
                updateConnections();
            }
            return;
        }

        connections.push({
            from: fromId,
            fromAnchor: fromAnchor,
            to: toId,
            toAnchor: toAnchor,
            style: style,
            id: `conn-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`
        });
        updateConnections();
    }


    function getConnectorConfig(style, lineType = 'straight') {
        const lineTypeValue = lineType || document.getElementById('connection-line-type')?.value || 'straight';

        // Determine connector type based on both lineType and style
        // Styles like 'curved' and 'wavy' always use Bezier regardless of lineType
        let connectorType;
        if (style === 'curved' || style === 'wavy') {
            connectorType = ['Bezier', { curviness: style === 'curved' ? 100 : 150 }];
        } else {
            connectorType = lineTypeValue === 'straight' ? 'Straight' : ['Bezier', { curviness: 50 }];
        }

        console.log('getConnectorConfig:', { style, lineType, lineTypeValue, connectorType });

        const arrowConfig = ['Arrow', {
            location: 0.95,
            width: 10,
            length: 10,
            direction: 1
        }];

        const configs = {
            'solid': {
                type: connectorType,
                paintStyle: { stroke: '#667eea', strokeWidth: 2.5 },
                overlays: [arrowConfig]
            },
            'dashed': {
                type: connectorType,
                paintStyle: { stroke: '#ef4444', strokeWidth: 2.5, dashstyle: '10 6' },
                overlays: [arrowConfig]
            },
            'dotted': {
                type: connectorType,
                paintStyle: { stroke: '#10b981', strokeWidth: 3, dashstyle: '1 5' },
                overlays: [arrowConfig]
            },
            'curved': {
                type: ['Bezier', { curviness: 100 }],
                paintStyle: { stroke: '#f59e0b', strokeWidth: 2.5 },
                overlays: [arrowConfig]
            },
            'thick': {
                type: connectorType,
                paintStyle: { stroke: '#8b5cf6', strokeWidth: 5 },
                overlays: [['Arrow', { location: 0.95, width: 12, length: 12, direction: 1 }]]
            },
            'double': {
                type: connectorType,
                paintStyle: { stroke: '#ec4899', strokeWidth: 2 },
                overlays: [arrowConfig]
            },
            'wavy': {
                type: ['Bezier', { curviness: 150 }],
                paintStyle: { stroke: '#06b6d4', strokeWidth: 2 },
                overlays: [arrowConfig]
            },
            'sub-topic': {
                type: connectorType,
                paintStyle: { stroke: '#3b82f6', strokeWidth: 2, dashstyle: '5 5', opacity: 0.7 },
                overlays: [arrowConfig]
            },
            'hierarchy': {
                type: connectorType,
                paintStyle: { stroke: '#3b82f6', strokeWidth: 3 },
                overlays: [['Arrow', { location: 0.95, width: 12, length: 12, direction: 1 }]]
            },
            'manual': {
                type: connectorType,
                paintStyle: { stroke: '#6b7280', strokeWidth: 2 },
                overlays: [arrowConfig]
            }
        };
        return configs[style] || configs['solid'];
    }

    function getAnchorPosition(nodeId, anchorPos) {
        const node = document.getElementById(nodeId);
        if (!node) return { x: 0, y: 0 };

        const nodeData = nodes.find(n => n.id === nodeId);
        if (!nodeData) return { x: 0, y: 0 };

        const nodeRect = node.getBoundingClientRect();
        const width = nodeRect.width;
        const height = nodeRect.height;
        const x = nodeData.x;
        const y = nodeData.y;

        // Calculate anchor position based on anchor type (no offset)
        switch(anchorPos) {
            case 'tl': return { x: x, y: y };
            case 't': return { x: x + width / 2, y: y };
            case 'tr': return { x: x + width, y: y };
            case 'r': return { x: x + width, y: y + height / 2 };
            case 'br': return { x: x + width, y: y + height };
            case 'b': return { x: x + width / 2, y: y + height };
            case 'bl': return { x: x, y: y + height };
            case 'l': return { x: x, y: y + height / 2 };
            default: return { x: x + width / 2, y: y + height / 2 };
        }
    }

    function getNodeAnchorXY(nodeId, anchor) {
        const node = document.getElementById(nodeId);
        if (!node) return null;
        const nd = nodes.find(n => n.id === nodeId);
        if (!nd) return null;
        const w = node.offsetWidth;
        const h = node.offsetHeight;
        const x = nd.x, y = nd.y;
        switch (anchor) {
            case 't':  return { x: x + w / 2, y: y };
            case 'b':  return { x: x + w / 2, y: y + h };
            case 'l':  return { x: x,         y: y + h / 2 };
            case 'r':  return { x: x + w,     y: y + h / 2 };
            default:   return { x: x + w / 2, y: y + h / 2 };
        }
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
        // Always clear handles from overlay
        const handlesSvg = document.getElementById('handles-svg');
        if (handlesSvg) handlesSvg.innerHTML = '';

        const styleColor  = { solid:'#475569', dashed:'#3b82f6', dotted:'#10b981', thick:'#7c3aed', curved:'#f59e0b' };
        const styleDash   = { dashed:'8 4', dotted:'2 5' };
        const styleWidth  = { thick: 4 };
        const styleMarker = { dashed:'arrow-dashed', dotted:'arrow-dotted' };

        connections.forEach(conn => {
            // Always auto-snap to best anchors based on current node positions
            const anchors = getBestAnchors(conn.from, conn.to);
            const fa = anchors.from;
            const ta = anchors.to;
            const p1 = getNodeAnchorXY(conn.from, fa);
            const p2 = getNodeAnchorXY(conn.to,   ta);
            if (!p1 || !p2) return;

            const style      = conn.style || 'solid';
            const lineType   = conn.lineType || 'straight';
            const isSelected = conn.id === selectedConnectionId;
            const stroke     = isSelected ? '#f59e0b' : (styleColor[style] || '#475569');
            const sw         = styleWidth[style] || 2; // fixed width, not enlarged on select
            const marker     = isSelected ? 'arrow-selected' : (styleMarker[style] || 'arrow-solid');

            // Build path: straight or curved Bezier
            let d;
            if (lineType === 'curved') {
                // Cubic Bezier: control points follow anchor direction
                // cp1 exits from source anchor direction, cp2 enters target anchor direction
                const tension = Math.max(60, Math.abs(p2.x - p1.x) * 0.5, Math.abs(p2.y - p1.y) * 0.5);
                const anchorDir = {
                    r: [1, 0], l: [-1, 0], b: [0, 1], t: [0, -1]
                };
                const d1 = anchorDir[anchors.from] || [1, 0];
                const d2 = anchorDir[anchors.to]   || [-1, 0];
                const cp1x = p1.x + d1[0] * tension;
                const cp1y = p1.y + d1[1] * tension;
                const cp2x = p2.x + d2[0] * tension;
                const cp2y = p2.y + d2[1] * tension;
                d = `M ${p1.x} ${p1.y} C ${cp1x} ${cp1y}, ${cp2x} ${cp2y}, ${p2.x} ${p2.y}`;
            } else {
                d = `M ${p1.x} ${p1.y} L ${p2.x} ${p2.y}`;
            }

            // Invisible wide hit-area for easier clicking
            const hit = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            hit.setAttribute('d', d);
            hit.setAttribute('class', 'conn-hit');
            hit.setAttribute('fill', 'none');
            hit.setAttribute('stroke', 'transparent');
            hit.setAttribute('stroke-width', '14');
            hit.style.cursor = 'pointer';
            hit.style.pointerEvents = 'stroke';
            hit.addEventListener('click', (e) => { e.stopPropagation(); selectConnection(conn.id); });
            svg.appendChild(hit);

            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('d', d);
            path.setAttribute('class', 'conn-path' + (isSelected ? ' conn-selected' : ''));
            path.setAttribute('fill', 'none');
            path.setAttribute('stroke', stroke);
            path.setAttribute('stroke-width', sw);
            if (styleDash[style]) path.setAttribute('stroke-dasharray', styleDash[style]);
            path.setAttribute('marker-end', `url(#${marker})`);
            path.dataset.connId = conn.id;
            path.style.pointerEvents = 'none';
            svg.appendChild(path);

            // Endpoint drag handles when selected — rendered in high-z overlay
            if (isSelected) {
                const hSvg = document.getElementById('handles-svg');
                if (hSvg) {
                    [{ pt: p1, ep: 'from', color: '#3b82f6' }, { pt: p2, ep: 'to', color: '#10b981' }].forEach(({ pt, ep, color }) => {
                        const handle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                        handle.setAttribute('cx', pt.x);
                        handle.setAttribute('cy', pt.y);
                        handle.setAttribute('r', '7');
                        handle.setAttribute('class', 'conn-handle');
                        handle.setAttribute('fill', color);
                        handle.setAttribute('stroke', '#fff');
                        handle.setAttribute('stroke-width', '2.5');
                        handle.style.cssText = 'cursor:crosshair;pointer-events:fill';
                        handle.addEventListener('mousedown', (e) => {
                            e.stopPropagation();
                            e.preventDefault();
                            startConnEndpointDrag(conn.id, ep, pt);
                        });
                        hSvg.appendChild(handle);
                    });
                }
            }
        });
    }

    // ─── Endpoint re-route drag ───
    let connEndpointDrag = null;

    function startConnEndpointDrag(connId, endpoint, startPt) {
        // Disable pointer-events on handles overlay so elementsFromPoint reaches anchors below
        const hSvg = document.getElementById('handles-svg');
        if (hSvg) hSvg.style.pointerEvents = 'none';
        // Show all anchors on all nodes during drag
        document.getElementById('mindmap-canvas').classList.add('endpoint-drag-active');
        const svg = document.getElementById('connections-svg');
        const preview = document.createElementNS('http://www.w3.org/2000/svg', 'line');
        preview.setAttribute('x1', startPt.x);
        preview.setAttribute('y1', startPt.y);
        preview.setAttribute('x2', startPt.x);
        preview.setAttribute('y2', startPt.y);
        preview.setAttribute('stroke', '#f59e0b');
        preview.setAttribute('stroke-width', '2');
        preview.setAttribute('stroke-dasharray', '6 3');
        preview.setAttribute('marker-end', 'url(#arrow-preview)');
        preview.setAttribute('class', 'conn-endpoint-preview');
        preview.style.pointerEvents = 'none';
        svg.appendChild(preview);
        connEndpointDrag = { connId, endpoint, previewLine: preview };
    }

    function commitConnEndpointDrag(targetNodeId, targetAnchor) {
        if (!connEndpointDrag) return;
        const { connId, endpoint, previewLine } = connEndpointDrag;
        const conn = connections.find(c => c.id === connId);
        if (conn) {
            if (endpoint === 'from' && targetNodeId !== conn.to) {
                conn.from = targetNodeId;
                conn.fromAnchor = targetAnchor;
            } else if (endpoint === 'to' && targetNodeId !== conn.from) {
                conn.to = targetNodeId;
                conn.toAnchor = targetAnchor;
            }
        }
        previewLine.remove();
        connEndpointDrag = null;
        document.getElementById('mindmap-canvas').classList.remove('endpoint-drag-active');
        document.querySelectorAll('.endpoint-drag-hover').forEach(el => el.classList.remove('endpoint-drag-hover'));
        updateConnections();
        if (conn) selectConnection(conn.id);
    }

    function cancelConnEndpointDrag() {
        if (!connEndpointDrag) return;
        connEndpointDrag.previewLine.remove();
        connEndpointDrag = null;
        document.getElementById('mindmap-canvas').classList.remove('endpoint-drag-active');
        document.querySelectorAll('.endpoint-drag-hover').forEach(el => el.classList.remove('endpoint-drag-hover'));
    }

    function createSolidLine(x1, y1, x2, y2) {
        // Create orthogonal L-shaped path instead of diagonal line
        return createOrthogonalLine(x1, y1, x2, y2, 'solid-line', 'arrowhead-solid');
    }

    function createDashedLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'dashed-line', 'arrowhead-dashed');
    }

    function createDottedLine(x1, y1, x2, y2) {
        return createOrthogonalLine(x1, y1, x2, y2, 'dotted-line', 'arrowhead-dotted');
    }

    function createCurvedLine(x1, y1, x2, y2) {
        // For curved lines, we'll keep the original curved behavior but make it orthogonal-inspired
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        
        // Create a curved path that starts horizontal/vertical then curves
        const midX = (x1 + x2) / 2;
        const midY = (y1 + y2) / 2;
        
        // Determine the dominant direction for the curve
        const deltaX = Math.abs(x2 - x1);
        const deltaY = Math.abs(y2 - y1);
        
        let d;
        if (deltaX > deltaY) {
            // Mostly horizontal - curve vertically
            d = `M ${x1} ${y1} L ${midX} ${y1} Q ${midX} ${midY - 20} ${midX} ${midY} L ${x2} ${midY} L ${x2} ${y2}`;
        } else {
            // Mostly vertical - curve horizontally
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
        // Create double orthogonal lines
        const group = document.createElementNS('http://www.w3.org/2000/svg', 'g');
        
        // Calculate orthogonal path
        const path1 = createOrthogonalLine(x1, y1 - 2, x2, y2 - 2, 'double-line', 'arrowhead-solid');
        const path2 = createOrthogonalLine(x1, y1 + 2, x2, y2 + 2, 'double-line', null);
        
        group.appendChild(path1);
        group.appendChild(path2);
        
        return group;
    }

    function createWavyLine(x1, y1, x2, y2) {
        // Create wavy orthogonal path
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        
        const midX = (x1 + x2) / 2;
        const midY = (y1 + y2) / 2;
        
        // Create wavy L-shaped path
        const deltaX = Math.abs(x2 - x1);
        const deltaY = Math.abs(y2 - y1);
        
        let d;
        if (deltaX > deltaY) {
            // Horizontal first, then vertical with waves
            d = `M ${x1} ${y1} Q ${x1 + 20} ${y1 - 5} ${x1 + 40} ${y1} T ${x1 + 80} ${y1} L ${midX} ${y1} Q ${midX + 10} ${midY - 5} ${midX} ${midY} T ${midX + 40} ${midY} L ${x2} ${midY} Q ${x2 - 10} ${midY + 5} ${x2} ${y2}`;
        } else {
            // Vertical first, then horizontal with waves
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

        // Direct line from anchor to anchor
        // Anchor positions already have offset to prevent line from entering node
        const pathData = `M ${x1} ${y1} L ${x2} ${y2}`;

        path.setAttribute('d', pathData);
        path.setAttribute('class', `connection-line ${lineClass}`);
        path.style.fill = 'none';
        if (arrowMarker) {
            path.setAttribute('marker-end', `url(#${arrowMarker})`);
        }

        return path;
    }

    function createManualPath(x1, y1, x2, y2, pathPoints, connection) {
        // TODO: Implement manual path creation
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        path.setAttribute('d', `M ${x1} ${y1} L ${x2} ${y2}`);
        path.setAttribute('class', 'connection-line manual-line');
        return path;
    }

    function addControlPointsForLine(svg, x1, y1, x2, y2, connection) {
        // TODO: Implement control point addition for lines
    }

    function addControlPointsForPath(pathPoints, connection, x1, y1, x2, y2) {
        // TODO: Implement control point addition for paths
    }

    function createControlPoint(x, y, connection, type, index = null) {
        // TODO: Implement control point creation
        const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
        circle.setAttribute('cx', x);
        circle.setAttribute('cy', y);
        circle.setAttribute('r', '6');
        circle.setAttribute('class', 'control-point');
        return circle;
    }

    function removeNode(node) {
        if (node.id === 'root-node') return; // Don't remove root node
        
        // Remove connections
        connections = connections.filter(conn => 
            conn.from !== node.id && conn.to !== node.id
        );
        
        // Remove from nodes array
        nodes = nodes.filter(n => n.id !== node.id);
        
        // Remove from DOM
        node.remove();
        
        // Clear selections and reset properties panel
        clearAllSelections();
        document.getElementById('properties-panel').innerHTML = '<p class="text-muted">Select an element to edit properties</p>';
        
        updateConnections();
        updateNodeCount();
        
        // Refresh materials list to make the material available again in sidebar
        refreshMaterialsList();
    }

    function clearCanvas() {
        if (confirm('Apakah Anda yakin ingin membersihkan canvas?')) {
            document.querySelectorAll('.mindmap-node:not(#root-node)').forEach(node => node.remove());
            nodes = [];
            connections = [];
            document.getElementById('connections-svg').innerHTML = '';
            const hSvgFull = document.getElementById('handles-svg');
            if (hSvgFull) hSvgFull.innerHTML = '';
            updateNodeCount();
            
            // Refresh materials list to make all materials available again in sidebar
            refreshMaterialsList();
        }
    }

    function autoLayout() {
        if (nodes.length === 0) return;
        
        // Calculate viewport center for layout
        const canvasArea = document.querySelector('.drawio-canvas-area');
        const viewportCenterX = canvasArea.clientWidth / 2;
        const viewportCenterY = canvasArea.clientHeight / 2;
        
        // Convert viewport coordinates to canvas coordinates
        const centerX = (viewportCenterX - panOffset.x) / zoomLevel;
        const centerY = (viewportCenterY - panOffset.y) / zoomLevel;
        
        const radius = 150;
        const angleStep = (2 * Math.PI) / nodes.length;
        
        nodes.forEach((node, index) => {
            const angle = index * angleStep;
            const x = centerX + radius * Math.cos(angle) - 60;
            const y = centerY + radius * Math.sin(angle) - 20;
            
            const nodeElement = document.getElementById(node.id);
            if (nodeElement) {
                nodeElement.style.left = x + 'px';
                nodeElement.style.top = y + 'px';
                node.x = x;
                node.y = y;
            }
        });
        
        updateConnections();
    }

    function saveMindmap() {
        console.log('saveMindmap called');
        console.log('selectedCategory:', selectedCategory);
        console.log('nodes:', nodes);
        console.log('connections:', connections);

        if (!selectedCategory) {
            alert('Pilih kategori terlebih dahulu');
            return;
        }

        const mindmapData = {
            nodes: nodes.map(node => ({
                id: node.id,
                materialId: node.materialId,
                title: node.title,
                x: node.x,
                y: node.y,
                type: node.type,
                completed: node.completed || false,
                style: node.style || {}
            })),
            connections: connections
        };

        console.log('mindmapData:', mindmapData);

        // Get title from selected category (no root node)
        const categoryBtn = document.querySelector(`[data-category-id="${selectedCategory}"]`);
        const title = categoryBtn ? categoryBtn.querySelector('.category-text').textContent : 'Mind Map';

        console.log('title:', title);

        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        console.log('csrfToken:', csrfToken ? csrfToken.getAttribute('content') : 'not found');

        fetch('/mindmap-creator/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
            },
            body: JSON.stringify({
                category_id: selectedCategory,
                title: title,
                mindmap_data: mindmapData
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message || 'Unknown error',
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error saving mindmap:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan saat menyimpan mind map: ' + error.message,
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        });
    }
</script>
@endsection


@push('scripts')
    @include('backend.layouts.scriptcustom')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function () {
            const MENU_KEY = 'nexel-classic-dashboard-menu-mini-theme';
            let previousSidebarState = null;

            function setSidebarMini(isMini) {
                if (isMini) {
                    $('html').addClass('minimenu');
                    $('.logo-full').hide();
                    $('.logo-abbr').show();
                    $('#menu-mini-button').hide();
                    $('#menu-expend-button').show();
                    return;
                }

                $('html').removeClass('minimenu');
                $('.logo-full').show();
                $('.logo-abbr').hide();
                $('#menu-mini-button').show();
                $('#menu-expend-button').hide();
            }

            previousSidebarState = {
                wasMini: $('html').hasClass('minimenu'),
                menuKey: localStorage.getItem(MENU_KEY)
            };

            $('html').addClass('mindmap-mini-sidebar-active');
            setSidebarMini(true);

            // common-init may re-expand sidebar on wide screens; keep mini on this page
            $(window).on('resize.mindmapMiniSidebar', function () {
                if ($('html').hasClass('mindmap-mini-sidebar-active') && !window.__mindmapSidebarExpandedByUser) {
                    setSidebarMini(true);
                }
            });

            $('#menu-expend-button').on('click.mindmapMiniSidebar', function () {
                window.__mindmapSidebarExpandedByUser = true;
            });

            $('#menu-mini-button').on('click.mindmapMiniSidebar', function () {
                window.__mindmapSidebarExpandedByUser = false;
            });

            $(window).on('pagehide', function () {
                if (!previousSidebarState) return;

                setSidebarMini(previousSidebarState.wasMini);

                if (previousSidebarState.menuKey) {
                    localStorage.setItem(MENU_KEY, previousSidebarState.menuKey);
                }

                $('html').removeClass('mindmap-mini-sidebar-active');
                $(window).off('resize.mindmapMiniSidebar');
                $('#menu-expend-button, #menu-mini-button').off('.mindmapMiniSidebar');
            });
        });
    </script>
@endpush