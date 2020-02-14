@extends('buyer.layouts.app')

@section('content')
        <nav aria-label="breadcrumb" class="breadcrumb-nav mt-5">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Electronics</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Headsets</li>
                </ol>
            </div><!-- End .container -->
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="product-single-container product-single-default">
                        <div class="row">
                            <div class="col-lg-7 col-md-6 product-single-gallery">
                                <div class="product-slider-container product-item">
                                    <div class="product-single-carousel owl-carousel owl-theme">
                                        <div class="product-item">
                                            <img class="product-single-image" src="{{str_replace("public","/storage",$product->featured_image)}}" data-zoom-image="assets/images/products/zoom/product-1-big.jpg"/>
                                        </div>
{{--                                        <div class="product-item">--}}
{{--                                            <img class="product-single-image" src="assets/images/products/zoom/product-2.jpg" data-zoom-image="assets/images/products/zoom/product-2-big.jpg"/>--}}
{{--                                        </div>--}}
{{--                                        <div class="product-item">--}}
{{--                                            <img class="product-single-image" src="assets/images/products/zoom/product-3.jpg" data-zoom-image="assets/images/products/zoom/product-3-big.jpg"/>--}}
{{--                                        </div>--}}
{{--                                        <div class="product-item">--}}
{{--                                            <img class="product-single-image" src="assets/images/products/zoom/product-4.jpg" data-zoom-image="assets/images/products/zoom/product-4-big.jpg"/>--}}
{{--                                        </div>--}}
                                    </div>
                                    <!-- End .product-single-carousel -->
                                    <span class="prod-full-screen">
                                            <i class="icon-plus"></i>
                                        </span>
                                </div>
                                <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
                                    <div class="col-3 owl-dot">
                                        <img src="{{str_replace("public","/storage",$product->featured_image)}}"/>
                                    </div>
{{--                                    <div class="col-3 owl-dot">--}}
{{--                                        <img src="assets/images/products/zoom/product-2.jpg"/>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-3 owl-dot">--}}
{{--                                        <img src="assets/images/products/zoom/product-3.jpg"/>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-3 owl-dot">--}}
{{--                                        <img src="assets/images/products/zoom/product-4.jpg"/>--}}
{{--                                    </div>--}}
                                </div>
                            </div><!-- End .col-lg-7 -->

                            <div class="col-lg-5 col-md-6">
                                <div class="product-single-details">
                                    <h1 class="product-title m-0" style="line-height: normal;">{{$product->name}}</h1>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:60%"></span><!-- End .ratings -->
                                        </div><!-- End .product-ratings -->

                                        <a href="#" class="rating-link">( 6 Reviews )</a>
                                    </div><!-- End .product-container -->

                                    <div class="price-box">
{{--                                        <span class="old-price">$81.00</span>--}}
                                        <span class="product-price">Rs. {{$product->price}}</span>
                                    </div><!-- End .price-box -->

                                    <div class="product-desc">
                                        <p>{{$product->description}}</p>
                                    </div><!-- End .product-desc -->

{{--                                    <div class="product-filters-container">--}}
{{--                                        <div class="product-single-filter">--}}
{{--                                            <label>Colors:</label>--}}
{{--                                            <ul class="config-swatch-list">--}}
{{--                                                <li class="active">--}}
{{--                                                    <a href="#" style="background-color: #6085a5;"></a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" style="background-color: #ab6e6e;"></a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" style="background-color: #b19970;"></a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" style="background-color: #11426b;"></a>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </div><!-- End .product-single-filter -->--}}
{{--                                    </div><!-- End .product-filters-container -->--}}

                                    <div class="product-action product-all-icons">
                                        <div class="product-single-qty">
                                            <input class="horizontal-quantity form-control" type="text">
                                        </div><!-- End .product-single-qty -->

                                        <a href="cart.html" class="paction add-cart" title="Add to Cart">
                                            <span>Add to Cart</span>
                                        </a>
                                        <a href="#" class="paction add-wishlist" title="Add to Wishlist">
                                            <span>Add to Wishlist</span>
                                        </a>
                                    </div><!-- End .product-action -->

                                    <div class="product-single-share">
                                        <label>Share:</label>
                                        <!-- www.addthis.com share plugin-->
                                        <div class="addthis_inline_share_toolbox"></div>
                                    </div><!-- End .product single-share -->
                                </div><!-- End .product-single-details -->
                            </div><!-- End .col-lg-5 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-single-container -->

                    <div class="product-single-tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="true">Description</a>
                            </li>
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" id="product-tab-tags" data-toggle="tab" href="#product-tags-content" role="tab" aria-controls="product-tags-content" aria-selected="false">Tags</a>--}}
{{--                            </li>--}}
                            <li class="nav-item">
                                <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab" aria-controls="product-reviews-content" aria-selected="false">Reviews</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                                <div class="product-desc-content">
                                    <p>{{$product->description}}</p>
                                </div><!-- End .product-desc-content -->
                            </div><!-- End .tab-pane -->

{{--                            <div class="tab-pane fade" id="product-tags-content" role="tabpanel" aria-labelledby="product-tab-tags">--}}
{{--                                <div class="product-tags-content">--}}
{{--                                    <form action="#">--}}
{{--                                        <h4>Add Your Tags:</h4>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <input type="text" class="form-control form-control-sm" required>--}}
{{--                                            <input type="submit" class="btn btn-primary" value="Add Tags">--}}
{{--                                        </div><!-- End .form-group -->--}}
{{--                                    </form>--}}
{{--                                    <p class="note">Use spaces to separate tags. Use single quotes (') for phrases.</p>--}}
{{--                                </div><!-- End .product-tags-content -->--}}
{{--                            </div><!-- End .tab-pane -->--}}

                            <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                                <div class="product-reviews-content">
                                    <div class="collateral-box">
                                        <ul>
                                            <li>Be the first to review this product</li>
                                        </ul>
                                    </div><!-- End .collateral-box -->

                                    <div class="add-product-review">
                                        <h3 class="text-uppercase heading-text-color font-weight-semibold">WRITE YOUR OWN REVIEW</h3>
                                        <p>How do you rate this product? *</p>

                                        <form action="#">
                                            <table class="ratings-table">
                                                <thead>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>1 star</th>
                                                    <th>2 stars</th>
                                                    <th>3 stars</th>
                                                    <th>4 stars</th>
                                                    <th>5 stars</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Quality</td>
                                                    <td>
                                                        <input type="radio" name="ratings[1]" id="Quality_1" value="1" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="ratings[1]" id="Quality_2" value="2" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="ratings[1]" id="Quality_3" value="3" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="ratings[1]" id="Quality_4" value="4" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="ratings[1]" id="Quality_5" value="5" class="radio">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Value</td>
                                                    <td>
                                                        <input type="radio" name="value[1]" id="Value_1" value="1" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="value[1]" id="Value_2" value="2" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="value[1]" id="Value_3" value="3" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="value[1]" id="Value_4" value="4" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="value[1]" id="Value_5" value="5" class="radio">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Price</td>
                                                    <td>
                                                        <input type="radio" name="price[1]" id="Price_1" value="1" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="price[1]" id="Price_2" value="2" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="price[1]" id="Price_3" value="3" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="price[1]" id="Price_4" value="4" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="price[1]" id="Price_5" value="5" class="radio">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <div class="form-group">
                                                <label>Nickname <span class="required">*</span></label>
                                                <input type="text" class="form-control form-control-sm" required>
                                            </div><!-- End .form-group -->
                                            <div class="form-group">
                                                <label>Summary of Your Review <span class="required">*</span></label>
                                                <input type="text" class="form-control form-control-sm" required>
                                            </div><!-- End .form-group -->
                                            <div class="form-group mb-2">
                                                <label>Review <span class="required">*</span></label>
                                                <textarea cols="5" rows="6" class="form-control form-control-sm"></textarea>
                                            </div><!-- End .form-group -->

                                            <input type="submit" class="btn btn-primary" value="Submit Review">
                                        </form>
                                    </div><!-- End .add-product-review -->
                                </div><!-- End .product-reviews-content -->
                            </div><!-- End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .product-single-tabs -->
                </div><!-- End .col-lg-9 -->

                <div class="sidebar-overlay"></div>
                <div class="sidebar-toggle"><i class="icon-sliders"></i></div>
                <aside class="sidebar-product col-lg-3 padding-left-lg mobile-sidebar">
                    <div class="sidebar-wrapper">
{{--                        <div class="widget widget-brand">--}}
{{--                            <a href="#">--}}
{{--                                <img src="assets/images/product-brand.png" alt="brand name">--}}
{{--                            </a>--}}
{{--                        </div><!-- End .widget -->--}}

                        <div class="widget widget-info">
                            <ul>
                                <li>
                                    <i class="icon-shipping"></i>
                                    <h4>FREE<br>SHIPPING</h4>
                                </li>
                                <li>
                                    <i class="icon-us-dollar"></i>
                                    <h4>100% MONEY<br>BACK GUARANTEE</h4>
                                </li>
                                <li>
                                    <i class="icon-online-support"></i>
                                    <h4>ONLINE<br>SUPPORT 24/7</h4>
                                </li>
                            </ul>
                        </div><!-- End .widget -->

                        <div class="widget widget-banner">
                            <div class="banner banner-image">
                                <a href="#">
                                    <img src="assets/images/banners/banner-sidebar.jpg" alt="Banner Desc">
                                </a>
                            </div><!-- End .banner -->
                        </div><!-- End .widget -->

                        <div class="widget widget-featured">
                            <h3 class="widget-title">Featured Products</h3>

                            <div class="widget-body">
                                <div class="owl-carousel widget-featured-products">
                                    <div class="featured-col">
                                        <div class="product product-sm">
                                            <figure class="product-image-container">
                                                <a href="product.html" class="product-image">
                                                    <img src="assets/images/products/small/product-1.jpg" alt="product">
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h2 class="product-title">
                                                    <a href="product.html">Mouse</a>
                                                </h2>
                                                <div class="ratings-container">
                                                    <div class="product-ratings">
                                                        <span class="ratings" style="width:80%"></span><!-- End .ratings -->
                                                    </div><!-- End .product-ratings -->
                                                </div><!-- End .product-container -->
                                                <div class="price-box">
                                                    <span class="product-price">$45.00</span>
                                                </div><!-- End .price-box -->
                                            </div><!-- End .product-details -->
                                        </div><!-- End .product -->

                                        <div class="product product-sm">
                                            <figure class="product-image-container">
                                                <a href="product.html" class="product-image">
                                                    <img src="assets/images/products/home-featured-1.jpg" alt="product">
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h2 class="product-title">
                                                    <a href="product.html">Headset</a>
                                                </h2>
                                                <div class="ratings-container">
                                                    <div class="product-ratings">
                                                        <span class="ratings" style="width:20%"></span><!-- End .ratings -->
                                                    </div><!-- End .product-ratings -->
                                                </div><!-- End .product-container -->
                                                <div class="price-box">
                                                    <span class="old-price">$60.00</span>
                                                    <span class="product-price">$45.00</span>
                                                </div><!-- End .price-box -->
                                            </div><!-- End .product-details -->
                                        </div><!-- End .product -->

                                        <div class="product product-sm">
                                            <figure class="product-image-container">
                                                <a href="product.html" class="product-image">
                                                    <img src="assets/images/products/home-featured-2.jpg" alt="product">
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h2 class="product-title">
                                                    <a href="product.html">Technicca</a>
                                                </h2>
                                                <div class="ratings-container">
                                                    <div class="product-ratings">
                                                        <span class="ratings" style="width:100%"></span><!-- End .ratings -->
                                                    </div><!-- End .product-ratings -->
                                                </div><!-- End .product-container -->
                                                <div class="price-box">
                                                    <span class="product-price">$50.00</span>
                                                </div><!-- End .price-box -->
                                            </div><!-- End .product-details -->
                                        </div><!-- End .product -->
                                    </div><!-- End .featured-col -->

                                    <div class="featured-col">
                                        <div class="product product-sm">
                                            <figure class="product-image-container">
                                                <a href="product.html" class="product-image">
                                                    <img src="assets/images/products/home-featured-3.jpg" alt="product">
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h2 class="product-title">
                                                    <a href="product.html">Skullcanddy</a>
                                                </h2>
                                                <div class="ratings-container">
                                                    <div class="product-ratings">
                                                        <span class="ratings" style="width:100%"></span><!-- End .ratings -->
                                                    </div><!-- End .product-ratings -->
                                                </div><!-- End .product-container -->
                                                <div class="price-box">
                                                    <span class="old-price">$50.00</span>
                                                    <span class="product-price">$35.00</span>
                                                </div><!-- End .price-box -->
                                            </div><!-- End .product-details -->
                                        </div><!-- End .product -->

                                        <div class="product product-sm">
                                            <figure class="product-image-container">
                                                <a href="product.html" class="product-image">
                                                    <img src="assets/images/products/home-featured-4.jpg" alt="product">
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h2 class="product-title">
                                                    <a href="product.html">Phillips</a>
                                                </h2>
                                                <div class="ratings-container">
                                                    <div class="product-ratings">
                                                        <span class="ratings" style="width:60%"></span><!-- End .ratings -->
                                                    </div><!-- End .product-ratings -->
                                                </div><!-- End .product-container -->
                                                <div class="price-box">
                                                    <span class="product-price">$29.00</span>
                                                </div><!-- End .price-box -->
                                            </div><!-- End .product-details -->
                                        </div><!-- End .product -->

                                        <div class="product product-sm">
                                            <figure class="product-image-container">
                                                <a href="product.html" class="product-image">
                                                    <img src="assets/images/products/home-featured-5.jpg" alt="product">
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h2 class="product-title">
                                                    <a href="product.html">Senheisser</a>
                                                </h2>
                                                <div class="ratings-container">
                                                    <div class="product-ratings">
                                                        <span class="ratings" style="width:20%"></span><!-- End .ratings -->
                                                    </div><!-- End .product-ratings -->
                                                </div><!-- End .product-container -->
                                                <div class="price-box">
                                                    <span class="product-price">$40.00</span>
                                                </div><!-- End .price-box -->
                                            </div><!-- End .product-details -->
                                        </div><!-- End .product -->
                                    </div><!-- End .featured-col -->
                                </div><!-- End .widget-featured-slider -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .widget -->
                    </div>
                </aside><!-- End .col-md-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

        <div class="featured-section">
            <div class="container">
                <h2 class="carousel-title">Featured Products</h2>

                <div class="featured-products owl-carousel owl-theme owl-dots-top">
                    <div class="product">
                        <figure class="product-image-container">
                            <a href="product.html" class="product-image">
                                <img src="assets/images/products/product-1.jpg" alt="product">
                            </a>
                            <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>
                        </figure>
                        <div class="product-details">
                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:80%"></span><!-- End .ratings -->
                                </div><!-- End .product-ratings -->
                            </div><!-- End .product-container -->
                            <h2 class="product-title">
                                <a href="product.html">Pen drive</a>
                            </h2>
                            <div class="price-box">
                                <span class="product-price">$189.00</span>
                            </div><!-- End .price-box -->

                            <div class="product-action">
                                <a href="#" class="paction add-wishlist" title="Add to Wishlist">
                                    <span>Add to Wishlist</span>
                                </a>

                                <a href="product.html" class="paction add-cart" title="Add to Cart">
                                    <span>Add to Cart</span>
                                </a>

                                <a href="#" class="paction add-compare" title="Add to Compare">
                                    <span>Add to Compare</span>
                                </a>
                            </div><!-- End .product-action -->
                        </div><!-- End .product-details -->
                    </div><!-- End .product -->

                    <div class="product">
                        <figure class="product-image-container">
                            <a href="product.html" class="product-image">
                                <img src="assets/images/products/product-2.jpg" alt="product">
                            </a>
                            <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>
                        </figure>
                        <div class="product-details">
                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:100%"></span><!-- End .ratings -->
                                </div><!-- End .product-ratings -->
                            </div><!-- End .product-container -->
                            <h2 class="product-title">
                                <a href="product.html">Headphone</a>
                            </h2>
                            <div class="price-box">
                                <span class="product-price">$55.00</span>
                            </div><!-- End .price-box -->

                            <div class="product-action">
                                <a href="#" class="paction add-wishlist" title="Add to Wishlist">
                                    <span>Add to Wishlist</span>
                                </a>

                                <a href="product.html" class="paction add-cart" title="Add to Cart">
                                    <span>Add to Cart</span>
                                </a>

                                <a href="#" class="paction add-compare" title="Add to Compare">
                                    <span>Add to Compare</span>
                                </a>
                            </div><!-- End .product-action -->
                        </div><!-- End .product-details -->
                    </div><!-- End .product -->

                    <div class="product">
                        <figure class="product-image-container">
                            <a href="product.html" class="product-image">
                                <img src="assets/images/products/product-3.jpg" alt="product">
                            </a>
                            <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>
                        </figure>
                        <div class="product-details">
                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:40%"></span><!-- End .ratings -->
                                </div><!-- End .product-ratings -->
                            </div><!-- End .product-container -->
                            <h2 class="product-title">
                                <a href="product.html">Computer Mouse</a>
                            </h2>
                            <div class="price-box">
                                <span class="product-price">$31.00</span>
                            </div><!-- End .price-box -->

                            <div class="product-action">
                                <a href="#" class="paction add-wishlist" title="Add to Wishlist">
                                    <span>Add to Wishlist</span>
                                </a>

                                <a href="product.html" class="paction add-cart" title="Add to Cart">
                                    <span>Add to Cart</span>
                                </a>

                                <a href="#" class="paction add-compare" title="Add to Compare">
                                    <span>Add to Compare</span>
                                </a>
                            </div><!-- End .product-action -->
                        </div><!-- End .product-details -->
                    </div><!-- End .product -->

                    <div class="product">
                        <figure class="product-image-container">
                            <a href="product.html" class="product-image">
                                <img src="assets/images/products/product-4.jpg" alt="product">
                            </a>
                            <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>
                        </figure>
                        <div class="product-details">
                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:0%"></span><!-- End .ratings -->
                                </div><!-- End .product-ratings -->
                            </div><!-- End .product-container -->
                            <h2 class="product-title">
                                <a href="product.html">Camera</a>
                            </h2>
                            <div class="price-box">
                                <span class="product-price">$335.00</span>
                            </div><!-- End .price-box -->

                            <div class="product-action">
                                <a href="#" class="paction add-wishlist" title="Add to Wishlist">
                                    <span>Add to Wishlist</span>
                                </a>

                                <a href="product.html" class="paction add-cart" title="Add to Cart">
                                    <span>Add to Cart</span>
                                </a>

                                <a href="#" class="paction add-compare" title="Add to Compare">
                                    <span>Add to Compare</span>
                                </a>
                            </div><!-- End .product-action -->
                        </div><!-- End .product-details -->
                    </div><!-- End .product -->

                    <div class="product">
                        <figure class="product-image-container">
                            <a href="product.html" class="product-image">
                                <img src="assets/images/products/product-5.jpg" alt="product">
                            </a>
                            <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>
                        </figure>
                        <div class="product-details">
                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:50%"></span><!-- End .ratings -->
                                </div><!-- End .product-ratings -->
                            </div><!-- End .product-container -->
                            <h2 class="product-title">
                                <a href="product.html">Leather Boots</a>
                            </h2>
                            <div class="price-box">
                                <span class="product-price">$60.00</span>
                            </div><!-- End .price-box -->

                            <div class="product-action">
                                <a href="#" class="paction add-wishlist" title="Add to Wishlist">
                                    <span>Add to Wishlist</span>
                                </a>

                                <a href="product.html" class="paction add-cart" title="Add to Cart">
                                    <span>Add to Cart</span>
                                </a>

                                <a href="#" class="paction add-compare" title="Add to Compare">
                                    <span>Add to Compare</span>
                                </a>
                            </div><!-- End .product-action -->
                        </div><!-- End .product-details -->
                    </div><!-- End .product -->
                </div><!-- End .featured-proucts -->
            </div><!-- End .container -->
        </div><!-- End .featured-section -->
@endsection
