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

// Get options for form
$sqlkerja = mysqli_query($koneksi, "SELECT * FROM tb_kerja");
$sqldidik = mysqli_query($koneksi, "SELECT * FROM tb_didik");

// Redirect if already logged in
if (isLoggedIn()) {
    redirect("../link.php");
}

function validasiPanjang($username, $password)
{
    return (strlen($username) >= 5 && strlen($password) >= 8);
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

    if (isset($_POST['kirim']) && $_POST['kirim'] != "") {
        // Validate CSRF token
        if (!validateCSRF()) {
            echo '<script>
                Swal.fire(
                    "Error",
                    "Invalid request. Please try again.",
                    "error"
                ).then(function() {
                    window.location = "register.php?tempat=' . cleanOutput($tempat) . '";
                })
                </script>';
            exit;
        }

        // Rate limiting
        if (!checkRateLimit($_SERVER['REMOTE_ADDR'] . '_register', 3, 300)) {
            echo '<script>
                Swal.fire(
                    "Terlalu Banyak Percobaan",
                    "Silakan tunggu beberapa menit sebelum mendaftar lagi.",
                    "error"
                ).then(function() {
                    window.location = "register.php?tempat=' . cleanOutput($tempat) . '";
                })
                </script>';
            exit;
        }

        $tanggal = date('Y-m-d');
        $jam = date('H:i:s');

        // Sanitize and validate inputs
        $username = sanitizeInput($_POST['username']);
        $rawpass = $_POST['password']; // Don't sanitize password

        // Validate username and password
        if (!validateUsername($username)) {
            echo '<script>
                Swal.fire(
                    "Pendaftaran Gagal",
                    "Username harus 5-20 karakter dan hanya mengandung huruf, angka, dan underscore",
                    "error"
                ).then(function() {
                    window.location = "register.php?tempat=' . cleanOutput($tempat) . '";
                })
                </script>';
            exit;
        }

        if (!validatePassword($rawpass)) {
            echo '<script>
                Swal.fire(
                    "Pendaftaran Gagal",
                    "Password harus minimal 8 karakter",
                    "error"
                ).then(function() {
                    window.location = "register.php?tempat=' . cleanOutput($tempat) . '";
                })
                </script>';
            exit;
        }

        // Hash password securely
        $password = hashPassword($rawpass);

        $nama = sanitizeInput($_POST['nama']);
        $umur = validateInt($_POST['umur']);

        if ($umur === false || $umur < 1 || $umur > 150) {
            echo '<script>
                Swal.fire(
                    "Pendaftaran Gagal",
                    "Umur tidak valid",
                    "error"
                ).then(function() {
                    window.location = "register.php?tempat=' . cleanOutput($tempat) . '";
                })
                </script>';
            exit;
        }

        $kerja = sanitizeInput($_POST['kerja']);
        $didik = sanitizeInput($_POST['didik']);
        $jk = sanitizeInput($_POST['jk']);
        $alamat = sanitizeInput($_POST['alamat']);

        // Check if username already exists using prepared statement
        $db = getDB();
        $existing = $db->select(
            "SELECT id FROM tb_pengguna WHERE username = ?",
            "s",
            [$username]
        );

        if (!empty($existing)) {
            echo '<script>
        Swal.fire(
    
            "Pendaftaran Gagal",
            "Username telah digunakan. Harap gunakan username lain",
            "error"
        ).then(function() {
            window.location = "register.php?tempat=' . cleanOutput($tempat) . '";
        })
        </script>';
            exit;
        }

        // Insert using prepared statement
        $result = $db->execute(
            "INSERT INTO tb_pengguna (username, `password`, tanggal, jam, nama, umur, kerja, didik, jk, alamat) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            "sssssissss",
            [$username, $password, $tanggal, $jam, $nama, $umur, $kerja, $didik, $jk, $alamat]
        );

        if ($result) {
            $_SESSION['lokasi'] = $lokasi;
            logSecurityEvent('New user registered', ['username' => $username]);

            echo '<script>
        Swal.fire(
    
            "Pendaftaran Berhasil",
            "Silahkan login menggunakan username dan password yang telah didaftarkan",
            "success"
        ).then(function() {
            window.location = "index.php?tempat=' . cleanOutput($tempat) . '";
        })
        </script>';
        } else {
            echo '<script>
        Swal.fire(
    
            "Pendaftaran Gagal",
            "Terjadi kesalahan. Silakan coba lagi",
            "error"
        ).then(function() {
            window.location = "register.php?tempat=' . cleanOutput($tempat) . '";
        })
        </script>';
        }

        exit;
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
                                        <p class="text-danger"><small>Harap mengingat password serta username untuk login anda</small></p>

                                    </div>
                                    <form class="user" action="" method="POST">
                                        <?php echo getCSRFField(); ?>

                                        <div class="form-group">
                                            <input type="text" required name="username" class="form-control form-control-user" id="Username" placeholder="Username" maxlength="20" pattern="[a-zA-Z0-9_]{5,20}" title="5-20 karakter, hanya huruf, angka, dan underscore">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" required name="password" class="form-control form-control-user" id="Password" placeholder="Password" minlength="8" maxlength="100">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" required name="nama" class="form-control form-control-user" id="nama" placeholder="Nama" maxlength="100">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" required name="umur" class="form-control form-control-user" id="umur" placeholder="Umur" min="1" max="150">
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleFormControlSelect1">Pekerjaan</label>
                                            <select class="form-control" name="kerja" id="exampleFormControlSelect1">
                                                <?php
                                                while ($datakerja = mysqli_fetch_assoc($sqlkerja)) { ?>
                                                    <option>
                                                        <?= $datakerja['kerja']; ?>
                                                    </option> <?php } ?>
                                            </select>
                                        </div>


                                        <div class="mb-3">
                                            <label for="exampleFormControlSelect1">Pendidikan Terakhir</label>
                                            <select class="form-control" name="didik" id="exampleFormControlSelect1">
                                                <?php
                                                while ($datakerja = mysqli_fetch_assoc($sqldidik)) { ?>
                                                    <option>
                                                        <?= $datakerja['didik']; ?>
                                                    </option> <?php } ?>
                                            </select>
                                        </div>



                                        <div>
                                            <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault1" type="radio" value="laki-laki" name="jk" checked>
                                            <label class="form-check-label" for="flexRadioDefault1">Laki-Laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="flexRadioDefault2" type="radio" value="perempuan" name="jk">
                                            <label class="form-check-label" for="flexRadioDefault2">Perempuan</label>
                                        </div>

                                        <div class="mb-0 mt-3">
                                            <label for="exampleFormControlTextarea1">Alamat</label>
                                            <textarea required name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                        </div>

                                        <div class="row mt-5">
                                            <div class="col-md-6 mb-3">
                                                <input type="submit" value="Kirim" name="kirim" class=" btn btn-primary btn-user btn-block">


                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <a href="register.php?tempat=<?= $tempat ?>" class=" btn btn-primary btn-user btn-block">
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