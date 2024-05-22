<?php
session_start();
include('../config/db.php');

if (isset($_SESSION["login"])) {
  header("Location:dashboard.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <!-- Bs -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <!-- Default -->
  <link rel="stylesheet" href="./style/style.css" />

  <style>
    .form-control {
      border: none;
      border-bottom: 1px solid #ced4da;
    }
  </style>
</head>

<body style="background-color: #f6f5f2">
  <!-- Header -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Toko Wisdom</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        
      </div>
    </nav>
  </header>

  <!-- Login -->
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem">
            <div class="card-body p-5 text-center">
              <h3 class="mb-5">Login Admin</h3>
              <form action="process_login_admin.php" method="POST" class="mb-3 form-control-lg">
                <div class="form-outline mb-4">
                  <input type="text" class="form-control form-control-lg" name="username" placeholder="Username" />
                </div>

                <div class="form-outline mb-4">
                  <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" />
                </div>

                <button class="btn btn-warning btn-lg btn-block form-control form-control-lg" type="submit" name="login" style="color: white; border-bottom: none;">
                  Login
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Bs -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Ion Icon -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>