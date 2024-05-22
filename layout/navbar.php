<?php
if (isset($_SESSION['login'])) {
    $direct = '/cart/cart.php';
} else {
    $direct = '/user/login.php';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />

</head>

<style>
    .input-group {
        border: none;
        width: 20em;
        margin-right: 100px;
        margin-top: 20px;
    }

    .input-search:focus {
        border: none;
        border-color: white;
    }
</style>



<nav class="navbar navbar-expand-xl navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">Toko Wisdom</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#produk">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
            </ul>
            <div class="search-bar mx-auto mb-4 hide-on-login">
                <div class="input-group">
                    <input type="text" id="search_product" class="input-search form-control bg-white" placeholder="Search Product" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <button class="input-group-text bg-warning" id="basic-addon2"><i class="bi bi-search"></i></button>
                </div>
            </div>
            <button type="button" class="btn hide-on-login me-4 mb-2" onclick="location.href='<?php echo $direct; ?>'">
                <i class="bi bi-cart" style="font-size: 30px; color:white;"></i>
            </button>
            <?php
            if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
                $user_id = $_SESSION['id'];
                
                $query = "SELECT * FROM users WHERE id = $user_id";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    $userDetails = $result->fetch_assoc();
            ?>
                    <li class="nav-item dropdown mb-2">
                        <a class="nav-link" href="#user-dropdown" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="user-section">
                                <span class="me-2" id="user-avatar"><i class="bi bi-person-circle text-white" style="font-size: 35px;"></i></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu" style="list-style: none;">
                            <li><a class="dropdown-item" href="account_profile.php?id=<?php echo $userDetails['id']; ?>">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../user/logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <span style="font-size: 20px;" class="text-white fw-bold mt-2 mb-3 me-5" id="username"><?php echo $userDetails['username']; ?></span>
                <?php
                }
            } else {
                ?>
                <div class="page-on">
                    <span id="login-section">
                        <button type="button" class="btn btn-warning btn-masuk"><a href="../user/login.php" class="masuk">Masuk</a></button>
                        <span style="color: white">|</span>
                        <button type="button" class="btn btn-light btn-daftar"><a href="../user/register.php" class="daftar">Daftar</a></button>
                    </span>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
</nav>


</html>