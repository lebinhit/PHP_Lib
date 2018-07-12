//Edit in file: shipping.html

<!-- ko if: method.method_code =="freeshipping" -->
<!-- ko i18n: 'Free!' --><!-- /ko -->
<!-- /ko -->
<!-- ko if: method.method_code !="freeshipping" -->
<!-- ko foreach: $parent.getRegion('price') -->
<!-- ko template: getTemplate() --><!-- /ko -->
<!-- /ko -->
<!-- /ko -->