<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left header-dropdowns">

                <div class="dropdown compare-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        Welcome to Gharpey
                    </a>

                    <div class="dropdown-menu">
                        <div class="dropdownmenu-wrapper">
                            <ul class="compare-products">
                                <li class="product">
                                    <a href="#" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a>
                                    <h4 class="product-title"><a href="product.html">Lady White Top</a></h4>
                                </li>
                                <li class="product">
                                    <a href="#" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a>
                                    <h4 class="product-title"><a href="product.html">Blue Women Shirt</a></h4>
                                </li>
                            </ul>

                            <div class="compare-actions">
                                <a href="#" class="action-link">Clear All</a>
                                <a href="#" class="btn btn-primary">Compare</a>
                            </div>
                        </div>
                        <!-- End .dropdownmenu-wrapper -->
                    </div>
                    <!-- End .dropdown-menu -->
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
                                <li><a href="my-account.html">MY ACCOUNT </a></li>
                                <li><a href="#">MY WISHLIST </a></li>
                            @endauth
                            @guest('buyer')
                                <li><a href="{{route('buyer.register')}}">REGISTER</a></li>
                                <li><a href="{{route('buyer.login')}}">LOG IN</a></li>
                            @endguest
                        </ul>
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
                <a href="index.html" class="logo">
                    <img src="assets1/images/logo.png" style="height: 60px;" alt="">
                </a>
            </div>
            <!-- End .header-left -->

            <div class="header-center">
                <div class="header-search">
                    <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                    <form action="#" method="get">
                        <div class="header-search-wrapper">
                            <input type="search" class="form-control" name="q" id="q" placeholder="Search..." required="">
                            <div class="select-custom">
                                <select id="cat" name="cat">
                                    <option value="" class="" style="font-weight:900;">Islamabad</option>
                                    <option value="4" class="pl-5">Sector 1</option>
                                    <option value="12">Sector 2</option>
                                    <option value="13">Sector 3</option>
                                    <option value="66">Sector 4</option>
                                    <option value="" class="" style="font-weight:900;">Rawalpindi</option>
                                    <option value="12">Gulurg</option>
                                    <option value="13">DHA</option>
                                    <option value="66">Behria</option>

                                </select>
                            </div>
                            <!-- End .select-custom -->
                            <button class="btn" type="submit"><i class="icon-magnifier"></i></button>
                        </div>
                        <!-- End .header-search-wrapper -->
                    </form>
                </div>
                <!-- End .header-search -->
            </div>
            <!-- End .headeer-center -->

            <div class="header-right">
                <button class="mobile-menu-toggler" type="button">
                    <i class="icon-menu"></i>
                </button>

                @php($cart_items = \Cart::session(request()->session()->get('_token'))->getContent())
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
                                <a href="{{route('buyer.cart.index')}}" class="btn">Checkout</a>
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
                    <a href="index.html" class="logo">
                        <img src="assets1/images/logo.png" alt="Porto Logo" width="101" height="41">
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
                                    <a href="{{route('buyer.cart.index')}}" class="btn">Checkout</a>
                                </div>
                                <!-- End .dropdown-cart-total -->
                            </div>
                            <!-- End .dropdownmenu-wrapper -->
                        </div>
                        <!-- End .dropdown-menu -->
                    </div>
                    <nav class="main-nav">
                        <ul class="menu sf-arrows sf-js-enabled" style="touch-action: auto;">
                            <li><a href="index.html">Home</a></li>
                            <li>
                                <a href="category.html" class="sf-with-ul">Services</a>
                                <div class="megamenu megamenu-fixed-width" style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="menu-title">
                                                        <a href="#">Main Service<span class="tip tip-new">New!</span></a>
                                                    </div>
                                                    <ul>
                                                        <li><a href="category.html">SubService<span class="tip tip-hot">Hot!</span></a></li>
                                                        <li><a href="category.html">SubService</a></li>
                                                        <li><a href="category.html">SubService</a></li>
                                                        <li><a href="category.html">SubService</a></li>
                                                        <li><a href="category.html">SubService</a></li>
                                                        <li><a href="category.html">SubService</a></li>
                                                        <li><a href="category.html">SubService</a></li>

                                                    </ul>
                                                </div>
                                                <!-- End .col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="menu-title">
                                                        <a href="#">Main Service</a>
                                                    </div>
                                                    <ul>
                                                        <li><a href="category.html">SubService<span class="tip tip-hot">Hot!</span></a></li>
                                                        <li><a href="category.html">SubService</a></li>
                                                        <li><a href="category.html">SubService</a></li>
                                                        <li><a href="category.html">SubService</a></li>
                                                        <li><a href="category.html">SubService</a></li>
                                                        <li><a href="category.html">SubService</a></li>
                                                        <li><a href="category.html">SubService</a></li>
                                                    </ul>
                                                </div>
                                                <!-- End .col-lg-6 -->
                                            </div>
                                            <!-- End .row -->
                                        </div>
                                        <!-- End .col-lg-8 -->

                                        <!-- End .col-lg-4 -->
                                    </div>
                                </div>
                                <!-- End .megamenu -->
                            </li>
                            <li class="megamenu-container">
                                <a href="product.html" class="sf-with-ul">Products</a>
                                <div class="megamenu" style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="menu-title">
                                                        <a href="#">Products Catagory</a>
                                                    </div>
                                                    <ul>
                                                        <li><a href="product-main-page.html">Product Sub Catagory</a></li>
                                                        <li><a href="product-main-page.html">Product Sub Catagory</a></li>
                                                        <li><a href="product-main-page.html">Product Sub Catagory</a></li>
                                                        <li><a href="product-main-page.html">Product Sub Catagory</a></li>
                                                        <li><a href="product-main-page.html">Product Sub Catagory</a></li>
                                                        <li><a href="product-main-page.html">Product Sub Catagory</a></li>

                                                    </ul>
                                                </div>
                                                <!-- End .col-lg-4 -->
                                                <div class="col-lg-4">
                                                    <div class="menu-title">
                                                        <a href="#">Variations</a>
                                                    </div>
                                                    <ul>
                                                        <li><a href="product-sticky-tab.html">Sticky Tabs</a></li>
                                                        <li><a href="product-simple.html">Simple Product</a></li>
                                                        <li><a href="product-sidebar-left.html">With Left Sidebar</a></li>
                                                    </ul>
                                                </div>
                                                <!-- End .col-lg-4 -->
                                                <div class="col-lg-4">
                                                    <div class="menu-title">
                                                        <a href="#">Product Layout Types</a>
                                                    </div>
                                                    <ul>
                                                        <li><a href="product.html">Default Layout</a></li>
                                                        <li><a href="product-extended-layout.html">Extended Layout</a></li>
                                                        <li><a href="product-full-width.html">Full Width Layout</a></li>
                                                        <li><a href="product-grid-layout.html">Grid Images Layout</a></li>
                                                        <li><a href="product-sticky-both.html">Sticky Both Side Info<span class="tip tip-hot">Hot!</span></a></li>
                                                        <li><a href="product-sticky-info.html">Sticky Right Side Info</a></li>
                                                    </ul>
                                                </div>
                                                <!-- End .col-lg-4 -->
                                            </div>
                                            <!-- End .row -->
                                        </div>
                                        <!-- End .col-lg-8 -->
                                        <div class="col-lg-4">
                                            <div class="banner">
                                                <a href="#">
                                                    <img src="assets1/images/menu-banner.jpg" alt="Menu banner" class="product-promo">
                                                </a>
                                            </div>
                                            <!-- End .banner -->
                                        </div>
                                        <!-- End .col-lg-4 -->
                                    </div>
                                    <!-- End .row -->
                                </div>
                                <!-- End .megamenu -->
                            </li>
                            <li>
                                <a href="#" class="sf-with-ul">Pages</a>

                                <ul style="display: none;">
                                    <li><a href="cart.html">Shopping Cart</a></li>
                                    <li><a href="checkout-shipping.html">Checkout</a>

                                    </li>
                                    <li><a href="#" class="sf-with-ul">Dashboard</a>
                                        <ul style="display: none;">
                                            <li><a href="dashboard.html">Dashboard</a></li>
                                            <li><a href="my-account.html">My Account</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="#" class="login-link">Login</a></li>
                                    <li><a href="forgot-password.html">Forgot Password</a></li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>
                <!-- End .header-bottom -->
            </div>
        </div>
    </div>
</header>
