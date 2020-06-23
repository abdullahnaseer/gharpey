@extends('seller.layouts.dashboard')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Finance</span>
@endsection

@section('breadcrumb-elements')
    <a class="btn btn-brand btn-elevate" href="#paymentModal" data-toggle="modal" data-target="#paymentModal">
        <i class="la la-cc-visa"></i>
        Payment Settings
    </a>
@endsection

@section('content')
    <div class="alert alert-primary">
        Payments are sent weekly if you reach threshold amount. And all earnings have to stay in system for 15 days to become withdraw able.
    </div>
    <div class="kt-widget17">
        <div class="kt-widget17__stats" style="margin: 0; width: 100%;">
            <div class="kt-widget17__items">
                <div class="kt-widget17__item">
                    <span class="kt-widget17__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                    </span>
                    <span class="kt-widget17__subtitle">
                        Current Balance
                    </span>
                    <span class="kt-widget17__desc">
                        PKR. {{ $current_balance }}
                    </span>
                </div>
                <div class="kt-widget17__item">
                    <span class="kt-widget17__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                    </span>
                    <span class="kt-widget17__subtitle">
                        WithdrawAble Amount
                    </span>
                    <span class="kt-widget17__desc">
                        PKR. {{ $withdraw_able }}
                    </span>
                </div>
                <div class="kt-widget17__item">
                    <span class="kt-widget17__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                    </span>
                    <span class="kt-widget17__subtitle">
                        Total Withdrawn
                    </span>
                    <span class="kt-widget17__desc">
                        PKR. {{ $total_withdrawn }}
                    </span>
                </div>
                <div class="kt-widget17__item">
                    <span class="kt-widget17__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                    </span>
                    <span class="kt-widget17__subtitle">
                        Lifetime Earnings
                    </span>
                    <span class="kt-widget17__desc">
                        PKR. {{ $lifetime_earnings }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @include('shared.charts.chart', ['col-sm-6'])
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        {{ Form::model($payment_detail, ['route' => 'seller.finance.payment', 'method' => 'POST', 'files' => true]) }}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('bank', 'Select Bank', ['class' => "col-form-label"]) !!}
                        {!! Form::select('bank', $banks, $payment_detail ? array_search($payment_detail->bank, $banks) : null, ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('name', 'Name', ['class' => "col-form-label"]) !!}
                        {!! Form::text('name', null, ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('account_no', 'Account No', ['class' => "col-form-label"]) !!}
                        {!! Form::text('account_no', null, ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('threshold', 'Select Threshold Amount', ['class' => "col-form-label"]) !!}
                        {!! Form::select('threshold', $threshold_amounts, $payment_detail ? array_search($payment_detail->threshold, $threshold_amounts) : null, ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>

@endsection

@push('scripts')
    @include('shared.charts.script')
@endpush
