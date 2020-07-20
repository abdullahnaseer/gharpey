@extends('seller.layouts.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var states = {!! $states->toJson() !!};

            function update_cities(state_value, stateEl, cityEl, areaEl) {
                cityEl.empty(); // remove old options
                areaEl.empty(); // remove old options
                for (var i = 0; i < states.length; i++) {
                    if (states[i].id == state_value) {
                        for (var j = 0; j < states[i].cities.length; j++)
                            cityEl.append($("<option></option>")
                                .attr("value", states[i].cities[j].id).text(states[i].cities[j].name));

                        for (var j = 0; j < states[i].cities[0].areas.length; j++)
                            areaEl.append($("<option></option>")
                                .attr("value", states[i].cities[0].areas[j].id).text(states[i].cities[0].areas[j].name));
                    }
                }
            }

            function update_areas(city_value, stateEl, cityEl, areaEl) {
                areaEl.empty(); // remove old options

                for (var i = 0; i < states.length; i++) {
                    if (states[i].id == stateEl.val()) {
                        for (var j = 0; j < states[i].cities.length; j++) {
                            if (states[i].cities[j].id == city_value) {
                                for (var k = 0; k < states[i].cities[j].areas.length; k++)
                                    areaEl.append($("<option></option>")
                                        .attr("value", states[i].cities[j].areas[k].id).text(states[i].cities[j].areas[k].name));
                            }
                        }
                    }
                }
            }

            $('#warehouse_state').on('change', function () {
                update_cities(this.value, this, $("#warehouse_city"), $("#warehouse_area"));
            });

            $('#warehouse_city').on('change', function () {
                update_areas(this.value, $("#warehouse_state"), this, $("#warehouse_area"));
            });

            $('#business_state').on('change', function () {
                update_cities(this.value, this, $("#business_city"), $("#business_area"));
            });

            $('#business_city').on('change', function () {
                update_areas(this.value, $("#business_state"), this, $("#business_area"));
            });

            $('#return_state').on('change', function () {
                update_cities(this.value, this, $("#return_city"), $("#return_area"));
            });

            $('#return_city').on('change', function () {
                update_areas(this.value, $("#return_state"), this, $("#return_area"));
            });


            $('#business_is_same').change(function () {
                if (this.checked) {
                    $('#business').removeClass('d-block');
                    $('#business').addClass('d-none');
                } else {
                    $('#business').removeClass('d-none');
                    $('#business').addClass('d-block');
                }
            });

            $('#return_is_same').change(function () {
                if (this.checked) {
                    $('#return').removeClass('d-block');
                    $('#return').addClass('d-none');
                } else {
                    $('#return').removeClass('d-none');
                    $('#return').addClass('d-block');
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-lg-10 col-md-10 col-sm-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="post" action="{{ route('seller.address.store') }}">
                    @csrf
                    @php($types = array('warehouse', 'business', 'return'))
                    @foreach($types as $type)
                        <div class="card mb-4">
                            <div class="card-header">{{ucfirst($type)}} Address</div>
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="col-12">
                                        @unless($loop->first)
                                            <div class="form-group row">
                                                <div class="">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="{{$type}}_is_same"
                                                               id="{{$type}}_is_same" {{ old($type.'_is_same') ? 'checked' : 'checked' }}>

                                                        <label class="form-check-label" for="{{$type}}_is_same">
                                                            {{ __('Same as Warehouse Address') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endunless

                                        <div id="{{$type}}" class="{{$loop->first ? '' : 'd-none'}}">
                                            <div class="form-group">
                                                <label for="{{$type}}_address">Address</label>
                                                <input id="{{$type}}_address"
                                                       class="form-control{{ $errors->has($type.'_address') ? ' is-invalid' : '' }}"
                                                       name="{{$type}}_address" type="text"
                                                       placeholder="{{ucfirst($type)}} Address" autofocus>
                                                @if ($errors->has($type."_address"))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first($type.'_address') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="{{$type}}_state">State</label>
                                                <select id="{{$type}}_state"
                                                        class="form-control{{ $errors->has($type.'_state') ? ' is-invalid' : '' }}"
                                                        name="{{$type}}_state" type="text"
                                                        placeholder="{{ucfirst($type)}} State" autofocus>
                                                    @foreach($states as $state)
                                                        <option value="{{$state->id}}">{{$state->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has($type.'_state'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first($type.'_state') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="{{$type}}_city">City</label>
                                                <select id="{{$type}}_city"
                                                        class="form-control{{ $errors->has($type.'_city') ? ' is-invalid' : '' }}"
                                                        name="{{$type}}_city" type="text"
                                                        placeholder="{{ucfirst($type)}} City" autofocus>
                                                    <option disabled>Select City</option>
                                                    @foreach($states->first()->cities as $city)
                                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has($type.'_city'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first($type.'_city') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="{{$type}}_area">Area</label>
                                                <select id="{{$type}}_area"
                                                        class="form-control{{ $errors->has($type.'_area') ? ' is-invalid' : '' }}"
                                                        name="{{$type}}_area" type="text"
                                                        placeholder="{{ucfirst($type)}} Area" autofocus>
                                                    <option disabled>Select Area</option>
                                                    @foreach($states->first()->cities->first()->areas as $area)
                                                        <option value="{{$area->id}}">{{$area->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has($type.'_area'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first($type.'_area') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="form-group">
                        <button class="btn btn-primary" style="width: 100%">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
