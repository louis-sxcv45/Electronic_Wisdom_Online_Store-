<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_user']) && isset($_POST['id_product'])) {
    include '../config/db.php';

    $id_user = intval($_POST['id_user']);
    $id_product = intval($_POST['id_product']);

    $sql = "DELETE FROM cart WHERE id_user = ? AND id_product = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $id_user, $id_product);

    // Execute the query
    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            $response = array('success' => true, 'message' => 'Product deleted successfully');
        } else {
            $response = array('success' => false, 'message' => 'No product found to delete');
        }
    } else {
        $response = array('success' => false, 'message' => 'Failed to delete product');
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    $response = array('success' => false, 'message' => 'Invalid request');
}

// Return the response as JSON
echo json_encode($response);
?>
