/**
 * Edit in file: default.js
 */

isChecked: ko.computed(function () {
    if(quote.paymentMethod()){
        return quote.paymentMethod().method;
    } else {
        selectPaymentMethodAction({
                        "method": 'braintree',
                        "po_number": null,
                        "additional_data": null
                    });
                    checkoutData.setSelectedPaymentMethod('braintree');
                    return 'braintree';
                }
    /* return quote.paymentMethod() ? quote.paymentMethod().method : null;*/
}),