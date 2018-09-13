<?php
function sign($method, $url, $data, $consumerSecret, $tokenSecret)
{
    $url = urlEncodeAsZend($url);
    $data = urlEncodeAsZend(http_build_query($data, '', '&'));
    $data = implode('&', [$method, $url, $data]);
    $secret = implode('&', [$consumerSecret, $tokenSecret]);
    return base64_encode(hash_hmac('sha1', $data, $secret, true));
}
function urlEncodeAsZend($value)
{
    $encoded = rawurlencode($value);
    $encoded = str_replace('%7E', '~', $encoded);
    return $encoded;
}
// REPLACE WITH YOUR ACTUAL DATA OBTAINED WHILE CREATING NEW INTEGRATION
$consumerKey = 'f3ayp1mol6rcr';
$consumerSecret = 'ehg5v8b1ojeqxle6pl5';
$accessToken = 'bdj7fs4xn9ldavjk3n9wf';
$accessTokenSecret = '6gjxy7g12iwyxpw7y';
$method = 'GET';
$url = 'https://www.yourweb.com/index.php/rest/V1/godatafeed/getproduct/id/18693';
$url = 'https://www.yourweb.com/index.php/rest/default/V1/godatafeed/products';
#$url = 'https://www.yourweb.com/index.php/rest/V1/godatafeed/products/count';
#$url = 'https://yourweb.com/index.php/rest/V1/store/storeViews';
$data = [
    'oauth_consumer_key' => $consumerKey,
    'oauth_nonce' => md5(uniqid(rand(), true)),
    'oauth_signature_method' => 'HMAC-SHA1',
    'oauth_timestamp' => time(),
    'oauth_token' => $accessToken,
    'oauth_version' => '1.0',
];
$data['oauth_signature'] = sign($method, $url, $data, $consumerSecret, $accessTokenSecret);
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,//.'?limit=100&page=1&store=1&type=simple',
    CURLOPT_HTTPHEADER => [
        'Authorization: OAuth ' . http_build_query($data, '', ',')
    ]
]);
$result = curl_exec($curl);
curl_close($curl);
var_dump($result);


Or use:

###REST API
#Obtain REST token
curl -X POST "https://domain/index.php/rest/V1/integration/admin/token" -H "Content-Type:application/json" -d '{"username":"", "password":""}'
#Get Customer Info
curl -X GET "https://domain/index.php/rest/V1/customers/2764" -H "Authorization: Bearer p8k4hhn1upq5byn5j37ej6wa8cwq6nbd"
#Create shipment
curl -X POST "https://domain/index.php/rest/V1/shipment" -H "Content-Type:application/json" -H "Authorization: Bearer p8k4hhn1upq5byn5j37ej6wa8cwq6nbd" -d '{"entity": {"order_id": 116}}'
