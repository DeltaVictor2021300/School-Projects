<?php
function redir()
{
    header("Location: updateHistoryForm.php");
    exit;
}


session_start();

//get user history
if (isset($_SESSION['token_session']) && isset($_SESSION['user_id'])) {
    $apiUrl = ("http://127.0.0.1:8000/api/users/" . $_SESSION['user_id'] . "/clinic_histories");
    $headers = array(
        'Authorization: Bearer ' . $_SESSION['token_session']
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $responseData = json_decode($response, true);

    curl_close($ch);
    if (!isset($responseData['id'])) {
        redir();
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="carlos Johel Mejia Arribasplata" />
    <meta name="email" content="carlosmejia1814@gmail.com" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/logo.png" sizes="16x16">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Aquadent Dental</title>
    <script src="js/js.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dcae34017c.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <section>
            <?php require 'header.php'; ?>
        </section>
        <section>
           <img src="img/Banner2.png">           
        </section>
    </header>
    <main>
        
        <div class="container mt-5 mb-5">
        <div class="conatinerSection1a2 scroll-content fadeTop">
            <div class="row d-flex">

                <div class="col-4 me-4 p-5">
                    <img src="img/merylin.png" alt="">
                </div>

                <div class="col-7 m-4">
                    <h3 class="fw-bold d-flex justify-content-center">Clinic History</h3>
                    <br>

                    <table class="table table-striped" id="display">
                        <thead>
                        </thead>
                        <tbody>
                            <?php foreach ($responseData as $key => $value) : ?>
                                <tr>
                                    <td><?php echo ($key) ?></td>
                                    <td><?php echo ($value) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <a href="updateHistoryForm.php" class="btn btn-primary pl-5 pr-5" role="button">Edit</a>
                </div>
            </div>
        </div>
        </div>
    </main>
    <Footer class="container-fluid">
        <?php require 'footer.php'; ?>
    </Footer>
</body>