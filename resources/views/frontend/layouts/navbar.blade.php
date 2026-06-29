 <nav class="navbar navbar-Concept navbar-custom navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-main-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand page-scroll" href="/">
            <!-- Text or Image logo--><img class="logo" src="{{ asset('frontend/img/logo.png') }}" alt="Logo"><img class="logodark" src="{{ asset('frontend/img/logodark.png') }}" alt="Logo"></a>
        </div>
        <div class="collapse navbar-collapse navbar-main-collapse">
          <ul class="nav navbar-nav navbar-left">
            <li class="hidden"><a href="#page-top"></a></li>
            <li><a href="/">Home</a></li>
            <li><a href="/about">About</a></li>
            <li><a href="/teacher">Guru</a></li>
            <li><a href="#">Kelas <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><strong class="text-muted">Akademik</strong></li>
                <li><a href="/kelas/matematika">Matematika</a></li>
                <li><a href="/kelas/fisika">Fisika</a></li>
                <li><a href="/kelas/kimia">Kimia</a></li>
                <li><strong class="text-muted">Digital</strong></li>
                <li><a href="/kelas/programming">Programming</a></li>
                <li><a href="/kelas/web-design">Web Design</a></li>
                <li><strong class="text-muted">Bisnis</strong></li>
                <li><a href="/kelas/akuntansi">Akuntansi</a></li>
                <li class="divider"></li>
                <li><a href="/kelas"><i class="ion-ios-grid-outline"></i> Lihat Semua Kelas</a></li>
              </ul>
            </li>
            <li><a href="#">Program <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><strong class="text-muted">Program Reguler</strong></li>
                <li><a href="/program/pelajar">Program Pelajar</a></li>
                <li><a href="/program/mahasiswa">Program Mahasiswa</a></li>
                <li><a href="/program/profesional">Program Profesional</a></li>
                <li><strong class="text-muted">Program Intensif</strong></li>
                <li><a href="/program/bootcamp">Bootcamp</a></li>
                <li><a href="/program/workshop">Workshop</a></li>
                <li><a href="/program/private-lesson">Private Lesson</a></li>
                <li><strong class="text-muted">Sertifikasi</strong></li>
                <li><a href="/program/sertifikasi-kompetensi">Sertifikasi Kompetensi</a></li>
                <li><a href="/program/sertifikasi-internasional">Sertifikasi Internasional</a></li>
              </ul>
            </li>
            <li><a href="#">Layanan <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/layanan/konsultasi-akademik"><i class="fa fa-users fa-lg fa-fw"></i> Konsultasi Akademik</a></li>
                <li><a href="/layanan/tutor-private"><i class="fa fa-user-graduate fa-lg fa-fw"></i> Tutor Private</a></li>
                <li><a href="/layanan/materi-custom"><i class="fa fa-book fa-lg fa-fw"></i> Materi Custom</a></li>
                <li><a href="/layanan/assessment-test"><i class="fa fa-clipboard-check fa-lg fa-fw"></i> Assessment Test</a></li>
                <li><a href="/layanan/progress-tracking"><i class="fa fa-chart-line fa-lg fa-fw"></i> Progress Tracking</a></li>
                <li><a href="/layanan/sertifikat"><i class="fa fa-certificate fa-lg fa-fw"></i> Sertifikat</a></li>
              </ul>
            </li>
            <li><a href="/contact">Contact</a></li>
            <li class="menu-divider visible-lg">&nbsp;</li>
            @auth
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            @else
            <li class="dropdown">
              <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:#4f8ef7;color:#fff;font-weight:700;font-size:12px;vertical-align:middle;margin-right:4px;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">{{ auth()->user()->name }}<br><small class="text-muted">{{ auth()->user()->email }}</small></li>
                <li class="divider"></li>
                <li><a href="{{ auth()->user()->student ? route('student.profile') : '/profile' }}"><i class="fa fa-user fa-fw"></i> Profile</a></li>
                <li><a href="/learning-tracking"><i class="fa fa-chart-line fa-fw"></i> Learning Tracking</a></li>
                <li><a href="/sertifikat"><i class="fa fa-certificate fa-fw"></i> Sertifikat</a></li>
                <li class="divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link" style="padding:3px 20px;width:100%;text-align:left;color:#333;text-decoration:none;">
                      <i class="fa fa-sign-out fa-fw"></i> Logout
                    </button>
                  </form>
                </li>
              </ul>
            </li>
            @endif
            @else
            <li><a href="{{ route('login') }}">Login</a></li>
            @endauth
            <li class="visible-lg">&nbsp;</li>
            <li class="dropdown"><a class="dropdown-toggle" href="#"><i class="fa fa-globe fa-lg"></i> En<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/">English</a></li>
                <li><a href="/">Español</a></li>
                <li><a href="/">Deutsch</a></li>
                <li><a href="/">Français</a></li>
                <li><a href="/">Русский</a></li>
                <li><a href="/">日本語</a></li>
                <li><a href="/">中文(简体)</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>