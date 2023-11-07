<?php 
session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $endpoint = "http://127.0.0.1:8000/api/users/". $_SESSION['user_id'] ."/clinic_histories/". $_POST['id'];

    $data = array(
        'birth_date' => $_POST['birth_date'],
        'gender' => $_POST['gender'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'email' => $_POST['email'],
        'medical_conditions' => $_POST['medical_conditions'],
        'current_medications' => $_POST['current_medications'],
        'allergies' => $_POST['allergies'],
        'personal_habits' => $_POST['personal_habits'],
        'frequency_visits' => $_POST['frequency_visits']
    );

    $jsonData = json_encode($data);

    $headers = array(
        'Authorization: Bearer ' . $_SESSION['token_session'],
        'Content-Type: application/json'
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    }
    
    curl_close($ch);
    header("Location: history.php");
    exit;
}
?>