<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/banner1.jpg" class="d-block w-100" alt="banner1">
    </div>
    <div class="carousel-item">
      <img src="img/banner2.jpg" class="d-block w-100" alt="banner2">
    </div>
    <div class="carousel-item">
      <img src="img/banner3.jpg" class="d-block w-100" alt="banner3">
    </div>
    <div class="carousel-item">
      <img src="img/banner4.jpg" class="d-block w-100" alt="banner3">
    </div>
  </div>
</div>

<div class="Bannerbox scroll-content fadeBanner text-center my-auto">
  <h4 class="fw-bold BannerTitleLetter">New Patients Welcome</h4><br>
  <h6 >Dental Treatments for Whole Family</h6><br>
  <p >Call us today to book an appointment or request an appointment online</p> <br>

  <div class="mb-1 d-flex justify-content-center">
                            <?php if ($userLoggedIn) : ?>
                                                               <button class="button" type="submit" data-bs-toggle="modal" data-bs-target="#ModalToggleAppointment">Schedule an Appointment</button>
                            <?php else : ?>
                                <button class="button" id="loginLink" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
                                <i class="fa-solid fa-user"></i> Login or register to appointments.</button>
                           <?php endif; ?>
                        </div>
</div>

<div class="BannerLogo">
  <img src="img/logo.png" alt="logo" >
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
                                        <input class="form-control form-control-sm inputnone" type="date" placeholder="Date for Appointment" aria-label=".form-control-sm example" name="date" required>
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

