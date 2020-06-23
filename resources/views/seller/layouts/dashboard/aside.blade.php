<!-- begin:: Aside -->
<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

    <!-- begin:: Aside -->
    <div class="kt-aside__brand kt-grid__item" id="kt_aside_brand">
        <div class="kt-aside__brand-logo">
            <a href="{{route('seller.dashboard')}}" class="pr-4">
                <img class="img-fluid" alt="Logo" src="{{url('/assets1/images/logo.png')}}" style="height: 45px;">
            </a>
        </div>
        <div class="kt-aside__brand-tools">
            <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler"><span></span></button>
        </div>
    </div>

    <!-- end:: Aside -->

    <!-- begin:: Aside Menu -->
    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1"
             data-ktmenu-dropdown-timeout="500">
            <ul class="kt-menu__nav ">
                <li class="kt-menu__item {{ (request()->is('seller/dashboard')) ? 'kt-menu__item--active' : '' }} "
                    aria-haspopup="true"><a href="{{route('seller.dashboard')}}" class="kt-menu__link "><i
                            class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span
                            class="kt-menu__link-text">Dashboard</span></a></li>

                <li class="kt-menu__item {{ (request()->is('seller/account/settings/shop')) ? 'kt-menu__item--active' : '' }} "
                    aria-haspopup="true"><a href="{{route('seller.account.getShop')}}" class="kt-menu__link "><i
                            class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span
                            class="kt-menu__link-text">Shop Settings</span></a></li>

                <li class="kt-menu__section ">
                    <h4 class="kt-menu__section-text">Products</h4>
                    <i class="kt-menu__section-icon flaticon-more-v2"></i>
                </li>
                <li class="kt-menu__item {{ (request()->is('seller/products')) ? 'kt-menu__item--active' : '' }} "
                    aria-haspopup="true"><a href="{{route('seller.products.index')}}" class="kt-menu__link "><i
                            class="kt-menu__link-icon flaticon-users"></i><span
                            class="kt-menu__link-text">All Products</span></a></li>
                <li class="kt-menu__item {{ (request()->is('seller/products/orders')) ? 'kt-menu__item--active' : '' }} "
                    aria-haspopup="true"><a href="{{route('seller.orders.index')}}" class="kt-menu__link "><i
                            class="kt-menu__link-icon flaticon-users"></i><span
                            class="kt-menu__link-text">Orders</span></a></li>

                <li class="kt-menu__section ">
                    <h4 class="kt-menu__section-text">Services</h4>
                    <i class="kt-menu__section-icon flaticon-more-v2"></i>
                </li>
                <li class="kt-menu__item {{ (request()->is('seller/services*') && !request()->is('seller/services*')) ? 'kt-menu__item--active' : '' }} "
                    aria-haspopup="true"><a href="{{route('seller.services.index')}}" class="kt-menu__link "><i
                            class="kt-menu__link-icon flaticon-users"></i><span
                            class="kt-menu__link-text">All Services</span></a></li>
                <li class="kt-menu__item {{ (request()->is('seller/services/requests*')) ? 'kt-menu__item--active' : '' }} "
                    aria-haspopup="true"><a href="{{route('seller.requests.index')}}" class="kt-menu__link "><i
                            class="kt-menu__link-icon flaticon-users"></i><span
                            class="kt-menu__link-text">Service Requests</span></a></li>
            </ul>
        </div>
    </div>
    <!-- end:: Aside Menu -->
</div>
<!-- end:: Aside -->
