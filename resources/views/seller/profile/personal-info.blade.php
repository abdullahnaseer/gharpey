@extends('seller.profile.template')
<!-- change title -->
@section('breadcrumb')
    <a href="{{ route('seller.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Personal Information</span>
@endsection
<!-- css styles -->
@push('styles')
@endpush
<!-- main content -->
@section('appcontent')
    <!--Begin:: App Content-->
    <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
        <div class="row">
            <div class="col-xl-12">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">Personal Information <small>update your personal
                                    informaiton here</small></h3>
                        </div>
                        {{-- for portlet options --}}
                    </div>
                    <form class="kt-form kt-form--label-right" method="POST"
                          action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="kt-section kt-section--first mb-0">
                                <div class="kt-section__body">
                                    <div class="row">
                                        <label class="col-xl-3"></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <h3 class="kt-section__title kt-section__title-sm">Account Holder:</h3>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Avatar</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="kt-avatar kt-avatar--outline" id="kt_user_avatar">
                                                <div class="kt-avatar__holder" id="profile-avatar"
                                                     style="background-image: url({{ empty(auth('seller')->user()->avatar) ? url('assets/media/users/300_25.jpg') : url( str_replace('public', 'storage', auth('seller')->user()->avatar) )}})"></div>
                                                <label class="kt-avatar__upload" data-toggle="kt-tooltip" title=""
                                                       data-original-title="Change avatar">
                                                    <i class="fa fa-pen"></i>
                                                    <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg"
                                                           onchange="document.getElementById('profile-avatar').style.backgroundImage = 'url(' + window.URL.createObjectURL(this.files[0]) + ')' ">
                                                </label>
                                                <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title=""
                                                      data-original-title="Cancel avatar">
                                                <i class="fa fa-times"></i>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Name</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control @error('name') is-invalid @enderror" name="name"
                                                   type="text"
                                                   value="{{auth('seller')->user()->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="la la-at"></i></span></div>
                                                <input disabled type="text"
                                                       class="form-control disabled @error('email') is-invalid @enderror"
                                                       name="email"
                                                       value="{{auth('seller')->user()->email}}" placeholder="Email"
                                                       aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="la la-phone"></i></span></div>
                                                <input type="text"
                                                       class="form-control @error('phone') is-invalid @enderror"
                                                       name="phone"
                                                       value="{{auth('seller')->user()->phone}}" placeholder="Phone"
                                                       aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-3 col-xl-3">
                                    </div>
                                    <div class="col-lg-9 col-xl-9">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--End:: App Content-->
@stop
<!-- aditional scripts -->
@push('scripts')
@endpush
