
window.paypalCheckoutReady = function () {
  paypal.checkout.setup('TM23WPCQUEY42', {
  // paypal.checkout.setup(null, {
    //locale: (document.getElementsByTagName('html')[0].lang == 'de') ? 'de_DE' : 'en_EN',
    locale: 'de_DE',
    //locale: 'en_US',
    env: 'sandbox{#live#}',
    environment: 'sandbox{#live#}',
    //container: 'paypal-express-checkout',
    //button: 'checkout-payment-paypal-button',
    buttons: [
        {
            container: 'paypal-express-checkout',
            type: 'checkout'
        }
    ],
    cancelUrl: '{{ url('checkout_payment_paypal', {'cancel': 1}) }}'
  });
};