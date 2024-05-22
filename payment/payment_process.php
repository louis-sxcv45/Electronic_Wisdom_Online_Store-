<?php
session_start();
include '../config/db.php';
header('Content-Type: application/json');

if (isset($_POST['total_amount'])) {
    // Get id_user from the session
    $id_user = $_SESSION['id'];

    // Get total_amount from POST data
    $total_amount = $_POST['total_amount'];

    // Save purchase information to the payment table
    $sql_payment = "INSERT INTO payment (id_user, total_amount) VALUES (?, ?)";
    $stmt_payment = $conn->prepare($sql_payment);
    
    // Check if the statement was prepared successfully
    if ($stmt_payment) {
        // Bind parameters and execute the statement
        $stmt_payment->bind_param("id", $id_user, $total_amount);
        $stmt_payment->execute();

        // Check if the payment was successfully added
        if ($stmt_payment->affected_rows > 0) {
            $response = array(
                "success" => true,
                "message" => "Payment processed successfully."
            );
            echo json_encode($response); // Send the response as JSON
        } else {
            // If the payment wasn't added, send a failed response
            $response = array(
                "success" => false,
                "message" => "Failed to process payment."
            );
            echo json_encode($response); // Send the response as JSON
        }
    } else {
        // If the statement preparation failed, send a failed response
        $response = array(
            "success" => false,
            "message" => "Failed to prepare payment statement."
        );
        echo json_encode($response); // Send the response as JSON
    }
} else if(isset($_POST['total_harga'])){
    $id_user = $_SESSION['id'];
    $total_amount = $_POST['total_harga'];

    // Save purchase information to the payment table
    $sql_payment = "INSERT INTO payment (id_user, total_amount) VALUES (?, ?)";
    $stmt_payment = $conn->prepare($sql_payment);
    
    // Check if the statement was prepared successfully
    if ($stmt_payment) {
        // Bind parameters and execute the statement
        $stmt_payment->bind_param("id", $id_user, $total_amount);
        $stmt_payment->execute();

        // Check if the payment was successfully added
        if ($stmt_payment->affected_rows > 0) {
            $response = array(
                "success" => true,
                "message" => "Payment processed successfully."
            );
            echo json_encode($response); // Send the response as JSON
        } else {
            // If the payment wasn't added, send a failed response
            $response = array(
                "success" => false,
                "message" => "Failed to process payment."
            );
            echo json_encode($response); // Send the response as JSON
        }
    } else {
        // If the statement preparation failed, send a failed response
        $response = array(
            "success" => false,
            "message" => "Failed to prepare payment statement."
        );
        echo json_encode($response); // Send the response as JSON
    }
}else{
    // If the required data is not received, send a failed response
    $response = array(
        "success" => false,
        "message" => "Required data not found."
    );
    echo json_encode($response); // Send the response as JSON
}
?>
