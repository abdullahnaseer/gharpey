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
                    <div class="card-header">Verify your phone</div>
                    <div class="card-body">
                        <p>Thanks for registering with our platform. We will call you to verify your phone number in a jiffy. Provide the code below.</p>

                        <div class="d-flex justify-content-center">
                            <div class="col-8">
                                <form method="post" action="{{ route('seller.phone_verification.verify') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="code">Verification Code</label>
                                        <input id="code" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" type="text" placeholder="Verification Code" required autofocus>
                                        @if ($errors->has('code'))
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('code') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary">Verify Phone</button>
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
