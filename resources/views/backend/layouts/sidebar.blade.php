    <nav class="nxl-navigation">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="/" class="b-brand">
                    <!-- ========   change your logo hear   ============ -->
                    <img src="{{ asset('backend/assets/images/logo-full.png') }}" style="width: 200px;" alt="" class="logo logo-lg" />
                    <img src="{{ asset('backend/assets/images/logo-abbr.png') }}" alt="" class="logo logo-sm" />
                </a>
            </div>
            <div class="navbar-content">
                <ul class="nxl-navbar">
                    <li class="nxl-item nxl-caption">
                        <label>{{ __('messages.backend_sidebar_main_menu') }}</label>
                    </li>
                    <li class="nxl-item">
                        <a href="{{ route('dashboard.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-home"></i></span>
                            <span class="nxl-mtext">{{ __('messages.backend_dashboard') }}</span>
                        </a>
                    </li>
                    
                    <li class="nxl-item nxl-caption">
                        <label>{{ __('messages.backend_educational_content') }}</label>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-folder"></i></span>
                            <span class="nxl-mtext">{{ __('messages.backend_categories') }}</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('categories.index') }}">{{ __('messages.backend_all_categories') }}</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('categories.create') }}">{{ __('messages.backend_add_category') }}</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-layers"></i></span>
                            <span class="nxl-mtext">{{ __('messages.backend_subcategories') }}</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('subcategories.index') }}">{{ __('messages.backend_all_subcategories') }}</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('subcategories.create') }}">{{ __('messages.backend_add_subcategory') }}</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-book-open"></i></span>
                            <span class="nxl-mtext">{{ __('messages.backend_materials') }}</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('materis.index') }}">{{ __('messages.backend_all_materials') }}</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('materis.create') }}">{{ __('messages.backend_add_material') }}</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item">
                        <a class="nxl-link" href="{{ route('mindmap.index') }}">
                            <span class="nxl-micon"><i class="feather-git-branch"></i></span>
                            <span class="nxl-mtext">{{ __('messages.backend_mindmap') }}</span>
                        </a>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-activity"></i></span>
                            <span class="nxl-mtext">Hasil Pembelajaran</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('learning-results.index') }}">Tracking Siswa</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('learning-results.quizzes') }}">Hasil Quiz</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-caption">
                        <label>{{ __('messages.backend_report_and_analytics') }}</label>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-bar-chart-2"></i></span>
                            <span class="nxl-mtext">{{ __('messages.backend_sidebar_report') }}</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('reports.users') }}">{{ __('messages.backend_report_users') }}</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('reports.mindmaps') }}">{{ __('messages.backend_report_mindmaps') }}</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('reports.activities') }}">{{ __('messages.backend_report_activities') }}</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-trending-up"></i></span>
                            <span class="nxl-mtext">{{ __('messages.backend_analytics') }}</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">

                            <li class="nxl-item"><a class="nxl-link" href="{{ route('analytics.index') }}">{{ __('messages.backend_analytics_dashboard') }}</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="analytics-learning.html">{{ __('messages.backend_analytics_learning') }}</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('engagement.index') }}">{{ __('messages.backend_analytics_engagement') }}</a></li>
                        </ul>
                    </li>
                    
                    <li class="nxl-item nxl-caption">
                        <label>{{ __('messages.backend_user_management') }}</label>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-users"></i></span>
                            <span class="nxl-mtext">{{ __('messages.backend_user_management_menu') }}</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('users.index') }}">{{ __('messages.backend_all_users') }}</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('users.create') }}">{{ __('messages.backend_add_user') }}</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-shield"></i></span>
                            <span class="nxl-mtext">{{ __('messages.backend_role_management') }}</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('roles.index') }}">{{ __('messages.backend_all_roles') }}</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('roles.create') }}">{{ __('messages.backend_add_role') }}</a></li>
                        </ul>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-key"></i></span>
                            <span class="nxl-mtext">{{ __('messages.backend_sidebar_permission') }}</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('permissions.index') }}">{{ __('messages.backend_all_permissions') }}</a></li>
                            <li class="nxl-item"><a class="nxl-link" href="{{ route('permissions.create') }}">{{ __('messages.backend_add_permission') }}</a></li>
                        </ul>
                    </li>
                        <li class="nxl-item nxl-caption">
                        <label>{{ __('messages.backend_help') }}</label>
                    </li>
                    <li class="nxl-item">
                        <a href="{{ route('help.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-help-circle"></i></span>
                            <span class="nxl-mtext">{{ __('messages.backend_help_center') }}</span>
                        </a>
                    </li>
                    <li class="nxl-item">
                        <form action="{{ route('logout') }}" method="POST" id="sidebar-logout-form">
                            @csrf
                            <a href="javascript:void(0)" class="nxl-link" onclick="document.getElementById('sidebar-logout-form').submit()">
                                <span class="nxl-micon"><i class="feather-log-out"></i></span>
                                <span class="nxl-mtext">{{ __('messages.backend_logout') }}</span>
                            </a>
                        </form>
                    </li>
                </ul>
                <div class="card text-center">
                    <div class="card-body">
                        <i class="feather-book-open fs-4 text-primary"></i>
                        <h6 class="mt-4 text-dark fw-bolder">{{ __('messages.backend_mindmap_education') }}</h6>
                        <p class="fs-11 my-3 text-dark">{{ __('messages.backend_mindmap_education_description') }}</p>
                        <a href="help.html" class="btn btn-primary w-100">{{ __('messages.backend_help') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>