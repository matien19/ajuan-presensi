<?php
require_once "../database/config.php";
?>
<!DOCTYPE html>
<html>

<head>
</head>

<body>
  <div class="wrapper" style="zoom:90%" !important>
    <?php

    if (isset($_GET['id']) && isset($_GET['aksi'])) {
      $id = mysqli_real_escape_string($con, $_GET['id']);
      $aksi = $_GET['aksi'];

      // Tentukan status berdasarkan aksi
      if ($aksi == 'acc') {
        $status = 'Disetujui';
      } elseif ($aksi == 'tolak') {
        $status = 'Ditolak';
      } else {
        echo "<script>alert('Aksi tidak valid!'); window.location='index.php';</script>";
        exit;
      }

      // Query untuk update status ajuan
      // Sesuaikan "id" dengan nama Primary Key di tabel ajuan_presensi Anda
      $query = "UPDATE ajuan_presensi SET status_ajuan='$status' WHERE id_ajuan='$id'";
      $update = mysqli_query($con, $query);

      if ($update) {
        echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
      swal("Berhasil", "Data Ajuan telah diperbarui", "success");

      setTimeout(function() {
        window.location.href = "../admin_backend_ajuan";

      }, 2000);
    </script>';
      } else {
        echo "<script>
                alert('Gagal memperbarui status ajuan. Silakan coba lagi.'); 
                window.location='index.php';
              </script>";
      }
    } else {
      // Jika diakses tanpa parameter, kembalikan ke halaman utama
      header("Location: index.php");
    }

    ?>


</body>

</html>