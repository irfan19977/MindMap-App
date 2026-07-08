<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('direction', 'ltr') }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="maryinparis" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--! The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags !-->
    <!--! BEGIN: Apps Title-->
    <title>@yield('title', 'MindMap || Dashboard')</title>
    <!--! END:  Apps Title-->
    <!--! BEGIN: Favicon-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/assets/images/logo-abbr.png') }}" />
    <!--! END: Favicon-->
    <!--! BEGIN: Bootstrap CSS-->
    @if(session('direction') === 'rtl')
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/bootstrap.rtl.min.css') }}" />
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/bootstrap.min.css') }}" />
    @endif
    <!--! END: Bootstrap CSS-->
    <!--! BEGIN: Vendors CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/vendors.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/daterangepicker.min.css') }}" />
	
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/jquery-jvectormap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/select2.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/select2-theme.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/jquery.time-to.min.css') }}" />
	
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/tagify.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/tagify-data.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/quill.min.css') }}" />

    <link type="text/css" rel="stylesheet" href="{{ asset('backend/assets/vendors/css/tui-calendar.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('backend/assets/vendors/css/tui-theme.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('backend/assets/vendors/css/tui-time-picker.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('backend/assets/vendors/css/tui-date-picker.min.css') }}" />

	<link type="text/css" rel="stylesheet" href="{{ asset('backend/assets/vendors/css/emojionearea.min.css') }}" />

	<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/jquery.time-to.min.css') }}" />
	
	<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/vendors/css/dataTables.bs5.min.css') }}" />	
    <!--! END: Vendors CSS-->
    <!--! BEGIN: Custom CSS-->
    @if(session('direction') === 'rtl')
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/theme.rtl.min.css') }}" />
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/theme.min.css') }}" />
    @endif
    @stack('styles')

</head>
<body>
    @include('backend.layouts.sidebar')
    @include('backend.layouts.header')
    <main class="nxl-container">
        @yield('content')

        @include('backend.layouts.footer')
    </main>
    
    @include('backend.layouts.theme')
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Check for session messages and show SweetAlert
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        @endif
    </script>
    
    @stack('scripts')
</body>
</html>
