<!DOCTYPE html>
<html lang="en">

<head>
    <title>MindMap - Platform Pembelajaran Interaktif</title>
    <link rel="icon" href="{{ asset('frontend/images/icon.webp') }}" type="image/gif" sizes="16x16">
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
        
    <footer class="section-dark">
        <div class="container">
            <div class="row gx-5">

                <div class="col-lg-4 col-sm-6">
                    <img src="images/logo-white.webp" class="logo-footer" alt="">
                    <div class="spacer-20"></div>

                    <p>
                        We specialize in residential and commercial renovations, delivering quality craftsmanship,
                        innovative designs, and reliable project management. From remodeling single rooms to complete
                        property transformations, we bring your vision to life with precision and care.
                    </p>

                    <div class="social-icons mb-sm-30">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-12 order-lg-1 order-sm-2">
                    <div class="row">

                        <div class="col-lg-6 col-sm-6">
                            <div class="widget">
                                <h2 class="hs-5">Company</h2>
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="services.html">Our Services</a></li>
                                    <li><a href="projects.html">Projects</a></li>
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="blog.html">Blog</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="widget">
                                <h2 class="hs-5">Our Services</h2>
                                <ul>
                                    <li><a href="service-single.html">Home Renovation</a></li>
                                    <li><a href="service-single.html">Kitchen Remodeling</a></li>
                                    <li><a href="service-single.html">Bathroom Renovation</a></li>
                                    <li><a href="service-single.html">Interior Remodeling</a></li>
                                    <li><a href="service-single.html">Exterior Renovation</a></li>
                                    <li><a href="service-single.html">Commercial Renovation</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 order-lg-2 order-sm-1">
                    <div class="widget">

                        <div class="fw-bold text-white">
                            <i class="icofont-clock-time me-2 id-color-2"></i>
                            Working Hours
                        </div>
                        Monday - Sat: 8:00 AM - 6:00 PM<br>

                        <div class="spacer-20"></div>

                        <div class="fw-bold text-white">
                            <i class="icofont-location-pin me-2 id-color-2"></i>
                            Office Location
                        </div>
                        100 S Main Street, New York, NY 10001

                        <div class="spacer-20"></div>

                        <div class="fw-bold text-white">
                            <i class="icofont-envelope me-2 id-color-2"></i>
                            Email Us
                        </div>
                        contact@renovast.com

                        <div class="spacer-10"></div>

                        <div class="fw-bold text-white">
                            <i class="icofont-phone me-2 id-color-2"></i>
                            Call Us
                        </div>
                        +1 (800) 123-4567

                    </div>
                </div>

            </div>
        </div>

        <div class="subfooter">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="de-flex">
                            <div class="de-flex-col">
                                Copyright © 2026 Renovast by Designesia. All Rights Reserved.
                            </div>

                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="#">Terms &amp; Conditions</a></li>
                                <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
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