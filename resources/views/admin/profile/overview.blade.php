@extends('admin.profile.template')
<!-- change title -->
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Profile Overview</span>
@endsection
<!-- css styles -->
@push('styles')
@endpush
<!-- main content -->
@section('appcontent')
    <!--Begin:: App Content-->
    <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
        <div class="row">
            <div class="col-xl-6">
            @php($notifications = auth('admin')->user()->notifications)
            <!--begin:: Widgets/Notifications-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-menu__link-icon flaticon2-bell-4 text-success"></i>
                                </span>
                                Notifications
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab1_content_notification"
                                       role="tab">
                                        Latest
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab2_content_notification" role="tab">
                                        Over the Week
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab3_content_notification" role="tab">
                                        Over the Month
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab1_content_notification" role="tabpanel">
                                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true"
                                     data-height="300" data-mobile-height="200">
                                    @foreach($notifications as $notification)
                                        @if($notification->created_at->format('d') === date('d'))
                                            <div style="outline: 1px dotted green;">
                                                <div class="kt-notification">
                                                    <span class="kt-notification__item"
                                                          @if($notification->read_at === null)
                                                          style="transition: background-color 0.3s ease;
                                                        background-color: #f7f8fa;"
                                                        @endif
                                                        >
                                                        <div class="kt-notification__item-icon">

                                                        </div>

                                                        <div class="kt-notification__item-details">
                                                            <div class="kt-notification__item-title">
                                                                {{ $notification->data['data'] }}
                                                            </div>
                                                            <div class="kt-notification__item-time">
                                                                Today at {{$notification->created_at->format('g:i a')}}
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="kt-notification__item-time">
                                                &nbsp;
                                            </div>
                                        @endif
                                        <div class="kt-notification__item-time">
                                            &nbsp;
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- over the week -->
                            <div class="tab-pane" id="tab2_content_notification" role="tabpanel">
                                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true"
                                     data-height="300" data-mobile-height="200">
                                    @foreach($notifications as $notification)
                                        @if($notification->created_at->format('d') < date('d') &&
                                            $notification->created_at->format('M') === date('M'))
                                            <div style=" outline: 1px dotted green">

                                                <div class="kt-notification">
                                        <span href="#" class="kt-notification__item" @if($notification->read_at ===
                                            null)
                                        style="transition: background-color 0.3s ease;
                                            background-color: #f7f8fa;"
                                            @endif
                                            >
                                            <div class="kt-notification__item-icon">

                                            </div>
                                            <div class="kt-notification__item-details">
                                                <div class="kt-notification__item-title">
                                                    {{ $notification->data['data'] }}
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    On {{$notification->created_at->format('d M')}} at
                                                    {{$notification->created_at->format('g:i a')}}
                                                </div>
                                            </div>
                                        </span>
                                                </div>
                                            </div>
                                            <div class="kt-notification__item-time">
                                                &nbsp;
                                            </div>
                                        @endif
                                        <div class="kt-notification__item-time">
                                            &nbsp;
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- over the month -->
                            <div class="tab-pane" id="tab3_content_notification" role="tabpanel">
                                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true"
                                     data-height="300" data-mobile-height="200">
                                    @foreach($notifications as $notification)
                                        @if($notification->created_at->format('M') < date('M'))
                                            <div style=" outline: 1px dotted green">
                                                <div class="kt-notification">
                                    <span class="kt-notification__item" @if($notification->read_at === null)
                                    style="transition: background-color 0.3s ease;
                                        background-color: #f7f8fa;"
                                        @endif
                                        >
                                        <div class="kt-notification__item-icon">

                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                {{ $notification->data['data'] }}
                                            </div>
                                            <div class="kt-notification__item-time">
                                                On {{$notification->created_at->format('d M')}} at
                                                {{$notification->created_at->format('g:i a')}}
                                            </div>
                                        </div>
                                    </span>
                                                </div>
                                            </div>

                                            <div class="kt-notification__item-time">
                                                &nbsp;
                                            </div>
                                        @endif
                                        <div class="kt-notification__item-time">
                                            &nbsp;
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:: Widgets/Notifications-->
            </div>
        </div>

    </div>

@stop
<!-- aditional scripts -->
@push('scripts')
@endpush
