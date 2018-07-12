<!-- success.phtml Google Code for eCommerce  -->
<script>
    ga("require", "ecommerce");
    /* <![CDATA[ */
    ga('ecommerce:addTransaction', {
        'id': '<?php echo $orderId;?>',                     // Transaction ID. Required.
        'affiliation': 'Website name',   // Affiliation or store name.
        'revenue': '<?php echo $order->getGrandTotal();?>',               // Grand Total.
        'shipping': '<?php echo $order->getShippingAmount();?>',                  // Shipping.
        'tax': '<?php echo $order->getTaxAmount();?>'                     // Tax.
    });
    <?php foreach($ordered_items as $orderItem):?>
    ga('ecommerce:addItem', {
        'id': '<?php echo $orderId;?>',                     // Transaction ID. Required.
        'name': '<?php echo trim(htmlspecialchars(strip_tags($orderItem->getName())));?>',    // Product name. Required.
        'sku': '<?php echo $orderItem->getSku();?>',                 // SKU/code.
        'price': '<?php echo $orderItem->getPrice();?>',                 // Unit price.
        'quantity': '<?php echo $orderItem->getQtyOrdered();?>'                   // Quantity.
    });
    <?php endforeach; ?>
    ga('ecommerce:send');
    ga("send", "pageview");
    /* ]]> */
</script>
<!-- END Google Code for eCommerce  -->