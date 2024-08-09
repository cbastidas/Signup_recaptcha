<?php
$data = $_POST;

// Verificar si 'api_link' está definido
if (!isset($data['api_link']) || empty($data['api_link'])) {
    echo json_encode(array(
        'success' => false,
        'error_code' => 400,
        'data' => 'Missing or empty api_link parameter',
    ));
    exit;
}

$api_link = $data['api_link'];
unset($data['api_link']);

header('Content-Type: application/json');

// Consider using a more secure authentication method (e.g., token-based)
$username = 'signupapi';
$password = 'J8az&X(4IkuUaOS!8p3R';

$apiEndpoint = $api_link . 'feeds.php?FEED_ID=26';

$queryString = http_build_query($data);
$apiEndpoint .= '&' . $queryString;

$ch = curl_init($apiEndpoint);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);

$response = curl_exec($ch);
//echo $response;
//curl_close($ch);
//return null;

if ($response === false) {
    $error = curl_error($ch);
    $response = json_encode(array(
        'success' => false,
        'error_code' => 500,
        'data' => 'cURL Error: ' . $error,
    ));
} else {
    $xml = @simplexml_load_string($response);

    if ($xml === false) {
        $response = json_encode(array(
            'success' => false,
            'error_code' => 500,
            'data' => 'Invalid XML response',
        ));
    } else {
        $errors = $xml->xpath('//ERROR');

        if (!empty($errors)) {
            $errorMessages = [];
            $errorCode = (int)$errors[0]['CODE']; // Assuming the first error contains the code

            foreach ($errors as $error) {
                $detail = 'PARAM_' . (string)$error['DETAIL'];
                $message = (string)$error->MSG;
                $errorMessages[$detail] = $message;
            }

            $response = json_encode(array(
                'success' => false,
                'error_code' => $errorCode, // Use retrieved code
                'data' => $errorMessages,
            ));
        } else {
            $response = json_encode(array(
                'success' => true,
                'error_code' => 200,
                'data' => json_encode($xml, JSON_PRETTY_PRINT),
            ));
        }
    }
}

echo $response;
curl_close($ch);
?>
