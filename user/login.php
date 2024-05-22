<?php
include '../config/db.php';
session_start();

if (isset($_SESSION["login"])) {
    header("Location:../index.php");
    exit();
}

// if ($conn){
//     echo "Connection success";
// }
// else{
//     echo "Connection failed";
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <!-- Bs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <!-- Default -->
    <link rel="stylesheet" href="../style/style.css" />

    <style>
        .form-control {
            border: none;
            border-bottom: 1px solid #ced4da;
        }
        .hide-on-login {
            display: none;
        }
        .page-on {
            margin-left: 45em;
        }

        .error {
            font-size: 15px;
            color: red;
        }
        label.error {
            text-align: start;
            width: 20em;
        }

        .error::placeholder {
            font-size: 20px;
        }

        input.error {
            border-color: red;

        }
    </style>
</head>

<body class="page-user" style="background-color: #f6f5f2">
    <header>
        <?php include '../layout/navbar.php' ?>
    </header>
    <!-- Login -->
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem">
                        <div class="card-body p-5 text-center">
                            <h3 class="mb-5">Login</h3>
                            <form action="javascript:void(0)" method="POST" id="form" class="mb-3 form-control-lg">
                                <div class="form-outline mb-4">
                                    <input type="text" class="form-control form-control-lg rounded-0" id="username" name="username" placeholder="Username" />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" class="form-control form-control-lg rounded-0" id="pass" name="pass" placeholder="Password" />
                                </div>

                                <button class="btn btn-warning btn-lg btn-block form-control form-control-lg" type="submit" name="login" style="color: white; border-bottom: none;">
                                    Login
                                </button>
                            </form>
                            <span>Belum punya akun?<a href="register.php" class="daftar">Sign Up</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bs -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Ion Icon -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
</body>

<script>

    $('#form').validate({
        rules: {
            username: "required",
            pass: "required"
        },
        messages: {
            username: "Username is required",
            pass: "Password is required"
        },
        submitHandler: function(form) {
            form.action = 'process_login.php';
            form.submit();
        }
    });


</script>

</html>