<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
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

        .error::placeholder{
            font-size: 20px;
        }
        input.error {
            border-color: red;
            
        }
    </style>
</head>

<body class="page-user" style="background-color: #f6f5f2">
    <!-- Header -->
    <header>
        <?php include '../layout/navbar.php'; ?>
    </header>

    <!-- Login -->
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem">
                        <div class="card-body p-5 text-center ">
                            <h3 class="mb-5">Sign Up</h3>
                            <form action="javascript:void(0)" method="POST" id="form" class="mb-3 form-control-lg">
                                <div class="form-outline mb-4">
                                    <input type="text" class="form-control form-control-lg rounded-0" name="username" placeholder="Username" required />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="email" class="form-control form-control-lg rounded-0" name="email" placeholder="Email" required />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" class="form-control form-control-lg rounded-0" name="pass" id="password" placeholder="Password" required />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" class="form-control form-control-lg rounded-0" name="konfirmasipassword" placeholder="Konfirmasi Password" required />
                                </div>

                                <button class="btn btn-warning btn-lg btn-block form-control form-control-lg" type="submit" name="submit" style="color: white; border-bottom: none">
                                    Sign Up
                                </button>
                            </form>
                            <span>Sudah punya akun?<a href="login.php" class="login">Login</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        $("#form").validate({
            rules: {
                username: "required",
                email: {
                    required: true,
                    email: true
                },
                password: "required",
                konfirmasipassword: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                username: "Username is required",
                email: {
                    required: "Email is required",
                    email: "Please enter a valid email address"
                },
                password: "Password is required",
                konfirmasipassword: {
                    required: "Confirm Password is required",
                    equalTo: "Password not matching"
                }
            },
            submitHandler: function(form) {
                form.action = "process-regis.php";
                form.submit();
            }
        });
    </script>

</body>

</html>