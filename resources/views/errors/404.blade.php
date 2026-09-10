<!DOCTYPE html>
<html lang="en">

<head>
    <title>Halaman Tidak Ditemukan - MindMap</title>
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
        .error-container {
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
        
        .error-container::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(245, 245, 245, 0.85);
            z-index: 1;
        }
        
        .error-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            padding: 50px 40px;
            position: relative;
            z-index: 2;
            text-align: center;
        }
        
        .error-logo {
            margin-bottom: 30px;
        }
        
        .error-logo img {
            max-width: 100px;
            height: auto;
        }
        
        .error-code {
            font-size: 120px;
            font-weight: 800;
            color: #8B9A46;
            line-height: 1;
            margin-bottom: 20px;
        }
        
        .error-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }
        
        .error-message {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .btn-home {
            background: #8B9A46;
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-home:hover {
            background: #7A8739;
            color: white;
            transform: translateY(-2px);
            text-decoration: none;
        }
        
        .error-icon {
            font-size: 80px;
            color: #e0e0e0;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-card">
            <div class="error-logo">
                <img src="{{ asset('frontend/images/logo/logodark.png') }}" alt="MindMap Logo">
            </div>
            
            <div class="error-icon">
                <i class="fa-solid fa-page-break"></i>
            </div>
            
            <div class="error-code">404</div>
            
            <h1 class="error-title">Halaman Tidak Ditemukan</h1>
            
            <p class="error-message">
                Maaf, halaman yang Anda cari tidak dapat ditemukan. Halaman mungkin telah dipindahkan, dihapus, atau URL yang Anda masukkan salah.
            </p>
            
            <a href="{{ url('/') }}" class="btn-home">
                <i class="fa-solid fa-home me-2"></i>Kembali ke Beranda
            </a>
        </div>
    </div>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>

</html>