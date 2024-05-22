<?php
session_start();
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'get_total_amount') {
        if (isset($_POST['id_user'])) {
            $id_user = $_POST['id_user'];

            $sql = "SELECT SUM(total_harga) AS total_harga FROM cart WHERE id_user = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_user);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            // Ensure total_amount is 0 if it's null
            $total_amount = $row['total_harga'] ?? 0;

            $response = array("success" => true, "total_amount" => $total_amount);
            echo json_encode($response);
        } else {
            $response = array("success" => false, "message" => "Missing user ID");
            echo json_encode($response);
        }
    } else {
        if (isset($_POST['id_product'], $_POST['quantity'], $_POST['total_price'])) {
            $id_product = $_POST['id_product'];
            $id_user = $_SESSION['id'];
            $quantity = $_POST['quantity'];
            $total_price = $_POST['total_price'];

            $update_cart = "UPDATE cart SET quantity = ?, total_harga = ? WHERE id_user = ? AND id_product = ?";
            $stmt = $conn->prepare($update_cart);
            $stmt->bind_param("idii", $quantity, $total_price, $id_user, $id_product);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response = array("success" => true, "message" => "Cart updated successfully");
            } else {
                $response = array("success" => false, "message" => "Failed to update cart");
            }
            echo json_encode($response);
        } else {
            $response = array("success" => false, "message" => "Missing parameters");
            echo json_encode($response);
        }
    }
} else {
    $response = array("success" => false, "message" => "Invalid request method");
    echo json_encode($response);
}
?>
