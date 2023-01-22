define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_CheckoutAgreements/js/model/agreements-assigner',
    'Magento_Checkout/js/model/quote',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/url-builder',
    'mage/url',
    'Magento_Checkout/js/model/error-processor',
    'uiRegistry'
], function (
    $,
    wrapper,
    agreementsAssigner,
    quote,
    customer,
    urlBuilder,
    urlFormatter,
    errorProcessor,
    registry
) {
    'use strict';

    return function (placeOrderAction) {

        /** Override default place order action and add agreement_ids to request */
        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, messageContainer) {
            agreementsAssigner(paymentData);
            let isCustomer = customer.isLoggedIn();
            let quoteId = quote.getQuoteId();

            let url = urlFormatter.build('todo_instructions/save/quote');

            let toDoInstruction = $('[name="todo_instructions"]').val();

            if (toDoInstruction) {

                let payload = {
                    'cartId': quoteId,
                    'todo_instructions': toDoInstruction,
                    'is_customer': isCustomer
                };

                if (!payload.to_do_instruction) {
                    return true;
                }

                let result = true;

                $.ajax({
                    url: url,
                    data: payload,
                    dataType: 'textarea',
                    type: 'POST',
                }).done(
                    function (response) {
                        result = true;
                    }
                ).fail(
                    function (response) {
                        result = false;
                        errorProcessor.process(response);
                    }
                );
            }

            return originalAction(paymentData, messageContainer);
        });
    };
});
