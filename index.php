<?php
require_once __DIR__ . '/includes/init.php';

// Get and validate tempat parameter
if (isset($_GET['tempat']) && $_GET['tempat'] != "") {
    $tempat = validateInt($_GET['tempat']);
    if ($tempat === false) {
        redirect('error.php');
    }

    // Use prepared statement to get location
    $db = getDB();
    $lokasi_data = $db->select(
        "SELECT * FROM tb_lokasi WHERE id = ?",
        "i",
        [$tempat]
    );

    if (empty($lokasi_data)) {
        redirect('error.php');
    }

    $lokasi = $lokasi_data[0]['lokasi'];
} else {
    redirect('error.php');
}

// Get work types for display (no SQL injection risk - no user input)
$sqllogin = mysqli_query($koneksi, "SELECT * FROM tb_kerja");

// Redirect if already logged in
if (isLoggedIn()) {
    redirect("link.php");
}

// Function to check login with prepared statement
function cekLogin($username, $password)
{
    global $tempat;

    // Rate limiting
    if (!checkRateLimit($_SERVER['REMOTE_ADDR'] . '_login', 5, 300)) {
        logSecurityEvent('Rate limit exceeded for login', ['ip' => $_SERVER['REMOTE_ADDR'], 'username' => $username]);
        return false;
    }

    $db = getDB();

    // Use prepared statement to prevent SQL injection
    $users = $db->select(
        "SELECT * FROM tb_pengguna WHERE username = ?",
        "s",
        [$username]
    );

    if (!empty($users)) {
        $row = $users[0];
        if (verifyPassword($password, $row['password'])) {
            // Regenerate session ID on successful login
            session_regenerate_id(true);

            $_SESSION['id'] = $row['id'];
            $_SESSION['user'] = $row['nama'];
            $_SESSION['tempat'] = $tempat;
            $_SESSION['jk'] = $row['jk'];
            $_SESSION['usia'] = $row['umur'];
            $_SESSION['didik'] = $row['didik'];
            $_SESSION['kerja'] = $row['kerja'];

            logSecurityEvent('User logged in successfully', ['username' => $username]);
            return true;
        } else {
            logSecurityEvent('Failed login attempt - wrong password', ['username' => $username, 'ip' => $_SERVER['REMOTE_ADDR']]);
        }
    } else {
        logSecurityEvent('Failed login attempt - user not found', ['username' => $username, 'ip' => $_SERVER['REMOTE_ADDR']]);
    }

    return false;
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

    <title>BUKU TAMU</title>
    <!-- sweet alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>




<body class="bg-gradient-primary">

    <?php

    if (isset($_POST['login'])) {
        // Validate CSRF token
        if (!validateCSRF()) {
            echo '<script>
                Swal.fire(
                    "Error",
                    "Invalid request. Please try again.",
                    "error"
                ).then(function() {
                    window.location = "index.php?tempat=' . cleanOutput($tempat) . '";
                })
                </script>';
            exit;
        }

        // Sanitize inputs
        $username = sanitizeInput($_POST['Username']);
        $password = $_POST['Password']; // Don't sanitize password before verification

        if (cekLogin($username, $password)) {
            echo '<script>
        Swal.fire(

            "Login Berhasil",
            "Selamat datang di web pengunjung dinas perpustakaan dan kearsipan",
            "success"
        ).then(function() {
            window.location = "link.php";
        })
        </script>';
        } else {
            echo '<script>
                Swal.fire(

                    "Login Gagal",
                    "username atau password tidak cocok",
                    "error"
                ).then(function() {
                    window.location = "index.php?tempat=' . cleanOutput($tempat) . '";
                })
                </script>';
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
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">


                                        <img class="mb-4" style="height: 90px;" src="img/medan.png" alt="">
                                        <h1 class="h4 text-gray-900 mb-4">Dinas Perpustakaan dan Kearsipan Kota Medan</h1>
                                        <h1 class="h4 text-gray-900 mb-4">BUKU TAMU</h1>

                                    </div>
                                    <form class="user" action="" method="POST">
                                        <?php echo getCSRFField(); ?>

                                        <div class="form-group">
                                            <input type="text" required name="Username" class="form-control form-control-user" id="Username" placeholder="Username" maxlength="50">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" required name="Password" class="form-control form-control-user" id="Password" placeholder="Password" maxlength="100">
                                        </div>

                                        <div class="row mt-5">
                                            <div class="col-md-12 mb-3">
                                                <input type="submit" value="Login" name="login" class=" btn btn-primary btn-user btn-block">


                                            </div>
                                            <div class=" col-md-12 text-center">
                                                <a class="text-danger" href="register.php?tempat=<?= cleanOutput($tempat) ?>">
                                                    <small>Register<small>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>