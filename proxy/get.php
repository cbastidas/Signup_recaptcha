<?php
// Set your return content type
 //header("Access-Control-Allow-Origin: *");
?>
<?php

$enable_jsonp    = false;
$enable_native   = false;
$valid_url_regex = '/.*/';

$api_method = $_GET['m'];
$url="";
if($api_method=="paymentmethods"){
  $url= 'https://api-gate-shared01.netrefer.com/v3/org/6BB63825-D7D7-4580-8E67-43CACBC89C55/paymentmethods';
}else if($api_method=="categories"){
  $url='https://api-gate-shared01.netrefer.com/v3/org/6BB63825-D7D7-4580-8E67-43CACBC89C55/categories';
}


if ( !$url ) {
  
  // Passed url not specified.
  $contents = 'ERROR: url not specified';
  $status = array( 'http_code' => 'ERROR' );
  
} else if ( !preg_match( $valid_url_regex, $url ) ) {
  
  // Passed url doesn't match $valid_url_regex.
  $contents = 'ERROR: invalid url';
  $status = array( 'http_code' => 'ERROR' );
  
} else {
  $ch = curl_init( $url );
  
  if ( strtolower($_SERVER['REQUEST_METHOD']) == 'post' ) {
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $_POST );

  }
  
  if ( $_GET['send_cookies'] ) {
    $cookie = array();
    foreach ( $_COOKIE as $key => $value ) {
      $cookie[] = $key . '=' . $value;
    }
    if ( $_GET['send_session'] ) {
      $cookie[] = SID;
    }
    $cookie = implode( '; ', $cookie );
    
    curl_setopt( $ch, CURLOPT_COOKIE, $cookie );
  }
  
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
  curl_setopt( $ch, CURLOPT_HEADER, true );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  
  curl_setopt( $ch, CURLOPT_USERAGENT, $_GET['user_agent'] ? $_GET['user_agent'] : $_SERVER['HTTP_USER_AGENT'] );

	
	
	$headers = [
    'APIKey: iK0aMMWObOPVSAvW1k56nxqrwVgwPGC4O5298UtKPycRq5nZxeIsu2zzWzLXTaF3Y74Io1gZudJeXJgSmmO7ow=='
  ];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	

  
  list( $header, $contents ) = preg_split( '/([\r\n][\r\n])\\1/', curl_exec( $ch ), 2 );
  
  $status = curl_getinfo( $ch );
  
  curl_close( $ch );
}

// Split header text into an array.
$header_text = preg_split( '/[\r\n]+/', $header );

if ( $_GET['mode'] == 'native' ) {
  if ( !$enable_native ) {
    $contents = 'ERROR: invalid mode';
    $status = array( 'http_code' => 'ERROR' );
  }
  
  // Propagate headers to response.
  foreach ( $header_text as $header ) {
    if ( preg_match( '/^(?:Content-Type|Content-Language|Set-Cookie):/i', $header ) ) {
      header( $header );
    }
  }
  
  print $contents;
  
} else {
  
  // $data will be serialized into JSON data.
  $data = array();
  
  // Propagate all HTTP headers into the JSON data object.
  if ( $_GET['full_headers'] ) {
    $data['headers'] = array();
    
    foreach ( $header_text as $header ) {
      preg_match( '/^(.+?):\s+(.*)$/', $header, $matches );
      if ( $matches ) {
        $data['headers'][ $matches[1] ] = $matches[2];
      }
    }
  }
  
  // Propagate all cURL request / response info to the JSON data object.
  if ( $_GET['full_status'] ) {
    $data['status'] = $status;
  } else {
    $data['status'] = array();
    $data['status']['http_code'] = $status['http_code'];
  }
  
  // Set the JSON data object contents, decoding it from JSON if possible.
  $decoded_json = json_decode( $contents );
  $data['contents'] = $decoded_json ? $decoded_json : $contents;
  
  // Generate appropriate content-type header.
  $is_xhr = strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
  header( 'Content-type: application/' . ( $is_xhr ? 'json' : 'x-javascript' ) );
  
  // Get JSONP callback.
  $jsonp_callback = $enable_jsonp && isset($_GET['callback']) ? $_GET['callback'] : null;
  
  // Generate JSON/JSONP string
  $json = json_encode( $data );
  
  print $jsonp_callback ? "$jsonp_callback($json)" : $json;
  
}

?>