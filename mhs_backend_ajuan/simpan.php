<?php
// Menggunakan file koneksi sesuai referensi Anda
require_once "../database/config.php";

// Cek sesi login mahasiswa
if (!isset($_SESSION['peran']) || $_SESSION['peran'] != 'mhs') {
    echo "<script>window.location='../auth/logout.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proses Ajuan Presensi</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <div class="wrapper" style="zoom:90%" !important>
        <?php
        // Cek jika request datang dari method POST (submit form)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // 1. Ambil & bersihkan data menggunakan mysqli_real_escape_string sesuai referensi
            $id_mahasiswa   = trim(mysqli_real_escape_string($con, $_SESSION['user']));
            $tanggal_kuliah = trim(mysqli_real_escape_string($con, $_POST['tanggal_kuliah']));
            $id_kelas       = trim(mysqli_real_escape_string($con, $_POST['id_kelas']));
            $keterangan     = trim(mysqli_real_escape_string($con, $_POST['keterangan']));

            // 2. Proses upload file bukti
            $file_name = $_FILES['bukti']['name'];
            $file_size = $_FILES['bukti']['size'];
            $file_tmp  = $_FILES['bukti']['tmp_name'];
            $file_err  = $_FILES['bukti']['error'];

            // Cek jika ada error upload
            if ($file_err !== 0) {
                echo '
                <script>
                    swal("Gagal", "Terjadi kesalahan saat mengunggah file. Silakan coba lagi.", "error");
                    setTimeout(function(){ window.history.back(); }, 2000);
                </script>';
                exit();
            }

            // Validasi ekstensi
            $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'pdf'];
            $x                  = explode('.', $file_name);
            $ekstensi           = strtolower(end($x));

            if (!in_array($ekstensi, $ekstensi_diizinkan)) {
                echo '
                <script>
                    swal("Peringatan", "Format file tidak valid! Harap unggah file JPG, PNG, atau PDF.", "warning");
                    setTimeout(function(){ window.history.back(); }, 2000);
                </script>';
                exit();
            }

            // Validasi ukuran maksimal 2 MB (2097152 bytes)
            if ($file_size > 2097152) {
                echo '
                <script>
                    swal("Peringatan", "Ukuran file terlalu besar! Maksimal ukuran file adalah 2 MB.", "warning");
                    setTimeout(function(){ window.history.back(); }, 2000);
                </script>';
                exit();
            }

            // Penamaan file unik & persiapkan folder
            $nama_file_baru = "bukti_" . $id_mahasiswa . "_" . time() . "." . $ekstensi;
            $folder_tujuan  = "bukti_presensi/";

            if (!is_dir($folder_tujuan)) {
                mkdir($folder_tujuan, 0777, true);
            }

            $path_simpan = $folder_tujuan . $nama_file_baru;

            // 3. Pindahkan file dan eksekusi query MySQL
            if (move_uploaded_file($file_tmp, $path_simpan)) {

                // Query disesuaikan tepat dengan kolom tabel ajuan_presensi
                $query = "INSERT INTO ajuan_presensi (id_mahasiswa, id_kelas, tanggal_kuliah, keterangan, file_bukti, status_ajuan) 
                          VALUES ('$id_mahasiswa', '$id_kelas', '$tanggal_kuliah', '$keterangan', '$nama_file_baru', 'Menunggu')";

                if (mysqli_query($con, $query)) {
                    // Notifikasi sukses menggunakan SweetAlert
                    echo '
                    <script>
                        swal("Berhasil", "Ajuan presensi Anda telah dikirim dan menunggu persetujuan.", "success");
                        setTimeout(function(){ 
                            window.location.href = "../mhs_backend_ajuan"; // Sesuaikan dengan folder/halaman tujuan return
                        }, 1500);
                    </script>';
                } else {
                    // Jika query gagal, hapus file yang sempat ter-upload
                    if (file_exists($path_simpan)) {
                        unlink($path_simpan);
                    }
                    echo '
                    <script>
                        swal("Gagal", "Gagal menyimpan ke database: ' . mysqli_error($con) . '", "error");
                        setTimeout(function(){ window.history.back(); }, 2000);
                    </script>';
                }
            } else {
                echo '
                <script>
                    swal("Gagal", "Gagal memindahkan file yang diunggah ke server.", "error");
                    setTimeout(function(){ window.history.back(); }, 2000);
                </script>';
            }
        }
        ?>
    </div>
</body>

</html>