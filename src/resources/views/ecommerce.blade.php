<div class="row">
    <div class="col-md-12">
        @php \Actions::do_action('pre_stripe_checkout_form',$gateway) @endphp
        <form action="{{ url($action) }}" method="post" id="payment-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

            <div class="card panel panel-default">
                <div class="card-header panel-heading">
                    @lang('Stripe::labels.card.credit_or_debit')
                </div>
                <div class="card-body panel-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div id="card-element" style="width: 100%;">
                                <!-- a Stripe Element will be inserted here. -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div id="card-errors" role="alert"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    div#card-errors {
        color: red;
        font-weight: 600;
        padding: 10px;
    }
</style>
<script type="text/javascript">

    var isAjax = '{{ request()->ajax() }}';

    window.onload = function () {
        initStripe();
    };

    if (isAjax == '1') {
        initStripe();
    }

    function initStripe() {
        // Create a Stripe client
        var stripe = Stripe('{{ $gateway->getApiPublicKey() }}');

        // Create an instance of Elements
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element
        var card = elements.create('card', {style: style});
        var errors = document.getElementById('card-errors');
        // Add an instance of the card Element into the `card-element` <div>
        card.mount('#card-element');


        // Handle form submission
        $('#payment-form').on('submit', function (event) {
            event.preventDefault();

            stripe.createPaymentMethod(
                'card',
                card
            ).then(function (result) {
                if (result.error) {
                    errors.textContent = result.error.message;
                    Ladda.stopAll();
                    return;
                } else {
                    errors.textContent = "";
                    // Send paymentMethod.id to server
                    blockUI($('#payment-form'));

                    let gatewayPaymentTokenURL = `{{url( $gatewayPaymentTokenURL ?? 'checkout/gateway-payment-token/'.$gateway->getName().'/'.$order->hashed_id) }}`;

                    fetch(`${gatewayPaymentTokenURL}?payment_method_id=${result.paymentMethod.id}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Data-Type': 'json',
                        }
                    }).then(function (result) {
                        // Handle server response (see Step 3)
                        result.json().then(function (json) {
                            handleServerResponse(json);
                        })
                    });
                }
            });

        });

        function handleServerResponse(response) {

            unblockUI($('#payment-form'));

            if ((response.status == "requires_action") && (response.next_action.type == "use_stripe_sdk")) {
                $("#payment-errors").textContent = "Requires action";
                // Use Stripe.js to handle required card action
                handleAction(response);
            } else if (response.status == "requires_payment_method") {
                errors.textContent = "Invalid Payment method, Please select another card or payment method";
                return;
            } else if (response.status == "requires_capture") {
                $('#payment-form-btn').remove();
                $('#cancel-btn').remove();
                $form = $('#payment-form');
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='checkoutToken' value='" + response.payment_intent_id + "'/>");
                $form.append("<input type='hidden' name='gateway' value='Stripe'/>");
                ajax_form($form);
            } else {
                $("#payment-errors").textContent = "Payment Error";

            }
        }

        function handleAction(response) {


            stripe.handleCardAction(
                response.client_secret
            ).then(function (result) {
                if (result.error) {
                    errors.textContent = result.error.message;
                    return;
                } else {
                    // The card action has been handled
                    // The PaymentIntent can be confirmed again on the server
                    blockUI($('#payment-form'));
                    fetch('{{url('checkout/gateway-check-payment-token/'.$gateway->getName()) }}?payment_intent_id=' + response.payment_intent_id, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Data-Type': 'json',
                        }
                    }).then(function (confirmResult) {
                        return confirmResult.json();
                    }).then(handleServerResponse);
                }
            });

        }

    }
</script>