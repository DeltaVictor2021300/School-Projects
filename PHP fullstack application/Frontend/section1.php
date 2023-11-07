<?php
    $currentDate = date("Y-m-d");
?>
<div class="container">
    <div class="d-flex justify-content-between mr-20 ml-20 scroll-content fadeLeft section1">
        <div class="row">
            <div class="col-xl-4 mb-5">
                <div class="conatinerSection1a ">
                    <form action="AddAppointment.php" method="post" id="formRegisterAppointment" <?php if ($userLoggedIn) {?>class="row g-3 needs-validation" novalidate<?php }?>>
                        <h5 class="mb-2 LoginTitle bold">Make an appointment:</h5>

                        <div class="input-group mt-2">
                            <div class="input-group-text buttonLogin2">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input class="form-control form-control-sm inputnone " type="text" placeholder="Your Name" aria-label=".form-control-sm example" name="name" <?php if ($userLoggedIn) {?> value="<?php echo $_SESSION['user_name']; ?>"required disabled class="fw-bold"<?php }?>>
                            <div class="invalid-feedback" style="font-size: 0.8rem">
                                Please enter your name.
                            </div>
                        </div>

                        <div class="input-group mt-2">
                            <div class="input-group-text buttonLogin2">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <input class="form-control form-control-sm inputnone" type="tel" placeholder="Your Phone" aria-label=".form-control-sm example" name="phone" <?php if ($userLoggedIn) {?>required<?php }?>>
                            <div class="invalid-feedback" style="font-size: 0.8rem">
                                Please enter your phone.
                            </div>
                        </div>

                        <div class="input-group mt-2">
                            <div class="input-group-text buttonLogin2">
                                <i class="fa-solid fa-circle-question"></i>
                            </div>
                            <input class="form-control form-control-sm inputnone" type="text" placeholder="How did you Hear About Us ?" aria-label=".form-control-sm example" name="howdiduhearaboutus" <?php if ($userLoggedIn) {?>required<?php }?>>
                            <div class="invalid-feedback" style="font-size: 0.8rem">
                                Please enter your opinion.
                            </div>
                        </div>

                        <div class="input-group mt-2">
                            <div class="input-group-text buttonLogin2">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <input class="form-control form-control-sm inputnone" type="date" min="<?php echo $currentDate; ?>" placeholder="Date for Appointment" aria-label=".form-control-sm example" name="date" <?php if ($userLoggedIn) {?>required<?php }?>>
                            <div class="invalid-feedback" style="font-size: 0.8rem">
                                Please enter your date.
                            </div>
                        </div>

                        <div class="input-group mt-2">
                            <div class="input-group-text buttonLogin2">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <input class="form-control form-control-sm inputnone" type="time" placeholder="Time to Appointment" aria-label=".form-control-sm example" name="time" <?php if ($userLoggedIn) {?>required<?php }?>>
                            <div class="invalid-feedback" style="font-size: 0.8rem">
                                Please enter your time.
                            </div>
                        </div>

                        <div class="input-group mt-2">
                            <div class="input-group-text buttonLogin2">
                                <i class="fa-solid fa-stethoscope"></i>
                            </div>
                            <select class="form-select form-select-sm" name="specialist" <?php if ($userLoggedIn) {?>required<?php }?>>
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
                        <div class="input-group mt-2 mb-2">
                            <div class="input-group-text buttonLogin2">
                                <i class="fa-solid fa-comment"></i>
                            </div>
                            <textarea class="form-control form-control-sm inputnone" type="textArea" rows="5" placeholder="Leave the reason here..." id="floatingTextarea" name="comment" <?php if ($userLoggedIn) {?>required<?php }?>></textarea>
                            <div class="invalid-feedback" style="font-size: 0.8rem">
                                Describe the reason for the appointment.
                            </div>
                        </div>

                        <div class="mb-1 d-flex justify-content-center">
                            <?php if ($userLoggedIn) : ?>
                                                               <button class="button" type="submit">Schedule an Appointment</button>
                            <?php else : ?>
                                <input type="button" class="btn buttonLogin" id="loginLink" data-bs-toggle="modal" data-bs-target="#exampleModalToggle" value="Login or register to appointments">
 <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-8 d-flex align-items-center">
                <div class="d-flex justify-content-between conatinerSection1b">
                    <div class="row">
                        <div class="col-lg-6 ">
                            <span class=" textTitleWhite">OTTAWA DENTIST</span>
                            <hr class="hr2">
                            <p>Aquadent Dental, Located In Ottawa, Ottawa Dental Needs. With State Of The Art Technology On-Site, We Are Proud To Offer Our Patients A Comprehensive Approach To Their Ottawa Family Dentistry Needs, Including Denture Fabrication And Dental Implant Treatments. We Offer A Variety Of Family-Friendly Services, Including General Dental Cleaning And Check-Ups, Dental Implants & Prosthetics, Denture Fabrication, Root Canal Treatment, And More, With Appointments Available Off-Hours.</p>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-center align-items-center">
                            <img src="img/ottawa-dentist.png" alt="Ottawa Dentist" class="OttawaDentistImg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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