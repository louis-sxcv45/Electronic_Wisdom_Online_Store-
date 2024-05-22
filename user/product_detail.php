<?php
include '../config/db.php';
session_start();

if (isset($_GET['id'])) {
    $id_product = $_GET['id'];
    $sql = "SELECT * FROM product WHERE id_product = $id_product";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['nama_product'];
        $harga = $row['harga'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />

    <style>
        .hr-custom {
            margin-top: 2em;
            margin-bottom: 2em;
            min-width: 95%;
            max-width: 20em;
            margin-left: 0em;
            border: 1px solid #000000;
        }

        .description {
            margin-bottom: 3em;
        }

        .button {
            margin-right: 20em;
        }

        .btn-cart {
            background-color: #EEEEEE;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4), 0 1px 3px rgba(0, 0, 0, 0.08);
            min-width: 9em;
            height: 3.2em;
            align-items: center;
            border: none;
            border-radius: 14px;
        }

        .btn-cart:hover {
            background-color: #EEEEEE;
            border: none;
        }

        .btn-pay {
            margin-left: 10px;
            background-color: #FF9900;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4), 0 1px 3px rgba(0, 0, 0, 0.08);
            min-width: 8em;
            height: 3.2em;
            align-items: center;

            border: none;
            border-radius: 14px;
        }

        .btn-pay span {
            color: white;
            font-weight: bold;
        }

        .btn-pay:hover {
            background-color: #FF9900;
            border: none;
        }
    </style>
</head>

<header>
    <?php include '../layout/navbar.php' ?>
</header>

<body>
    <?php if ($row) { ?>
        <div class="container-fluid mt-4 vh-100">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="card-detail" style="margin-right:20vh;">
                        <img src="<?php echo $row['img'] ?>" class="card-img-top ms-5" alt="<?php echo $title ?>" style="max-width: 30rem;" />
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="detail-card">
                        <h1 class="title"><?php echo $title ?></h1>
                        <h2 class="price">Rp<?php echo number_format($row['harga'], 0, ',', '.') ?></h2>
                        <div class="hr-custom"></div>
                        <div class="description">
                            <p>Detail</p>
                            <p class="d-flex">Kondisi: <span class="fw-bold ms-1"><?php echo $row['status'] ?></span></p>
                            <p><?php echo $row['description'] ?></p>
                        </div>
                        <div class="count justify-content-around d-flex align-items-center">
                            <div class="input-group form-detail mb-3 shadow-sm" style="max-width: 8rem; min-width: 8rem;">
                                <button class="input-group-text bg-white rounded-start rounded-1 text-center decrement" id="decrement">-</button>
                                <input type="text" class="form-control text-center bg-white ms-0" name="quantity" id="quantity" value="1" disabled>
                                <button class="input-group-text bg-white rounded-end rounded-1 text-center increment" id="increment">+</button>
                            </div>
                            <div class="d-flex stok mb-3 ms-4">
                                <span class="d-flex">
                                    Stok: <span class="ms-1"><?php echo $row['stok'] ?></span>
                                </span>
                            </div>
                        </div>

                        <div class="button d-flex mt-4">
                            <button type="button" class="btn-cart btn btn-lg me-2" id="addToCart">
                                <i class="bi bi-cart"></i>
                                <span>+ Keranjang</span>
                            </button>
                            <button type="button" class="btn-pay btn btn-lg ms-5" id="pay">
                                <span>Beli</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</body>

<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 mt-4 bg-dark text-white">
    <?php include '../layout/footer.php'; ?>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        var quantity = 1;
        var harga = <?php echo $harga; ?>;
        var id_user = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 'null'; ?>;

        $('#addToCart').click(function() {
            if (id_user) {
                var id_product = <?php echo $id_product; ?>;
                var quantity = $('#quantity').val();
                var total_harga = quantity * harga;
                $.post("../cart/add_to_cart.php", {
                    id_product: id_product,
                    id_user: id_user,
                    quantity: quantity,
                    total_harga: total_harga
                }, function(response) {
                    if (response === 'success') {
                        alert('Produk berhasil ditambahkan ke keranjang!');
                        window.location.href = "../cart/cart.php";
                    } else {
                        alert('Terjadi kesalahan: ' + response);
                    }
                });
            } else {
                window.location.href = "login.php";
            }
        });

        $('#pay').click(function() {
            if (id_user) {
                var id_product = <?php echo $id_product; ?>;
                var quantity = $('#quantity').val();
                var total_harga = quantity * harga;
                $.post("../cart/add_to_cart.php", {
                    id_product: id_product,
                    id_user: id_user,
                    quantity: quantity,
                    total_harga: total_harga
                }, function(response) {
                    if (response === 'success') {
                        $.post("../payment/payment_process.php", {
                            id_user: id_user,
                            total_harga: total_harga
                        }, function(paymentResponse) {
                            if (paymentResponse.success) {
                                window.location.href = "../payment/payment.php";
                            } else {
                                alert('Gagal melakukan pembayaran: ' + paymentResponse.message);
                            }
                        }, 'json');
                    } else {
                        alert('Gagal menambahkan produk ke keranjang: ' + response);
                    }
                });
            } else {
                window.location.href = "login.php";
            }
        });

        // Increment and decrement functions
        $('#increment').click(function() {
            quantity++;
            $('#quantity').val(quantity);
        });

        $('#decrement').click(function() {
            if (quantity > 1) {
                quantity--;
                $('#quantity').val(quantity);
            }
        });
    });
</script>


</html>