<?php
session_start();
include '../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {
        $id_user = $_SESSION['id'];
        $email = $_POST['email'];
        $nama = $_POST['nama'];
        $no_hp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];
        $metode_pembayaran = $_POST['metode_pembayaran'];

        // Fetch the total amount from the payment table
        $query = "SELECT SUM(product.harga * cart.quantity) AS total_amount 
                    FROM cart 
                    INNER JOIN product ON cart.id_product = product.id_product 
                    WHERE cart.id_user = ?";
        $stmt_total = $conn->prepare($query);
        $stmt_total->bind_param("i", $id_user);
        $stmt_total->execute();
        $result = $stmt_total->get_result();
        $row = $result->fetch_assoc();
        $total_amount = $row['total_amount'];
        $ongkir = 30000;
        $total_pay = $total_amount + $ongkir;

        // Start a transaction
        $conn->begin_transaction();

        // Insert payment details
        // Update payment details
        $insert_query = "UPDATE payment SET email = ?, nama = ?, no_hp = ?, alamat = ?, metode_pembayaran = ?, status_pembayaran = 'Pending', total_amount = ? WHERE id_user = ?";
        $stmt_insert = $conn->prepare($insert_query);
        $stmt_insert->bind_param('ssssidi', $email, $nama, $no_hp, $alamat, $metode_pembayaran, $total_pay, $id_user);


        if ($stmt_insert->execute()) {
            // Fetch and update product stock
            $stmt_cart = $conn->prepare("SELECT cart.id_product, cart.quantity, product.stok FROM cart INNER JOIN product ON cart.id_product = product.id_product WHERE cart.id_user = ?");
            $stmt_cart->bind_param("i", $id_user);
            $stmt_cart->execute();
            $result_cart = $stmt_cart->get_result();

            while ($row_cart = $result_cart->fetch_assoc()) {
                $id_product = $row_cart['id_product'];
                $quantity = $row_cart['quantity'];
                $current_stock = $row_cart['stok'];
                $new_stock = $current_stock - $quantity;

                $insert_history_query = "INSERT INTO history (id_user, id_product, quantity) SELECT ?, cart.id_product, cart.quantity FROM cart WHERE cart.id_user = ?";
                $stmt_insert_history = $conn->prepare($insert_history_query);
                $stmt_insert_history->bind_param("ii", $id_user, $id_user);
                $stmt_insert_history->execute();
                // Update product stock
                $stmt_stock_update = $conn->prepare("UPDATE product SET stok = ? WHERE id_product = ?");
                $stmt_stock_update->bind_param("ii", $new_stock, $id_product);
                $stmt_stock_update->execute();

                // Insert order details into admin_order table
                $stmt_order_insert = $conn->prepare("INSERT INTO admin_order (id_user, username, img, nama_product, harga_product, quantity) SELECT ?, users.username, product.img, product.nama_product, product.harga, cart.quantity FROM users, product, cart WHERE users.id = ? AND product.id_product = ? AND cart.id_user = ?");
                $stmt_order_insert->bind_param("iiii", $id_user, $id_user, $id_product, $id_user);                
                $stmt_order_insert->execute();
            }

            // Clear the cart
            $delete_query = "DELETE FROM cart WHERE id_user = ?";
            $stmt_delete = $conn->prepare($delete_query);
            $stmt_delete->bind_param('i', $id_user);
            $stmt_delete->execute();

            // Commit the transaction
            $conn->commit();

            // Send a successful response
            $response = array(
                "success" => true,
                "message" => "Pembelian berhasil!"
            );
            echo json_encode($response);
        } else {
            // Rollback the transaction if failed to insert payment information
            $conn->rollback();

            // Send a failed response
            $response = array(
                "success" => false,
                "message" => "Gagal menyimpan informasi pembayaran."
            );
            echo json_encode($response);
        }
    } else {
        // Send a failed response if user is not logged in
        $response = array(
            "success" => false,
            "message" => "Anda harus login terlebih dahulu."
        );
        echo json_encode($response);
    }
} else {
    // Send a failed response if it's not a POST request
    $response = array(
        "success" => false,
        "message" => "Metode tidak diizinkan."
    );
    echo json_encode($response);
}
