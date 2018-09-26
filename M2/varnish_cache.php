http://www.networkinghowtos.com/howto/configure-varnish-to-allow-purging-the-cache/
https://devdocs.magento.com/guides/v2.0/config-guide/varnish/use-varnish-cache.html or add config in app/etc/env.php

'http_cache_hosts' =>
array (
0 =>
array (
'host' => 'xx.xx.xx.xx',
'port' => '6081',
)
),



Varnish cache don't work for menu
vendor/magento/module-theme/view/frontend/layout/default.xml
remove the ttl="3600" Or app/code/Magestore/Megamenu/view/frontend/layout/default.xml

https://github.com/magento/magento2/issues/3421
https://github.com/magento/magento2/issues/3897