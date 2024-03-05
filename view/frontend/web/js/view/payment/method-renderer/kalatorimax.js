define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/action/select-payment-method',
        'Magento_Checkout/js/checkout-data'
    ],
    function (
        $,
        Component,
        selectPaymentMethodAction,
        checkoutData
    ) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Alzymologist_KalatoriMax/payment/kalatorimax'
            },

            /**
             * @return {Boolean}
             */
            selectPaymentMethod: function () {
                selectPaymentMethodAction(this.getData());
                checkoutData.setSelectedPaymentMethod(this.item.method);

                $('body').trigger('processStart');
                this.debugWait(5000);
                $('body').trigger('processStop');

                return true;
            },

            debugWait: function (ms) {
                var start = Date.now(),
                    now = start;
                while (now - start < ms) {
                    now = Date.now();
                }
            },
        });
    }
);
