<?php
session_start();
include('includes/scripts.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="img/logo.png">
  <title> Technology Sandbox </title>

  <!-- Custom fonts -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  
  <script>
    // error message fade out
    $(document).ready(function() {
      $('.alert').fadeIn().delay(1000).fadeOut();
    });
  </script>

</head>

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-1 static-top shadow">
  <a class="logo"  href="https://library.wit.edu/tech-sandbox" target="_blank">
    <img class="logo" alt="Technology Sandbox Logo" src="img/logo2.png" width="260" height="35">
  </a>
</nav>


<body id="page-top" style="background-image: url('img/bg.jpg'); width: 100%; height:100%;">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <div class="container">

      <!-- Outer Row -->
      <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-6">
          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-4">

              <!-- Nested Row within Card Body -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="p-5">
                    <div class="text-center">
                      <h1 class="h3 text-gray-900 mb-4">Admin Login</h1>
                      <?php
                      if (isset($_SESSION['message'])) : ?>
                        <div class="alert alert-<?= $_SESSION['msg_type'] ?>">
                          <?php
                          // display error message
                          echo $_SESSION['message'];
                          unset($_SESSION['message']);
                          ?>
                        </div>
                      <?php endif ?>
                    </div>
                    <form class="user" action="process.php" method="POST">
                      <div class="form-group">
                        <input type="email" name="loginEmail" class="form-control form-control-user" placeholder="Enter Email Address">
                      </div>
                      <div class="form-group">
                        <input type="password" name="loginPassword" class="form-control form-control-user" placeholder="Enter Password"> </br>
                      </div>
                      <button type="submit" name="login_btn" class="btn btn-primary btn-user btn-block"> Login </button>
                      <button class="btn btn-light btn-user btn-block" onclick="document.location='user_index.html'">Cancel</button>
                    </form>

                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
  <!-- End of Page Wrapper -->


</body>

</html>