<?php 
session_start();
if(!isset($_SESSION["login"])) {
  header("Location: login_admin.php");
  exit();
}

include ('../config/db.php');

$query = "SELECT COUNT(*) AS total_user FROM users";
$result = $conn->query($query);
if($result) {
    $row = $result->fetch_assoc();
    $total_user = $row['total_user'];
}else{
  $total_user = 0;
}
$query = "SELECT COUNT(*) AS total_barang FROM product";
$result = $conn->query($query);
if($result) {
    $row = $result->fetch_assoc();
    $total_barang = $row['total_barang'];
}else{
  $total_barang = 0;
}
$query = "SELECT COUNT(*) AS total_orderan FROM admin_order";
$result = $conn->query($query);
if($result) {
    $row = $result->fetch_assoc();
    $total_orderan = $row['total_orderan'];
}else{
  $total_orderan = 0;
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <!-- Data Table -->
    <link
      href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css"
      rel="stylesheet"
    />

    <link href="./style/dashboard.css" rel="stylesheet" />
    <link rel="stylesheet" href="./style/style.css" />

    <!-- Font Awesome -->
    <script
      src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
      crossorigin="anonymous"
    ></script>

    <!-- Bs -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    />

    <style>
      nav {
        background-color: #003f62;
      }
    </style>
  </head>

  <body class="sb-nav-fixed">
        <?php include './layout/navbar-admin.php'?>
      <!-- Content -->
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item active">Utama</li>
            </ol>

            <div class="row">
              <div class="col-xl-4 col-md-6">
                <div class="card mb-4">
                  <div class="card-body">Total Barang</div>
                  <div class="card-footer">
                    <span><?php echo $total_barang ?></span>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 col-md-6">
                <div class="card mb-4">
                  <div class="card-body">User</div>
                  <div class="card-footer">
                    <span><?php echo $total_user?></span>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 col-md-6">
                <div class="card mb-4">
                  <div class="card-body">Total Orderan</div>
                  <div class="card-footer">
                    <span><?php echo $total_orderan?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

    <!-- Bs -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar -->
    <script src="./script/script.js"></script>

    <!-- Data Table -->
    <script
      src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="./script/data-table.js"></script>
  </body>
</html>
