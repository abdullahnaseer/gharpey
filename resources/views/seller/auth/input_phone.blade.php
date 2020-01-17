@extends('seller.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Enter your phone</div>
                    <div class="card-body">
                        <p>Thanks for registering with our platform. We need your phone number to complete registration.</p>

                        <div class="d-flex justify-content-center">
                            <div class="col-8">
                                <form method="post" action="{{ route('seller.phone_verification.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="code">Phone Number</label>
                                        <input id="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" type="text" placeholder="Phone Number" required autofocus>
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
