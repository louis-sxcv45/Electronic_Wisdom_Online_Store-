<?php
if (isset($_POST['submit'])) {
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['pass'];

    include("../config/db.php");

    $query = "INSERT INTO users (username, email, pass)
        VALUES ('$username', '$email', '$password')";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    if ($stmt->execute()) {
        session_start();
        $_SESSION['id'] = $conn->insert_id;
        $_SESSION['username'] = $username;
        echo "<script> alert('Registration Successful'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script> alert('Registration Failed'); window.location.href = 'register.php';</script>";
    }

    $stmt->close();
    $conn->close();
}