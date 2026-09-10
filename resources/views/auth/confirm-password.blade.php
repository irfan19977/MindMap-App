<!DOCTYPE html>
<html lang="en">

<head>
    <title>Konfirmasi Password - MindMap</title>
    <link rel="icon" href="{{ asset('frontend/images/logo/logodark.png') }}" type="image/gif" sizes="16x16">
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
            background-image: url('{{ asset('frontend/images/slider/1.png') }}');
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
        
        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.2s;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            color: white;
            transform: translateY(-2px);
        }
        
        .back-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #666;
        }
        
        .back-link a {
            color: #8B9A46;
            font-weight: 600;
            text-decoration: none;
        }
        
        .back-link a:hover {
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
                <img src="{{ asset('frontend/images/logo/logodark.png') }}" alt="MindMap Logo" style="width: 60px;">
            </div>
            
            <h2 class="login-title">Konfirmasi Password</h2>
            <p class="login-subtitle">Masukkan password untuk verifikasi keamanan</p>
            
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="password" class="form-label" style="font-weight: 600; color: #333; font-size: 14px;">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password Anda" required autocomplete="current-password">
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-login">Konfirmasi</button>
            </form>
            
            <div class="back-link">
                <a href="{{ route('dashboard') }}">Batal</a>
            </div>
        </div>
    </div>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>

</html>
