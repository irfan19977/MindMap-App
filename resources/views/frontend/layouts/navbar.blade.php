 <nav class="navbar navbar-Concept navbar-custom navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-main-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand page-scroll" href="/">
            <!-- Text or Image logo--><img class="logo" src="{{ asset('frontend/img/logo.png') }}" alt="Logo"><img class="logodark" src="{{ asset('frontend/img/logodark.png') }}" alt="Logo"></a>
        </div>
        <div class="collapse navbar-collapse navbar-main-collapse">
          <ul class="nav navbar-nav navbar-left">
            <li class="hidden"><a href="#page-top"></a></li>
            <li><a href="/">{{ __('messages.home') }}</a></li>
            <li><a href="/about">{{ __('messages.about') }}</a></li>
            <li><a href="/teacher">{{ __('messages.teachers') }}</a></li>
            <li><a href="#">{{ __('messages.courses') }} <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><strong class="text-muted">{{ __('messages.nav_academic') }}</strong></li>
                <li><a href="/kelas/matematika">{{ __('messages.nav_mathematics') }}</a></li>
                <li><a href="/kelas/fisika">{{ __('messages.nav_physics') }}</a></li>
                <li><a href="/kelas/kimia">{{ __('messages.nav_chemistry') }}</a></li>
                <li><strong class="text-muted">{{ __('messages.nav_digital') }}</strong></li>
                <li><a href="/kelas/programming">{{ __('messages.nav_programming') }}</a></li>
                <li><a href="/kelas/web-design">{{ __('messages.nav_web_design') }}</a></li>
                <li><strong class="text-muted">{{ __('messages.nav_business') }}</strong></li>
                <li><a href="/kelas/akuntansi">{{ __('messages.nav_accounting') }}</a></li>
                <li class="divider"></li>
                <li><a href="/kelas"><i class="ion-ios-grid-outline"></i> {{ __('messages.view_all_courses') }}</a></li>
              </ul>
            </li>
            <li><a href="#">{{ __('messages.nav_program') }} <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><strong class="text-muted">{{ __('messages.nav_regular_program') }}</strong></li>
                <li><a href="/program/pelajar">{{ __('messages.nav_student_program') }}</a></li>
                <li><a href="/program/mahasiswa">{{ __('messages.nav_university_program') }}</a></li>
                <li><a href="/program/profesional">{{ __('messages.nav_professional_program') }}</a></li>
                <li><strong class="text-muted">{{ __('messages.nav_intensive_program') }}</strong></li>
                <li><a href="/program/bootcamp">{{ __('messages.nav_bootcamp') }}</a></li>
                <li><a href="/program/workshop">{{ __('messages.nav_workshop') }}</a></li>
                <li><a href="/program/private-lesson">{{ __('messages.nav_private_lesson') }}</a></li>
                <li><strong class="text-muted">{{ __('messages.nav_certification') }}</strong></li>
                <li><a href="/program/sertifikasi-kompetensi">{{ __('messages.nav_competency_certification') }}</a></li>
                <li><a href="/program/sertifikasi-internasional">{{ __('messages.nav_international_certification') }}</a></li>
              </ul>
            </li>
            <li><a href="#">{{ __('messages.nav_services') }} <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/layanan/konsultasi-akademik"><i class="fa fa-users fa-lg fa-fw"></i> {{ __('messages.nav_academic_consultation') }}</a></li>
                <li><a href="/layanan/tutor-private"><i class="fa fa-user-graduate fa-lg fa-fw"></i> {{ __('messages.nav_private_tutor') }}</a></li>
                <li><a href="/layanan/materi-custom"><i class="fa fa-book fa-lg fa-fw"></i> {{ __('messages.nav_custom_materials') }}</a></li>
                <li><a href="/layanan/assessment-test"><i class="fa fa-clipboard-check fa-lg fa-fw"></i> {{ __('messages.nav_assessment_test') }}</a></li>
                <li><a href="/layanan/progress-tracking"><i class="fa fa-chart-line fa-lg fa-fw"></i> {{ __('messages.nav_progress_tracking') }}</a></li>
                <li><a href="/layanan/sertifikat"><i class="fa fa-certificate fa-lg fa-fw"></i> {{ __('messages.nav_certificate_service') }}</a></li>
              </ul>
            </li>
            <li><a href="/contact">{{ __('messages.contact') }}</a></li>
            <li class="menu-divider visible-lg">&nbsp;</li>
            @auth
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
            <li><a href="{{ route('dashboard.index') }}">{{ __('messages.dashboard') }}</a></li>
            @else
            <li class="dropdown">
              <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:#4f8ef7;color:#fff;font-weight:700;font-size:12px;vertical-align:middle;margin-right:4px;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">{{ auth()->user()->name }}<br><small class="text-muted">{{ auth()->user()->email }}</small></li>
                <li class="divider"></li>
                <li><a href="{{ auth()->user()->student ? route('student.profile') : '/profile' }}"><i class="fa fa-user fa-fw"></i>{{ __('messages.nav_profile') }}</a></li>
                <li><a href="/learning-tracking"><i class="fa fa-chart-line fa-fw"></i>{{ __('messages.nav_learning_tracking') }}</a></li>
                <li><a href="/sertifikat"><i class="fa fa-certificate fa-fw"></i>{{ __('messages.nav_certificate') }}</a></li>
                <li class="divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link" style="padding:3px 20px;width:100%;text-align:left;color:#333;text-decoration:none;">
                      <i class="fa fa-sign-out fa-fw"></i> {{ __('messages.logout') }}
                    </button>
                  </form>
                </li>
              </ul>
            </li>
            @endif
            @else
            <li><a href="{{ route('login') }}">{{ __('messages.login') }}</a></li>
            @endauth
            <li class="visible-lg">&nbsp;</li>
            <li class="dropdown">
              <a class="dropdown-toggle" href="#">
                <i class="fa fa-globe fa-lg"></i> 
                {{ strtoupper(app()->getLocale()) }}<span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="{{ request()->fullUrlWithQuery(['lang' => 'id']) }}">🇮🇩 Bahasa Indonesia</a></li>
                <li><a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}">🇺🇸 English</a></li>
                <li><a href="{{ request()->fullUrlWithQuery(['lang' => 'es']) }}">🇪🇸 Español</a></li>
                <li><a href="{{ request()->fullUrlWithQuery(['lang' => 'ar']) }}">🸀 العربية</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>