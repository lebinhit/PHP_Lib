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




OR with GTM

<script type="text/javascript">
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({
        'event' : 'transactionComplete',
        'eventLabel' : 'Transaction Complete <?php echo $block->getOrderId() ?>',
        'ecommerce': {
            'purchase': {
                'actionField': {
                    'id': '<?php echo $block->getOrderId() ?>',
                    'revenue': '<?php echo $order->getGrandTotal(); ?>',
                    'affiliation': 'Online Store'
                },
                'products': [
                    <?php foreach($items as $item): ?>
                    <?php $product = $item->getProduct(); ?>
                    {
                        'name': '<?php echo $product->getName(); ?>',
                        'id': '<?php echo $product->getSku(); ?>',
                        'price': '<?php echo $item->getPriceInclTax() ?>',
                        'quantity': '<?php echo $item->getQtyOrdered() ?>',
                        'brand': '<?php
                            $categoryIds = $product->getCategoryIds();
                            if($categoryIds) {
                                $categories = $orderHelper->getCategoryCollection()
                                    ->addAttributeToFilter('entity_id', $categoryIds);
                                $i = 0;
                                foreach ($categories as $category) {
                                    if ($i == 0) {
                                        $i++;
                                        echo $category->getName();
                                    }
                                }
                            } ?>',
                    },
                    <?php endforeach; ?>
                ]
            }
        }
    });
</script>