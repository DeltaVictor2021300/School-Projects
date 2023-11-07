<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
/*     $apiUrl = "http://127.0.0.1:8000/api/users/".$_SESSION['user_id']."/appointments"; // URL for API de Laravel Breeze */
    $apiUrl = "http://127.0.0.1:8000/api/users/".$_SESSION['user_id']."/appointments"; // URL for API de Laravel Breeze
    $phone = $_POST["phone"];
    $howdiduhearaboutus = $_POST["howdiduhearaboutus"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $specialist = $_POST["specialist"];
    $comment = $_POST["comment"];
    // form data for appointment
    $data = array(
        'name' => $_SESSION['user_name'],
        'phone' => $phone,
        'howdiduhearaboutus' => $howdiduhearaboutus,
        'date' => $date,
        'time' => $time.":00",
        'specialist' => $specialist,
        'comment' => $comment,
        'user_id' => $_SESSION['user_id'],
    );

    $header = array(
        'Authorization: Bearer '. $_SESSION['token_session'],
    );
    // start cURL
    $ch = curl_init();
    
    // setup request cURL
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
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
        if ($httpCode === 201) {
            // decode the JSON response
            $responseData = json_decode($response, true);
            // get response data
            $_SESSION['alert_appointment'] = "true";
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
