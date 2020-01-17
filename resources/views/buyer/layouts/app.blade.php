<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>GharPey</title>

    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Porto - Bootstrap eCommerce Template">
    <meta name="author" content="SW-THEMES">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{url('assets1/images/icons/favicon.ico')}}">

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{url('assets1/css/bootstrap.min.css')}}">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{url('assets1/css/style.min.css')}}">
    <link rel="stylesheet" href="{{url('assets1/css/mystyle.min.css')}}">
</head>

<body>
    <div class="page-wrapper">

        @include('buyer.layouts.includes.header')

        <main class="main">
            @yield('content')

            <div class="mb-4"></div>
            <!-- margin -->
        </main>

        @include('buyer.layouts.includes.footer')

    </div>

    @include('buyer.layouts.includes.mobile-menu')

    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

    <!-- Plugins JS File -->
    <script src="{{url('assets1/js/jquery.min.js')}}"></script>
    <script src="{{url('assets1/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('assets1/js/plugins.min.js')}}"></script>

    <!-- Main JS File -->
    <script src="{{url('assets1/js/main.min.js')}}"></script>
</body>
</html>
