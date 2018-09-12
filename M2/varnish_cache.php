http://www.networkinghowtos.com/howto/configure-varnish-to-allow-purging-the-cache/
https://devdocs.magento.com/guides/v2.0/config-guide/varnish/use-varnish-cache.html

Or add config in app/etc/env.php

'http_cache_hosts' =>
array (
0 =>
array (
'host' => 'xx.xx.xx.xx',
'port' => '6081',
)
),