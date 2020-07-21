@extends('moderator.layouts.dashboard', ['page_title' => "Service Requests"])


@section('breadcrumb')
    <a href="{{ route('moderator.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Product Orders</span>
@endsection

@section('breadcrumb-elements')
    <div class="kt-input-icon kt-input-icon--left">
        <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
        <span class="kt-input-icon__icon kt-input-icon__icon--left">
            <span><i class="la la-search"></i></span>
        </span>
    </div>
@endsection

@push('styles')

@endpush

@section('content')
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-user"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Product Order Details
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="table-responsive">
                <table class="table table-light table-bordered">
                    <tbody>
                    <tr>
                        <th width="150">Name</th>
                        <td>{{$order->product->name}}</td>
                    </tr>
                    <tr>
                        <th width="150">Status</th>
                        <td>
                            @if($order->status == \App\Models\ProductOrder::STATUS_COMPLETED)
                                <p>
                                    <span class="badge badge-success">Completed</span>
                                    @if(is_null($order->reviewed_at))
                                        <span class="badge badge-info">Review Pending</span>
                                    @else
                                        <span class="badge badge-success">Reviewed</span>
                                    @endif
                                </p>
                            @elseif($order->status == \App\Models\ProductOrder::STATUS_CANCELED)
                                <p><span class="badge badge-danger">Cancelled</span></p>
                            @elseif($order->status == \App\Models\ProductOrder::STATUS_CONFIRMED
                                    || $order->status == \App\Models\ProductOrder::STATUS_SELLER_SENT)
                                <p><span class="badge badge-info">Confirmed</span></p>
                            @elseif($order->status == \App\Models\ProductOrder::STATUS_WAREHOUSE_RECEVIED)
                                <p><span class="badge badge-info">In Processing</span></p>
                            @elseif($order->status == \App\Models\ProductOrder::STATUS_SENT)
                                <p><span class="badge badge-info">In Delivery</span></p>
                            @else
                                <p><span class="badge badge-info">{{$order->status}}</span></p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th width="150">Receipt Email</th>
                        <td><a href="mailto:{{$order->receipt_email}}">{{$order->order->receipt_email}}</a></td>
                    </tr>
                    <tr>
                        <th width="150">Shipping Phone</th>
                        <td><a href="tel:{{$order->shipping_phone}}">{{$order->order->shipping_phone}}</a></td>
                    </tr>
                    <tr>
                        <th width="150">Shipping Address</th>
                        <td>{{$order->order->shipping_address}}</td>
                    </tr>
                    <tr>
                        <th width="150">Shipping Area</th>
                        <td>{{$order->order->location ? $order->location->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Shipping City</th>
                        <td>{{$order->order->location && $order->location->city ? $order->location->city->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Shipping State</th>
                        <td>{{$order->location && $order->location->city && $order->location->city->state ? $order->location->city->state->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Product Price</th>
                        <td>{{$order->price}}</td>
                    </tr>
                    <tr>
                        <th width="150">Product Quantity</th>
                        <td>{{$order->quantity}}</td>
                    </tr>
                    <tr>
                        <th width="150">Product Current Price</th>
                        <td>{{$order->product->price}}</td>
                    </tr>
                    <tr>
                        <th width="150">Product Featured Image</th>
                        <td><img class="img-thumbnail"
                                 src="{{$order->product->featured_image != null ? str_replace('public', 'storage', $order->product->featured_image): ''}}">
                        </td>
                    </tr>
                    <tr>
                        <th width="150">Product Description</th>
                        <td>{{$order->product->short_description}}</td>
                    </tr>
                    <tr>
                        <th width="150">Seller Name</th>
                        <td>{{$order->product->seller->name}}</td>
                    </tr>
                    <tr>
                        <th width="150">Seller Email</th>
                        <td><a href="mailto:{{$order->product->seller->email}}">{{$order->product->seller->email}}</td>
                    </tr>
                    <tr>
                        <th width="150">Seller Email</th>
                        <td><a href="tel:{{$order->product->seller->phone}}">{{$order->product->seller->phone}}</td>
                    </tr>
                    <tr>
                        <th width="150">Seller CNIC</th>
                        <td>{{$order->product->seller->cnic}}</td>
                    </tr>
                    <tr>
                        <th width="150">Seller Shop Name</th>
                        <td>{{$order->product->seller->shop_name}}</td>
                    </tr>
                    <tr>
                        <th width="150">Note</th>
                        <td>{{$order->note}}</td>
                    </tr>
                    <tr>
                        <th width="150">Completed At</th>
                        <td>{{$order->completed_at != null ? \Illuminate\Support\Carbon::parse($order->completed_at)->format('M d, Y'): ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Cancelled At</th>
                        <td>{{$order->canceled_at != null ? \Illuminate\Support\Carbon::parse($order->canceled_at)->format('M d, Y'): ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Confirmed At</th>
                        <td>{{$order->confirmed_at != null ? \Illuminate\Support\Carbon::parse($order->confirmed_at)->format('M d, Y'): ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Reviewed At</th>
                        <td>{{$order->reviewed_at != null ? \Illuminate\Support\Carbon::parse($order->reviewed_at)->format('M d, Y'): ''}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
