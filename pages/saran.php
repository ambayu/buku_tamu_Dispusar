<?php include("../config/koneksi.php");
session_start();
if (!isset($_SESSION['adminname'])) {
    header('Location: loginadmin.php');
} ?>

<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Landing page, Template, Business, Service">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="dispusar">

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="img/medan.png" type="image/png">
    <title>Saran dan Masukkan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/css/animate.css">
    <link rel="stylesheet" href="vendor/css/LineIcons.css">
    <link rel="stylesheet" href="vendor/css/owl.carousel.css">
    <link rel="stylesheet" href="vendor/css/owl.theme.css">
    <link rel="stylesheet" href="vendor/css/magnific-popup.css">
    <link rel="stylesheet" href="vendor/css/nivo-lightbox.css">
    <link rel="stylesheet" href="vendor/css/main.css">
    <link rel="stylesheet" href="vendor/css/responsive.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <div class="container" style="max-width: 90%; margin-bottom:100px; margin-top:100px;">

        <div class="col-md-12">
            <?php $_SESSION['menu'] = "saran";
            include("../includes/menu.php");
            $no = 1; ?>
        </div>

        <h5 class="fw-bold">SARAN/MASUKAN</h5>
        <table id="data_kunjungan" class="display table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Saran</th>
                </tr>
            </thead>
            <tbody>
                <?php $sqlkunjungan = mysqli_query($koneksi1, "SELECT * FROM tb_isian");
                while ($datakunjungan = mysqli_fetch_assoc($sqlkunjungan)) { ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= date('d-m-Y', strtotime($datakunjungan['tanggal'])); ?></td>
                        <td><?= $datakunjungan['saran']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
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
    </div>
</body>

</html>