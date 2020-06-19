@extends('buyer.layouts.app')

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('buyer.cart.index')}}">Shopping Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </div>
        <!-- End .container -->
    </nav>

    <div class="container">
        <ul class="checkout-progress-bar">
            <li class="active">
                <span>Shipping</span>
            </li>
            <li>
                <span>Review &amp; Payments</span>
            </li>
        </ul>
        <div class="row">
            <div class="col-lg-8">
                <ul class="checkout-steps">
                    <li>
                        <h2 class="step-title">Shipping Address</h2>

                        @guest('buyer')
                            <form method="POST" action="{{ route('buyer.login') }}">
                                @csrf
                                <input type="hidden" name="return_url" value="{{route('buyer.checkout.shipping.get')}}">

                                <div class="form-group required-field">
                                    <label>Email Address </label>
                                    <div class="form-control-tooltip">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <span class="input-tooltip" data-toggle="tooltip" title="We'll send your order confirmation here." data-placement="right"><i class="icon-question-circle"></i></span>
                                    </div>
                                    <!-- End .form-control-tooltip -->
                                </div>
                                <!-- End .form-group -->

                                <div class="form-group required-field">
                                    <label>Password </label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!-- End .form-group -->

                                <p>Sign in or continue as guest.</p>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary">LOGIN</button>

                                    @if (Route::has('buyer.password.request'))
                                        <a class="forget-pass" href="{{ route('buyer.password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                                <!-- End .form-footer -->
                            </form>
                        @endguest

                        <form action="{{route('buyer.service.checkout.shipping.post', [$service_request->id])}}" method="POST">
                            @csrf
                            <div class="form-group required-field">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control  @error('name') is-invalid @enderror" required value="{{old('name', auth('buyer')->check() ? auth('buyer')->user()->name : null)}}">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @if(auth()->guest())
                                <div class="form-group required-field">
                                    <label>Receipt Email</label>
                                    <input name="receipt_email" type="text" class="form-control  @error('receipt_email') is-invalid @enderror" required value="{{old('receipt_email', auth('buyer')->check() ? auth('buyer')->user()->email : null)}}">

                                    @error('receipt_email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif

                            <div class="form-group required-field">
                                <label>Address </label>
                                <input name="address" type="text" class="form-control  @error('address') is-invalid @enderror" required value="{{old('address', auth('buyer')->check() ? auth('buyer')->user()->address : null)}}">

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!-- End .form-group -->

                            <div class="form-group">
                                <label>Area</label>
                                <div class="select-custom">
                                    <select class="form-control kt-select2 @error('area') is-invalid @enderror" id="area" name="area" required
                                            style="width: 100%">
                                        @foreach($cities as $city)
                                            @if($city->areas->count())
                                                <optgroup label="{{$city->name}}">
                                                    @foreach($city->areas as $area)
                                                        <option value="{{$area->id}}" @if((int) old('area', auth('buyer')->check() ? auth('buyer')->user()->location_id : null) == $area->id) selected @endif>{{$area->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('area')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group required-field">
                                <label>Phone Number </label>
                                <div class="form-control-tooltip">
                                    <input name="phone" type="tel" class="form-control  @error('phone') is-invalid @enderror" required value="{{old('phone', auth('buyer')->check() ? auth('buyer')->user()->phone : null)}}">
                                    <span class="input-tooltip" data-toggle="tooltip" title="For delivery questions." data-placement="right"><i class="icon-question-circle"></i></span>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!-- End .form-control-tooltip -->
                            </div>
                            <!-- End .form-group -->

                            <div class="checkout-steps-action">
                                <button class="btn btn-primary" type="submit">NEXT</button>
                            </div>
                        </form>
                    </li>

                </ul>
            </div>
            <!-- End .col-lg-8 -->

            <div class="col-lg-4">
                <div class="order-summary">
                    <h3>Summary</h3>

                    <h4>
                        <a data-toggle="collapse" href="#order-cart-section" class="collapsed" role="button" aria-expanded="false" aria-controls="order-cart-section">{{$service_request->service_seller->service->name}}</a>
                    </h4>

                    <div class="collapse" id="order-cart-section">
                        <table class="table table-mini-cart">
                            <tbody>
                            <tr>
                                <td class="product-col">
                                    <figure class="product-image-container">
                                        <a href="#" class="product-image">
                                            <img src="{{str_replace("public","/storage",$service_request->service_seller->featured_image)}}" alt="product">
                                        </a>
                                    </figure>
                                    <div>
                                        <h2 class="product-title">
                                            <a href="#">{{$service_request->service_seller->service->name}}</a>
                                        </h2>

                                        <span class="product-qty">Qty: 1</span>
                                    </div>
                                </td>
                                <td class="price-col">Rs. {{$service_request->total_amount}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- End #order-cart-section -->
                </div>
                <!-- End .order-summary -->
            </div>
            <!-- End .col-lg-4 -->
        </div>
        <!-- End .row -->
    </div>
    <!-- End .container -->

    <div class="mb-6"></div>
    <!-- margin -->
@endsection
