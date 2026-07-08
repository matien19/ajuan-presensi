<?php
// 1. Logika pemrosesan diletakkan PALING ATAS sebelum ada HTML/spasi/enter
require_once "../database/config.php";
require "../assets_adminlte/dist/phpexcel-xls-library/vendor/phpoffice/phpexcel/Classes/PHPExcel.php";

// Tips: Aktifkan error reporting sementara jika masih ada masalah
// error_reporting(E_ALL); 
error_reporting(0);

if (isset($_POST['impor'])) {
  $file = $_FILES['file']['name'];
  $ekstensi = explode(".", $file);

  $file_name = "file" . round(microtime(true)) . "." . end($ekstensi);
  $sumber = $_FILES['file']['tmp_name'];
  $target_dir = "template/";
  $target_file = $target_dir . $file_name;

  if (move_uploaded_file($sumber, $target_file)) {
    $file_excel = PHPExcel_IOFactory::load($target_file);
    $data_excel = $file_excel->getActiveSheet()->toArray(null, true, true, true);

    for ($j = 2; $j <= count($data_excel); $j++) {
      $kd_matkul  = $data_excel[$j]['B'];
      $nama_ind   = addslashes($data_excel[$j]['C']);
      $nama_eng   = addslashes($data_excel[$j]['D']);
      $sks        = $data_excel[$j]['E'];

      // Cek apakah data kosong agar tidak memasukkan baris kosong dari Excel
      if (!empty($kd_matkul)) {
        $query_pengguna = mysqli_query($con, "SELECT kode_matkul FROM tbl_matkul WHERE kode_matkul='$kd_matkul'");

        if (mysqli_num_rows($query_pengguna) == 0) {
          mysqli_query($con, "INSERT INTO tbl_matkul VALUES (NULL,'$kd_matkul','$nama_ind','$nama_eng',$sks)");
        }
      }
    }

    // Hapus file setelah selesai
    if (file_exists($target_file)) {
      unlink($target_file);
    }
  }

  // 2. REDIRECT LANGSUNG DARI PHP
  header("Location: ../admin_backend_matkul");
  exit(); // PENTING: Gunakan exit() setelah header location
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Proses Impor</title>
</head>

<body>
  <div class="wrapper" style="zoom: 90% !important;">
  </div>
</body>

</html>