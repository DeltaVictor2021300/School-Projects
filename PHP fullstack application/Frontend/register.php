<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    $apiUrl = "http://127.0.0.1:8000/register"; // URL for API de Laravel Breeze
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    // form data for login
    $data = array(
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'password_confirmation' => $password_confirmation,
    );

    // start cURL
    $ch = curl_init();

    // setup request cURL
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
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
            $token = $responseData['token'];
            $_SESSION['token_session'] = $token;
            $_SESSION['username'] = $_POST["email"];
            $_SESSION['alert_register'] = "true";
            $_SESSION['user_id'] = $responseData['user']['id'];
            $_SESSION['user_name'] = $responseData['user']['name'];
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['alert_register_error'] = "true";
            $_SESSION['emailRegister'] = $_POST["email"];
            header("Location: index.php");
            exit;
        }
    }

    // close cURL
    curl_close($ch);
}
?>