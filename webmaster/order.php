<?
session_start();
include '../config/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>

  <!-- Data Table -->
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />

  <link href="./style/dashboard.css" rel="stylesheet" />
  <link rel="stylesheet" href="./style/style.css" />

  <!-- Font Awesome -->
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

  <!-- Bs -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />

  <style>
    nav {
      background-color: #003f62;
    }
  </style>
</head>

<body class="sb-nav-fixed">
  <?php include './layout/navbar-admin.php' ?>

  <!-- Content -->
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <h1 class="mt-4">Orderan</h1>
        <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item active">Utama</li>
        </ol>

        <div class="card mb-4">
          <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Orderan
          </div>
          <div class="card-body">
            <table id="datatablesSimple">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>Image</th>
                  <th>Nama Barang</th>
                  <th>Harga Barang</th>
                  <th>Quantity</th>
                  <th>Time</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include '../config/db.php';
                $data = "SELECT orders.*, product.img AS product_img FROM orders JOIN product ON orders.id_product = product.id_product"; // Assuming product table has all necessary fields
                $number = 1;
                $result = $conn->query($data);
                if ($result->num_rows > 0) {
                  while ($data_order = $result->fetch_assoc()) {
                ?>
                    <tr>
                      <td><?= $number++ ?></td>
                      <td><?php echo isset($data_order['username']) ? $data_order['username'] : "N/A" ?></td>
                      <td><?php echo isset($data_order['img']) ? $data_order['img'] : "N/A" ?></td>
                      <td><?php echo isset($data_order['nama_product']) ? $data_order['nama_product'] : "N/A" ?></td>
                      <td><?php echo isset($data_order['harga_product']) ? $data_order['harga_product'] : "N/A" ?></td>
                      <td><?php echo isset($data_order['quantity']) ? $data_order['quantity'] : "N/A" ?></td>
                      <td><?php echo isset($data_order['created_at']) ? $data_order['created_at'] : "N/A" ?></td>
                    </tr>
                <?php
                  }
                }
                ?>
            </table>
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
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="./script/data-table.js"></script>
</body>

</html>