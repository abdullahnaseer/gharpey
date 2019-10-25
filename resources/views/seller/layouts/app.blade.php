<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">

    <link href="{{asset('css/seller.css')}}" rel="stylesheet" type="text/css">

    <script src="{{asset('js/limitless.js')}}"></script>
    <script src="{{asset('js/seller.js')}}"></script>
</head>
<body>

<!-- Main navbar -->
@include('seller.layouts.navbar')
<!-- /main navbar -->

<!-- Page content -->
<div class="page-content">
    <!-- Main sidebar -->
    @include('seller.layouts.sidebar')
    <!-- /main sidebar -->

    @yield('content')
</div>
<!-- /page content -->

</body>
</html>
