http://www.networkinghowtos.com/howto/configure-varnish-to-allow-purging-the-cache/
https://devdocs.magento.com/guides/v2.0/config-guide/varnish/use-varnish-cache.html

Or add config in app/etc/env.php

'http_cache_hosts' =>
array (
0 =>
array (
'host' => '172.18.80.10',
'port' => '6081',
)
),