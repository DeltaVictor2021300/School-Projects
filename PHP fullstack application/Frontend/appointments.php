<?php
session_start();
if (!isset($_SESSION['token_session'])) {
    // Si no hay una sesión activa, redirecciona al usuario a una página de inicio de sesión o a otra página de tu elección.
    header("Location: index.php");
    exit;
}
    $currentDate = date("Y-m-d");

if (isset($_SESSION['alert_appointment_delete'])) {
    echo "
<script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Your appointment was cancelled !',
        showConfirmButton: false,
        timer: 2200
      }).then(() => {
            var loginLink = document.getElementById('loginLink');
            loginLink.click();
        });
    });
</script>
";
    unset($_SESSION['alert_appointment_delete']);
}

if (isset($_SESSION['alert_appointment'])) {
    echo "
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Appointment was generated !!!',
      showConfirmButton: false,
      timer: 2000
    })
});
</script>
  ";
    unset($_SESSION['alert_appointment']);
}

if (isset($_SESSION['alert_appointment_update'])) {
    echo "
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Appointment was updated !!!',
      showConfirmButton: false,
      timer: 2000
    })
});
</script>
  ";
    unset($_SESSION['alert_appointment_update']);
}
?>
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
            <div class="container conatinerSection1a2 mt-5 mb-5">
                <div class="mt-5 mb-5  scroll-content fadeTop">
                <h3 class="fw-bold d-flex justify-content-center">Appointments</h3>
                    <div class="d-flex justify-content-end">
                        <button title="Add" class="p-2 mb-2 button" data-bs-toggle="modal" data-bs-target="#ModalToggleAppointment"><i class="fa-solid fa-address-card"></i> add Appointment</button>
                    </div>
                    <div class="table">
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>specialist</th>
                                    <th>comment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_SESSION['dataAppointment'])) {
                                    $appointments = $_SESSION['dataAppointment'];
                                    if (is_array($appointments) && !empty($appointments)) {
                                        foreach ($appointments as $appointment) {
                                ?>
                                            <tr>

                                                <td><?php echo $appointment['name']; ?></td>
                                                <td><?php echo $appointment['date']; ?></td>
                                                <td><?php echo $appointment['time']; ?></td>
                                                <td><?php echo $appointment['specialist']; ?></td>
                                                <td><?php echo $appointment['comment']; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <form action="GetupdateAppointment.php" method="post">
                                                                <input type="hidden" name="idAppointment" value="<?php echo $appointment['id']; ?>">
                                                                <button class="btn btn-outline-success me-2" title="Modify Appointment"><i class="fa-solid fa-user-pen"></i></button>
                                                            </form>
                                                        </div>
                                                        <div>
                                                            <form action="deleteAppointment.php" method="post">
                                                                <input type="hidden" name="idAppointment" value="<?php echo $appointment['id']; ?>">
                                                                <button type="submit" class="btn btn-outline-danger" title="Cancel Appointment" href=""><i class="fa-solid fa-user-xmark"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>specialist</th>
                                    <th>comment</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!--           VIEW MODAL TO ADD -->
            <div class="modal fade " id="ModalToggleAppointment" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered custom-modal">
                    <div class="modal-content p-1 rounded-4 text-secondary shadow">
                        <div class="d-flex justify-content-center">
                            <div class="bg-white p-4 stext-secondary " style="width: 25rem">

                                <form action="AddAppointment.php" method="post" id="formRegisterAppointment" class="row g-3 needs-validation" novalidate>
                                    <h5 class="mb-2 LoginTitle bold">Make an appointment:</h5>

                                    <div class="input-group mt-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <input class="form-control form-control-sm inputnone fw-bold" type="text" placeholder="Your Name" aria-label=".form-control-sm example" name="name" value="<?php echo $_SESSION['user_name']; ?>" required disabled>
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please enter your name.
                                        </div>
                                    </div>

                                    <div class="input-group mt-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                        <input class="form-control form-control-sm inputnone" type="tel" placeholder="Your Phone" aria-label=".form-control-sm example" name="phone" required>
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please enter your phone.
                                        </div>
                                    </div>

                                    <div class="input-group mt-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </div>
                                        <input class="form-control form-control-sm inputnone" type="text" placeholder="How did you Hear About Us ?" aria-label=".form-control-sm example" name="howdiduhearaboutus" required>
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please enter your opinion.
                                        </div>
                                    </div>

                                    <div class="input-group mt-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </div>
                                        <input class="form-control form-control-sm inputnone" type="date" min="<?php echo $currentDate; ?>" placeholder="Date for Appointment" aria-label=".form-control-sm example" name="date" required>
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please enter your date.
                                        </div>
                                    </div>

                                    <div class="input-group mt-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-regular fa-clock"></i>
                                        </div>
                                        <input class="form-control form-control-sm inputnone" type="time" placeholder="Time to Appointment" aria-label=".form-control-sm example" name="time" required>
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
                                            <option value="Hygiene & Prevention">Hygiene & Prevention</option>
                                            <option value="Dental Crowns">Dental Crowns</option>
                                            <option value="Dental Bridges">Dental Bridges</option>
                                            <option value="Dental Fillings">Dental Fillings</option>
                                            <option value="Root Canal">Root Canal</option>
                                            <option value="Oral Surgery">Oral Surgery</option>
                                            <option value="Implants">Implants</option>
                                        </select>
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please Chose the Service.
                                        </div>
                                    </div>
                                    <div class="input-group mt-2">
                                        <div class="input-group-text buttonLogin2">
                                            <i class="fa-solid fa-comment"></i>
                                        </div>
                                        <textarea class="form-control form-control-sm inputnone" type="textArea" rows="5" placeholder="Leave the reason here..." id="floatingTextarea" name="comment" required></textarea>
                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Describe the reason for the appointment.
                                        </div>
                                    </div>
                                    <div class="mb-0 text-end">
                                        <button class="button" type="submit">Schedule an Appointment</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--  --- -->


        </section>
    </main>
    <Footer class="container-fluid">
        <?php require 'footer.php'; ?>
    </Footer>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        new DataTable('#example');
    </script>

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

    <script>
        // Cuando la vista modal se cierra, limpiar los campos del formulario
        $('#ModalToggleAppointment').on('hidden.bs.modal', function() {
            $('#formRegisterAppointment').find('input').val('');
            $('#formRegisterAppointment').find('textarea').val('');
        });
    </script>
</body>

</html>