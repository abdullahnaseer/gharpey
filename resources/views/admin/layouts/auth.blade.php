<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GharPey') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">

    <link href="{{asset('css/admin.css')}}" rel="stylesheet" type="text/css">

    <script src="{{asset('js/limitless.js')}}"></script>
    <script src="{{asset('js/admin.js')}}"></script>
</head>
<body>
    <!-- Main navbar -->
    @include('admin.layouts.navbar', ['auth' => true])
    <!-- /main navbar -->

    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /Main content -->
    </div>
    <!-- /page content -->
</body>
</html>
