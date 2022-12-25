<?php
    session_save_path('/tmp');

    session_start();
    session_unset();
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!--<link href="img/logo/logo.png" rel="icon">-->
  <title>Login - PT Berkah Permata Logistik</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center" style="text-align:center;">
      <div class="col-xl-10 col-lg-12 col-md-9">
	   <!--<h2 style="color:black; text-align:center" class="mb-4">PT Berkah Permata Logistik</h2>
	  <h4 style="color:black; text-align:center" class="mb-4">Management</h4>-->
	      <img src="img/logo-BPL-min.png" style="width:70%;margin-left:auto;margin-right:auto;margin-top:50px;">
        <div class="card shadow-sm my-5" style="margin-top:5px !important;">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                    <p>v1.1.4</p>
                  </div>
                  <?php 
                    if(isset($_GET['pesan'])){
                        if($_GET['pesan'] == "gagal"){
                          echo '<p><div class="alert alert-warning">Login gagal! Kombinasi username dan password salah!</div></p>';
                        }else if($_GET['pesan'] == "inactive"){
                          echo '<p><div class="alert alert-warning">Login gagal! Akun tidak aktif, silahkan hubungi admin</div></p>';
                        }else if($_GET['pesan'] == "logout"){
                          echo '<p><div class="alert alert-success">Logout berhasil</div></p>';
                        }
                    }
                  ?>

                  <form class="user" method="post" action="config/cek-login.php">
                    <div class="form-group">
                      <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-group mb-4">
                      <!-- <input type="password" class="form-control" name="password" placeholder="Password"> -->
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="changeType()"><i id="btnPasswordIcon" class="fas fa-eye"></i></button>
                      </div>
                    </div>
                    <div class="form-group">
                      <!--<a href="dashboard.html" class="btn btn-primary btn-block">Login</a>-->
					            <input type="submit" name="doLogin" class="btn btn-primary btn-block" value="Login">
                    </div>
                  </form>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script>
    function changeType() {
      var passwordInputType = document.getElementById('password');
      var btnPasswordIcon = document.getElementById('btnPasswordIcon');
      if(passwordInputType.type == 'password') {
        passwordInputType.type = 'text';
        btnPasswordIcon.classList.remove('fa-eye');
        btnPasswordIcon.classList.add('fa-eye-slash');
      } else {
        passwordInputType.type = 'password';
        btnPasswordIcon.classList.remove('fa-eye-slash');
        btnPasswordIcon.classList.add('fa-eye');
      }
    }
  </script>
</body>

</html>