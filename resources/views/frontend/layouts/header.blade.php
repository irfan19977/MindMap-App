    <header class="header-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="de-flex sm-pt10">
                        <div class="de-flex-col">
                            <!-- logo begin -->
                            <div id="logo">
                                <a href="/">
                                    <img class="logo-main" src="{{ asset('frontend/images/logo/logodark.png') }}" alt="" style="width: 40px;">
                                    <img class="logo-scroll" src="{{ asset('frontend/images/logo/logodark.png') }}" alt="" style="width: 40px;">
                                    <img class="logo-mobile" src="{{ asset('frontend/images/logo/logodark.png') }}" alt="" style="width: 40px;">
                                </a>
                            </div>
                            <!-- logo end -->
                        </div>
                        <div class="de-flex-col header-col-mid">
                            <!-- mainemenu begin -->
                            <ul id="mainmenu">
                                @guest
                                <li><a class="menu-item" href="/">Home</a></li>
                                <li><a class="menu-item" href="/about">Tentang</a></li>
                                <li><a class="menu-item" href="/teacher">Guru</a></li>
                                <li><a class="menu-item" href="/leaderboard">Leaderboard</a></li>
                                <li><a class="menu-item" href="/kelas">Kelas</a></li>
                                <li><a class="menu-item" href="/contact">Kontak</a></li>
                                <li><a class="menu-item" href="{{ route('login') }}?intended={{ urlencode(request()->fullUrl()) }}">Login</a></li>
                                @endguest
                                @auth
                                <li><a class="menu-item" href="/">Home</a></li>
                                <li><a class="menu-item" href="/teacher">Guru</a></li>
                                <li><a class="menu-item" href="/leaderboard">Leaderboard</a></li>
                                <li><a class="menu-item" href="/kelas">Kelas</a></li>
                                <li><a class="menu-item" href="/contact">Kontak</a></li>
                                <li><a class="menu-item" href="#">Akun Saya</a>
                                    <ul>
                                        @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('teacher') && auth()->user()->is_active))
                                        <li><a href="{{ route('backend.profile.show') }}">Profil</a></li>
                                        @else
                                        <li><a href="{{ route('student.profile') }}">Profil</a></li>
                                        @endif
                                        @if(!(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('teacher') && auth()->user()->is_active)))
                                        <li><a href="{{ route('student.profile') }}#classes">Kelas Saya</a></li>
                                        @endif
                                        @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('teacher') && auth()->user()->is_active))
                                        <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                        @endif
                                        @if(auth()->user()->student)
                                        <li><a href="{{ route('student.profile') }}#certificates">Sertifikat</a></li>
                                        @endif
                                        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                    </ul>
                                </li>
                                @endauth
                            </ul>
                            <!-- mainmenu end -->
                        </div>
                        <div class="de-flex-col">
                            <div class="menu_side_area">
                                @guest
                                <a href="{{ route('login') }}?intended={{ urlencode(request()->fullUrl()) }}" class="btn-main fx-slide"><span>Mulai Belajar</span></a>
                                @endauth
                                @auth
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn-main fx-slide"><span>Logout</span></button>
                                </form>
                                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                                    @csrf
                                </form>
                                @endauth
                                <span id="menu-btn"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>