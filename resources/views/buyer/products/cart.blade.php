@extends('buyer.layouts.app')

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div>
        <!-- End .container -->
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <form action="{{route('buyer.cart.store')}}" method="POST">
                    @csrf
                    <div class="cart-table-container">
                        <table class="table table-cart">
                            <thead>
                            <tr>
                                <th class="product-col">Product</th>
                                <th class="price-col">Price</th>
                                <th class="qty-col">Qty</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($cart_items->count())
                                @foreach($cart_items as $item)
                                <tr class="product-row">
                                    <td class="product-col">
                                        <figure class="product-image-container">
                                            <a href="{{route('buyer.products.show', [$item->model->slug])}}" class="product-image">
                                                <img src="{{str_replace("public","/storage",$item->model->featured_image)}}" alt="product">
                                            </a>
                                        </figure>
                                        <h2 class="product-title">
                                            <a href="{{route('buyer.products.show', [$item->model->slug])}}">{{$item->name}}</a>
                                        </h2>
                                    </td>
                                    <td>{{$item->price}}</td>
                                    <td>
                                        <input type="hidden" name="product_id[]" value="{{$item->id}}">
                                        <input class="vertical-quantity form-control" name="quantity[]" type="text" value="{{$item->quantity}}">
                                    </td>
                                    <td>{{$item->getPriceSum()}}</td>
                                </tr>
                                <tr class="product-action-row">
                                    <td colspan="4" class="clearfix">
                                        <div class="float-left">
                                            <a href="#" class="btn-move">Move to Wishlist</a>
                                        </div>
                                        <!-- End .float-left -->

                                        <div class="float-right">
{{--                                            <a href="#" title="Edit product" class="btn-edit"><span class="sr-only">Edit</span><i class="icon-pencil"></i></a>--}}
                                            <a href="{{route('buyer.products.cart.create', [$item->model->id, 'remove'])}}" title="Remove product" class="btn-remove"><span class="sr-only">Remove</span></a>
                                        </div>
                                        <!-- End .float-right -->
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>

                            <tfoot>

                            @unless($cart_items->count())
                                <tr>
                                    <td colspan="4" class="clearfix">
                                        <p class="text-info">No item found in cart.</p>
                                    </td>
                                </tr>
                            @endunless
                            <tr>
                                <td colspan="4" class="clearfix">
                                    <div class="float-left">
                                        <a href="{{route('buyer.products.index')}}" class="btn btn-outline-secondary">Continue Shopping</a>
                                    </div>

                                    @if($cart_items->count())
                                        <div class="float-right">
                                            <a href="{{route('buyer.cart.index', ['clear'])}}" class="btn btn-outline-secondary btn-clear-cart">Clear Shopping Cart</a>
                                            <button type="submit" class="btn btn-outline-secondary btn-update-cart">Update Shopping Cart</button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- End .cart-table-container -->
                </form>

                <div class="cart-discount">
                    <h4>Apply Discount Code</h4>
                    <form action="#">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" placeholder="Enter discount code" required>
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="submit">Apply Discount</button>
                            </div>
                        </div>
                        <!-- End .input-group -->
                    </form>
                </div>
                <!-- End .cart-discount -->
            </div>
            <!-- End .col-lg-8 -->

            <div class="col-lg-4">
                <div class="cart-summary">
                    <h3>Summary</h3>

                    <table class="table table-totals">
                        <tbody>
                        <tr>
                            <td>Subtotal</td>
                            <td>Rs. {{$cart->getSubTotal()}}</td>
                        </tr>

                        <tr>
                            <td>Tax</td>
                            <td>Rs. 0</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>Order Total</td>
                            <td>Rs. {{$cart->getTotal()}}</td>
                        </tr>
                        </tfoot>
                    </table>

                    <div class="checkout-methods">
                        <a href="checkout-shipping.html" class="btn btn-block btn-sm btn-primary">Go to Checkout</a>
                    </div>
                    <!-- End .checkout-methods -->
                </div>
                <!-- End .cart-summary -->
            </div>
            <!-- End .col-lg-4 -->
        </div>
        <!-- End .row -->
    </div>
    <!-- End .container -->

    <div class="mb-6"></div>
    <!-- margin -->
@endsection
