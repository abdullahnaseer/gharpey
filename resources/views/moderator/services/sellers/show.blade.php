@extends('moderator.layouts.dashboard', ['page_title' => "Service Seller Detail"])


@section('breadcrumb')
    <a href="{{ route('moderator.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Service Sellers</span>
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
                    Service Seller Details
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="table-responsive">
                <table class="table table-light table-bordered">
                    <tbody>
                    <tr>
                        <th width="150">Name</th>
                        <td>{{$request->service->name}}</td>
                    </tr>
                    <tr>
                        <th width="150">Receipt Email</th>
                        <td><a href="mailto:{{$request->receipt_email}}">{{$request->receipt_email}}</a></td>
                    </tr>
                    <tr>
                        <th width="150">Shipping Phone</th>
                        <td><a href="tel:{{$request->shipping_phone}}">{{$request->shipping_phone}}</a></td>
                    </tr>
                    <tr>
                        <th width="150">Shipping Address</th>
                        <td>{{$request->shipping_address}}</td>
                    </tr>
                    <tr>
                        <th width="150">Service Price</th>
                        <td>{{$request->service_seller->price}}</td>
                    </tr>
                    <tr>
                        <th width="150">Service Featured Image</th>
                        <td><img class="img-thumbnail"
                                 src="{{$request->service_seller->featured_image != null ? str_replace('public', 'storage', $request->service_seller->featured_image): ''}}">
                        </td>
                    </tr>
                    <tr>
                        <th width="150">Service Description</th>
                        <td>{{$request->service_seller->short_description}}</td>
                    </tr>
                    <tr>
                        <th width="150">Seller Name</th>
                        <td>{{$request->seller->name}}</td>
                    </tr>
                    <tr>
                        <th width="150">Seller Email</th>
                        <td><a href="mailto:{{$request->seller->email}}">{{$request->seller->email}}</td>
                    </tr>
                    <tr>
                        <th width="150">Seller Email</th>
                        <td><a href="tel:{{$request->seller->phone}}">{{$request->seller->phone}}</td>
                    </tr>
                    <tr>
                        <th width="150">Seller CNIC</th>
                        <td>{{$request->seller->cnic}}</td>
                    </tr>
                    <tr>
                        <th width="150">Seller Shop Name</th>
                        <td>{{$request->seller->shop_name}}</td>
                    </tr>
                    <tr>
                        <th width="150">Seller Warehouse Address</th>
                        <td>{{$request->seller->warehouse_address}}</td>
                    </tr>
                    <tr>
                        <th width="150">Price</th>
                        <td>{{$request->total_amount}}</td>
                    </tr>
                    <tr>
                        <th width="150">Note</th>
                        <td>{{$request->note}}</td>
                    </tr>
                    <tr>
                        <th width="150">Paid At</th>
                        <td>{{$request->paid_at != null ? \Illuminate\Support\Carbon::parse($request->paid_at)->format('M d Y'): ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Completed At</th>
                        <td>{{$request->completed_at != null ? \Illuminate\Support\Carbon::parse($request->completed_at)->format('M d Y'): ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Cancelled At</th>
                        <td>{{$request->canceled_at != null ? \Illuminate\Support\Carbon::parse($request->canceled_at)->format('M d Y'): ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Confirmed At</th>
                        <td>{{$request->confirmed_at != null ? \Illuminate\Support\Carbon::parse($request->confirmed_at)->format('M d Y'): ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Reviewed At</th>
                        <td>{{$request->reviewed_at != null ? \Illuminate\Support\Carbon::parse($request->reviewed_at)->format('M d Y'): ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Disputed At</th>
                        <td>{{$request->disputed_at != null ? \Illuminate\Support\Carbon::parse($request->disputed_at)->format('M d Y') : ''}}</td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-light table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Question</th>
                        <th scope="col">Answer</th>
                        <th scope="col">Price Change</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($request->answers as $answer)
                        <tr>
                            <th scope="row">{{$answer->id}}</th>
                            <td>{{$answer->question}}</td>
                            <td>
                                @if ($answer->answer_type === str_replace('\\', '\\\\', \App\Models\ServiceRequestAnswerChoice::class))
                                    {{$answer->answer->choice}}
                                @else
                                    {{$answer->answer->answer}}
                                @endif
                            </td>
                            <td>
                                @if ($answer->answer_type === str_replace('\\', '\\\\', \App\Models\ServiceRequestAnswerChoice::class))
                                    {{$answer->answer->price_change}}
                                @else
                                    "N/A"
                                @endif
                            </td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            ClassicEditor
                .create(document.querySelector('#content'))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endpush
