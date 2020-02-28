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

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{url('assets1/images/icons/favicon.ico')}}">

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{url('assets1/css/bootstrap.min.css')}}">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{url('assets1/css/style.min.css')}}">
    {{--    <link rel="stylesheet" href="{{url('assets1/css/mystyle.min.css')}}">--}}
    @yield('styles')
</head>

<body>
<div class="page-wrapper">

    @include('buyer.layouts.includes.header')

    <main class="main">

        @yield('breadcrumb')

        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-lg-last dashboard-content">
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
                <!-- End .col-lg-9 -->

                <aside class="sidebar col-lg-3">
                    <div class="widget widget-dashboard">
                        <h3 class="widget-title">My Account</h3>

                        <ul class="list">
                            <li @if(request()->is('/account/settings*')) class="active" @endif ><a href="{{route('buyer.account.index')}}">Account Information</a></li>
                            <li @if(request()->is('/account/orders*')) class="active" @endif ><a href="{{route('buyer.account.orders.index')}}">My Product Orders</a></li>
                            <li @if(request()->is('/account/service-requests*')) class="active" @endif ><a href="#">My Service Requests</a></li>
                            <li @if(request()->is('/account/dsfdsfsdf')) class="active" @endif ><a href="#">My Wishlist</a></li>
                            <li @if(request()->is('/account/dfssdf')) class="active" @endif ><a href="#">Newsletter Subscriptions</a></li>
                        </ul>
                    </div>
                    <!-- End .widget -->
                </aside>
                <!-- End .col-lg-3 -->
            </div>
            <!-- End .row -->
        </div>

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
<script src="{{url('assets1/js/nouislider.min.js')}}"></script>

<!-- Main JS File -->
<script src="{{url('assets1/js/main.min.js')}}"></script>
@yield('scripts')
</body>
</html>
