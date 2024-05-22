<?php
include '../config/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_product = $_POST['id_product'];
    $id_user = $_SESSION['id'];
    $quantity = $_POST['quantity'];
    $total_harga = $_POST['total_harga']; // Ambil total harga dari produkdetail.php

    // Mengambil nama produk berdasarkan id_product
    $sql_nama_produk = "SELECT nama_product FROM product WHERE id_product = $id_product";
    $result_nama_produk = $conn->query($sql_nama_produk);
    
    $sql_image_produk = "SELECT img FROM product WHERE id_product = $id_product";
    $result_image_produk = $conn->query($sql_image_produk);
    if ($result_nama_produk->num_rows > 0 && $result_image_produk->num_rows > 0) {
        $row_nama_produk = $result_nama_produk->fetch_assoc();
        $nama_produk = $row_nama_produk['nama_product'];

        $row_image_produk = $result_image_produk->fetch_assoc();
        $image_produk = $row_image_produk['img'];
        
        // Mengambil username berdasarkan id_user
        $sql_username = "SELECT username FROM users WHERE id = $id_user";
        $result_username = $conn->query($sql_username);
        if ($result_username->num_rows > 0) {
            $row_username = $result_username->fetch_assoc();
            $username = $row_username['username'];
            
            // Memeriksa apakah produk sudah ada di keranjang
            $sql_check = "SELECT * FROM cart WHERE id_product = $id_product AND id_user = $id_user";
            $result_check = $conn->query($sql_check);

            if ($result_check->num_rows > 0) {
                echo "Error: Produk sudah ada di keranjang.";
            } else {
                // Jika produk belum ada di keranjang, tambahkan produk baru ke keranjang
                $sql_insert_cart = "INSERT INTO cart (id_user, id_product, nama_product, img, quantity, total_harga, username) 
                                    VALUES ($id_user, $id_product, '$nama_produk', '$image_produk', $quantity, $total_harga, '$username')";

                if ($conn->query($sql_insert_cart) === TRUE) {
                    // Jika berhasil menambahkan ke keranjang, tambahkan juga ke tabel orderan
                    $sql_insert_order = "INSERT INTO orders (id_user, id_product, nama_product, img, quantity, total_harga, username) 
                                        VALUES ($id_user, $id_product, '$nama_produk', '$image_produk', $quantity, $total_harga, '$username')";

                    if ($conn->query($sql_insert_order) === TRUE) {
                        echo "success";
                    } else {
                        echo "Error: " . $sql_insert_order . "<br>" . $conn->error;
                    }
                } else {
                    echo "Error: " . $sql_insert_cart . "<br>" . $conn->error;
                }
            }
        } else {
            echo "Error: Username tidak ditemukan.";
        }
    } else {
        echo "Error: Produk tidak ditemukan.";
    }
} else {
    echo "Error: Metode request tidak valid.";
}
?>
