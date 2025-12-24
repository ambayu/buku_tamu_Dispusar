<?php
require_once __DIR__ . '/../includes/init.php';

// Redirect if already logged in as admin
if (isAdminLoggedIn()) {
    redirect("admin.php");
}

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Admin Buku Tamu</title>
    <!-- sweet alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>




<body class="bg-gradient-primary">


    <?php
    if (isset($_POST["login"])) {
        // Validate CSRF token
        if (!validateCSRF()) {
            echo '<script>
            Swal.fire(
                "Error",
                "Invalid request. Please try again.",
                "error"
            ).then(function() {
                window.location = "loginadmin.php";
            })
            </script>';
            exit;
        }

        // Rate limiting
        if (!checkRateLimit($_SERVER['REMOTE_ADDR'] . '_admin_login', 5, 300)) {
            echo '<script>
            Swal.fire(
                "Terlalu Banyak Percobaan",
                "Silakan tunggu beberapa menit sebelum mencoba lagi",
                "error"
            ).then(function() {
                window.location = "loginadmin.php";
            })
            </script>';
            exit;
        }

        // Sanitize inputs
        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'];

        // Use prepared statement to prevent SQL injection
        $db2 = getDB2();
        $admins = $db2->select(
            "SELECT * FROM tb_login WHERE username = ?",
            "s",
            [$username]
        );

        if (empty($admins)) {
            logSecurityEvent('Admin login failed - user not found', ['username' => $username, 'ip' => $_SERVER['REMOTE_ADDR']]);
            echo '<script>
            Swal.fire(
        
                "Login gagal",
                "username atau password salah",
                "error"
            ).then(function() {
                window.location = "loginadmin.php";
            })
            </script>';
            exit;
        }

        $login = $admins[0];

        if (!verifyPassword($password, $login['password'])) {
            logSecurityEvent('Admin login failed - wrong password', ['username' => $username, 'ip' => $_SERVER['REMOTE_ADDR']]);
            echo '<script>
            Swal.fire(
        
                "Login gagal",
                "username atau password salah",
                "error"
            ).then(function() {
                window.location = "loginadmin.php";
            })
            </script>';
            exit;
        } else {
            // Regenerate session ID on successful login
            session_regenerate_id(true);

            $_SESSION['adminname'] = $login['nama'];
            $_SESSION['username'] = $login['username'];
            $_SESSION['status'] = $login['status'];
            $_SESSION['level'] = $login['level'];

            logSecurityEvent('Admin logged in successfully', ['username' => $username]);

            echo '<script>
            Swal.fire(
        
                "Login Success",
                "Selamat datang admin pengelola",
                "success"
            ).then(function() {
                window.location = "admin.php";
            })
            </script>';
            exit;
        }
    }

    ?>




    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background: url(../img/logins.jpg); 
                            background-position: center; background-size: cover;"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">


                                        <img class="mb-4" style="height: 90px;" src="../img/medan.png" alt="">
                                        <h1 class="h4 text-gray-900 mb-4">Dinas Perpustakaan dan Kearsipan Kota Medan</h1>
                                        <h1 class="h4 text-gray-900 mb-4">Login Admin</h1>

                                    </div>
                                    <form class="user" action="" method="POST">
                                        <?php echo getCSRFField(); ?>

                                        <div class="form-group">
                                            <input type="text" required name="username" class="form-control form-control-user" id="username" placeholder="Username" maxlength="50">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" required name="password" class="form-control form-control-user" id="password" placeholder="Password" maxlength="100">
                                        </div>







                                        <div class="row mt-5">
                                            <div class="col-md-6 mb-3">
                                                <input type="submit" value="Login" name="login" class=" btn btn-primary btn-user btn-block">


                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <a href="loginadmin.php" class=" btn btn-primary btn-user btn-block">
                                                    Reset
                                                </a>
                                            </div>

                                        </div>



                                    </form>
                                    <hr>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>


    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>