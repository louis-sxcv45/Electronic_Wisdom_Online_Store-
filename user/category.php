<?php
session_start();
include '../config/db.php';

if (isset($_GET['category'])) {
    $selected_category = $_GET['category'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $selected_category ?></title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .container-fluid {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
        }
    </style>
</head>

<header>
    <?php include '../layout/navbar.php' ?>
</header>

<body>

    <div class="container-fluid mt-5 vh-100">
        <h3 class="mb-5">Produk <?php echo $selected_category ?></h3>
        <div class="row mb-4">
            <div class="col-6">
                <?php
                $sql = "SELECT * FROM product WHERE jenis_product = '$selected_category'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="product_category col-md-2">
                            <a href="product_detail.php?id=<?php echo $row['id_product']; ?>" style="text-decoration: none;">
                                <div class="card mb-2 shadow-sm" style="width:25vh;">
                                    <img src="<?php echo $row['img'] ?>" class="card-img-top" alt="<?php echo $row['nama_product'] ?>" />
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['nama_product'] ?></h5>
                                        <div>
                                            <small class="text-muted">Rp<?php echo number_format($row['harga'], 0, ',', '.') ?></small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

</body>
<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 mt-5 mb-5 bg-dark text-white" style="height:30vh;">
    <?php include '../layout/footer.php'; ?>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

</html>