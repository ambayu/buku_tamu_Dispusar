<?php
session_start();
ob_start();
date_default_timezone_set("Asia/Jakarta");
include("koneksi.php");
$sqlsoal = mysqli_query($koneksi1, "SELECT * FROM tb_soal");

$tempat = $_SESSION["tempat"];

if (isset($_SESSION['user'])) {
} else {

    if (isset($_SESSION['tempat'])) {
        header("Location:index.php?tempat=" . $tempat . "");
    } else {
        header("Location:error.php");
    }
}
if (isset($_POST['logout'])) {

    session_destroy();

    header("Location: index.php?tempat=" . $tempat . "");
}


//submit




?>


<!DOCTYPE html>
<html lang="en">
<style>
    @media only screen and (max-width: 600px) {
        .textlogo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo {
            width: 70%;

            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .p {
            font-size: 20px !important;
        }

        p {
            font-size: 17px !important;
        }

    }
</style>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Landing page, Template, Business, Service">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="Grayrids">
    <title>Dinas Perpustakaan dan Kearsipan Kota Medan</title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="/img/medan.png" type="image/png">

    <!-- sweet alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

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

</head>

<body>

    <?php


    if (isset($_POST['tombol'])) {

        $layanan = "Perpustakaan";
        $nama = $_SESSION['user'];

        $tanggal = date('Y-m-d');
        $waktu = date('H:i:s');
        $jk = $_SESSION['jk'];
        $usia = $_SESSION['usia'];
        $didik = $_SESSION['didik'];
        $kerja = $_SESSION['kerja'];
        $pilih1 = htmlspecialchars($_POST['pilih1']);
        $pilih2 = htmlspecialchars($_POST['pilih2']);
        $pilih3 = htmlspecialchars($_POST['pilih3']);
        $pilih4 = htmlspecialchars($_POST['pilih4']);
        $pilih5 = htmlspecialchars($_POST['pilih5']);
        $pilih6 = htmlspecialchars($_POST['pilih6']);
        $pilih7 = htmlspecialchars($_POST['pilih7']);
        $pilih8 = htmlspecialchars($_POST['pilih8']);
        $pilih9 = htmlspecialchars($_POST['pilih9']);
        $saran = htmlspecialchars($_POST['saran']);

        $simpan = mysqli_query($koneksi1, "INSERT INTO tb_isian (layanan,nama,tanggal,jam,jk,usia,pendidikan,pekerjaan,jawab1,jawab2,jawab3,jawab4,jawab5,jawab6,jawab7,jawab8,jawab9,saran) VALUES ('$layanan','$nama','$tanggal','$waktu','$jk','$usia','$didik','$kerja','$pilih1','$pilih2','$pilih3','$pilih4','$pilih5','$pilih6','$pilih7','$pilih8','$pilih9','$saran')");


        echo '<script>
    Swal.fire(

        "Data Berhasil Dikirim",
        "Terimakasih Surveinya",
        "success"
    ).then(function() {
        window.location = "link.php";
    })
    </script>';
    }

    ?>

    <!-- Business Plan Section Start -->
    <section id="business-plan">
        <div class="container">

            <div class="row">
                <!-- Start Col -->
                <div class="col-lg-6 col-md-12 pl-0 pt-70 pr-5">
                    <div class="business-item-img">
                        <img src="img/contact/01.png" class="img-fluid" alt="">
                    </div>
                </div>
                <!-- End Col -->
                <!-- Start Col -->
                <div class="col-lg-6 col-md-12 pl-4">
                    <div class="business-item-info">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 pl-0 pr-0">
                                <img class="logo" src="img/medan.png" width="100%" alt="">
                            </div>
                            <div class="textlogo col-lg-8 col-md-8 col-sm-8 pl-0 pr-0">
                                <h3 class="textlogo">Dinas Perpustakaan dan Kearsipan Kota Medan</h3>
                            </div>
                        </div>

                        <p>Selamat datang di Dinas Perpustakaan dan Kearsipan Kota Medan. Kami berkomitmen untuk memberikan pelayanan terbaik kepada masyarakat dalam bidang perpustakaan dan kearsipan. Melalui survei kepuasan ini, kami ingin mengetahui pendapat Anda tentang kualitas layanan kami. Masukan dan saran Anda sangat berharga untuk meningkatkan kualitas pelayanan perpustakaan yang lebih baik di masa mendatang. Terima kasih atas partisipasi Anda dalam mengisi survei kepuasan masyarakat ini.</p>

                        <a class="btn btn-common" href="index2.php">Home</a>


                    </div>
                </div>
                <!-- End Col -->

            </div>
        </div>
    </section>
    <!-- Business Plan Section End -->
    <!-- Cool Fetatures Section Start -->
    <section id="features" class="section">
        <div class="container">
            <!-- Start Row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="features-text section-header text-center">
                        <div>
                            <h2 class="section-title">SURVEI KEPUASAN MASYARAKAT</h2>
                            <div class="desc-text">
                                <p>Kami memiliki beberapa pertanyaan survei guna meningkatkan pelayanan dan kenyamanan pembaca diperpustakaan, dimohon berikan survei anda guna meningkatkan kualitas dari Dinas Perpustakaan dan Kearsipan Kota Medan</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Row -->
            <!-- Start Row -->


            <!-- End Row -->
        </div>
    </section>
    <!-- Cool Fetatures Section End -->


    <div class="col-lg-12 col-md-12 ">
        <div class="container">
            <div class="col-lg-12 col-md-6">
                <form action="" method="post">
                    <table>
                        <?php while ($datasoal = mysqli_fetch_assoc($sqlsoal)) {
                            $no = $datasoal['id']; ?>
                            <tr>
                                <td valign="top" style="width:30px;">
                                    <p style="font-size: 24px;"><br><?= $no; ?>.</p>
                                </td>
                                <td>
                                    <p class="p" style="font-size: 30px;"><br><?= $datasoal['soal'] . " ? <br> <br>"; ?> </p>
                                </td>
                            <tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input style="width: 20px; height:20px;" type="radio" name="pilih<?= $no; ?>" value=1 id="opsi1<?= $no ?>" required>
                                    <label for="opsi1<?= $no ?>">
                                        <p style="font-size: 27px; color:black"> &nbsp; <?= $datasoal['opsi1']; ?></p>
                                    </label><br>
                                    <input style="width: 20px; height:20px;" type="radio" name="pilih<?= $no; ?>" value=2 id="opsi2<?= $no ?>"><label for="opsi2<?= $no ?>">
                                        <p style="font-size: 27px; color:black"> &nbsp; <?= $datasoal['opsi2']; ?></p>
                                    </label><br>
                                    <input style="width: 20px; height:20px;" type="radio" name="pilih<?= $no; ?>" value=3 id="opsi3<?= $no ?>"><label for="opsi3<?= $no ?>">
                                        <p style="font-size: 27px; color:black"> &nbsp; <?= $datasoal['opsi3']; ?> </p>
                                    </label><br>
                                    <input style="width: 20px; height:20px;" type="radio" name="pilih<?= $no; ?>" value=4 id="opsi4<?= $no ?>"><label for="opsi4<?= $no ?>">
                                        <p style="font-size: 27px; color:black"> &nbsp; <?= $datasoal['opsi4']; ?> </p>
                                    </label>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td></td>
                            <td><br>
                                <bold>Saran/Masukan</bold><br>
                                <textarea name="saran" class="form-control"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><br> <input class="btn btn-common" style="width: 100%;" type="submit" value="Kirim" name="tombol" class=" btn btn-primary btn-user btn-block"></td>
                        </tr>
                    </table><br>

                </form>

            </div>
        </div>
    </div>








    <!-- Footer Section Start -->
    <footer>
        <!-- Footer Area Start -->
        <section id="footer-Content" style="padding-top: 0;">

            <!-- Copyright Start  -->

            <div class="copyright">
                <div class="container">
                    <!-- Star Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="site-info text-center">
                                <p>Crafted by Dinas Perpustakaan <a href="" rel="nofollow">2023</a></p>
                            </div>

                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- Copyright End -->
        </section>
        <!-- Footer area End -->

    </footer>
    <!-- Footer Section End -->


    <!-- Go To Top Link -->
    <a href="#" class="back-to-top">
        <i class="lni-chevron-up"></i>
    </a>

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader" id="loader-1"></div>
    </div>
    <!-- End Preloader -->

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="vendor/js/jquery-min.js"></script>
    <script src="vendor/js/popper.min.js"></script>
    <script src="vendor/js/bootstrap.min.js"></script>
    <script src="vendor/js/owl.carousel.js"></script>
    <script src="vendor/js/jquery.nav.js"></script>
    <script src="vendor/js/scrolling-nav.js"></script>
    <script src="vendor/js/jquery.easing.min.js"></script>
    <script src="vendor/js/nivo-lightbox.js"></script>
    <script src="vendor/js/jquery.magnific-popup.min.js"></script>
    <script src="vendor/js/form-validator.min.js"></script>
    <script src="vendor/js/contact-form-script.js"></script>
    <script src="vendor/js/main.js"></script>

</body>

</html>