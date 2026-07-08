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

    if (isset($_POST['editdata'])) {

      $kd_jurusan = trim(mysqli_real_escape_string($con, $_POST['kd_jurusan']));
      $nama       = trim(mysqli_real_escape_string($con, $_POST['nama']));


      mysqli_query($con, "UPDATE tbl_jurusan SET nama='$nama' WHERE kode_jurusan='$kd_jurusan'") or die(mysqli_error($con));
    }

    ?>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
      swal("Berhasil", "Data Jurusan telah diedit", "success");

      setTimeout(function() {
        window.location.href = "../admin_backend_jurusan";

      }, 2000);
    </script>
</body>

</html>