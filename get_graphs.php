<?php
// this will print a json-encoded array of available graphs for the user

$timestamp = time();
$canonical = ''; // there are no query string parameters in this request, so $canonical is empty
$host = 'api.nationalnet.com';
$method = 'GET';
$user = ''; // your myNatNet username
$apiKey = ''; // api-key string found in myNatNet user profile
$path = '/api/v1/graphs';

$uri = "https://$host$path";

$stringToSign = $method . "\n"
    . $user . "\n"
    . $host . "\n"
    . $timestamp . "\n"
    . $canonical;

$signature = base64_encode(
    hash_hmac(
        'sha256',
        $stringToSign,
        $apiKey,
        true
    )
);

/* raw curl command to use from shell:
$cmd = "curl -k -H \"x-nnws-auth:$user:$signature\" -H \"date:".date('r')."\" $uri";
echo "$cmd\n";
*/

$ch = curl_init();
$headers = array(
	"x-nnws-auth:$user:$signature",
	"date:".date('r', $timestamp)
);

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $uri);

echo curl_exec($ch);

?>
