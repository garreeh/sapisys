<?php
include 'connections/connections.php';


if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['user_id'])) {
  if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == "1") {
    // If the user is an admin, redirect to the admin dashboard
    header("Location: /appointment/views/admin/dashboard.php");
  } else {
    // If the user is not an admin, redirect to the user dashboard
    header("Location: /appointment/index.php");
  }
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
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center mb-4">
                    <h1 class="h4 text-gray-900 mb-4"><strong>Choose Your Access</strong> </h1>
                  </div>

                  <!-- Responsive Box Grid -->
                  <div class="row text-center">

                    <!-- Accounting -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                      <a href="./accounting_login.php" class="text-decoration-none">
                        <div class="card shadow border-0 p-4">
                          <i class="fas fa-calculator fa-3x text-primary mb-3"></i>
                          <h6 class="text-dark">Accounting</h6>
                        </div>
                      </a>
                    </div>

                    <!-- Admin -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                      <a href="./admin_login.php" class="text-decoration-none">
                        <div class="card shadow border-0 p-4">
                          <i class="fas fa-user-shield fa-3x text-danger mb-3"></i>
                          <h6 class="text-dark">Admin</h6>
                        </div>
                      </a>
                    </div>

                    <!-- Executive -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                      <a href="./executive_login.php" class="text-decoration-none">
                        <div class="card shadow border-0 p-4">
                          <i class="fas fa-user-tie fa-3x text-success mb-3"></i>
                          <h6 class="text-dark">Executive</h6>
                        </div>
                      </a>
                    </div>

                    <!-- Finance -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                      <a href="./finance_login.php" class="text-decoration-none">
                        <div class="card shadow border-0 p-4">
                          <i class="fas fa-money-bill-wave fa-3x text-warning mb-3"></i>
                          <h6 class="text-dark">Finance</h6>
                        </div>
                      </a>
                    </div>

                    <!-- System Manager -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                      <a href="./system_manager_login.php" class="text-decoration-none">
                        <div class="card shadow border-0 p-4">
                          <i class="fas fa-laptop-code fa-3x text-info mb-3"></i>
                          <h6 class="text-dark">System Manager</h6>
                        </div>
                      </a>
                    </div>

                    <!-- Warehouse -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                      <a href="./warehouse_login.php" class="text-decoration-none">
                        <div class="card shadow border-0 p-4">
                          <i class="fas fa-warehouse fa-3x text-secondary mb-3"></i>
                          <h6 class="text-dark">Warehouse</h6>
                        </div>
                      </a>
                    </div>

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

  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

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

  function toggleRememberMe() {
    var rememberMeCheckbox = document.getElementById('customCheck');
    var rememberMeInput = document.getElementById('remember_me');

    // Check if rememberMeInput is not null
    if (rememberMeInput !== null) {
      rememberMeInput.value = rememberMeCheckbox.checked ? "1" : "0";
    }

    console.log(rememberMeInput);
  }

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
    // Get form data
    var usernameOrEmail = document.getElementById('username_or_email').value;
    var user_password = document.getElementById('user_password').value;
    var rememberMe = document.getElementById('remember_me').value; // Fix: use .value instead of .checked

    // Create data object
    var data = {
      username_or_email: usernameOrEmail,
      user_password: user_password,
      remember_me: rememberMe
    };

    $.ajax({
      type: 'POST',
      url: '../controllers/login_process.php',
      data: data,
      dataType: 'json',
      success: function(response) {
        console.log(response);
        if (response.success) {
          // Check if the user is an admin
          if (response.is_admin === "1") {
            window.location.href = "/appointment/views/admin/dashboard.php"; // Redirect to admin page
          } else {
            window.location.href = "/appointment/views/user/user_dashboard.php"; // Redirect to user page
          }
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