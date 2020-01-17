<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                {{ isset($page_title) ? $page_title : 'Dashboard' }} </h3>
            <span class="kt-subheader__separator kt-hidden"></span>
            <div class="kt-subheader__breadcrumbs">
                <a href="{{url('/seller')}}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>

            @yield('breadcrumb')
            <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">
                @yield('breadcrumb-elements')
            </div>
        </div>
    </div>
</div>
<!-- end:: Subheader -->
