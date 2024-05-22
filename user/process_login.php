<?php
session_start();

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["pass"];

    include ("../config/db.php");

    $query = "SELECT * FROM users WHERE username = ? AND pass = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user_data = $result->fetch_assoc();

        if ($password === $user_data['pass']) {

            $_SESSION["login"] = true;
            $_SESSION["id"] = $user_data['id']; 

            header("Location: ../index.php");
            exit();
        } else {
            echo "<script> alert('Invalid Username or Password'); window.location.href = 'login.php';</script>";
        }
    } else {
        echo "<script> alert('Invalid Username or Password'); window.location.href = 'login.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Error connecting to the database.";
}

?>
