<?php
require_once "../database/config.php";
$hal = 'dasbor';
if (isset($_SESSION['peran'])) {
  if ($_SESSION['peran'] != 'mhs') {
    echo "<script>window.location='../auth/logout.php';</script>";
  }
} else {
  echo "<script>window.location='../auth/logout.php';</script>";
}

// Ambil ID Mahasiswa / NIM dari session
$id_mahasiswa = $_SESSION['user'] ?? '42421079';
$nama_mhs     = $_SESSION['nama'] ?? 'Mahasiswa';

// --- CONTOH QUERY STATISTIK (Sesuaikan dengan tabel Anda) ---
// 1. Menghitung total ajuan berstatus 'Menunggu'
$q_menunggu = mysqli_query($con, "SELECT COUNT(*) AS total FROM ajuan_presensi WHERE id_mahasiswa='$id_mahasiswa' AND status_ajuan='Menunggu'");
$d_menunggu = mysqli_fetch_assoc($q_menunggu);
$total_menunggu = $d_menunggu['total'] ?? 0;

// 2. Menghitung total ajuan berstatus 'Disetujui'
$q_setuju = mysqli_query($con, "SELECT COUNT(*) AS total FROM ajuan_presensi WHERE id_mahasiswa='$id_mahasiswa' AND status_ajuan='Disetujui'");
$d_setuju = mysqli_fetch_assoc($q_setuju);
$total_setuju = $d_setuju['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel | Dashboard </title>

  <?php
  include "../linksheet.php";
  ?>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php
    include '../navbar.php';
    ?>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <?php
          include '../sidebar_mhs.php';
          ?>
          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <div class="content">
              <div class="container-fluid">
                <br>
                <div class="alert alert-info alert-dismissible shadow-sm" style="background-color: #86090f; border-color: #6d070c; color: #fff;">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #fff;">&times;</button>
                  <h5><i class="icon fas fa-user-graduate"></i> Selamat Datang, <b><?= htmlspecialchars($nama_mhs); ?></b>!</h5>
                  Anda berada di Portal Layanan Presensi Mahasiswa. Jangan lupa untuk selalu memeriksa jadwal perkuliahan dan status ajuan izin/sakit Anda.
                </div>

                <div class="row">
                  
                  <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                      <div class="inner">
                        <h3><?= $total_menunggu ?></h3>
                        <p>Ajuan Diproses</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-clock"></i>
                      </div>
                      <!-- <a href="../mhs_backend_ajuan" class="small-box-footer" style="color: #1f2d3d !important;">Cek Status <i class="fas fa-arrow-circle-right"></i></a> -->
                    </div>
                  </div>
                  <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h3><?= $total_setuju; ?></h3>
                        <p>Ajuan Disetujui</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-check-circle"></i>
                      </div>
                      <!-- <a href="../mhs_backend_ajuan" class="small-box-footer">Riwayat Ajuan <i class="fas fa-arrow-circle-right"></i></a> -->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card card-outline" style="border-top: 3px solid #86090f;">
                      <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-history mr-1"></i> Riwayat Ajuan Presensi Terakhir</h3>
                        <!-- <div class="card-tools">
                          <a href="../mhs_backend_ajuan" class="btn btn-tool btn-sm"><i class="fas fa-external-link-alt"></i> Lihat Semua</a>
                        </div> -->
                      </div>
                      <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Tanggal Kuliah</th>
                              <th>Keterangan</th>
                              <th>Bukti</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 1;
                            $query_riwayat = mysqli_query($con, "SELECT * FROM ajuan_presensi WHERE id_mahasiswa='$id_mahasiswa' ORDER BY created_at DESC LIMIT 5");

                            if (mysqli_num_rows($query_riwayat) > 0) {
                              while ($row = mysqli_fetch_assoc($query_riwayat)) {
                                // Menentukan warna badge status
                                $badge = 'badge-secondary';
                                if ($row['status_ajuan'] == 'Menunggu')  $badge = 'badge-warning';
                                if ($row['status_ajuan'] == 'Disetujui') $badge = 'badge-success';
                                if ($row['status_ajuan'] == 'Ditolak')   $badge = 'badge-danger';
                            ?>
                                <tr>
                                  <td><?= $no++; ?></td>
                                  <td><?= date('d/m/Y', strtotime($row['tanggal_kuliah'])); ?></td>
                                  <td><?= htmlspecialchars(substr($row['keterangan'], 0, 30)) . '...'; ?></td>
                                  <td><a href="../mhs_backend_ajuan/bukti_presensi/<?= $row['file_bukti']; ?>" target="_blank" class="btn btn-xs btn-info"><i class="fas fa-eye"></i> Lihat</a></td>
                                  <td><span class="badge <?= $badge; ?>"><?= $row['status_ajuan']; ?></span></td>
                                </tr>
                              <?php
                              }
                            } else {
                              ?>
                              <tr>
                                <td colspan="5" class="text-center text-muted py-3">Belum ada riwayat pengajuan presensi.</td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.container-fluid -->
            </div>
          </div>
          <!-- /.content-wrapper -->

          <!-- Control Sidebar -->
          <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
          </aside>
          <!-- /.control-sidebar -->

          <!-- Main Footer -->
          <?php
          include "../footer.php";
          ?>
    </div>
    <!-- ./wrapper -->
    <?php
    include "../script.php";
    ?>
</body>

</html>