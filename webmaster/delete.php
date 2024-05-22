<?php
session_start();
include '../config/db.php';

if (isset($_POST['id_product'])) {
    $id_product = $_POST['id_product'];
    $sql = "DELETE FROM product WHERE id_product = $id_product";
    $conn->query($sql);
}

?>