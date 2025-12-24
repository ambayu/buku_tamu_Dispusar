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
    <title>Indeks Kepuasan Masyarakat</title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="../img/medan.png" type="image/png">

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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>

    <div class="container" style="max-width: 90%; margin-bottom:100px; margin-top:100px;">
        <?php $_SESSION['menu'] = "skm";
        include("menu.php");
        $no = 1; ?>
        <h5 class="fw-bold">INDEKS KEPUASAN MASYARAKAT</h5>
        <form action="" method="POST">
            <select name="posisi">
                <option value="Semua">--------Semua--------</option>
                <?php $tempat = mysqli_query($koneksi1, "SELECT * FROM tb_layanan");
                while ($datatempat = mysqli_fetch_assoc($tempat)) { ?>
                    <option value="<?= $datatempat['layanan']; ?>"><?= $datatempat['layanan']; ?></option><?php } ?>
            </select>
            Tanggal : <input type="date" name="tgl_awal" required> sampai
            <input type="date" name="tgl_akhir" required>
            <input type="submit" name="proses" value="Proses" class="btn btn-info">
        </form>



        <?php if (isset($_POST['proses'])) {
            $posisi = $_POST['posisi'];
            $tgl_awal = $_POST['tgl_awal'];
            $tgl_akhir = $_POST['tgl_akhir'];
            $_SESSION['posisi'] = $posisi;
            $_SESSION['tgl_awal'] = $tgl_awal;
            $_SESSION['tgl_akhir'] = $tgl_akhir;
            echo "Layanan : " . $posisi . ", Tanggal : " . date('d-m-Y', strtotime($tgl_awal)) . " sampai " . date('d-m-Y', strtotime($tgl_akhir));
            if ($posisi == "Semua") {
                $sqlkunjungan = mysqli_query($koneksi1, "SELECT * FROM tb_isian WHERE tanggal>='$tgl_awal' AND tanggal<='$tgl_akhir'");
            } else {
                $sqlkunjungan = mysqli_query($koneksi1, "SELECT * FROM tb_isian WHERE layanan='$posisi' AND tanggal>='$tgl_awal' AND tanggal<='$tgl_akhir'");
            } ?>
            <table id="data_kunjungan" class="display table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Nama</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                        <th>9</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data[1] = 0;
                    $data[2] = 0;
                    $data[3] = 0;
                    $data[4] = 0;
                    $data[5] = 0;
                    $data[6] = 0;
                    $data[7] = 0;

                    $data[8] = 0;
                    $data[9] = 0;

                    ?>
                    <?php while ($datakunjungan = mysqli_fetch_assoc($sqlkunjungan)) {

                    ?>

                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d-m-Y', strtotime($datakunjungan['tanggal'])); ?></td>
                            <td><?= $datakunjungan['jam']; ?></td>
                            <td><?= $datakunjungan['nama']; ?></td>
                            <td><?= $datakunjungan['jawab1']; ?></td>
                            <td><?= $datakunjungan['jawab2']; ?></td>
                            <td><?= $datakunjungan['jawab3']; ?></td>
                            <td><?= $datakunjungan['jawab4']; ?></td>
                            <td><?= $datakunjungan['jawab5']; ?></td>
                            <td><?= $datakunjungan['jawab6']; ?></td>
                            <td><?= $datakunjungan['jawab7']; ?></td>
                            <td><?= $datakunjungan['jawab8']; ?></td>
                            <td><?= $datakunjungan['jawab9']; ?></td>
                            <td><a class="btn btn-danger" href="aksiskm.php?aksi=hapus&id=<?= $datakunjungan['id']; ?>"><i class="bi bi-trash"></i></a></td>
                            <?php

                            $data[1] = $data[1] + $datakunjungan['jawab1'];
                            $data[2] = $data[2] + $datakunjungan['jawab2'];
                            $data[3] = $data[3] + $datakunjungan['jawab3'];
                            $data[4] = $data[4] + $datakunjungan['jawab4'];
                            $data[5] = $data[5] + $datakunjungan['jawab5'];
                            $data[6] = $data[6] + $datakunjungan['jawab6'];
                            $data[7] = $data[7] + $datakunjungan['jawab7'];
                            $data[8] = $data[8] + $datakunjungan['jawab8'];
                            $data[9] = $data[9] + $datakunjungan['jawab9']; ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        <?php }


        $bobotp[] = null;
        $bobots = null;
        if ($no > 1) {
            for ($i = 1; $i <= 9; $i++) {
                $bobot[$i] = ($data[$i] / ($no - 1)) / 9;


                $bobots = $bobots + $bobot[$i];
            }
            $ikm = $bobots * 25;
        } else {
            $ikm = 0;
        }
        ?>
        <h3 style="margin-bottom: 100px;">Indeks Kepuasan Masyarakat : <?= $ikm; ?></h3>
    </div>
</body>

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