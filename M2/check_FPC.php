<?php
/*@Verify FPC working or not
Go to file vendor/magento/framework/View/Layout.php, search for cacheable="false", print all xpath by adding */

print_r($this->getXml()->xpath('//' . Element::TYPE_BLOCK . '[@cacheable="false"]'));