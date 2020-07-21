@extends('buyer.layouts.app')

@section("styles")
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .alert {
            display: none;
        }

        .visible {
            display: block;
        }

        @media screen and (max-width: 576px) {
            .m-padding-20 {
                padding-top: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('buyer.cart.index')}}">Shopping
                        Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </div>
        <!-- End .container -->
    </nav>

    <div class="container">
        <ul class="checkout-progress-bar">
            <li>
                <span>Shipping</span>
            </li>
            <li class="active">
                <span>Review &amp; Payments</span>
            </li>
        </ul>
        <div class="row">
            <div class="col-lg-4">
                <div class="order-summary">
                    <h3>Summary</h3>

                    <h4>
                        <a data-toggle="collapse" href="#order-cart-section" class="collapsed" role="button"
                           aria-expanded="false" aria-controls="order-cart-section">{{$cart->getContent()->count()}}
                            products in Cart</a>
                    </h4>

                    <div class="collapse show" id="order-cart-section">
                        <table class="table table-mini-cart">
                            <tbody>
                            @foreach($cart->getContent() as $item)
                                <tr>
                                    <td class="product-col">
                                        <figure class="product-image-container">
                                            <a href="{{route('buyer.products.show', [$item->model->slug])}}"
                                               class="product-image">
                                                <img
                                                    src="{{str_replace("public","/storage",$item->model->featured_image)}}"
                                                    alt="product">
                                            </a>
                                        </figure>
                                        <div>
                                            <h2 class="product-title">
                                                <a href="{{route('buyer.products.show', [$item->model->slug])}}">{{$item->name}}</a>
                                            </h2>

                                            <span class="product-qty">Qty: {{$item->quantity}}</span>
                                        </div>
                                    </td>
                                    <td class="price-col">Rs. {{$item->getPriceSum()}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- End #order-cart-section -->
                </div>
                <!-- End .order-summary -->

                <div class="checkout-info-box">
                    <h3 class="step-title">Ship To:
                        <a href="{{route('buyer.checkout.shipping.get')}}" title="Edit" class="step-title-edit"><span
                                class="sr-only">Edit</span><i class="icon-pencil"></i></a>
                    </h3>

                    <address>
                        {{$shipping['name']}} <br>
                        {{$shipping['address']}} <br>
                        {{$shipping['area']->name}}, {{$shipping['area']->city->name}}
                        , {{$shipping['area']->city->state->name}} <br>
                        {{$shipping['area']->city->state->country->name}} <br>
                        {{$shipping['phone']}}
                    </address>
                </div>
                <!-- End .checkout-info-box -->
            </div>
            <!-- End .col-lg-4 -->

            <div class="col-lg-8 order-lg-first">
                <div class="checkout-payment">
                    <h2 class="step-title">Billing Details:</h2>

                    <div id="checkout-shipping-address">
                        <address>
                            {{$shipping['name']}} <br>
                            {{$shipping['address']}} <br>
                            {{$shipping['area']->name}}, {{$shipping['area']->city->name}}
                            , {{$shipping['area']->city->state->name}} <br>
                            {{$shipping['area']->city->state->country->name}} <br>
                            {{$shipping['phone']}}
                        </address>
                    </div>

                    <div id="payment-gateway-container">
                        <div class="form-group">
                            <label for="payment-gateway">Payment Gateway</label>
                            <select name="payment-gateway" id="payment-gateway" class="form-control">
                                <option value="{{\App\Models\Order::PAYMENT_GATEWAY_COD}}">Cash On Delivery</option>
                                <option value="{{\App\Models\Order::PAYMENT_GATEWAY_STRIPE}}">Visa/Master Card</option>
                            </select>
                        </div>
                    </div>

                    <div id="cod">
                        <form action="{{route('buyer.checkout.payment.post')}}" method="POST">
                            @csrf

                            <button id="pay-btn" type="submit" class="btn btn-primary float-right">Place Order
                            </button>
                            <a href="{{route('buyer.checkout.shipping.get')}}"
                               class="btn btn-secondary float-right mr-1">Back</a>

                            <div class="clearfix"></div>
                        </form>
                    </div>

                    <div id="stripe" style="display: none;">
                        <div id="new-checkout-address" class="show payment-form">
                            <form action="#" class="">
                                <div class="form-group">
                                    <label for="name" data-tid="elements.form.name_label">Name</label>
                                    <input id="name" name="name" data-tid="elements.form.name_placeholder"
                                           class="form-control" type="text"
                                           placeholder="" required="" autocomplete="name">
                                </div>
                                <div class="form-group">
                                    <label for="address" data-tid="elements.form.address_label">Address</label>
                                    <input id="address" name="address" data-tid="elements.form.address_placeholder"
                                           class="form-control"
                                           type="text" placeholder="" required="" autocomplete="address-line1">
                                </div>

                                <div class="form-group">
                                    <label for="city" name="city" data-tid="elements.form.city_label">City</label>
                                    <input id="city" data-tid="elements.form.city_placeholder" class="form-control"
                                           type="text"
                                           placeholder="" required="" autocomplete="address-level2">
                                </div>

                                <div class="form-group">
                                    <label for="state" data-tid="elements.form.state_label">State/Province</label>
                                    <input id="state" name="state" data-tid="elements.form.state_placeholder"
                                           class="form-control"
                                           type="text" placeholder="" required="" autocomplete="address-level1">
                                </div>
                                <div class="form-group">
                                    <label for="zip" data-tid="elements.form.postal_code_label">ZIP</label>
                                    <input id="zip" name="zipcode" data-tid="elements.form.postal_code_placeholder"
                                           class="form-control" type="text" placeholder="" required=""
                                           autocomplete="postal-code">
                                </div>

                                <h2 class="step-title">Card Details:</h2>

                                {{--                            <h3 class="">Payment Gateway:</h3>--}}

                                <div class="form-group">
                                    <label for="card-number" data-tid="elements.form.card_number_label">Card
                                        number</label>
                                    <div id="card-number" class="input"></div>
                                </div>

                                <div class="form-group">
                                    <label for="card-expiry" data-tid="elements_examples.form.card_expiry_label">Expiration</label>
                                    <div id="card-expiry" class="input"></div>
                                </div>
                                <div class="form-group">
                                    <label for="card-cvc" data-tid="elements.form.card_cvc_label">CVC</label>
                                    <div id="card-cvc" class="input"></div>
                                </div>


                                <div class="clearfix"></div>
                                <!-- End .clearfix -->

                                <div class="error alert alert-danger" id="pay-error" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                                        <path class="base" fill="#000"
                                              d="M8.5,17 C3.80557963,17 0,13.1944204 0,8.5 C0,3.80557963 3.80557963,0 8.5,0 C13.1944204,0 17,3.80557963 17,8.5 C17,13.1944204 13.1944204,17 8.5,17 Z"></path>
                                        <path class="glyph" fill="#FFF"
                                              d="M8.5,7.29791847 L6.12604076,4.92395924 C5.79409512,4.59201359 5.25590488,4.59201359 4.92395924,4.92395924 C4.59201359,5.25590488 4.59201359,5.79409512 4.92395924,6.12604076 L7.29791847,8.5 L4.92395924,10.8739592 C4.59201359,11.2059049 4.59201359,11.7440951 4.92395924,12.0760408 C5.25590488,12.4079864 5.79409512,12.4079864 6.12604076,12.0760408 L8.5,9.70208153 L10.8739592,12.0760408 C11.2059049,12.4079864 11.7440951,12.4079864 12.0760408,12.0760408 C12.4079864,11.7440951 12.4079864,11.2059049 12.0760408,10.8739592 L9.70208153,8.5 L12.0760408,6.12604076 C12.4079864,5.79409512 12.4079864,5.25590488 12.0760408,4.92395924 C11.7440951,4.59201359 11.2059049,4.59201359 10.8739592,4.92395924 L8.5,7.29791847 L8.5,7.29791847 Z"></path>
                                    </svg>
                                    <span class="message"></span></div>

                                <button id="pay-btn" type="submit" class="btn btn-primary float-right"
                                        data-tid="elements.form.pay_button">Pay Now
                                </button>
                                <a href="{{route('buyer.checkout.shipping.get')}}"
                                   class="btn btn-secondary float-right mr-1">Back</a>

                                <div class="clearfix"></div>

                                <div id="payment-request-button" class="mb-3">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End #new-checkout-address -->

                    <div class="clearfix"></div>
                </div>
                <!-- End .checkout-payment -->

                {{--                <div class="checkout-discount">--}}
                {{--                    <h4>--}}
                {{--                        <a data-toggle="collapse" href="#checkout-discount-section" class="collapsed" role="button" aria-expanded="false" aria-controls="checkout-discount-section">Apply Discount Code</a>--}}
                {{--                    </h4>--}}

                {{--                    <div class="collapse" id="checkout-discount-section">--}}
                {{--                        <form action="#">--}}
                {{--                            <input type="text" class="form-control form-control-sm" placeholder="Enter discount code" required>--}}
                {{--                            <button class="btn btn-sm btn-outline-secondary" type="submit">Apply Discount</button>--}}
                {{--                        </form>--}}
                {{--                    </div>--}}
                {{--                    <!-- End .collapse -->--}}
                {{--                </div>--}}
                {{--                <!-- End .checkout-discount -->--}}
            </div>
            <!-- End .col-lg-8 -->
        </div>
        <!-- End .row -->
    </div>
    <!-- End .container -->

    <div class="mb-6"></div>
    <!-- margin -->
@endsection


@section('scripts')
    <script>
        (function () {
            'use strict';

            $('#payment-gateway').on('change', function () {
                if (this.value == "{{\App\Models\Order::PAYMENT_GATEWAY_COD}}") {
                    $('#stripe').fadeOut();
                    $('#cod').fadeIn();
                } else if (this.value == "{{\App\Models\Order::PAYMENT_GATEWAY_STRIPE}}") {
                    $('#cod').fadeOut();
                    $('#stripe').fadeIn();
                }
            });

            var stripe = Stripe('{{ config('services.stripe.key') }}');

            var elements = stripe.elements({
                fonts: [
                    {
                        cssSrc: 'https://fonts.googleapis.com/css?family=Source+Code+Pro',
                    },
                ]
            });

            // Floating labels
            var inputs = document.querySelectorAll('.payment-form .form-control');
            Array.prototype.forEach.call(inputs, function (input) {
                input.addEventListener('focus', function () {
                    input.classList.add('focused');
                });
                input.addEventListener('blur', function () {
                    input.classList.remove('focused');
                });
                input.addEventListener('keyup', function () {
                    if (input.value.length === 0) {
                        input.classList.add('empty');
                    } else {
                        input.classList.remove('empty');
                    }
                });
            });

            var elementStyles = {
                base: {
                    color: '#32325D',
                    fontWeight: 500,
                    fontFamily: 'Source Code Pro, Consolas, Menlo, monospace',
                    fontSize: '16px',
                    fontSmoothing: 'antialiased',

                    '::placeholder': {
                        color: '#CFD7DF',
                    },
                    ':-webkit-autofill': {
                        color: '#e39f48',
                    },
                },
                invalid: {
                    color: '#E25950',

                    '::placeholder': {
                        color: '#FFCCA5',
                    },
                },
            };

            var elementClasses = {
                focus: 'focused',
                empty: 'empty',
                invalid: 'invalid',
                base: 'form-control'
            };

            var cardNumber = elements.create('cardNumber', {
                style: elementStyles,
                classes: elementClasses,
            });
            cardNumber.mount('#card-number');

            var cardExpiry = elements.create('cardExpiry', {
                style: elementStyles,
                classes: elementClasses,
            });
            cardExpiry.mount('#card-expiry');

            var cardCvc = elements.create('cardCvc', {
                style: elementStyles,
                classes: elementClasses,
            });
            cardCvc.mount('#card-cvc');

            function registerElements(elements, exampleName) {
                var formClass = '.payment-form';
                var example = document.querySelector(formClass);

                var form = example.querySelector('form');
                var resetButton = example.querySelector('a.reset');
                var error = form.querySelector('.error');
                var errorMessage = error.querySelector('.message');

                function enableInputs() {
                    $('#pay-btn').prop('disabled', false);
                    Array.prototype.forEach.call(
                        form.querySelectorAll(
                            "input[type='text'], input[type='email'], input[type='tel']"
                        ),
                        function (input) {
                            input.removeAttribute('disabled');
                        }
                    );
                }

                function disableInputs() {
                    $('#pay-btn').prop('disabled', true);
                    Array.prototype.forEach.call(
                        form.querySelectorAll(
                            "input[type='text'], input[type='email'], input[type='tel']"
                        ),
                        function (input) {
                            input.setAttribute('disabled', 'true');
                        }
                    );
                }

                function triggerBrowserValidation() {
                    // The only way to trigger HTML5 form validation UI is to fake a user submit
                    // event.
                    var submit = document.createElement('input');
                    submit.type = 'submit';
                    submit.style.display = 'none';
                    form.appendChild(submit);
                    submit.click();
                    submit.remove();
                }

                // Listen for errors from each Element, and show error messages in the UI.
                var savedErrors = {};
                elements.forEach(function (element, idx) {
                    element.on('change', function (event) {
                        if (event.error) {
                            error.classList.add('visible');
                            savedErrors[idx] = event.error.message;
                            errorMessage.innerText = event.error.message;
                        } else {
                            savedErrors[idx] = null;

                            // Loop over the saved errors and find the first one, if any.
                            var nextError = Object.keys(savedErrors)
                                .sort()
                                .reduce(function (maybeFoundError, key) {
                                    return maybeFoundError || savedErrors[key];
                                }, null);

                            if (nextError) {
                                // Now that they've fixed the current error, show another one.
                                errorMessage.innerText = nextError;
                            } else {
                                // The user fixed the last error; no more errors.
                                error.classList.remove('visible');
                            }
                        }
                    });
                });

                // Listen on the form's 'submit' handler...
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Trigger HTML5 validation UI on the form if any of the inputs fail
                    // validation.
                    var plainInputsValid = true;
                    Array.prototype.forEach.call(form.querySelectorAll('input'), function (
                        input
                    ) {
                        if (input.checkValidity && !input.checkValidity()) {
                            plainInputsValid = false;

                        }
                    });
                    if (!plainInputsValid) {
                        triggerBrowserValidation();
                        return;
                    }

                    // Show a loading screen...
                    example.classList.add('submitting');

                    // Disable all inputs.
                    disableInputs();

                    // Gather additional customer data we may have collected in our form.
                    var name = form.querySelector('#name');
                    var address1 = form.querySelector('#address');
                    var city = form.querySelector('#city');
                    var state = form.querySelector('#state');
                    var zip = form.querySelector('#zip');
                    var additionalData = {
                        name: name ? name.value : undefined,
                        address_line1: address1 ? address1.value : undefined,
                        address_city: city ? city.value : undefined,
                        address_state: state ? state.value : undefined,
                        address_zip: zip ? zip.value : undefined,
                    };

                    // Use Stripe.js to create a token. We only need to pass in one Element
                    // from the Element group in order to create a token. We can also pass
                    // in the additional customer data we collected in our form.
                    stripe.createToken(elements[0], additionalData).then(function (result) {
                        // Stop loading!
                        example.classList.remove('submitting');

                        if (result.token) {
                            // If we received a token, show the token ID.
                            example.classList.add('submitted');

                            // Send the token to your server to charge it!
                            $.ajax({
                                method: "POST",
                                url: "{{ route('buyer.checkout.charge') }}",
                                data: JSON.stringify({
                                    stripeToken: result.token.id,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                }),
                                headers: {
                                    'content-type': 'application/json',
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: "json"
                            })
                                .done(function (data) {
                                    console.log(data);
                                    if (data.success) {
                                        console.log('success');
                                        $('#pay-btn').slideUp();
                                        $('#pay-error').slideUp();
                                        $('#pay-success').slideDown();

                                        setTimeout(function () {

                                            console.log('redirecting');
                                            $(location).attr('href', "{{route('buyer.checkout.success')}}");
                                        }, 3000);
                                    } else if (data.error) {
                                        console.log('fail');

                                        $('#pay-success').slideUp();
                                        $('#pay-error').slideDown();
                                        errorMessage.innerText = data.error;
                                        enableInputs();
                                    }
                                }).fail(function () {
                                console.log('fail');

                                $('#pay-success').slideUp();
                                $('#pay-error').slideDown();
                                errorMessage.innerText = "Payment Declined! Something went wrong!";
                                enableInputs();
                            });
                        } else {
                            // Otherwise, un-disable inputs.
                            enableInputs();
                        }
                    });
                });

                // resetButton.addEventListener('click', function (e) {
                //     e.preventDefault();
                //     // Resetting the form (instead of setting the value to `''` for each input)
                //     // helps us clear webkit autofill styles.
                //     form.reset();
                //
                //     // Clear each Element.
                //     elements.forEach(function (element) {
                //         element.clear();
                //     });
                //
                //     // Reset error state as well.
                //     error.classList.remove('visible');
                //
                //     // Resetting the form does not un-disable inputs, so we need to do it separately:
                //     enableInputs();
                //     example.classList.remove('submitted');
                // });
            }

            registerElements([cardNumber, cardExpiry, cardCvc], '');
        })();
    </script>


    {{--    <script type="text/javascript">--}}
    {{--        $(document).ready(function () {--}}
    {{--            'use strict';--}}

    {{--            $('#payment-gateway').on('change', function() {--}}
    {{--                if(this.value == "{{\App\Models\Order::PAYMENT_GATEWAY_COD}}")--}}
    {{--                {--}}
    {{--                    $('#stripe').fadeOut();--}}
    {{--                    $('#cod').fadeIn();--}}
    {{--                }--}}
    {{--                else if(this.value == "{{\App\Models\Order::PAYMENT_GATEWAY_STRIPE}}")--}}
    {{--                {--}}
    {{--                    $('#cod').fadeOut();--}}
    {{--                    $('#stripe').fadeIn();--}}
    {{--                }--}}
    {{--            });--}}

    {{--            function enableInputs() {--}}
    {{--                console.log('en');--}}

    {{--                $('#pay-btn').prop('disabled', false);--}}
    {{--                Array.prototype.forEach.call(--}}
    {{--                    form.querySelectorAll(--}}
    {{--                        "input[type='text'], input[type='email'], input[type='tel']"--}}
    {{--                    ),--}}
    {{--                    function (input) {--}}
    {{--                        input.removeAttribute('disabled');--}}
    {{--                    }--}}
    {{--                );--}}
    {{--            }--}}

    {{--            function disableInputs() {--}}
    {{--                console.log('dis');--}}
    {{--                $('#pay-btn').prop('disabled', true);--}}
    {{--                Array.prototype.forEach.call(--}}
    {{--                    form.querySelectorAll(--}}
    {{--                        "input[type='text'], input[type='email'], input[type='tel']"--}}
    {{--                    ),--}}
    {{--                    function (input) {--}}
    {{--                        input.setAttribute('disabled', 'true');--}}
    {{--                    }--}}
    {{--                );--}}
    {{--            }--}}

    {{--            // Create a Stripe client.--}}
    {{--            var stripe = Stripe('{{ config('services.stripe.key') }}');--}}

    {{--            var paymentRequest = stripe.paymentRequest({--}}
    {{--                country: 'US',--}}
    {{--                currency: 'pkr',--}}
    {{--                total: {--}}
    {{--                    label: "Payment for Product Order by Buyer#{{auth('buyer')->id()}}",--}}
    {{--                    amount: {{(int) ($cart->getTotal() * 100)}},--}}
    {{--                },--}}
    {{--                requestPayerName: true,--}}
    {{--                requestPayerEmail: true,--}}
    {{--            });--}}

    {{--            var elements = stripe.elements();--}}
    {{--            var prButton = elements.create('paymentRequestButton', {--}}
    {{--                paymentRequest: paymentRequest,--}}
    {{--            });--}}

    {{--            // Check the availability of the Payment Request API first.--}}
    {{--            paymentRequest.canMakePayment().then(function (result) {--}}
    {{--                if (result) {--}}
    {{--                    prButton.mount('#payment-request-button');--}}
    {{--                } else {--}}
    {{--                    document.getElementById('payment-request-button').style.display = 'none';--}}
    {{--                }--}}
    {{--            });--}}

    {{--            paymentRequest.on('token', function (ev) {--}}
    {{--                disableInputs();--}}

    {{--                // Send the token to your server to charge it!--}}
    {{--                $.ajax({--}}
    {{--                    method: "POST",--}}
    {{--                    url: "{{ route('buyer.checkout.charge') }}",--}}
    {{--                    data: JSON.stringify({--}}
    {{--                        stripeToken: ev.token.id,--}}
    {{--                        _token: $('meta[name="csrf-token"]').attr('content')--}}
    {{--                    }),--}}
    {{--                    headers: {--}}
    {{--                        'content-type': 'application/json',--}}
    {{--                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
    {{--                    },--}}
    {{--                    dataType: "json"--}}
    {{--                })--}}
    {{--                .done(function (data) {--}}
    {{--                    console.log(data);--}}
    {{--                    if (data.success) {--}}
    {{--                        console.log('success');--}}
    {{--                        $('#payment-request-button').slideUp();--}}
    {{--                        $('#pay-error').slideUp();--}}
    {{--                        $('#pay-success').slideDown();--}}

    {{--                        setTimeout(function () {--}}
    {{--                            console.log('redirect to success');--}}
    {{--                            $(location).attr('href', "{{route('buyer.checkout.success')}}");--}}
    {{--                        }, 3000);--}}
    {{--                    } else if (data.error) {--}}
    {{--                        console.log('fail');--}}

    {{--                        $('#pay-success').slideUp();--}}
    {{--                        $('#pay-error').slideDown();--}}
    {{--                        errorMessage.innerText = data.error;--}}
    {{--                        enableInputs();--}}
    {{--                    }--}}
    {{--                }).fail(function () {--}}
    {{--                    console.log('fail');--}}

    {{--                    $('#pay-success').slideUp();--}}
    {{--                    $('#pay-error').slideDown();--}}
    {{--                    errorMessage.innerText = "Payment Declined! Something went wrong!";--}}
    {{--                    enableInputs();--}}
    {{--                });--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}

@endsection
