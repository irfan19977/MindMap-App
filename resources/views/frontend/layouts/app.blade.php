<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('direction', 'ltr') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('frontend/img/logodark.png') }}">
    <meta name="description" content="MindMap - Platform pembelajaran interaktif dengan sistem alur pembelajaran dan materi yang terstruktur untuk meningkatkan pemahaman konsep">
    <meta name="author" content="MindMap Team">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MindMap - Platform Pembelajaran Interaktif</title>
    <!-- Bootstrap Core CSS-->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS-->
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
    <!-- RTL Support CSS for Arabic -->
    @if(session('direction') === 'rtl')
    <link href="{{ asset('frontend/css/rtl.css') }}" rel="stylesheet">
    @endif
  </head>
  <body class="top {{ session('direction', 'ltr') }}" id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <!-- Preloader (Optional)-->

    <!-- Navigation-->
    @include('frontend.layouts.navbar')


    @yield('content')
    <!-- footer-->
    @include('frontend.layouts.footer')

    <!-- jQuery-->
    <script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript-->
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <!-- Plugin JavaScript-->
    <script src="{{ asset('frontend/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/js/device.min.js') }}"></script>
    <script src="{{ asset('frontend/js/form.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.placeholder.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.shuffle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.parallax.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.circle-progress.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.swipebox.min.js') }}"></script>
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.smartmenus.js') }}"></script>
    @stack('scripts')
    <!-- Youtube video background--><a class="player" id="bgndVideo" data-property="{videoURL:'https://www.youtube.com/watch?v=yx226REvbzw', containment:'.intro', autoPlay:true, loop:true, mute:true, startAt:0, stopAt: 240, quality:'default', opacity:1, showControls: false, showYTLogo:false, vol:25}"></a>
    <script src="{{ asset('frontend/js/jquery.mb.YTPlayer.js') }}"></script>
    <!-- Custom Theme JavaScript-->
    <script src="{{ asset('frontend/js/main.js') }}"></script>

  </body>
</html>