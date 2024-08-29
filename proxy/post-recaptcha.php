<?php
    $data = $_POST;
    $recaptchaSecret = '6LfX5zAqAAAAAAjHv1VYaQsSG8On1h96yurKJxWe';
    $recaptchaResponse = $data['g-recaptcha-response'];
    $api_link = $data['api_link'];
    unset($data['api_link']);


    // Consider using a more secure authentication method (e.g., token-based)
    $username = 'signupapi';
    //$password = '';
    $password_api = 'J8az&X(4IkuUaOS!8p3R';

    //$username = '';
    //$password = '!1';

    //This is the endpoint that MA provides to create a new Affiliate
    //$apiEndpoint = $api_link . '/feeds.php?FEED_ID=26';
    $apiEndpoint = $api_link;
    //$apiEndpoint = 'https://admin.throneneataffiliates.com/feeds.php?FEED_ID=26';

    $queryString = http_build_query($data);
    $apiEndpoint .= '&' . $queryString;

    $ch = curl_init($apiEndpoint);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password_api);

    $response = curl_exec($ch);
    //This line was added recently to get the errors
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    $responseCaptcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseKeys = json_decode($responseCaptcha, true);

    if (intval($responseKeys["success"]) !== 1) {
        echo json_encode(array(
            'success' => false,
            'message' => 'Please, Verify the reCAPTCHA',
        ));
        exit;
    }

    if ($httpCode !== 200) {
        echo json_encode(array(
            'success' => false,
            'error_code' => 400,
            'message' => $response,
            'data' => 'HTTP Error: ' . $httpCode,
        ));
        exit;
    }

    $xml = simplexml_load_string($response);

    if ($xml === false) {
        echo json_encode(array(
            'success' => false,
            'error_code' => 500,
            'data' => 'Invalid XML response',
        ));
        exit;
    }

    $errors = $xml->xpath('//ERROR');

    if (!empty($errors)) {
        $errorMessages = [];
        $errorCode = (int)$errors[0]['CODE']; // Assuming the first error contains the code

        foreach ($errors as $error) {
            $detail = 'PARAM_' . (string)$error['DETAIL'];
            $message = (string)$error->MSG;
            $errorMessages[$detail] = $message;
        }

        echo json_encode(array(
            'success' => false,
            'error_code' => $errorCode, // Use the retrieved code
            'data' => $errorMessages,
        ));
    } else {
        echo json_encode(array(
            'success' => true,
            'error_code' => 200,
            'data' => json_encode($xml, JSON_PRETTY_PRINT),
            'message' => 'Successfully registered',
        ));
    }
    header('Content-Type: application/json');
    echo $response;
    echo $responseKeys;
?>

   
