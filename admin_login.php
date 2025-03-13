<?php
include './connections/connections.php';


if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['user_id'])) {
  header("Location: /sapisys/admin/views/dashboard.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>St. Augustine</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <!-- Custom fonts for this template-->
  <link href="./assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="./assets/admin/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><strong>Admin</strong> | Sign-in</h1>
                  </div>

                  <form class="user" id="loginForm" onsubmit="submitForm(); return false;">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" placeholder="Enter User Code"
                        name="username" id="username" value="" required>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <input type="password" class="form-control form-control-user" placeholder="Password"
                          name="password" id="password" required>
                        <div class="input-group-append">
                          <span class="input-group-text" id="togglePassword">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <button type="button" class="btn btn-primary btn-user btn-block" onclick="submitForm()">Login</button>
                    <hr>
                  </form>

                  <div class="text-center">

                    <!-- <a class="small" href="./register.php">No Account? Register here</a>
                    </br>
                    <a class="small" href="./forgot_password.php">Forgot Password?</a>
                    </br> -->
                    <a class="small" href="./index.php">Home Page</a>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="./assets/admin/vendor/jquery/jquery.min.js"></script>
  <script src="./assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="./assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="./assets/admin/js/sb-admin-2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

</body>

</html>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('togglePassword').addEventListener('click', function() {
      var passwordInput = document.getElementById('user_password');
      var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      var icon = document.querySelector('#togglePassword i');
      icon.classList.toggle('fa-eye-slash');
    });
  });

  document.getElementById('loginForm').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
      submitForm();
    }
  });

  function showToast(message) {
    Toastify({
      text: message,
      duration: 3000,
      close: true,
      gravity: 'top',
      position: 'right',
      backgroundColor: 'red',
    }).showToast();
  }

  function submitForm() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    var data = {
      username: username,
      password: password,
    };

    $.ajax({
      type: 'POST',
      url: '/sapisys/admin/controllers/login_process.php',
      data: data,
      dataType: 'json',
      success: function(response) {
        console.log(response);
        if (response.success) {
          window.location.href = "/sapisys/admin/views/dashboard.php";
        } else {
          showToast(response.message);
        }
      },
      error: function(xhr, status, error) {
        showToast('Error occurred while processing the request.');
      }
    });
  }
</script>

<style>
  #togglePassword {
    cursor: pointer;
  }

  .custom-form-container {
    border: 1px solid #ced4da;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: whitesmoke;
    padding: 20px;
    margin-top: 50px;
  }

  /* Custom style to make the toast red */
  #incorrectPasswordToast,
  #userNotFoundToast {
    position: fixed;
    background-color: #dc3545;
    color: #fff;
  }

  @media (max-width: 576px) {
    #passwordMismatchToast {
      width: 100%;
      right: 0;
      margin: 0;
      transform: none;
      top: 70px;
      /* Adjust as needed */
    }
  }
</style>