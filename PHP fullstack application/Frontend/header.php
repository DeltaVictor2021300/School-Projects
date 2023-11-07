<?php
if (isset($_SESSION['alert'])) {
  echo "
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Login Successfull!',
      showConfirmButton: false,
      timer: 2000
    })
});
</script>
  ";
  unset($_SESSION['alert']);
}

if (isset($_SESSION['alert_register'])) {
  echo "
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Register Successfull!',
      showConfirmButton: false,
      timer: 2000
    })
});
</script>
  ";
  unset($_SESSION['alert_register']);
}
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="Aquadent" class="logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="mr-8">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#"><i class="fa fa-home fa-fw"></i> Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-sharp fa-solid fa-tooth"></i> Services
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Hygiene & Preventioin</a></li>
              <li><a class="dropdown-item" href="#">Dental Crowns</a></li>
              <li><a class="dropdown-item" href="#">Dental Bridges</a></li>
              <li><a class="dropdown-item" href="#">Dental Fillings</a></li>
              <li><a class="dropdown-item" href="#">Root Canal</a></li>
              <li><a class="dropdown-item" href="#">Oral Surgery</a></li>
              <li><a class="dropdown-item" href="#">Implants</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-user-doctor"></i> Our Team
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Dr. Ronald</a></li>
              <li><a class="dropdown-item" href="#">Dr. Merylin</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-stethoscope"></i> Specialties
            </a>

          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#"><i class="fa-solid fa-location-dot"></i> Locations</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link " aria-current="page" href="#"><i class="fa-solid fa-calendar-check"></i> Book Online</a>
          </li>

          <?php if (isset($_SESSION['token_session'])) {  ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-sharp fa-solid fa-user"></i> <?php echo $_SESSION['user_name']; ?></a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="AllApointments.php">Appointments</a></li>
                <li><a class="dropdown-item" href="history.php">Clinic History</a></li>
                <li><a class="dropdown-item" href="logout.php">Log out</a></li>
              </ul>
            <?php } else { ?>
            <li class="nav-item ">
              <a id="loginLink" class="nav-link " aria-current="page" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
                <i class="fa-solid fa-user"></i> Login</a>
            <?php } ?>
            </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<div class="modal fade " id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered custom-modal">
    <div class="modal-content p-1 rounded-4 text-secondary shadow">
      <div class="d-flex justify-content-center">
        <div class="bg-white p-5 stext-secondary " style="width: 25rem">
          <div class="d-flex justify-content-center">
            <img src="img/login-icon.svg" alt="login-icon" style="height: 4rem" />
          </div>
          <div class="text-center fs-4 fw-bold LoginTitle">Login</div>

          <form action="login_process.php" method="post" id="loginform" class="row g-3 needs-validation" novalidate>
            <div class="input-group mt-4">
              <div class="input-group-text buttonLogin2">
                <img src="img/username-icon.svg" alt="username-icon" style="height: 1rem" />
              </div>
              <input class="form-control bg-light" style="font-size: 0.9rem" type="text" placeholder="Username" id="emailLogin" name="email" required />
              <div class="invalid-feedback" style="font-size: 0.8rem">
                Please enter your email.
              </div>

            </div>
            <div class="input-group mt-1">
              <div class="input-group-text buttonLogin2">
                <img src="img/password-icon.svg" alt="password-icon" style="height: 1rem" />
              </div>
              <input class="form-control bg-light" style="font-size: 0.9rem" type="password" placeholder="Password" id="passwordLogin" name="password" required />
              <div class="invalid-feedback" style="font-size: 0.8rem">
                Please enter your password.
              </div>
            </div>
            <div class="d-flex justify-content-around align-items-center mt-1">
              <div class="d-flex align-items-center gap-1">
                <input class="form-check-input" type="checkbox" />
                <div class="pt-1" style="font-size: 0.9rem">Remember me</div>
              </div>
              <div>
                <a href="#" class="text-decoration-none text-primary fw-semibold fst-italic" style="font-size: 0.9rem">Forgot your password?</a>
              </div>
            </div>
            <input class="btn buttonLogin text-white w-100 mt-2 mb-3 fw-semibold shadow-sm" type="submit" value="Login">
          </form>

          <div class="pt-1" style="font-size: 0.9rem">Don't have an account?</div>
          <input id="registerLink" class="btn btn-danger text-white w-100 mt-1 fw-semibold shadow-sm" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" class="text-decoration-none text-info fw-semibold" value="Register" id="registerButton1" type="button">

          <div class="p-3">
            <div class="border-bottom text-center" style="height: 0.9rem">
              <span class="bg-white px-3">or</span>
            </div>
          </div>
          <div class="btn d-flex gap-2 justify-content-center border mt-2 shadow-sm">
            <img src="img/google-icon.svg" alt="google-icon" style="height: 1.6rem" />
            <div class="fw-semibold text-secondary" style="font-size: 0.9rem">Continue with Google</div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade " id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered custom-modal">
    <div class="modal-content">
      <!--       <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Register</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> -->
      <div class="modal-body p-5">
        <div class="text-center fs-5 LoginTitle">Registration</div>

        <div class="border-bottom text-center" style="height: 0.9rem">

        </div>

        <form action="register.php" method="post" id="formRegister" class="row g-3 needs-validation2" novalidate>

          <div class="input-group mt-4">
            <div class="input-group-text buttonLogin2">
              <img src="img/username-icon.svg" alt="username-icon" style="height: 1rem" />
            </div>
            <input class="form-control bg-light" style="font-size: 0.9rem" type="text" placeholder="Name" id="nameRegister" name="name" required />
            <div class="invalid-feedback" style="font-size: 0.8rem">
              Please enter your Name.
            </div>
          </div>

          <div class="input-group mt-1">
            <div class="input-group-text buttonLogin2">
            <i class="fa-solid fa-envelope"></i>
            </div>
            <input class="form-control bg-light" style="font-size: 0.9rem" type="email" placeholder="Email" id="emailRegister" name="email" required />
            <div class="invalid-feedback" style="font-size: 0.8rem">
              Please enter your email.
            </div>
          </div>

          <div class="input-group mt-1">
            <div class="input-group-text buttonLogin2">
              <img src="img/password-icon.svg" alt="password-icon" style="height: 1rem" />
            </div>
            <input class="form-control bg-light" style="font-size: 0.9rem" placeholder="Password" type="password" id="passwordRegister" name="password" required />
            <div class="invalid-feedback" style="font-size: 0.8rem">
              Please enter your password, must be at least 8 characters.
            </div>
          </div>
          <div class="input-group mt-1 mb-3">
            <div class="input-group-text buttonLogin2">
              <img src="img/password-icon.svg" alt="password-icon" style="height: 1rem" />
            </div>
            <input class="form-control bg-light" style="font-size: 0.9rem" type="password" placeholder="Repeat Password" id="password_confirmationRegister" name="password_confirmation" required />
            <div class="invalid-feedback" style="font-size: 0.8rem">
              The password field confirmation does not match.
            </div>
            <div class="text-danger" style="font-size: 0.7rem">
              The password field must be at least 8 characters.
            </div>
          </div>
          <div class="text-secondary" style="font-size: 0.8rem">
            By clicking Register, you agree on our <span class="text-primary">Privacy Policy.</span> </div>
          <input class="btn buttonLogin text-white w-100 mt-2 mb-3 fw-semibold shadow-sm" type="submit" value="Register">
        </form>


        <div class="pt-1" style="font-size: 0.9rem">Have an account?</div>
        <div class="btn btn-danger text-white w-100 mt-1 fw-semibold shadow-sm" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" class="text-decoration-none text-info fw-semibold">
          Login Here
        </div>

      </div>
      <?php
      if (isset($_SESSION['alert_error'])) {
        echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Invalid credentials. Try again!',
            showConfirmButton: false,
            timer: 2200
          }).then(() => {
                var loginLink = document.getElementById('loginLink');
                loginLink.click();
            });
        });
    </script>
    ";
        unset($_SESSION['alert_error']);
      }


      if (isset($_SESSION['alert_register_error'])) {
        echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
          
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'The email ".$_SESSION['emailRegister'].", is already used, try with another email',
            }).then(() => {
                var registerLink = document.getElementById('registerLink');
                registerLink.click();
            });
        });
    </script>
    ";
        unset($_SESSION['alert_register_error']);
        unset($_SESSION['emailRegister']);
      }
      ?>


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
        (() => {
          'use strict'
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          const forms = document.querySelectorAll('.needs-validation2')

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
        document.getElementById("loginform").addEventListener("submit", function(event) {
          event.preventDefault();
          // Get form elements
          var emailInput = document.getElementById("emailLogin");
          var passwordInput = document.getElementById("passwordLogin");
          // Perform validation
          var isValid = true;
          if (!isValidEmail(emailInput.value.trim())) {
            emailInput.classList.add("is-invalid");
            isValid = false;
          } else {
            emailInput.classList.remove("is-invalid");
          }
          if (passwordInput.value.trim() === "") {
            passwordInput.classList.add("is-invalid");
            isValid = false;
          } else {
            passwordInput.classList.remove("is-invalid");
          }
          // Function to validate email format
          function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
          }
          if (isValid) {
            // If all fields are valid, submit the form
            this.submit();
          }
        });
      </script>

      <script>
        document.getElementById("formRegister").addEventListener("submit", function(event) {
          event.preventDefault();

          var nameRegister = document.getElementById("nameRegister");
          var emailRegister = document.getElementById("emailRegister");
          var passwordRegister = document.getElementById("passwordRegister");
          var passwordConfirmRegister = document.getElementById("password_confirmationRegister");

          var isValid2 = true;
          if (!isValidEmail(emailRegister.value.trim())) {
            emailRegister.classList.add("is-invalid");
            isValid2 = false;
          } else {
            emailRegister.classList.remove("is-invalid");
          }

          if (nameRegister.value.trim() === "") {
            nameRegister.classList.add("is-invalid");
            isValid2 = false;
          } else {
            nameRegister.classList.remove("is-invalid");
          }

          if (passwordRegister.value.length < 8) {
            passwordRegister.classList.add("is-invalid");
            isValid2 = false;
          } else {
            passwordRegister.classList.remove("is-invalid");
          }

          if (passwordRegister.value !== passwordConfirmRegister.value) {
            passwordConfirmRegister.classList.add("is-invalid");
            isValid2 = false;
          } else {
            passwordConfirmRegister.classList.remove("is-invalid");
          }
          // Function to validate email format
          function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
          }

          if (isValid2) {
            // If all fields are valid, submit the form
            this.submit();
          }
        });
      </script>

