<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('frontend/img/misc/favicon.png') }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>MindMap - Verify Email</title>
    <!-- Bootstrap Core CSS-->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS-->
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
  </head>
  <body class="top" id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <!-- Preloader (Optional)-->
    <div id="preloader">
      <div id="status"></div>
    </div>
    <!-- Navigation-->
    <nav class="navbar navbar-Concept navbar-custom navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-main-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand page-scroll" href="#page-top">
            <!-- Text or Image logo--><img class="logo" src="{{ asset('frontend/img/logo.png') }}" alt="Logo"><img class="logodark" src="{{ asset('frontend/img/logodark.png') }}" alt="Logo"></a>
        </div>
        <div class="collapse navbar-collapse navbar-main-collapse">
          <ul class="nav navbar-nav navbar-left">
            <li class="hidden"><a href="#page-top"></a></li>
            <li><a href="/">Home</a></li>
            <li><a href="/about">About</a></li>
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
            <li><a href="{{ route('login') }}">Login</a></li>
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
    <!-- Header-->
    <header class="intro intro-fullscreen" data-background="{{ asset('frontend/img/main/33.jpg') }}">
      <div class="overlay"></div>
      <div class="intro-body">
        <!-- Verify Email-->
        <h2>Verify Your Email</h2>
        <div class="container">
          <div class="row wow fadeIn">
            <div class="col-md-6 col-md-offset-3">
              <div class="verify-email-container">
                <div class="text-center mb-4">
                  <i class="ion-ios-email-outline" style="font-size: 64px; color: #007bff;"></i>
                </div>
                
                <div class="alert alert-info">
                  <h4><i class="ion-ios-information-circle-outline"></i> Check Your Email</h4>
                  <p class="mb-0">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success">
                        <i class="ion-ios-checkmark-circle-outline"></i> A new verification link has been sent to the email address you provided during registration.
                    </div>
                @endif

                <div class="row mt-4">
                  <div class="col-sm-6">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button class="btn btn-lg btn-primary btn-block" type="submit">
                          <i class="ion-ios-refresh-outline"></i> Resend Verification Email
                        </button>
                    </form>
                  </div>
                  <div class="col-sm-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-lg btn-dark btn-block" type="submit">
                          <i class="ion-ios-log-out-outline"></i> Log Out
                        </button>
                    </form>
                  </div>
                </div>

                <div class="text-center mt-4">
                  <p class="text-muted small">Didn't receive the email? Check your spam folder or try resending the verification link.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header><a class="topbtn page-scroll" href="#page-top"></a>
    
    <!-- jQuery-->
    <script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript-->
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <!-- Plugin JavaScript-->
    <script src="{{ asset('frontend/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.smartmenus.js') }}"></script>
    <!-- Custom Theme JavaScript-->
    <script src="{{ asset('frontend/js/main.js') }}"></script>

  </body>
</html>
