@extends('seller.layouts.dashboard', ['page_title' => "Profile"])
<!-- css styles -->
@push('styles')
@endpush
<!-- main content -->
@section('content')
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            <!-- <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper"> -->
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                <!-- begin:: Content -->
                <!-- <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"> -->

                <!--Begin::App-->
                <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

                    <!--Begin:: App Aside Mobile Toggle-->
                    <button class="kt-app__aside-close" id="kt_user_profile_aside_close">
                        <i class="la la-close"></i>
                    </button>

                    <!--End:: App Aside Mobile Toggle-->

                    <!--Begin:: App Aside-->
                    <div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_user_profile_aside">

                        <!--begin:: Widgets/Applications/User/Profile1-->
                        <div class="kt-portlet kt-portlet--height-fluid-">
                            <div class="kt-portlet__head  kt-portlet__head--noborder">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                    </h3>
                                </div>
                                <div class="kt-portlet__head-toolbar"></div>
                            </div>
                            <div class="kt-portlet__body kt-portlet__body--fit-y">

                                <!--begin::Widget -->
                                <div class="kt-widget kt-widget--user-profile-1">
                                    <div class="kt-widget__head">
                                        <div class="kt-widget__media">
                                            <img src="{{ empty(auth('seller')->user()->avatar) ? url('assets/media/users/300_25.jpg') : url( str_replace('public', 'storage', auth('seller')->user()->avatar) )}}" alt="image" onerror="this.src = '{{ url('assets/media/users/300_25.jpg') }}';">
                                        </div>
                                        <div class="kt-widget__content">
                                            <div class="kt-widget__section">
                                            <span class="kt-widget__username">
                                                {{auth('seller')->user()->name}}
                                                <!-- <i class="flaticon2-correct kt-font-success"></i> -->
                                            </span>
                                                <span class="kt-widget__subtitle">
                                                Seller
                                            </span>
                                            </div>
                                            <div class="kt-widget__action">
{{--                                                <a href="{{route('seller.chat')}}" type="button"--}}
{{--                                                   class="btn btn-info btn-sm">chat</a>&nbsp;--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-widget__body">
                                        <div class="kt-widget__content">
                                            <div class="kt-widget__info">
                                                <span class="kt-widget__label">Email:</span>
                                                <span href="#" class="kt-widget__data">{{auth('seller')->user()->email}}</span>
                                            </div>
                                            <div class="kt-widget__info">
                                                <span class="kt-widget__label">Phone:</span>
                                                <span href="#" class="kt-widget__data">{{auth('seller')->user()->phone}}</span>
                                            </div>
                                            @if(auth('seller')->user()->location)
                                                <div class="kt-widget__info">
                                                    <span class="kt-widget__label">Location:</span>
                                                    <span class="kt-widget__data">
                                                        {{auth('seller')->user()->location->name . ', ' . auth('seller')->user()->location->city->name}}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="kt-widget__items">
                                            <a href="{{route('seller.profile.overview')}}"
                                               class="kt-widget__item @if(Route::getCurrentRoute()->uri() == 'seller/profile/overview') kt-widget__item--active @endif">
                                            <span class="kt-widget__section">
                                                <span class="kt-widget__icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                                         class="kt-svg-icon">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                                            <path
                                                                d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                                                fill="#000000" fill-rule="nonzero"/>
                                                            <path
                                                                d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                                                fill="#000000" opacity="0.3"/>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <span class="kt-widget__desc">
                                                    Profile Overview
                                                </span>
                                            </span>
                                            </a>
                                            <a href="{{route('seller.profile.personal')}}"
                                               class="kt-widget__item @if(Route::getCurrentRoute()->uri() == 'seller/profile/personal')kt-widget__item--active @endif">
                                            <span class="kt-widget__section">
                                                <span class="kt-widget__icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                                         class="kt-svg-icon">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                                            <path
                                                                d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                                                fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                            <path
                                                                d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                                                fill="#000000" fill-rule="nonzero"/>
                                                        </g>
                                                    </svg> </span>
                                                <span class="kt-widget__desc">
                                                    Personal Information
                                                </span>
                                            </span>
                                            </a>
                                            <a href="{{route('seller.profile.pass')}}"
                                               class="kt-widget__item @if(Route::getCurrentRoute()->uri() == 'seller/profile/pass')kt-widget__item--active @endif">
                                            <span class="kt-widget__section">
                                                <span class="kt-widget__icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                                         class="kt-svg-icon">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path
                                                                d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
                                                                fill="#000000" opacity="0.3"/>
                                                            <path
                                                                d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"
                                                                fill="#000000" opacity="0.3"/>
                                                            <path
                                                                d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
                                                                fill="#000000" opacity="0.3"/>
                                                        </g>
                                                    </svg> </span>
                                                <span class="kt-widget__desc">
                                                    Change Password
                                                </span>
                                            </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!--end::Widget -->
                            </div>
                        </div>

                        <!--end:: Widgets/Applications/User/Profile1-->
                    </div>

                    <!--End:: App Aside-->

                    <!--Begin:: App Content-->

                @yield('appcontent')

                <!--End:: App Content-->
                </div>

                <!--End::App-->
                <!-- </div> -->

                <!-- end:: Content -->
            </div>

            <!-- </div> -->
        </div>
    </div>
@stop
<!-- aditional scripts -->
@push('scripts')
@endpush
