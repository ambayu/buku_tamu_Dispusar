<?php
require_once __DIR__ . '/../includes/init.php';

// Check admin authentication
requireAdminLogin();
?>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Landing page, Template, Business, Service">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="dispusar">

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="../img/medan.png" type="image/png">
    <!-- sweet alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/css/animate.css">
    <link rel="stylesheet" href="../vendor/css/LineIcons.css">
    <link rel="stylesheet" href="../vendor/css/owl.carousel.css">
    <link rel="stylesheet" href="../vendor/css/owl.theme.css">
    <link rel="stylesheet" href="../vendor/css/magnific-popup.css">
    <link rel="stylesheet" href="../vendor/css/nivo-lightbox.css">
    <link rel="stylesheet" href="../vendor/css/main.css">
    <link rel="stylesheet" href="../vendor/css/responsive.css">
    <title>Pesan Buku</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <div class="container" style="max-width: 90%; margin-bottom:100px; margin-top:100px;">


        <?php $_SESSION['menu'] = "adminleader";
        include("../menu.php");
        $no = 1;

        if (isset($_POST['kirim'])) {

            $nama = htmlspecialchars($_POST['nama']);
            $username = htmlspecialchars($_POST['username']);


            $pass = htmlspecialchars($_POST['password']);
            $password = password_hash($pass, PASSWORD_BCRYPT);

            $email = htmlspecialchars($_POST['email']);
            $status = htmlspecialchars($_POST['status']);
            $level = htmlspecialchars($_POST['level']);

            $cek = mysqli_query($koneksi2, "SELECT * FROM tb_login where username = '$username' ");
            //   echo "SELECT * FROM tb_login where username = $username ";

            if ($cek->num_rows > 0) {

                echo '<script>
                    Swal.fire(
                
                        "TAMBAH GAGAL.!! USERNAME SUDAH ADA",
                        "Username tidak boleh sama dengan admin sebelumnya",
                        "error"
                    )
                    </script>';
            } else {
                $sqlpesan = mysqli_query($koneksi2, " INSERT INTO tb_login (nama,username,`password`,email,`status`,`level`) VALUES ('$nama','$username','$password','$email','$status','$level')");
                if ($sqlpesan) {
                    echo '<script>
                    Swal.fire(
                
                        "Data Berhasil Dikirim",
                        "ADMIN DITAMBAHKAN",
                        "success"
                    ).then(function() {
                        window.location = "adminleader.php";
                    })
                    </script>';
                }
            }
        }

        ?>
        <h5 class="fw-bold">ADMIN LEADER</h5>

        <br>
        <p>TAMBAH ADMIN</p>
        <form action="" method="post">
            <div class="row">


                <div class="col-md-2">
                    <div class="form-group">
                        <label for="nama">Nama </label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="text" required name="nama" class="form-control form-control-user" id="nama" placeholder="Nama">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="username">Username </label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="text" required name="username" class="form-control form-control-user" id="username" placeholder="Username">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="password">Password </label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="password" required name="password" class="form-control form-control-user" id="password" placeholder="Password">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="email">Email </label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="email" required name="email" class="form-control form-control-user" id="email" placeholder="Email">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status">Status </label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="text" required name="status" class="form-control form-control-user" id="status" placeholder="Status">
                    </div>
                </div>


                <div class="col-md-2">
                    <div class="form-group">
                        <label for="level">Level </label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="text" required name="level" class="form-control form-control-user" id="level" placeholder="Level">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <input type="submit" value="Kirim" name="kirim" class=" btn btn-primary btn-user btn-block">
                        <div class="form-group">
                        </div>
                    </div>


        </form>
        <hr>
        <p>TABEL DATA ADMIN</p>
        <table id="data_kunjungan" class="display table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $sqlkunjungan = mysqli_query($koneksi2, "SELECT * FROM tb_login");
                while ($datakunjungan = mysqli_fetch_assoc($sqlkunjungan)) { ?>
                    <tr>
                        <td><?= $no++; ?></td>

                        <td><?= $datakunjungan['nama']; ?></td>
                        <td><?= $datakunjungan['username']; ?></td>
                        <td><?= $datakunjungan['email']; ?></td>

                        <td><?= $datakunjungan['status']; ?></td>
                        <td><?= $datakunjungan['level']; ?></td>
                        <td><a class="btn btn-danger" href="aksiadmin.php?aksi=hapus&id=<?= $datakunjungan['id']; ?>"><i class="bi bi-trash"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#data_kunjungan').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });
</script>

</html>