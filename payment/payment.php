<?php
session_start();
include '../config/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .hr-custom {
            margin-top: 2em;
            margin-bottom: 2em;
            min-width: 95%;
            max-width: 20em;
            margin-left: 0em;
            border: 1px solid #000000;
        }
        .garis{
            max-width: 100vh; 
            min-width:20%; 
            margin-left: 1.5rem;
        }
    </style>
</head>

<header>
    <?php include '../layout/navbar.php' ?>
</header>

<body>
    <div class="container-fluid">
        <h3 class="title-pay mt-5" style="margin-left: 35px;">Rincian Pembayaran</h3>
        <form id="paymentForm">
            <div class="row" style="margin-left: 0px; margin-top: 3em;">
                <div class="col-lg-6 mb-5">
                    <div class="form-payment">
                        <input class="form-control form-control-lg shadow border-0" style="width: 100%;" type="email" name="email" placeholder="Email" aria-label=".form-control-lg example" required>
                        <input class="form-control form-control-lg shadow border-0" style="margin-top: 2em; width: 100%;" type="text" name="nama" placeholder="Nama" aria-label=".form-control-lg example" required>
                        <input class="form-control form-control-lg shadow border-0" style="margin-top: 2em; width: 100%;" type="text" name="no_hp" placeholder="Nomor Telepon" aria-label=".form-control-lg example" required>
                        <textarea class="form-control shadow border-0" style="margin-top: 2em; width: 100%;" name="alamat" placeholder="Alamat" id="exampleFormControlTextarea1" rows="3" required></textarea>
                        <div class="hr-custom"></div>
                        <div class="shadow d-flex align-items-center justify-content-between mt-4" style="width: 100%;">
                            <label class="form-check-label ms-3 d-flex flex-wrap align-items-center" for="inlineRadio1">
                                <img class="" style="width: 3rem;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/04/Visa.svg/1280px-Visa.svg.png" alt="bank">
                                <p class="ms-3 mt-3 text-center" style="color: #BEBFC0;">Bank</p>
                            </label>
                            <input class="form-check-input me-4" style="width: 23px; height: 23px;" type="radio" name="metode_pembayaran" value="Bank" required>
                        </div>
                        <div class="shadow d-flex align-items-center justify-content-between mt-4" style="width: 100%; height:4em;">
                            <label class="form-check-label form-check-label ms-3" for="inlineRadio2" style="color: #BEBFC0;">Cash On Delivery</label>
                            <input class="form-check-input me-4" style="width: 23px; height: 23px;" type="radio" name="metode_pembayaran" value="COD" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 bg-light">
                    <div class="me-5 mt-5">
                        <?php
                        if (isset($_SESSION['id'])) {
                            $id_user = $_SESSION['id'];
                            $query = "SELECT * FROM cart WHERE id_user = $id_user";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                        ?>
                                    <div class="card shadow-sm mb-4 me-4 rounded-5 ms-3" style="background-color: #f8f9fa; max-width:100vh; min-width:100%;">
                                        <div class="d-flex flex-row justify-content-between align-items-center p-3">
                                            <span class="card shadow-sm ms-3 me-3" style="max-width:5.5rem; min-width:15%;">
                                                <img src="<?php echo $row['img']; ?>" class="card-img-top" alt="..." />
                                            </span>

                                            <div class="d-flex flex-column ms-4">
                                                <span class="mb-2 fs-6"><?php echo $row['nama_product'] ?></span>
                                                <span>Rp<?php echo number_format($row['total_harga'], 0, ',', '.'); ?></span>
                                            </div>

                                            <span class="ms-auto me-3 d-flex">
                                                <?php echo $row['quantity']; ?>
                                            </span>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>

                    <div class="">
                        <div class="card shadow-sm mb-4 me-4 rounded ms-3">
                            <span class="ms-4 mb-4">
                                Detail Pembayaran
                            </span>
                            <hr class="mb-2 garis">
                            <?php
                            if (isset($_SESSION['id'])) {
                                $id_user = $_SESSION['id'];
                                $query = "SELECT total_amount FROM payment WHERE id_user = $id_user";
                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_amount = $row['total_amount'];
                                    $ongkir = 30000;
                                    $total_pay = $total_amount + $ongkir;
                            ?>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex flex-row justify-content-between">
                                            <span class="ms-4">Pesanan</span>
                                            <div style="margin-right: 2em;">
                                                <span style="margin-right: 1.0em;">
                                                    Rp
                                                </span>
                                                <span>
                                                    <?php echo number_format($total_amount, 0, ',', '.'); ?>
                                                </span>

                                            </div>
                                        </div>
                                        <div class="d-flex flex-row justify-content-between">
                                            <span class="ms-4">Ongkir</span>
                                            <div class="ongkir_harga" style="margin-right:2em;">
                                                <span style="margin-right: 2.8em;">
                                                    Rp
                                                </span>
                                                <span>
                                                    <?php echo number_format($ongkir, 0, ',', '.') ?>
                                                </span>
                                            </div>
                                        </div>
                                        <hr class="mb-3 garis" style="margin-left: 0;">
                                        <div class="d-flex flex-row justify-content-between">
                                            <span class="ms-4">Total</span>
                                            <div style="margin-right:2em;">
                                                <span style="margin-right: 1.0em;">
                                                    Rp
                                                </span>
                                                <span>
                                                    <?php echo number_format($total_pay, 0, ',', '.') ?>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="button-pay d-flex justify-content-center" style="margin-bottom: 10em;">
                                            <form id="paymentForm" method="POST">
                                                <button class="btn btn-primary bg-warning border-0 pay" style="width: 10em; margin-top:5em; height: 3em; position:absolute;" type="submit">
                                                    Bayar Sekarang
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<footer class="d-flex flex-wrap justify-content-between align-content-center py-3 mt-4 bg-dark text-white">
    <?php include '../layout/footer.php' ?>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Ion Icon -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#paymentForm').submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'delete_cart.php', // Perubahan di sini untuk mengarahkan ke file yang sesuai
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Pembelian berhasil!');
                        window.location.href = '../index.php'; // Redirect to home page
                    } else {
                        alert(response.message); // Menampilkan pesan kesalahan dari server
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Menampilkan kesalahan di console
                    alert('Terjadi kesalahan dalam proses pembayaran. Silakan coba lagi.');
                }
            });
        });
    });
</script>


</html>