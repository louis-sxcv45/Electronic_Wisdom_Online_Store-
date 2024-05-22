  <?php
  session_start();
  include '../config/db.php';
  if (isset($_POST['add_product'])) {
    $nama_product = $_POST['nama_product'];
    $jenis_product = $_POST['jenis_product'];
    $description = $_POST['description'];
    $harga = !empty($_POST['harga']) ? $_POST['harga'] : 0; // Set default value if harga is empty
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $stok = !empty($_POST['stok']) ? $_POST['stok'] : 0;
    $kode_barang = $_POST['kode_barang'];


    // Check if an image file is uploaded
    if (isset($_FILES["img"]) && $_FILES["img"]["error"] == 0) {
      $targetdir = "../img/";
      $img = $targetdir . basename($_FILES["img"]["name"]);
      // Move the uploaded file
      if (move_uploaded_file($_FILES["img"]["tmp_name"], $img)) {
        $insert_query = "INSERT INTO product (nama_product, jenis_product, description, harga, status, stok, kode_barang, img) 
                            VALUES ('$nama_product', '$jenis_product', '$description', '$harga', '$status', '$stok', '$kode_barang', '$img')";

        if (mysqli_query($conn, $insert_query)) {
          echo "<script>alert('Produk berhasil ditambahkan!');</script>";
        } else {
          echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
        }
      } else {
        echo "File upload failed.";
      }
    } else {
      // If no image uploaded, insert other fields only
      $insert_query = "INSERT INTO product (nama_product, jenis_product, description, harga, status, stok, kode_barang) 
                        VALUES ('$nama_product', '$jenis_product', '$description', '$harga', '$status', '$stok', '$kode_barang')";

      if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Produk berhasil ditambahkan!');</script>";
      } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
      }
    }

    // Close connection
    mysqli_close($conn);
  }
  if (isset($_POST['edit_product'])) {
    $id_product = $_POST['id_product'];
    $nama_product = $_POST['nama_product'];
    $jenis_product = $_POST['jenis_product'];
    $description = $_POST['description'];
    $harga = $_POST['harga'];
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $stok = $_POST['stok'];
    $kode_barang = $_POST['kode_barang'];

    // Check if an image file is uploaded
    if (isset($_FILES["img"]) && $_FILES["img"]["error"] == 0) {
      $targetdir = "../img/";
      $img = $targetdir . basename($_FILES["img"]["name"]);
      // Move the uploaded file
      if (move_uploaded_file($_FILES["img"]["tmp_name"], $img)) {
        $update_query = "UPDATE product SET 
                      nama_product='$nama_product', 
                      jenis_product='$jenis_product', 
                      description='$description', 
                      harga='$harga', 
                      status='$status', 
                      stok='$stok', 
                      kode_barang='$kode_barang', 
                      img = '$img'
                      WHERE id_product='$id_product'";

        if (mysqli_query($conn, $update_query)) {
          echo "<script>alert('Produk berhasil diupdate!');</script>";
        } else {
          echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
        }
      } else {
        echo "File upload failed.";
      }
    } else {
      // If no image uploaded, update other fields only
      $update_query = "UPDATE product SET 
                      nama_product='$nama_product', 
                      jenis_product='$jenis_product', 
                      description='$description', 
                      harga='$harga', 
                      status='$status', 
                      stok='$stok', 
                      kode_barang='$kode_barang'
                      WHERE id_product='$id_product'";

      if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Produk berhasil diupdate!');</script>";
      } else {
        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
      }
    }
  }

  if (isset($_POST['delete_product'])) {
    $id_product = $_POST['id_product'];

    $delete_query = "DELETE FROM product WHERE id_product='$id_product'";

    if (mysqli_query($conn, $delete_query)) {
      echo "<script>alert('Produk berhasil dihapus!');</script>";
    } else {
      echo "Error: " . $delete_query . "<br>" . mysqli_error($conn);
    }
  }
  ?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <!-- Data Table -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="./style/dashboard.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="./style/style.css" />

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Bs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />

    <style>
      nav {
        background-color: #003f62;
      }

      .modal-confirm {
        color: #636363;
        width: 400px;
      }

      .modal-confirm .modal-content {
        padding: 20px;
        border-radius: 5px;
        border: none;
        text-align: center;
        font-size: 14px;
      }

      .modal-confirm .modal-header {
        border-bottom: none;
        position: relative;
      }

      .modal-confirm h4 {
        text-align: center;
        font-size: 26px;
        margin: 30px 0 -10px;
      }

      .modal-confirm .close {
        position: absolute;
        top: -5px;
        right: -2px;
        font-size: 35px;
      }

      .modal-confirm .modal-body {
        color: #999;
      }

      .modal-confirm .modal-footer {
        border: none;
        text-align: center;
        border-radius: 5px;
        font-size: 13px;
        padding: 10px 15px 25px;
      }

      .modal-confirm .modal-footer a {
        color: #999;
      }

      .modal-confirm .icon-box {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        border-radius: 50%;
        z-index: 9;
        text-align: center;
        border: 3px solid #f15e5e;
      }

      .modal-confirm .icon-box i {
        color: #f15e5e;
        font-size: 46px;
        display: inline-block;
        margin-top: 13px;
      }

      .modal-confirm .btn,
      .modal-confirm .btn:active {
        color: #fff;
        border-radius: 4px;
        background: #60c7c1;
        text-decoration: none;
        transition: all 0.4s;
        line-height: normal;
        min-width: 120px;
        border: none;
        min-height: 40px;
        border-radius: 3px;
        margin: 0 5px;
      }

      .modal-confirm .btn-secondary {
        background: #c1c1c1;
      }

      .modal-confirm .btn-secondary:hover,
      .modal-confirm .btn-secondary:focus {
        background: #a8a8a8;
      }

      .modal-confirm .btn-danger {
        background: #f15e5e;
      }

      .modal-confirm .btn-danger:hover,
      .modal-confirm .btn-danger:focus {
        background: #ee3535;
      }

      .trigger-btn {
        display: inline-block;
        margin: 100px auto;
      }

      .fixed-bottom {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        /* Ensure the button is on top of other elements */
      }

      .fixed-bottom .btn {
        border-radius: 50%;
        /* Make the button round */
        width: 60px;
        /* Set width and height for the button */
        height: 60px;
        font-size: 24px;
        line-height: 1;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        /* Add shadow for depth */
      }

      /* If you want to change button color, you can adjust these */
      .fixed-bottom .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
      }

      .fixed-bottom .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
      }
    </style>
  </head>

  <body class="sb-nav-fixed">
    <?php include './layout/navbar-admin.php' ?>

    <!-- Content -->
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Produk</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Utama</li>
          </ol>

          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table me-1"></i>
              Data Produk
            </div>
            <div class="card-body">
              <table id="datatablesSimple">
                <thead>

                  <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Gambar</th>
                    <th>Jenis Product</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Stok</th>
                    <th>Kode Barang</th>
                    <th>Opsi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  include("../config/db.php");
                  $data = "SELECT * FROM product";
                  $number = 1;
                  $result = $conn->query($data);
                  if ($result->num_rows > 0) {
                    while ($data_product = $result->fetch_assoc()) {

                  ?>
                      <tr>
                        <td><?php echo $number++ ?></td>
                        <td><?php echo $data_product['nama_product'] ?></td>
                        <td>
                          <img src="<?php echo $data_product['img'] ?>" alt="Product Image" width="100" />
                        </td>
                        <td><?php echo $data_product['jenis_product'] ?></td>
                        <td><?php echo $data_product['description'] ?></td>
                        <td><?php echo $data_product['harga'] ?></td>
                        <td><?php echo $data_product['status'] ?></td>
                        <td><?php echo $data_product['stok'] ?></td>
                        <td><?php echo $data_product['kode_barang'] ?></td>
                        <td>

                          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $data_product['id_product'] ?>">
                            <i class="fa-solid fa-pencil"></i>
                            <span class="text-white">Edit</span>
                          </button>

                          <div class="modal fade" id="exampleModal<?php echo $data_product['id_product'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                <form action="produk.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id_product" value="<?php echo $data_product['id_product']; ?>">
                                    <div class="form-group">
                                      <label for="nama_barang">Nama Barang</label>
                                      <input type="text" class="form-control" id="nama_barang" name="nama_product" value="<?php echo $data_product['nama_product']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label for="deskripsi_barang">Deskripsi Barang</label>
                                      <textarea class="form-control" id="deskripsi_barang" rows="5" name="description"> <?php echo trim($data_product['description']); ?> </textarea>
                                    </div>
                                    <div class="form-group">
                                      <label for="deskripsi_barang">Jenis Barang</label>
                                      <input class="form-control" id="jenis_product" rows="5" name="jenis_product" value="<?php echo $data_product['jenis_product']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label for="harga_barang">Harga Barang</label>
                                      <input type="text" class="form-control" id="harga_barang" name="harga" value="<?php echo $data_product['harga']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label for="stok_barang">Stok Barang</label>
                                      <input type="text" class="form-control" id="stok_barang" name="stok" value="<?php echo $data_product['stok']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label for="stok_barang">Status</label>
                                      <input type="text" class="form-control" id="status" name="status" placeholder="Stok Barang" value="<?php echo $data_product['status']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label for="kode_barang">Kode Barang</label>
                                      <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?php echo $data_product['kode_barang']; ?>">
                                    </div>
                                    <div class="mb-3">
                                      <label for="formFile" class="form-label">Image</label>
                                      <input class="form-control" type="file" id="img" name="img">
                                      <!-- Display the current image -->
                                      <img src="<?php echo $data_product['img']; ?>" alt="Product Image" width="100" />
                                    </div>
                                    <button type="submit" name="edit_product" class="btn btn-primary">Save changes</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- Tombol Delete -->
                          <a href="#" data-bs-toggle="modal" data-bs-target="#delete_modal_<?php echo $data_product['id_product']; ?>" style="text-decoration: none;">
                            <button class="button-delete btn btn-primary bg-danger border-0 shadow-lg" style="width: 5em;">
                              <i class="bi bi-trash-fill"></i>
                            </button>
                          </a>

                          <!-- Modal Delete -->
                          <div id="delete_modal_<?php echo $data_product['id_product']; ?>" class="modal fade">
                            <div class="modal-dialog modal-confirm">
                              <div class="modal-content">
                                <div class="modal-header flex-column">
                                  <div class="icon-box">
                                    <i class="material-icons">&#xE5CD;</i>
                                  </div>
                                  <h4 class="modal-title w-100">Are you sure?</h4>

                                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x"></i></button>
                                </div>
                                <div class="modal-body">
                                  <p>Do you really want to delete these items permanently? This operation cannot be undone.</p>
                                </div>
                                <div class="modal-footer justify-content-center">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <!-- Form untuk delete -->
                                  <form action="produk.php" method="POST">
                                    <input type="hidden" name="id_product" value="<?php echo $data_product['id_product']; ?>">
                                    <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>

                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus"></i> Tambah Produk
          </button>
        </div>
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="produk.php" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" class="form-control" id="nama_barang" name="nama_product">
                  </div>
                  <div class="form-group">
                    <label for="deskripsi_barang">Deskripsi Barang</label>
                    <textarea class="form-control" id="deskripsi_barang" rows="5" name="description"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="deskripsi_barang">Jenis Barang</label>
                    <textarea class="form-control" id="jenis_product" rows="5" name="jenis_product"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="harga_barang">Harga Barang</label>
                    <input type="text" class="form-control" id="harga_barang" name="harga">
                  </div>
                  <div class="form-group">
                    <label for="stok_barang">Stok Barang</label>
                    <input type="text" class="form-control" id="stok_barang" name="stok">
                  </div>
                  <div class="form-group">
                    <label for="stok_barang">Status</label>
                    <input type="text" class="form-control" id="status" name="status" placeholder="Stok Barang">
                  </div>
                  <div class="form-group">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" class="form-control" id="kode_barang" name="kode_barang">
                  </div>
                  <div class="mb-3">
                    <label for="formFile" class="form-label">Image</label>
                    <input class="form-control" type="file" id="img" name="img">
                  </div>
                  <button type="submit" name="add_product" class="btn btn-primary">Tambah Product</button>
                </form>
              </div>
            </div>
          </div>
      </main>
    </div>

    <!-- Bs -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar -->
    <script src="./script/script.js"></script>

    <!-- Data Table -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="./script/data-table.js"></script>
  </body>


  </html>