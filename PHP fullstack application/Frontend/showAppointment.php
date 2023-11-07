<?php
session_start();
if (!isset($_SESSION['token_session'])) {
    // Si no hay una sesión activa, redirecciona al usuario a una página de inicio de sesión o a otra página de tu elección.
    header("Location: index.php");
    exit;
}

$currentDate = date("Y-m-d");

if (isset($_SESSION['showAppointment'])) {
    $showAppointment = $_SESSION['showAppointment'];
    $showPhoneName = $showAppointment['phone'];
    $showHowdiduhearaboutus = $showAppointment['howdiduhearaboutus'];
    $showDate = $showAppointment['date'];
    $showTime = $showAppointment['time'];
    $showSpecialist = $showAppointment['specialist'];
    $showComment = $showAppointment['comment'];
    $appointmentID = $showAppointment['id'];
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="carlos Johel Mejia Arribasplata" />
    <meta name="email" content="carlosmejia1814@gmail.com" />
    <!--     library for datatable -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
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
    <script type="text/javascript" src="js/js.js"></script>
</head>

<body>
    <Header>
        <section>
            <?php require 'header.php'; ?>
        </section>
        <section>
           <img src="img/Banner1.png">           
        </section>
    </Header>
    <main>
        <section>
            <div class="container mt-5 mb-5">
                <div class="d-flex justify-content-between mr-20 ml-20 scroll-content fadeLeft ">
                    <div class="row">
                        <div class="col-xl-6 d-flex align-items-center justify-content-center mb-5">
                            <img src="img/appointement.png" alt="Ottawa Dentist" class="OttawaDentistImg2">
                        </div>
                        <div class="col-xl-6 mb-5">
                            <div class="conatinerSection1a ">
                                <form action="UpdateAppointment.php" method="post" id="formRegisterAppointment" class="row g-3 needs-validation" novalidate>
                                    <h5 class="mb-2 LoginTitle bold">Make an appointment:</h5>
                                    <input type="hidden" name="appointmentID" value="<?php echo $appointmentID; ?>">
                                    <div class="input-group mt-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <input class="form-control form-control-sm inputnone " type="text" placeholder="Your Name" aria-label=".form-control-sm example" name="name" value="<?php echo $_SESSION['user_name']; ?>" required disabled>
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please enter your name.
                                        </div>
                                    </div>

                                    <div class="input-group d-flex align-items-center justify-content-center mt-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                        <input class="form-control form-control-sm inputnone" type="tel" placeholder="Your Phone" aria-label=".form-control-sm example" name="phone" value="<?php echo $showPhoneName; ?>" required>
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please enter your phone.
                                        </div>
                                    </div>

                                    <div class="input-group mt-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </div>
                                        <input class="form-control form-control-sm inputnone" type="text" placeholder="How did you Hear About Us ?" aria-label=".form-control-sm example" name="howdiduhearaboutus" value="<?php echo $showHowdiduhearaboutus; ?>" required>
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please enter your opinion.
                                        </div>
                                    </div>

                                    <div class="input-group mt-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </div>
                                        <input class="form-control form-control-sm inputnone" type="date" min="<?php echo $currentDate; ?>" placeholder="Date for Appointment" aria-label=".form-control-sm example" name="date" value="<?php echo $showDate; ?>" required>
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please enter your date.
                                        </div>
                                    </div>

                                    <div class="input-group mt-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-regular fa-clock"></i>
                                        </div>
                                        <input class="form-control form-control-sm inputnone" type="time" placeholder="Time to Appointment" aria-label=".form-control-sm example" name="time" value="<?php echo $showTime; ?>" >
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please enter your time.
                                        </div>
                                    </div>

                                    <div class="input-group mt-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-solid fa-stethoscope"></i>
                                        </div>
                                        <select class="form-select form-select-sm" name="specialist" required>
                                            <option selected disabled value="">What Services do you want ?</option>
                                            <option value="Hygiene & Prevention" <?php if ($showSpecialist === 'Hygiene & Prevention') echo 'selected'; ?>>Hygiene & Prevention</option>
                                            <option value="Dental Crowns" <?php if ($showSpecialist === 'Dental Crowns') echo 'selected'; ?>>Dental Crowns</option>
                                            <option value="Dental Bridges" <?php if ($showSpecialist === 'Dental Bridges') echo 'selected'; ?>>Dental Bridges</option>
                                            <option value="Dental Fillings" <?php if ($showSpecialist === 'Dental Fillings') echo 'selected'; ?>>Dental Fillings</option>
                                            <option value="Root Canal" <?php if ($showSpecialist === 'Root Canal') echo 'selected'; ?>>Root Canal</option>
                                            <option value="Oral Surgery" <?php if ($showSpecialist === 'Oral Surgery') echo 'selected'; ?>>Oral Surgery</option>
                                            <option value="Implants" <?php if ($showSpecialist === 'Implants') echo 'selected'; ?>>Implants</option>
                                        </select>
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please Chose the Service.
                                        </div>
                                    </div>
                                    <div class="input-group mt-2 mb-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-solid fa-comment"></i>
                                        </div>
                                        <textarea class="form-control form-control-sm inputnone" type="textArea" rows="5" placeholder="Leave the reason here..." id="floatingTextarea" name="comment" required><?php echo $showComment; ?></textarea>
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Describe the reason for the appointment.
                                        </div>
                                    </div>

                                    <div class="mb-1 d-flex justify-content-center">
                                    <a href="appointments.php"> <input type="button" class="btn buttonLogin me-4" value="Back to Appointments"></a>
                                        <button class="button" type="submit">Update your Appointment</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
    <Footer class="container-fluid">
        <?php require 'footer.php'; ?>
    </Footer>

    <script>
        (() => {
            'use strict'
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>