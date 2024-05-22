<?php
session_start();
include '../config/db.php';

if (isset($_POST['add_product'])) {
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
}
