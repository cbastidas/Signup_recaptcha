<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    
    // Verifies the MA API
    if (!isset($data['api_link']) || empty($data['api_link'])) {
        echo json_encode(array(
            'success' => false,
            'error_code' => 400,
            'message' => 'API link missing in request',
        ));
        exit;
    }

    

    $api_link = $data['api_link'];
    unset($data['api_link']);

    // Authentication for MA
    $username = 'username';
    $password_api = 'password';

    // Build the query
    $queryString = http_build_query($data);
    $apiEndpoint = $api_link . '&' . $queryString;

    // cURL initializes
    $ch = curl_init($apiEndpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password_api);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch); // Obtain any cURL error
    curl_close($ch);


    // Errors control HTTP and cURL
    if ($httpCode !== 200) {
        echo json_encode(array(
            'success' => false,
            'error_code' => $httpCode,
            'message' => !empty($curlError) ? $curlError : $response,
            'data' => 'HTTP Error: ' . $httpCode,
        ));
        exit;
    }

    // Process the answer XML
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode(array(
            'success' => false,
            'error_code' => 500,
            'data' => 'Invalid XML response: ' . $response,
        ));
        exit;
    }

    // Verifies if there are errors XML
    $errors = $xml->xpath('//ERROR');
    if (!empty($errors)) {
        $errorMessages = [];
        $errorCode = (int)$errors[0]['CODE'];

        foreach ($errors as $error) {
            $detail = 'PARAM_' . (string)$error['DETAIL'];
            $message = (string)$error->MSG;
            $errorMessages[$detail] = $message;
        }

        echo json_encode(array(
            'success' => false,
            'error_code' => $errorCode,
            'data' => $errorMessages,
        ));
        exit;
    } else {
        // If no errors, Success
        echo json_encode(array(
            'success' => true,
            'error_code' => 200,
            'data' => json_encode($xml, JSON_PRETTY_PRINT),
        ));
        exit;
    }
} else {
    // Not allowed methods
    echo json_encode(array(
        'success' => false,
        'message' => 'Invalid request method',
    ));
    exit;
}
?>
