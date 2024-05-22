<?php
include './config/db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Toko Wisdom</title>
    <!-- Bs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- Default -->
    <link rel="stylesheet" href="./style/style.css" />

    <style>
        .form-control {
            border-radius: 10px;
        }

        .icon-card {
            width: 8em;
            height: 8em;
            text-align: center;
            margin-top: 30px;
            margin-bottom: 50px !important;
        }

        .card-icon,
        .card-icon span {
            font-size: 50px;
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .card-name,
        .card-name span {
            font-size: 15px;
        }

        .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: black;
    }

    .carousel-control-prev,
    .carousel-control-next {
        color: black;
    }
    </style>
</head>
<!-- Header -->
<header>
    <?php include './layout/navbar.php' ?>
</header>



<body>


    <!-- Content -->
    <!-- Kategori -->
    <div class="container-fluid mt-4">
        <h3 class="mb-4">Kategori</h3>
        <div class="row mb-4 justify-content-around me-4">

            <?php
            $category = array(
                'Kulkas' => '<span class="material-symbols-outlined">kitchen</span>',
                'TV' => '<i class="bi bi-tv"></i>',
                'Kipas' => '<span class="material-symbols-outlined">mode_fan</span>',
                'Mesin Cuci' => '<span class="material-symbols-outlined">local_laundry_service</span>',
                'Smartphone' => '<span class="material-symbols-outlined">smartphone</span>',
                'Laptop' => '<i class="bi bi-laptop"></i>',
                'Oven' => '<span class="material-symbols-outlined">oven</span>'
            );

            foreach ($category as $nameCategory => $icon) {

            ?>
                <div class="col-md-1">
                    <a href="./user/category.php?category=<?php echo $nameCategory; ?>" style="text-decoration: none">
                        <div class="card icon-card mb-2 shadow">
                            <div class="card-icon">
                                <?php echo $icon; ?>
                            </div>
                            <div class="card-name">
                                <?php echo $nameCategory; ?>
                            </div>
                        </div>
                    </a>

                </div>
            <?php
            }
            ?>

        </div>
    </div>

    <!-- Carousel -->
    <div class="container-fluid">
        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./img/img_slide/slide_1.jpg" class="d-block w-100" alt="..." height="575" />
                </div>
                <div class="carousel-item">
                    <img src="./img/img_slide/slide_2.jpg" class="d-block w-100" alt="..." height="575" />
                </div>
                <div class="carousel-item">
                    <img src="./img/img_slide/slide_3.jpg" class="d-block w-100" alt="..." height="575" />
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- Rekomendasi Produk -->
    <div id="produk" class="container-fluid mt-4">
        <h3 class="mb-4">Rekomendasi Produk</h3>
        <div class="row mb-4">
            <?php
            $sql = "SELECT * FROM product WHERE id_product % 2 = 1 LIMIT 12";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {


            ?>
                    <div class="col-md-2">
                        <a href="./user/product_detail.php?id=<?php echo $row['id_product']; ?>" style="text-decoration: none;">
                            <div class="card mb-2 shadow-sm">
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

        <!--Produk Terlaris -->
        <div class="container-fluid mt-4">
            <h3 class="mb-4">Terlaris</h3>
            <div class="row mb-4">
                <?php
                $sql = "SELECT * FROM product WHERE stok < 100 LIMIT 12";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="col-md-2">
                            <a href="./user/product_detail.php?id=<?php echo $row['id_product']; ?>" style="text-decoration: none;">
                                <div class="card mb-2 shadow-sm">
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

        <!-- About Us -->
        <div id="about" class="container-fluid my-4">
            <h3 class="text-center mb-4">About Us</h3>
            <div class="row">
                <div class="col-md-6">
                    <img src="./img/img_about/about.jpg" class="card-img-top" alt="Product Image" height="300" />
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <p>
                        Toko Wisdom adalah destinasi utama bagi para pecinta teknologi yang
                        mencari produk berkualitas dengan harga terjangkau. kami telah
                        menjadi salah satu toko elektronik terpercaya yang menyediakan
                        berbagai macam produk elektronik terbaru dan terbaik.
                        <br />
                        <br />
                        Kami memiliki visi untuk menjadi toko elektronik terkemuka yang
                        selalu mengutamakan kepuasan pelanggan. Dengan motto "Memberikan
                        Solusi, Bukan Hanya Produk," kami berkomitmen untuk memberikan
                        pengalaman belanja yang memuaskan dan solusi terbaik untuk kebutuhan
                        elektronik Anda.
                    </p>
                </div>
            </div>
        </div>


</body>
<!-- Footer -->
<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 mt-4 bg-dark text-white">
    <?php include './layout/footer.php'; ?>
</footer>

<!-- Bs -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Ion Icon -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</html>