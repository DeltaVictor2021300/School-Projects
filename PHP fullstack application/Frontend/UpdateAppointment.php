<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {    
    $appointmentID = $_POST["appointmentID"];
    $apiUrl = "http://127.0.0.1:8000/api/users/".$_SESSION['user_id']."/appointments/".$appointmentID; // URL for API de Laravel Breeze

    // form data for appointment
    $data = array(
        'name' => $_SESSION['user_name'],
        'phone' => $_POST["phone"],
        'howdiduhearaboutus' => $_POST["howdiduhearaboutus"],
        'date' => $_POST["date"],
        'time' => $_POST["time"],
        'specialist' => $_POST["specialist"],
        'comment' => $_POST["comment"],
        'id' => $appointmentID
    );

    $header = array(
        'Authorization: Bearer ' . $_SESSION['token_session'],
         );

    // start cURL
    $ch = curl_init();
    
        // setup request cURL
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

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
            $_SESSION['alert_appointment_update'] = "true";
            include 'AllApointments.php';
            exit;
        } else {
            $_SESSION['alert_error_appointment'] = "true";
           header("Location: appointments.php");
            exit;           
        }
    }

    // close cURL
    curl_close($ch);
}
?>
