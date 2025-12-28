<?php
session_start();
$id = $_SESSION['id'];
include "../config/koneksi.php";
date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d');
$jam = date('H:i:s');
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
?>
<!DOCTYPE html>
<html lang="en">
<style>
  @media only screen and (max-width: 600px) {
    .textlogo {
      text-align: center;
      margin-bottom: 10px;
    }

    @media (max-width: 768px) {
      .gambar {
        display: none;
        /* Menghilangkan gambar saat lebar layar ≤ 768px */
      }
    }

    .logo {
      width: 70%;

      display: block;
      margin-left: auto;
      margin-right: auto;
    }
  }
</style>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="keywords" content="Bootstrap, Landing page, Template, Business, Service">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="author" content="dispusar">
  <title>Dinas Perpustakaan dan Kearsipan Kota Medan</title>
  <!-- sweet alert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

  <!--====== Favicon Icon ======-->
  <link rel="shortcut icon" href="/img/medan.png" type="image/png">
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

  <!-- Business Plan Section Start -->
  <section id="business-plan">
    <div class="container">

      <div class="row">
        <!-- Start Col -->
        <div class="col-lg-6 col-md-12 pl-0 pt-70 pr-5">
          <div class="business-item-img">
            <img src="img/business/business-img.png" class="img-fluid gambar" alt="">
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

            <header>

              <p>Kami hadir untuk menjadikan pengetahuan lebih dekat dengan Anda. Temukan beragam buku, jurnal, dan sumber daya belajar di sini.</p>
            </header>

            <!-- Tambahkan konten dan fitur aplikasi di sini -->

            <footer>
              <p>Terima kasih telah bergabung dengan kami. Mari bersama-sama menjelajahi dunia literasi!</p>
            </footer>

            <div style="  display: flex;align-items: center;margin-right: 10px;">
              <a style="margin-right:4px" class="btn btn-common" href="#">Portal</a>

              <form style="display: inline;" action="" method="post">
                <input class="btn btn-common" value="Logout" name="logout" type="submit"></input>
              </form>
            </div>
          </div>
        </div>
        <!-- End Col -->

      </div>
    </div>
  </section>
  <!-- Business Plan Section End -->
  <!-- Cool Fetatures Section Start -->

  <?php
  if (isset($_POST['buku_tamu'])) {

    $simpan = mysqli_query($koneksi, "INSERT INTO tb_pengunjung (id_pengguna,tanggal,jam,tempat) VALUES ('$id','$tanggal','$jam','$tempat')");
    if ($simpan) {
      echo '<script>
      Swal.fire(

          "BUKU TAMU TELAH DIISI",
          "Terimakasih atas kunjungannya, silahkan gunakan feature kami lainnya dan jika berkenan bisa isi survei dibawah ya",
          "success"
      ).then(function() {
          window.location = "link.php";
      })
      </script>';
    } else {
      echo '<script>
      Swal.fire(

          "BUKU TAMU GAGAL DIISI",
          "Silahkan refresh browser anda , atau hubungi admin",
          "error"
      ).then(function() {
          window.location = "link.php";
      })
      </script>';
    }
  }
  ?>



  <section style="padding: 0;" id="features" class="section">
    <div class="container">
      <!-- Start Row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="features-text section-header text-center">
            <div>
              <h2 class="section-title">KLIK TOMBOL DIBAWAH UNTUK MENGISI BUKU TAMU</h2>
              <div class="desc-text">
                <?php



                $cek_pengunjung = mysqli_query($koneksi, "SELECT * FROM tb_pengunjung WHERE id_pengguna='$id' and tanggal='$tanggal'");

                if (mysqli_num_rows($cek_pengunjung) > 0) {
                  echo "<p >Anda sudah mengisi buku tamu hari ini, silahkan datang lagi besok<p>";
                  echo "<img style='max-height:320px;' src='img/buku_tamu.png'>";
                } else {
                ?>
                  <form style="display: inline;" action="" method="post">
                    <input class="btn btn-common" value="ISI BUKU TAMU" name="buku_tamu" type="submit"></input>
                  </form>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>


  <section id="features" class="section">
    <div class="container">
      <!-- Start Row -->
      <div class="row">


        <div class="col-lg-12 mt-5">
          <div class="features-text section-header text-center">
            <div>
              <h2 class="section-title">Feature Yang Kami Miliki</h2>
              <div class="desc-text">
                <p>Kami memiliki beberapa feature yang dapat memudahkan anda dalam pencarian informasi di Dinas Perpustakaan dan Kearsipan Kota Medan.</p>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>
  <!-- Cool Fetatures Section End -->


  <!-- Services Section Start -->
  <section id="services" class="section">
    <div class="container">

      <div class="row">
        <!-- Start Col -->

        <div class="col-lg-4 col-md-6 col-xs-12">
          <a href="http://perpustakaan.pemkomedan.go.id/pendaftaran/">
            <div class=" services-item text-center">
              <div class="icon">
                <i class="lni-cog"></i>
              </div>
              <h4>Pendaftaran Anggota</h4>
              <p>Portal Dinas Perpustakaan dan Kearsipan Kota Medan untuk pendaftaran anggota secara online</p>
            </div>
          </a>
        </div>
        <!-- End Col -->
        <!-- Start Col -->
        <div class="col-lg-4 col-md-6 col-xs-12 mt-2">
          <a href="http://perpustakaan.pemkomedan.go.id/opac/">
            <div class="services-item text-center">
              <div class="icon">
                <i class="lni-archive"></i>
              </div>
              <h4>Online Public Access Catalog</h4>
              <p>Pencarian Buku atau catalog secara online</p>
            </div>
          </a>
        </div>
        <!-- End Col -->
        <!-- Start Col -->
        <div class="col-lg-4 col-md-6 col-xs-12 mt-2">
          <a href="https://play.google.com/store/apps/details?id=id.kubuku.kbk12325c5">
            <div class="services-item text-center">
              <div class="icon">
                <i class="lni-notepad"></i>
              </div>
              <h4>Buku digital</h4>
              <p>Aplikasi Buku digital Dinas Perpustakaan dan Kearsipan Kota Medan</p>
            </div>
          </a>
        </div>
        <div class="col-lg-6 col-md-6 col-xs-12 mt-2 ">
          <a href="pesanbuku.php">
            <div class="services-item text-center">
              <div class="icon">
                <i class="lni-layers"></i>
              </div>
              <h4>Pemesanan Buku</h4>
              <p>Form Request Buku di Dinas Perpustakaan dan Kearsipan Kota Medan</p>
            </div>
          </a>
        </div>

        <div class="col-lg-6 col-md-6 col-xs-12 mt-2">
          <a href="skm.php?tempat=<?= $tempat ?>">
            <div class="services-item text-center">
              <div class="icon">
                <i class="lni-heart"></i>
              </div>
              <h4>Survei Kepuasan Masyarakat </h4>
              <p>Form Survei Kepuasan Masyarakat</p>
            </div>
          </a>
        </div>


        <!-- End Col -->

      </div>
    </div>
  </section>
  <!-- Services Section End -->













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

  <script src="vendor/js/main.js"></script>

</body>

</html>