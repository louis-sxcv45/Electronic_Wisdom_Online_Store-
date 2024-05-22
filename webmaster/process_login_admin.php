<?php
session_start();

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    include ("../config/db.php");

    $query = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin_data = $result->fetch_assoc();

        if ($password === $admin_data['password']) {

            $_SESSION["login"] = true;
            $_SESSION["id_admin"] = $admin_data['id_admin']; 

            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script> alert('Invalid Username or Password'); window.location.href = 'login_admin.php';</script>";
        }
    } else {
        echo "<script> alert('Invalid Username or Password'); window.location.href = 'login_admin.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Error connecting to the database.";
}

?>
