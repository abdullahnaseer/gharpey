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
    @stack('styles')

    <script src="{{asset('js/limitless.js')}}"></script>
    <script src="{{asset('js/admin.js')}}"></script>
</head>
<body>
<!-- Main navbar -->
@include('admin.layouts.navbar', ['auth' => false])
<!-- /main navbar -->

<!-- Page content -->
<div class="page-content">
@auth('admin')
    <!-- Main sidebar -->
    @include('admin.layouts.sidebar')
    <!-- /main sidebar -->
@endauth
<!-- Main content -->
    <div class="content-wrapper">
    @include('admin.layouts.page-header', ['page_title' => isset($page_title) ? $page_title : "Dashboard", 'back_url' => isset($back_url) ? $back_url : url()->previous()])
        <!-- Content area -->
        <div class="content">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @include('flash::message')

            @yield('content')
        </div>
        <!-- /content area -->

        @include("admin.layouts.page-footer")
    </div>
    <!-- /Main content -->
</div>
<!-- /page content -->

@stack('modals')
@stack('scripts')
</body>
</html>
