<?php
require_once __DIR__ . '/../includes/init.php';

// Check admin authentication
requireAdminLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Landing page, Template, Business, Service">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="dispusar">
    <title>Buku Tamu</title>
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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">


</head>
<style>

</style>

<body>
    <div class="header">
        <?php $_SESSION['menu'] = "bukutamu2";
        include("../includes/menu.php");
        ?>
    </div>
    <div class="container" style="max-width: 90%; margin-bottom:100px; margin-top:100px;">
        <?php

        $no = 1; ?>

        <h5 class="fw-bold">DATA KUNJUNGAN PERPUSTAKAAN</h5>
        <form action="" method="POST">
            <select name="posisi">
                <option value="Semua">--------Semua--------</option>
                <?php
                $tempat = mysqli_query($koneksi, "SELECT * FROM tb_lokasi");
                while ($datatempat = mysqli_fetch_assoc($tempat)) { ?>
                    <option value="<?= $datatempat['lokasi']; ?>"><?= $datatempat['lokasi']; ?></option><?php
                                                                                                    } ?>
            </select>
            Tanggal : <input type="date" name="tgl_awal" required> sampai
            <input type="date" name="tgl_akhir" required>
            <input type="submit" name="proses" value="Proses" class="btn btn-info">
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

        <?php if (isset($_POST['proses'])) {
            $posisi = $_POST['posisi'];
            $tgl_awal = $_POST['tgl_awal'];
            $tgl_akhir = $_POST['tgl_akhir'];
            $_SESSION['posisi'] = $posisi;
            $_SESSION['tgl_awal'] = $tgl_awal;
            $_SESSION['tgl_akhir'] = $tgl_akhir;
            echo "Lokasi : " . $posisi . ", Tanggal : " . date('d-m-Y', strtotime($tgl_awal)) . " sampai " . date('d-m-Y', strtotime($tgl_akhir));
            if ($posisi == "Semua") {
                $query = "SELECT a.tanggal,a.jam,a.id,b.umur,b.kerja,b.didik,b.jk,b.alamat,b.nama,c.lokasi FROM tb_pengunjung a left join tb_pengguna b on a.id_pengguna=b.id  left join tb_lokasi c on a.tempat=c.id  WHERE a.tanggal>='$tgl_awal' AND a.tanggal<='$tgl_akhir' order by a.id DESC";
                $sqlkunjungan = mysqli_query($koneksi, $query);
            } else {
                $sqlkunjungan = mysqli_query($koneksi, "SELECT a.tanggal,a.jam,a.id,b.umur,b.kerja,b.didik,b.jk,b.alamat,b.nama,c.lokasi FROM tb_pengunjung a left join tb_pengguna b on a.id_pengguna=b.id left join tb_lokasi c on a.tempat=c.id  WHERE c.lokasi='$posisi' AND a.tanggal>='$tgl_awal' AND a.tanggal<='$tgl_akhir' order by a.id  desc");
            } ?>
            <table id="data_kunjungan" class="display table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Pekerjaan</th>
                        <th>Pendidikan</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($datakunjungan = mysqli_fetch_assoc($sqlkunjungan)) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d-m-Y', strtotime($datakunjungan['tanggal'])); ?></td>
                            <td><?= date('H:i', strtotime($datakunjungan['jam'])); ?></td>
                            <td><?= $datakunjungan['id']; ?></td>
                            <td><?= $datakunjungan['umur']; ?></td>
                            <td><?= $datakunjungan['kerja']; ?></td>
                            <td><?= $datakunjungan['didik']; ?></td>
                            <td><?= $datakunjungan['jk']; ?></td>
                            <td><?= $datakunjungan['alamat']; ?></td>
                            <td><?= $datakunjungan['lokasi']; ?></td>
                            <td><a class="btn btn-danger" href="aksi.php?aksi=hapus&id=<?= $datakunjungan['id']; ?>"><i class="bi bi-trash"></i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <strong>

                <?php


                if ($posisi == "Semua") {
                    $query = "SELECT 
							COUNT(*) AS total_data,
							SUM(b.jk LIKE '%laki-laki%') AS jumlah_laki_laki,
							SUM(b.jk LIKE '%perempuan%') AS jumlah_perempuan
						FROM 
							tb_pengunjung a
						LEFT JOIN 
							tb_pengguna b ON a.id_pengguna = b.id
						LEFT JOIN 
							tb_lokasi c ON a.tempat = c.id
						WHERE 
							a.tanggal >= '$tgl_awal' AND a.tanggal <= '$tgl_akhir'
						ORDER BY 
							a.id DESC;";
                } else {
                    $query = "SELECT 
							COUNT(*) AS total_data,
							SUM(b.jk LIKE '%laki-laki%') AS jumlah_laki_laki,
							SUM(b.jk LIKE '%perempuan%') AS jumlah_perempuan FROM tb_pengunjung a left join tb_pengguna b on a.id_pengguna=b.id left join tb_lokasi c on a.tempat=c.id  WHERE c.lokasi='$posisi' AND a.tanggal>='$tgl_awal' AND a.tanggal<='$tgl_akhir'  order by a.id  desc";
                }
                $result = $koneksi->query($query);
                $row = mysqli_fetch_assoc($result);
                echo "Jumlah Pengunjung : " . $row['total_data'];
                echo "<br>";
                echo "Jumlah Pengunjung Laki Laki : " . $row['jumlah_laki_laki'];
                echo "<br>";

                echo "Jumlah Pengunjung Perempuan : " . $row['jumlah_perempuan'];


                ?>

                <h1>Pendidikan</h1>

                <?php
                $didik = "Select * from tb_didik";
                $result2 = $koneksi->query($didik);
                while ($row = mysqli_fetch_assoc($result2)) {
                    $didik = " AND b.didik = '" . $row['didik'] . "'";

                    if ($posisi == "Semua") {
                        $query = "SELECT a.tanggal,a.jam,a.id,b.umur,b.kerja,b.didik,b.jk,b.alamat,b.nama,c.lokasi FROM tb_pengunjung a left join tb_pengguna b on a.id_pengguna=b.id  left join tb_lokasi c on a.tempat=c.id  WHERE a.tanggal>='$tgl_awal' AND a.tanggal<='$tgl_akhir' $didik order by a.id DESC";
                    } else {
                        $query = "SELECT a.tanggal,a.jam,a.id,b.umur,b.kerja,b.didik,b.jk,b.alamat,b.nama,c.lokasi FROM tb_pengunjung a left join tb_pengguna b on a.id_pengguna=b.id left join tb_lokasi c on a.tempat=c.id  WHERE c.lokasi='$posisi' AND a.tanggal>='$tgl_awal' AND a.tanggal<='$tgl_akhir' $didik order by a.id  desc";
                    }
                    $result = $koneksi->query($query);
                    echo "<br>";
                    echo $row['didik'] . " : " . mysqli_num_rows($result);
                }
                ?>
                <h1>Pekerjaan</h1>
                <?php
                $kerja = "Select * from tb_kerja";
                $result2 = $koneksi->query($kerja);
                while ($row = mysqli_fetch_assoc($result2)) {
                    $kerja = " AND b.kerja = '" . $row['kerja'] . "'";

                    if ($posisi == "Semua") {
                        $query = "SELECT a.tanggal,a.jam,a.id,b.umur,b.kerja,b.didik,b.jk,b.alamat,b.nama,c.lokasi FROM tb_pengunjung a left join tb_pengguna b on a.id_pengguna=b.id  left join tb_lokasi c on a.tempat=c.id  WHERE a.tanggal>='$tgl_awal' AND a.tanggal<='$tgl_akhir' $kerja order by a.id DESC";
                    } else {
                        $query = "SELECT a.tanggal,a.jam,a.id,b.umur,b.kerja,b.didik,b.jk,b.alamat,b.nama,c.lokasi FROM tb_pengunjung a left join tb_pengguna b on a.id_pengguna=b.id left join tb_lokasi c on a.tempat=c.id  WHERE c.lokasi='$posisi' AND a.tanggal>='$tgl_awal' AND a.tanggal<='$tgl_akhir' $kerja order by a.id  desc";
                    }
                    $result = $koneksi->query($query);
                    echo "<br>";
                    echo $row['kerja'] . " : " . mysqli_num_rows($result);
                }
                ?>




            </strong>






        <?php

        } ?>
    </div>


</body>

<script src="../vendor/js/jquery-min.js"></script>
<script src="../vendor/js/popper.min.js"></script>
<script src="../vendor/js/bootstrap.min.js"></script>
<script src="../vendor/js/owl.carousel.js"></script>
<script src="../vendor/js/jquery.nav.js"></script>
<script src="../vendor/js/scrolling-nav.js"></script>
<script src="../vendor/js/jquery.easing.min.js"></script>
<script src="../vendor/js/nivo-lightbox.js"></script>
<script src="../vendor/js/jquery.magnific-popup.min.js"></script>


<script src="../vendor/js/main.js"></script>

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