<?php session_start();
$userLoggedIn = isset($_SESSION['token_session']);
function isFieldDisabled($userLoggedIn)
{
    return $userLoggedIn ? '' : 'disabled';
}
?>
<!DOCTYPE html>
<html lang="en">

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
    <Header>
        <section>
        <?php require 'header.php'; ?>
        </section>
        <section>
            <?php require 'carousel.php'; ?>
        </section>
    </Header>
    <main>
        <section>
            <?php require 'section1.php'; ?>
        </section>
        <section>
            <?php require 'section3.php'; ?>
        </section>
        <section>
            <?php require 'section2.php'; ?>
        </section>
        <section>
            <?php require 'section4.php'; ?>
        </section>
    </main>
    <Footer class="container-fluid">
        <?php require 'footer.php'; ?>
    </Footer>

</body>

</html>