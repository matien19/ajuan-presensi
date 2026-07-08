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
    if (isset($_POST['tambahdata'])) {

      $kd_jurusan = trim(mysqli_real_escape_string($con, $_POST['kd_jurusan']));
      $nama       = trim(mysqli_real_escape_string($con, $_POST['nama']));
      $querycek   =  mysqli_query($con, "SELECT * FROM tbl_jurusan WHERE kode_jurusan ='$kd_jurusan'") or die(mysqli_error($con));

      if (mysqli_num_rows($querycek) > 0) {
        echo '
           <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script>
              swal("Peringatan", "Kode jurusan sudah Ada", "warning");
              
              setTimeout(function(){ 
              window.location.href = "../admin_backend_jurusan";

              }, 2000);
            </script>
           ';
      } else {
        mysqli_query($con, "INSERT INTO tbl_jurusan VALUES ('$kd_jurusan','$nama')") or die(mysqli_error($con));
        echo '
           <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script>
              swal("Berhasil", "Data jurusan telah ditambahkan", "success");
              
              setTimeout(function(){ 
              window.location.href = "../admin_backend_jurusan";

              }, 1000);
            </script>
           ';
      }
    }

    ?>

</body>
</html>