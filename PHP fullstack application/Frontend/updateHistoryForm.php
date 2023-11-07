<?php
session_start();
if (!isset($_SESSION['token_session'])) {
    // Si no hay una sesión activa, redirecciona al usuario a una página de inicio de sesión o a otra página de tu elección.
    header("Location: index.php");
    exit;
}

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
        <div class="conatinerSection1a scroll-content fadeLeft">
        <h2 class="fw-bold d-flex justify-content-center">Clinic History</h2>
        <div class="form-control">
            <form action="<?php if (isset($responseData['id'])) {
                                echo ("updateHistory.php");
                            } else {
                                echo ("createHistory.php");
                            } ?>" class="row g-3 needs-validation m-4" method="post" id="updateHistory" novalidate>

                <input type="hidden" name="id" value="<?php if (isset($responseData['id'])) {
                                                            echo ($responseData['id']);
                                                        } ?>">

                <div class="col-md-6 ">
                    <label for="birth_date" class="form-label">Birth date</label>
                    <div class="input-group">
                        <div class="input-group-text buttonLogin2">
                            <img src="img/password-icon.svg" alt="password-icon" style="height: 1rem" />
                        </div>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?php if (isset($responseData['birth_date'])) {
                                                                                                                echo ($responseData['birth_date']);
                                                                                                            } ?>" required>
                <div class="invalid-feedback" style="font-size: 0.8rem">
                Please insert Birth date.
                                        </div>    
                </div>
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <div class="input-group">
                        <div class="input-group-text buttonLogin2">
                        <i class="fa-solid fa-venus-mars"></i>
                        </div>
                        <select class="form-select" aria-label="Default select example" id="gender" name="gender">
                            <option selected value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Non-binary">Non-binary</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <div class="input-group">
                        <div class="input-group-text buttonLogin2">
                        <i class="fa-solid fa-phone"></i>
                        </div>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php if (isset($responseData['phone'])) {
                                                                                                    echo ($responseData['phone']);
                                                                                                }  ?>" required>
                <div class="invalid-feedback" style="font-size: 0.8rem">
                Please insert Phone.
                                        </div>    
                </div>
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <div class="input-group">
                        <div class="input-group-text buttonLogin2">
                        <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <input type="text" class="form-control" id="address" name="address" value="<?php if (isset($responseData['address'])) {
                                                                                                        echo ($responseData['address']);
                                                                                                    }  ?>" required>
                    <div class="invalid-feedback" style="font-size: 0.8rem">
                Please insert Address.
                                        </div>
                </div>
                </div>
                <div class="col-md-6">
                    <label for="city" class="form-label">City</label>
                    <div class="input-group ">
                        <div class="input-group-text buttonLogin2">
                        <i class="fa-solid fa-building-circle-arrow-right"></i>
                        </div>
                        <input type="text" class="form-control" id="city" name="city" value="<?php if (isset($responseData['city'])) {
                                                                                                    echo ($responseData['city']);
                                                                                                }  ?>" required>
                <div class="invalid-feedback" style="font-size: 0.8rem">
                Please insert  city.
                                        </div>    
                </div>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <div class="input-group-text buttonLogin2">
                        <i class="fa-solid fa-envelope"></i>
                        </div>
                        <input type="email" class="form-control" id="email" name="email" value="<?php if (isset($responseData['email'])) {
                                                                                                    echo ($responseData['email']);
                                                                                                }  ?>" required>
                <div class="invalid-feedback" style="font-size: 0.8rem">
                Please insert Email.
                                        </div>    
                </div>
                </div>
                <div class="col-md-12">
                    <label for="medical_conditions" class="form-label">Medical conditions</label>
                    <div class="input-group">
                        <div class="input-group-text buttonLogin2">
                        <i class="fa-solid fa-user-doctor"></i>
                        </div>
                        <textarea rows="3" type="text" class="form-control" id="medical_conditions" name="medical_conditions" required><?php if (isset($responseData['medical_conditions'])) {
                                                                                                                                echo ($responseData['medical_conditions']);
                                                                                                                            }  ?></textarea>
                <div class="invalid-feedback" style="font-size: 0.8rem">
                Please insert Medical conditions.
                                        </div>    
                </div>
                </div>
                <div class="col-md-12">
                    <label for="current_medications" class="form-label">Current Medications</label>
                    <div class="input-group">
                        <div class="input-group-text buttonLogin2">
                        <i class="fa-solid fa-prescription-bottle"></i>
                        </div>
                        <textarea rows="3"  type="text" class="form-control" id="current_medications" name="current_medications" required><?php if (isset($responseData['current_medications'])) {
                                                                                                                                echo ($responseData['current_medications']);
                                                                                                                            }  ?></textarea>
                <div class="invalid-feedback" style="font-size: 0.8rem">
                Please insert Current Medications.
                                        </div>    
                </div>
                </div>
                <div class="col-md-12">
                    <label for="allergies" class="form-label">Allergies</label>
                    <div class="input-group">
                        <div class="input-group-text buttonLogin2">
                        <i class="fa-solid fa-viruses"></i>
                        </div>
                        <textarea rows="3"  type="text" class="form-control" id="allergies" name="allergies"  required><?php if (isset($responseData['allergies'])) {
                                                                                                            echo ($responseData['allergies']);
                                                                                                        }  ?></textarea>
                                <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please insert Allergies.
                                        </div>    
                </div>
                </div>
                <div class="col-md-12">
                    <label for="personal_habits" class="form-label">Personal Habits</label>
                    <div class="input-group">
                        <div class="input-group-text buttonLogin2">
                        <i class="fa-solid fa-star-of-life"></i>
                        </div>
                        <textarea rows="3"  type="text" class="form-control" id="personal_habits" name="personal_habits" required><?php if (isset($responseData['personal_habits'])) {
                                                                                                                        echo ($responseData['personal_habits']);
                                                                                                                    }  ?></textarea>
                <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please insert Personal Habits.
                                        </div>    
                </div>
                </div>
                <div class="col-md-12">
                    <label for="frequency_visits" class="form-label">Frequency Visits</label>
                    <div class="input-group">
                        <div class="input-group-text buttonLogin2">
                        <i class="fa-solid fa-kit-medical"></i>
                        </div>
                        <textarea rows="3"  type="text" class="form-control" id="frequency_visits" name="frequency_visits" required><?php if (isset($responseData['frequency_visits'])) {
                                                                                                                            echo ($responseData['frequency_visits']);
                                                                                                                        }  ?></textarea>
                                                        <div class="invalid-feedback" style="font-size: 0.8rem">
                                            Please insert Frequency Visits.
                                        </div>    
                </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <?php if (isset($responseData['id'])) : ?>
                        <a href="history.php" class="btn btn-secondary" role="button">Back</a>
                    <?php else : ?>
                        <a href="history.php" class="btn btn-secondary" role="button">Back</a>
                    <?php endif; ?>
                </div>

            </form>
            </div>
        </div>
        </div>
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