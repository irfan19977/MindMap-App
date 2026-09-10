<!DOCTYPE html>
<html lang="en">

<head>
    <title>MindMap - Platform Pembelajaran Interaktif</title>
    <link rel="icon" href="{{ asset('frontend/images/logo/logodark.png') }}" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <meta content="MindMap - Platform Pembelajaran Interaktif" name="description" >
    <meta content="" name="keywords" >
    <meta content="" name="author" >
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Files
    ================================================== -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="{{ asset('frontend/css/plugins.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('frontend/css/swiper.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('frontend/css/coloring.css') }}" rel="stylesheet" type="text/css" >
    <!-- color scheme -->
    <link id="colors" href="{{ asset('frontend/css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css" >

</head>

<body>


    @include('frontend.layouts.header')
        
    <main>

        <a href="#" id="back-to-top"></a>
        
        <!-- page preloader begin -->
        <div id="de-loader"></div>
        <!-- page preloader close -->

        @yield('content')
        
    </main>
        
    @include('frontend.layouts.footer')
    
    <!-- Javascript Files
    ================================================== -->
    <script src="{{ asset('frontend/js/vendors.js') }}"></script>
    <script src="{{ asset('frontend/js/designesia.js') }}"></script>
    <script src="{{ asset('frontend/js/swiper.js') }}"></script>
    <script src="{{ asset('frontend/js/custom-swiper-1.js') }}"></script>
    <script src="{{ asset('frontend/js/custom-marquee.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.twentytwenty.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.event.move.js') }}"></script>
    <script src="{{ asset('frontend/js/custom-twentytwenty.js') }}"></script>
    <!-- SweetAlert2 for nice popups -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom script for dropdown menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle dropdown toggle for "Akun Saya" menu
            const accountMenuItems = document.querySelectorAll('#mainmenu > li > a[href="#"]');
            
            accountMenuItems.forEach(function(menuItem) {
                menuItem.addEventListener('click', function(e) {
                    e.preventDefault();
                    const parentLi = this.parentElement;
                    const submenu = parentLi.querySelector('ul');
                    const span = parentLi.querySelector('span');
                    
                    if (submenu) {
                        // Toggle the submenu
                        if (submenu.style.height && submenu.style.height !== '0px') {
                            submenu.style.height = '0px';
                            if (span) span.classList.remove('active');
                        } else {
                            submenu.style.height = 'auto';
                            const openHeight = submenu.offsetHeight;
                            submenu.style.height = '0px';
                            setTimeout(() => {
                                submenu.style.height = openHeight + 'px';
                            }, 10);
                            if (span) span.classList.add('active');
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>