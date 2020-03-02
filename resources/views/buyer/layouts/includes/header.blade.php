<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left header-dropdowns">

                <div class="dropdown compare-dropdown">
                    <a href="{{url('/')}}" class="dropdown-toggle" role="button">
                        Welcome to Gharpey
                    </a>
                </div>
                <!-- End .dropdown -->
            </div>
            <!-- End .header-left -->

            <div class="header-right">

                <div class="header-dropdown dropdown-expanded">
                    <a href="#">Links</a>
                    <div class="header-menu">
                        <ul>
                            @auth('buyer')
                                <li><a href="{{route('buyer.account.index')}}">MY ACCOUNT </a></li>
                                <li><a href="{{route('buyer.account.wishlist.index')}}">MY WISHLIST </a></li>
                                <li><a href="{{route('buyer.account.notifications.index')}}">Notifications </a></li>
                                <li><a href="{{ route('buyer.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">LOGOUT </a></li>
                            @endauth
                            @guest('buyer')
                                    <li><a href="{{route('seller.home')}}">Become a Seller</a></li>
                                <li><a href="{{route('buyer.register')}}">REGISTER</a></li>
                                <li><a href="{{route('buyer.login')}}">LOG IN</a></li>
                            @endguest
                        </ul>

                        <form id="logout-form" action="{{ route('buyer.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    <!-- End .header-menu -->
                </div>
                <!-- End .header-dropown -->
            </div>
            <!-- End .header-right -->
        </div>
        <!-- End .container -->
    </div>
    <!-- End .header-top -->

    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <a href="{{url('/')}}" class="logo">
                    <img src="/assets1/images/logo.png" style="height: 60px;" alt="">
                </a>
            </div>
            <!-- End .header-left -->

            <div class="header-center">
                <div class="header-search">
                    <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
{{--                    @if(request()->is('services*'))--}}
{{--                        <form action="{{route('buyer.services.index')}}" method="get">--}}
{{--                            <div class="header-search-wrapper">--}}
{{--                                <input type="search" class="form-control" name="q" id="q" placeholder="Search..." required="">--}}
{{--                                <div class="select-custom">--}}
{{--                                    <select id="city" name="city">--}}
{{--                                        @foreach(\App\Models\City::get() as $city)--}}
{{--                                            <option value="{{$city->id}}"--}}
{{--                                            @if(request()->input('city') == $city->id)--}}
{{--                                                selected--}}
{{--                                            @endif--}}
{{--                                            >{{$city->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <button class="btn" type="submit"><i class="icon-magnifier"></i></button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    @else--}}
                        <form action="{{route('buyer.products.index')}}" method="get">
                            @if(request()->has('category'))
                                <input type="hidden" name="category" value="{{request()->input('category')}}">
                            @endif

                            @if(request()->has('price-min'))
                                <input type="hidden" name="price-min" id="input-price-min" value="{{request()->input('price-min', 100)}}" />
                            @endif

                            @if(request()->has('price-max'))
                                <input type="hidden" name="price-max" id="input-price-max" value="{{request()->input('price-max', 1000)}}" />
                            @endif

                            <div class="header-search-wrapper">
                                <input type="search" class="form-control" name="q" id="q" placeholder="Search Products..." required="" value="{{request()->input('q')}}">

                                <button class="btn" type="submit"><i class="icon-magnifier"></i></button>
                            </div>
                        </form>
{{--                    @endif--}}
                </div>
                <!-- End .header-search -->
            </div>
            <!-- End .headeer-center -->

            <div class="header-right">
                <button class="mobile-menu-toggler" type="button">
                    <i class="icon-menu"></i>
                </button>

                @php($cart = \Cart::session(request()->session()->get('_token')))
                @php($cart_items = $cart->getContent())
                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <span class="cart-count">{{$cart_items->count()}}</span>
                    </a>

                    <div class="dropdown-menu">
                        <div class="dropdownmenu-wrapper">
                            <div class="dropdown-cart-products">
                                @foreach($cart_items as $item)
                                    <div class="product">
                                        <div class="product-details">
                                            <h4 class="product-title">
                                                <a href="{{route('buyer.products.show', [$item->model->id])}}">{{$item->name}}</a>
                                            </h4>

                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">{{$item->quantity}}</span> x Rs. {{$item->price}}
                                            </span>
                                        </div>
                                        <!-- End .product-details -->

                                        <figure class="product-image-container">
                                            <a href="{{route('buyer.products.show', [$item->model->id])}}" class="product-image">
                                                <img src="{{str_replace("public","/storage",$item->model->featured_image)}}" alt="product">
                                            </a>
                                            <a href="{{route('buyer.products.cart.create', [$item->model->id, 'remove'])}}" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a>
                                        </figure>
                                    </div>
                                @endforeach
                            </div>
                            <!-- End .cart-product -->

                            <div class="dropdown-cart-total">
                                <span>Total</span>

                                <span class="cart-total-price">Rs. {{\Cart::session(request()->session()->get('_token'))->getSubTotal()}}</span>
                            </div>
                            <!-- End .dropdown-cart-total -->

                            <div class="dropdown-cart-action">
                                <a href="{{route('buyer.cart.index')}}" class="btn">View Cart</a>
                                <a href="{{route('buyer.checkout.shipping.get')}}" class="btn">Checkout</a>
                            </div>
                            <!-- End .dropdown-cart-total -->
                        </div>
                        <!-- End .dropdownmenu-wrapper -->
                    </div>
                    <!-- End .dropdown-menu -->
                </div>
                <!-- End .dropdown -->
            </div>
            <!-- End .header-right -->
        </div>
        <!-- End .container -->
    </div>
    <!-- End .header-middle -->
    <div class="sticky-wrapper">
        <div class="sticky-wrapper">
            <div class="header-bottom sticky-header">
                <div class="container">
                    <a href="{{url('/')}}" class="logo">
                        <img src="/assets1/images/logo.png" alt="GharPey Logo" width="101" height="41">
                    </a>
                    <div class="dropdown cart-dropdown">
                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                            <span class="cart-count">{{$cart_items->count()}}</span>
                        </a>

                        <div class="dropdown-menu">
                            <div class="dropdownmenu-wrapper">
                                <div class="dropdown-cart-products">
                                    @foreach($cart_items as $item)
                                        <div class="product">
                                            <div class="product-details">
                                                <h4 class="product-title">
                                                    <a href="{{route('buyer.products.show', [$item->model->id])}}">{{$item->name}}</a>
                                                </h4>

                                                <span class="cart-product-info">
                                                <span class="cart-product-qty">{{$item->quantity}}</span> x Rs. $item->price}}
                                            </span>
                                            </div>
                                            <!-- End .product-details -->

                                            <figure class="product-image-container">
                                                <a href="{{route('buyer.products.show', [$item->model->id])}}" class="product-image">
                                                    <img src="{{str_replace("public","/storage",$item->model->featured_image)}}" alt="product">
                                                </a>
                                                <a href="{{route('buyer.products.cart.create', [$item->model->id, 'remove'])}}" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a>
                                            </figure>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- End .cart-product -->

                                <div class="dropdown-cart-total">
                                    <span>Total</span>

                                    <span class="cart-total-price">Rs. w{{\Cart::session(request()->session()->get('_token'))->getSubTotal()}}</span>
                                </div>
                                <!-- End .dropdown-cart-total -->

                                <div class="dropdown-cart-action">
                                    <a href="{{route('buyer.cart.index')}}" class="btn">View Cart</a>
                                    <a href="{{route('buyer.checkout.shipping.get')}}" class="btn">Checkout</a>
                                </div>
                                <!-- End .dropdown-cart-total -->
                            </div>
                            <!-- End .dropdownmenu-wrapper -->
                        </div>
                        <!-- End .dropdown-menu -->
                    </div>
                    <nav class="main-nav">
                        <ul class="menu sf-arrows sf-js-enabled" style="touch-action: auto;">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><a href="{{route('buyer.products.index')}}">Products</a></li>
                            <li><a href="{{route('buyer.services.index')}}">Services</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- End .header-bottom -->
            </div>
        </div>
    </div>
</header>
