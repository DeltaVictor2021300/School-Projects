<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idAppointment = $_POST["idAppointment"];
    $apiUrl = "http://127.0.0.1:8000/api/users/".$_SESSION['user_id']."/appointments/". $idAppointment; // URL for API de Laravel Breeze
    $header = array(
        'Authorization: Bearer '. $_SESSION['token_session'],
    );

    // start cURL
    $ch = curl_init();
    
    // setup request cURL
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    // run request cURL
    $response = curl_exec($ch);

    // check any error in connection
    if (curl_errno($ch)) {
        echo "Error request to the API: " . curl_error($ch);
    } else {
        // get the response in HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode === 200) {
            // decode the JSON response
            $responseData = json_decode($response, true);
            // get response data
            $_SESSION['alert_appointment_delete'] = "true";
            include 'AllApointments.php';
            exit;
        } else {
            $_SESSION['alert_error_appointment_delete'] = "true";
           header("Location: appointments.php");
            exit;           
        }
    }

    // close cURL
    curl_close($ch);
}
?>
