<!-- begin:: Aside -->
<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

    <!-- begin:: Aside -->
    <div class="kt-aside__brand kt-grid__item" id="kt_aside_brand">
        <div class="kt-aside__brand-logo">
            <a href="{{route('moderator.dashboard')}}" class="pr-4">
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
                <li class="kt-menu__item {{ (request()->is('moderator/dashboard')) ? 'kt-menu__item--active' : '' }} "
                    aria-haspopup="true"><a href="{{route('moderator.dashboard')}}" class="kt-menu__link "><i
                            class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span
                            class="kt-menu__link-text">Dashboard</span></a></li>
                <li class="kt-menu__section ">
                    <h4 class="kt-menu__section-text">Users</h4>
                    <i class="kt-menu__section-icon flaticon-more-v2"></i>
                </li>
                <li class="kt-menu__item {{ (request()->is('moderator/users/sellers*')) ? 'kt-menu__item--active' : '' }} "
                    aria-haspopup="true"><a href="{{route('moderator.users.sellers.index')}}" class="kt-menu__link "><i
                            class="kt-menu__link-icon flaticon-users"></i><span
                            class="kt-menu__link-text">Sellers</span></a></li>
                <li class="kt-menu__item {{ (request()->is('moderator/users/buyers*')) ? 'kt-menu__item--active' : '' }} "
                    aria-haspopup="true"><a href="{{route('moderator.users.buyers.index')}}" class="kt-menu__link "><i
                            class="kt-menu__link-icon flaticon-users"></i><span
                            class="kt-menu__link-text">Buyers</span></a></li>

                <li class="kt-menu__item  kt-menu__item--submenu {{ (request()->is('admin/products*') || request()->is('moderator/products*')) ? 'kt-menu__item--open kt-menu__item--here' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                        <i class="kt-menu__link-icon flaticon2-shopping-cart-1"><span></span></i>
                        <span class="kt-menu__link-text">Products</span>
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item {{ (request()->is('moderator/products')) ? 'kt-menu__item--active' : '' }} "
                                aria-haspopup="true"><a href="{{route('moderator.products.index')}}" class="kt-menu__link "><i
                                        class="kt-menu__link-icon flaticon-users"></i><span
                                        class="kt-menu__link-text">Products</span></a></li>

                            <li class="kt-menu__item {{ (request()->is('moderator/products/orders')) ? 'kt-menu__item--active' : '' }} "
                                aria-haspopup="true"><a href="{{route('moderator.orders.index')}}" class="kt-menu__link "><i
                                        class="kt-menu__link-icon flaticon-users"></i><span
                                        class="kt-menu__link-text">Orders</span></a></li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
    <!-- end:: Aside Menu -->
</div>
<!-- end:: Aside -->
