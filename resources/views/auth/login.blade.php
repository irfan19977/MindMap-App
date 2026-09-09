<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login - MindMap</title>
    <link rel="icon" href="{{ asset('frontend/images/icon.webp') }}" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="MindMap - Platform Pembelajaran Interaktif" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Files -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/css/plugins.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/css/coloring.css') }}" rel="stylesheet" type="text/css">
    <link id="colors" href="{{ asset('frontend/css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">
    
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f5f5;
            background-image: url('{{ asset('frontend/images/background/1.webp') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 20px;
        }
        
        .login-container::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(245, 245, 245, 0.85);
            z-index: 1;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
            padding: 40px;
            position: relative;
            z-index: 2;
        }
        
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-logo img {
            max-width: 120px;
            height: auto;
        }
        
        .login-title {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
            font-size: 28px;
            font-weight: 700;
        }
        
        .login-subtitle {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
            font-size: 14px;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #8B9A46;
            box-shadow: 0 0 0 0.2rem rgba(139, 154, 70, 0.25);
        }
        
        .btn-login {
            background: #8B9A46;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.2s;
        }
        
        .btn-login:hover {
            background: #7A8739;
            color: white;
            transform: translateY(-2px);
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            z-index: 10;
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-check-input {
            width: 18px;
            height: 18px;
            margin: 0;
            cursor: pointer;
        }
        
        .form-check-label {
            cursor: pointer;
            user-select: none;
        }
        
        .remember-forgot a {
            color: #8B9A46;
            text-decoration: none;
        }
        
        .remember-forgot a:hover {
            text-decoration: underline;
        }
        
        .social-login {
            text-align: center;
            margin-top: 30px;
        }
        
        .social-login .divider {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            color: #999;
            font-size: 13px;
        }
        
        .social-login .divider::before,
        .social-login .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }
        
        .social-login .divider span {
            padding: 0 15px;
        }
        
        .social-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        
        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            color: #666;
        }
        
        .social-btn:hover {
            border-color: #8B9A46;
            color: #8B9A46;
            transform: translateY(-2px);
        }
        
        .register-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #666;
        }
        
        .register-link a {
            color: #8B9A46;
            font-weight: 600;
            text-decoration: none;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <img src="{{ asset('frontend/images/logo.webp') }}" alt="MindMap Logo">
            </div>
            
            <h2 class="login-title">Selamat Datang Kembali</h2>
            <p class="login-subtitle">Masuk ke akun MindMap Anda</p>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                @php
                    $intendedUrl = old('intended', session()->get('url.intended'));
                    if (!$intendedUrl || $intendedUrl === url()->current()) {
                        $previousUrl = url()->previous();
                        if (!str_contains($previousUrl, '/login') && !str_contains($previousUrl, '/register')) {
                            $intendedUrl = $previousUrl;
                        } else {
                            $intendedUrl = '/';
                        }
                    }
                @endphp
                <input type="hidden" name="intended" value="{{ $intendedUrl }}">
                
                <div class="mb-3">
                    <label for="email" class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">Password</label>
                    <div class="password-wrapper">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
                        <i class="fa-solid fa-eye password-toggle" onclick="togglePassword()" id="passwordIcon"></i>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="remember-forgot">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="rememberMe" style="color: #666;">Ingat saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Lupa password?</a>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-login">Masuk</button>
            </form>
            
            <div class="social-login">
                <div class="divider">
                    <span>atau masuk dengan</span>
                </div>
                <div class="social-buttons">
                    <a href="{{ route('social.redirect', 'facebook') }}" class="social-btn" title="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="{{ route('social.redirect', 'google') }}" class="social-btn" title="Google">
                        <i class="fa-brands fa-google"></i>
                    </a>
                    <a href="{{ route('social.redirect', 'github') }}" class="social-btn" title="GitHub">
                        <i class="fa-brands fa-github"></i>
                    </a>
                </div>
            </div>
            
            <div class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
