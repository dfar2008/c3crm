<?php
ob_start();
define('PROXY_SERVER',  'http://crm123.sinaapp.com/rest.php');
$headers = (function_exists('getallheaders'))?getallheaders(): array();
$_headers  = array();
foreach($headers as $k=>$v){
	$_headers[strtolower($k)] = $v;
}
$url = parse_url(PROXY_SERVER);
if(!empty($_headers['referer']))$curl_headers['referer'] = 'Referer: '  . $_headers['referer'];
if(!empty($_headers['user-agent']))$curl_headers['user-agent'] = 'User-Agent: ' . $_headers['user-agent'];
if(!empty($_headers['accept']))$curl_headers['accept'] = 'Accept: ' . $_headers['accept'];
if(!empty($_headers['accept-language']))$curl_headers['accept-Language'] = 'Accept-Language: ' . $_headers['accept-language'];
if(!empty($_headers['accept-encoding']))$curl_headers['accept-encoding:'] = 'Accept-Encoding: ' .$_headers['accept-encoding'];
if(!empty($_headers['accept-charset']))$curl_headers['accept-charset:'] = 'Accept-Charset: ' .$_headers['accept-charset'];

// create a new cURL resource
$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, PROXY_SERVER);
curl_setopt ($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_headers);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0  );
$post_data = '';
if(!empty($_POST)){
	foreach($_POST as $k=>$v){
		if(get_magic_quotes_gpc())$v = stripslashes($v);
		if(!empty($post_data))$post_data .= '&';
		$post_data .= "$k=" . $v;
	}
}
curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);
// grab URL and pass it to the browser
sae_debug( 'client headers:' . var_export($headers, true) . "\n");
sae_debug( 'starting curl request' . "\n");
sae_debug( $post_data . "\n");
$result = curl_exec($ch);
curl_close($ch);
sae_debug( 'finished curl request' . "\n");
sae_debug( 'response:' . var_export($result, true) . "\n");
//we only handle 1 response no redirects
$result = explode("\r\n\r\n", $result, 2);
//we neeed to split up the ehaders
$result_headers = explode("\r\n", $result[0]);
//now echo out the same headers the server passed to us
sae_debug( "setting headers\n");
foreach($result_headers as &$header){
	if(substr_count($header, 'Set-Cookie:') ==0)
	header($header);
}
header('Content-Length: ' . strlen($result[1]));
header('Connection: close');
// now echo out the body
sae_debug( "sending body\n");
echo $result[1];
ob_end_flush();
sae_debug( "done\n");
die();
// close cURL resource, and free up system resources

?>