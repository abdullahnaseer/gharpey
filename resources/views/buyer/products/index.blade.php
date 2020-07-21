@extends('buyer.layouts.app')

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{route('buyer.products.index')}}">Products</a></li>
                @unless(is_null($category))
                    <li class="breadcrumb-item">{{$category->name}}</li>
                @endunless
            </ol>
        </div>
        <!-- End .container -->
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                @if($products->count())
                    <div class="row row-sm">
                        @foreach($products as $product)
                            <div class="col-6 col-md-4">
                                <div class="product">
                                    <figure class="product-image-container">
                                        <a href="{{route('buyer.products.show', [$product->slug])}}"
                                           class="product-image">
                                            <img src="{{str_replace("public","/storage",$product->featured_image)}}"
                                                 alt="product">
                                        </a>
                                        {{--                                    <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>--}}
                                    </figure>
                                    <div class="product-details">
                                        <div class="ratings-container">
                                            <div class="product-ratings">
                                                <span class="ratings"
                                                      style="width:{{$product->reviews_average * 20}}%"></span>
                                                <!-- End .ratings -->
                                            </div>
                                            <!-- End .product-ratings -->
                                            <a href="#" class="rating-link">( {{ $product->reviews_count }} Reviews
                                                )</a>
                                        </div>
                                        <!-- End .product-container -->
                                        <h2 class="product-title ">
                                            <a href="{{route('buyer.products.show', [$product->slug])}}">
                                                {{$product->name}} </a>
                                        </h2>

                                        <div class="price-box  m-b-5">
                                            <span class="product-price">Rs. {{$product->price}}</span>
                                        </div>
                                        <p class="product-location text-center m-b-5">
                                            <img src="/assets1/images/svg/shop/shop.svg" class="mr-2 d-inline-block"
                                                 width="15" alt="">

                                            <a href="{{route('buyer.shop.show', [$product->seller->shop_slug])}}">{{$product->seller->shop_name}}</a>
                                        </p>

                                        <div class="product-action ml-5">
                                            @if(is_null($product->cart_item))
                                                <a href="{{route('buyer.products.cart.create', [$product->id])}}"
                                                   class="paction add-cart" title="Add to Cart">
                                                    <span>Add to Cart</span>
                                                </a>
                                            @else
                                                <a href="{{route('buyer.products.cart.create', [$product->id, 'remove'])}}"
                                                   class="paction add-cart" title="Add to Cart">
                                                    <span>Remove from Cart</span>
                                                </a>
                                            @endif

                                            @if(auth('buyer')->check())
                                                @php($condition = auth('buyer')->user()->hasWish($product->id))
                                                <a href="{{route('buyer.products.wishlist.create', [$product->id])}}"
                                                   class="paction add-wishlist"
                                                   title="{{$condition ? "Remove from" : "Add to"}} Wishlist"
                                                   @if($condition) style="background-color: #9a2693;color: white;" @endif
                                                >
                                                    <span>{{$condition ? "Remove from" : "Add to"}} Wishlist</span>
                                                </a>
                                            @endif
                                        </div>
                                        <!-- End .product-action -->
                                    </div>
                                    <!-- End .product-details -->
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $products->links() }}
                @else
                    <div class="alert alert-info">No Products found!!!</div>
                @endif
            </div>

            <aside class="sidebar-shop col-lg-3 order-lg-first">
                <div class="sidebar-wrapper">
                    <div class="widget">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-1" role="button" aria-expanded="true"
                               aria-controls="widget-body-1">Categories</a>
                        </h3>

                        <div class="collapse show" id="widget-body-1">
                            <div class="widget-body">
                                <ul class="cat-list">
                                    @foreach($categories as $category)
                                        <li><a href="{{route('buyer.products.index', [
                                            'category' => $category->id,
                                            'price-min' => request()->input('price-min', 100),
                                            'price-max' => request()->input('price-max', 10000),
                                            'q' => request()->input('q'),
                                        ])}}">{{$category->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- End .widget-body -->
                        </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->

                    <div class="widget">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true"
                               aria-controls="widget-body-2">Price</a>
                        </h3>

                        <div class="collapse show" id="widget-body-2">
                            <div class="widget-body">
                                <form action="{{route('buyer.products.index')}}" onsubmit="handlePriceFilterForm()"
                                      id="form-price">
                                    @if(request()->has('category'))
                                        <input type="hidden" name="category" value="{{request()->input('category')}}">
                                    @endif

                                    @if(request()->has('q'))
                                        <input type="hidden" name="q" value="{{request()->input('q')}}"/>
                                    @endif

                                    <input type="hidden" name="price-min" id="input-price-min"
                                           value="{{request()->input('price-min', 100)}}"/>
                                    <input type="hidden" name="price-max" id="input-price-max"
                                           value="{{request()->input('price-max', 10000)}}"/>

                                    <div class="price-slider-wrapper">
                                        <div id="price-slider"></div>
                                        <!-- End #price-slider -->
                                    </div>
                                    <!-- End .price-slider-wrapper -->

                                    <div class="filter-price-action">
                                        <button type="submit" class="btn btn-primary"
                                                onclick="return handlePriceFilterForm();">Filter
                                        </button>

                                        <div class="filter-price-text">
                                            <span id="filter-price-range"></span>
                                        </div>
                                        <!-- End .filter-price-text -->
                                    </div>
                                    <!-- End .filter-price-action -->
                                </form>
                            </div>
                            <!-- End .widget-body -->
                        </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->

                </div>
                <!-- End .sidebar-wrapper -->
            </aside>
            <!-- End .col-lg-3 -->
        </div>
        <!-- End .row -->
    </div>
    <!-- End .container -->

    <div class="mb-5"></div>
    <!-- End .main -->
@endsection

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            var inputPriceMin = document.getElementById('input-price-min');
            var inputPriceMax = document.getElementById('input-price-max');
            document.getElementById("price-slider").noUiSlider
                .set([inputPriceMin.value, inputPriceMax.value]);
        });

        function handlePriceFilterForm() {
            var inputPriceMin = $('input#input-price-min');
            var inputPriceMax = $('input#input-price-max');

            var prices = document.getElementById("price-slider").noUiSlider.get();

            inputPriceMin.val(prices[0]);
            inputPriceMax.val(prices[1]);

            // return false;
            document.getElementById("price-form").submit();

        }
    </script>
@endsection
