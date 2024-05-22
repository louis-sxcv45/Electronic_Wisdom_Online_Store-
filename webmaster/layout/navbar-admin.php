<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
</head>
<nav class="sb-topnav navbar navbar-expand navbar-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="dashboard.php">Toko Wisdom</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>

    <?php 
    
    ?>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto me-3 me-lg-4">
    <?php
            if (isset($_SESSION['login']) && isset($_SESSION['id_admin'])) {
                $admin_id = $_SESSION['id_admin'];
                
                $query = "SELECT * FROM admin WHERE id_admin     = $admin_id";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    $adminDetails = $result->fetch_assoc();
            ?>
                    <li class="nav-item dropdown mb-2">
                        <a class="nav-link" href="#user-dropdown" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="user-section">
                                <span class="me-2" id="user-avatar"><i class="bi bi-person-circle text-white" style="font-size: 35px;"></i></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu" style="list-style: none;">
                            <li><a class="dropdown-item" href="account_profile.php?id=<?php echo $adminDetails['id_admin']; ?>">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <span style="font-size: 20px;" class="text-white fw-bold mt-3 mb-1 me-3" id="username"><?php echo $adminDetails['username']; ?></span>
                <?php
                }
            }
            ?>
    </ul>
</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Utama</div>
                    <a class="nav-link" href="dashboard.php">
                        <div class="sb-nav-link-icon">
                            <i class="fa-solid fa-house"></i>
                        </div>
                        Dashboard
                    </a>
                    <a class="nav-link" href="produk.php">
                        <div class="sb-nav-link-icon">
                            <i class="fa-solid fa-box"></i>
                        </div>
                        Produk
                    </a>
                    <a class="nav-link" href="order.php">
                        <div class="sb-nav-link-icon">
                            <i class="fa-solid fa-bars"></i>
                        </div>
                        Orderan
                    </a>
                </div>
            </div>
        </nav>
    </div>

</html>