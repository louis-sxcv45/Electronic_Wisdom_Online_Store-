<?php
session_start();
include '../config/db.php';
if (isset($_GET['id_product'])) {
    $id_product = $_GET['id_product'];
    $satuan_produk = "SELECT harga FROM product WHERE id_product = $id_product";
    $result = $conn->query($satuan_produk);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $harga = $row['harga'];
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../style/style.css" />


    <style>
        .cart-list {
            box-shadow: -9px 10px 7px -1px rgba(0, 0, 0, 0.15);
            -webkit-box-shadow: -9px 10px 7px -1px rgba(0, 0, 0, 0.15);
            -moz-box-shadow: -9px 10px 7px -1px rgba(0, 0, 0, 0.15);
        }

        .card {
            box-shadow: 9px 10px 7px -1px rgba(0, 0, 0, 0.15);
            -webkit-box-shadow: 9px 10px 7px -1px rgba(0, 0, 0, 0.15);
            -moz-box-shadow: 9px 10px 7px -1px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Varela Round', sans-serif;
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
    </style>
</head>
<header>
    <?php include '../layout/navbar.php'; ?>
</header>

<body>
    <div class="cart-user container-fluid mt-4">
        <h2>Keranjang Belanja</h2>
        <div class="row" style="margin-top: 2em;">
            <div class="cart-list col-lg-8 ms-3 mb-3" style="background-color: white; height:70vh; max-width: 105vh; width: 94%;"
            display: flex; flex-direction: column;">
                <div class="cols-1 cols-md-2 g-2">
                    <div class="mt-3" style="margin-left: 1em;">
                        <h5>Barang yang Dipilih</h5>
                    </div>
                    <?php
                    if (isset($_SESSION['id'])) {
                        $id_user = $_SESSION['id'];
                        $number = 1;
                        $sql = "SELECT product.harga, product.img, cart.* FROM cart INNER JOIN product ON cart.id_product = product.id_product WHERE cart.id_user = $id_user";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $quantity = $row['quantity'];
                    ?>
                                <div class="row mb-5 ms-3 mt-4 me-3 rounded-5 align-items-center shadow" style="background-color: white;">
                                    <div class="col-md-3 col-lg-2 mb-3 mb-md-0">
                                        <div class="card shadow-sm mt-4 mb-4 ms-3 me-3" style="max-width:auto; min-width:7rem;">
                                            <img src="<?php echo $row['img']; ?>" class="card-img-top" alt="..." />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-2">
                                        <div class="name-product ms-3">
                                            <p class="mb-0"><?php echo $row['nama_product']; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-2">
                                        <div class="price-product ms-2">
                                            <p class="mb-0 ms-2 product-price" data-id="<?php echo $row['id_product']; ?>" data-price="<?php echo $row['harga']; ?>">
                                                Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-6 mb-2 mt-3 align-items-center">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input-group form-detail mb-4 shadow me-2 ms-3" style="width: 7em;">
                                                    <button class="input-group-text bg-white rounded-start text-center decrement">-</button>
                                                    <input type="text" class="form-control text-center bg-white quantity" id="quantity_<?php echo $row['id_product']; ?>" name="quantity_<?php echo $row['id_product']; ?>" value="<?php echo $row['quantity']; ?>" data-id="<?php echo $row['id_product']; ?>" data-price="<?php echo $row['harga']; ?>" readonly>
                                                    <button class="input-group-text bg-white rounded-end text-center increment">+</button>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <a href="#delete_modal_<?php echo $row['id_product']; ?>" data-bs-toggle="modal" data-bs-target="#delete_modal_<?php echo $row['id_product']; ?>" style="text-decoration: none;">
                                                    <button class="button-delete btn btn-primary bg-danger border-0 shadow-lg mt-3" style="width: 5em;">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="delete_modal_<?php echo $row['id_product']; ?>" class="modal fade">
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
                                                <button type="button" class="btn btn-danger delete" data-id_product="<?php echo $row['id_product']; ?>">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card border-0 rounded-0" style="min-height: 97%; max-height:10em; max-width: 105vh; width: 98%; background-color:#EEEEEE;">
                    <div class="card-body d-flex flex-column align-items-center">
                        <div class="d-flex flex-row mt-3 text-center mb-5">
                            <h5 class="card-title me-3">Total Harga:</h5>
                            <?php
                            $sql = "SELECT SUM(total_harga) AS total_harga FROM cart WHERE id_user = $id_user";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $total_harga = 0;
                            $total_amount = $row['total_harga'];
                            ?>
                            <?php
                            function custom_number_format($number)
                            {
                                $number_str = strrev((string)$number);

                                $formatted_str = '';
                                for ($i = 0; $i < strlen($number_str); $i++) {
                                    if ($i > 0 && $i % 3 == 0) {
                                        $formatted_str .= '.';
                                    }
                                    $formatted_str .= $number_str[$i];
                                }

                                return strrev($formatted_str);
                            }
                            ?>
                            <p class="mb-3 fw-bold ms-4" style="font-size: 18px;" id="total-amount">
                                Rp <?php echo custom_number_format($total_amount); ?>
                            </p>
                        </div>
                        <div class="button-pay d-flex justify-content-center" style="margin-bottom: 20em;">
                            <button class="btn btn-primary bg-warning border-0 pay" style="width: 10em; height: 2.5em; position:absolute;" type="submit">Beli</button>
                        </div>
                    </div>


                </div>
            </div>
        <?php
                    }
        ?>
        </div>
    </div>

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
        $('.increment, .decrement').click(function() {
            var id_user = <?php echo $_SESSION['id']; ?>;
            var $row = $(this).closest('.row');
            var $quantityInput = $row.find('.quantity');
            var quantity = parseInt($quantityInput.val());
            var id_product = $quantityInput.data('id');
            var price = parseFloat($quantityInput.data('price'));

            if ($(this).hasClass('increment')) {
                quantity++;
            } else if ($(this).hasClass('decrement') && quantity > 1) {
                quantity--;
            }

            $quantityInput.val(quantity);
            var newTotalPrice = price * quantity;

            // Update the total price for this row
            $row.find('.product-price').text('Rp ' + new Intl.NumberFormat('id-ID').format(newTotalPrice));

            // Update the database and total amount
            updateCart(id_user, id_product, quantity, newTotalPrice);
            updateDisplayedPrice(id_product, newTotalPrice);
        });

        $('.delete').click(function() {
            var id_product = $(this).data('id_product');
            var id_user = <?php echo $_SESSION['id']; ?>;

            $.ajax({
                url: 'delete.php',
                method: 'POST',
                data: {
                    id_user: id_user,
                    id_product: id_product
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        alert('Item deleted successfully');
                        $('.row[data-id="' + id_product + '"]').remove();
                        updateTotalAmount(id_user);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Failed to delete product');
                }
            });
        });

        $('.pay').click(function() {
            var id_user = <?php echo $_SESSION['id']; ?>;
            var total_amount = parseFloat($('#total-amount').text().replace('Rp ', '').replace(/\./g, '').replace(',', '.'));
            $.ajax({
                url: '../payment/payment_process.php',
                method: 'POST',
                data: {
                    id_user: id_user,
                    total_amount: total_amount
                },
                success: function(response) {
                    console.log(response); // Log the response to see what you're getting
                    if (response.success) { // Assuming the response is an object
                        console.log("Redirection should happen now.");
                        window.location.href = '../payment/payment.php';
                    } else {
                        alert(response.message); // No need to parse, as it's already an object
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Log any error messages for debugging
                    alert("An error occurred while processing your payment.");
                }
            });
        });




        function updateCart(id_user, id_product, quantity, newTotalPrice) {
            $.ajax({
                url: 'update_cart.php',
                method: 'POST',
                data: {
                    id_user: id_user,
                    id_product: id_product,
                    quantity: quantity,
                    total_price: newTotalPrice
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        console.log('Cart updated successfully');
                        updateTotalAmount(id_user);

                    } else {
                        alert(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    console.log('Failed to update cart');
                }
            });
        }


        function updateDisplayedPrice(id_product, newTotalPrice) {
            // Find the paragraph with the data-id matching id_product
            var $priceParagraph = $('.product-price[data-id="' + id_product + '"]');
            // Update the text with the new total price
            $priceParagraph.text('Rp ' + new Intl.NumberFormat('id-ID').format(newTotalPrice));
        }

        function updateTotalAmount(id_user) {
            $.ajax({
                url: 'update_cart.php',
                method: 'POST',
                data: {
                    action: 'get_total_amount', // Special action to handle this request
                    id_user: id_user
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        var totalAmount = data.total_amount || 0; // Ensure total_amount is 0 if not provided
                        $('#total-amount').text('Rp ' + new Intl.NumberFormat('id-ID').format(totalAmount));
                    } else {
                        alert(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Failed to update total amount');
                }
            });
        }
    });
</script>

</html>