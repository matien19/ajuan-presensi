<?php
require_once '../database/config.php';
$hal = 'ajuan';
if (isset($_SESSION['peran'])) {
  if ($_SESSION['peran'] != 'Admin') {
    echo "<script>window.location='../auth/logout.php';</script>";
  }
} else {
  echo "<script>window.location='../auth/logout.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel | Ajuan </title>

  <?php
  include "../linksheet.php";
  ?>
</head>

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
          include '../sidebar_admin.php';
          ?>

          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <br>
            <div class="content">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header" style="background-color:#86090f">
                        <font color="ffffff">
                          <h3 class="card-title"><i class="nav-icon fas fa-file-alt"></i> Data Ajuan</h3>
                      </div>
                      </font>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-tambahdata" style="background-color:#86090f">
                          <i class="nav-icon fas fa-plus"></i> Tambah Data
                        </button> -->
                        <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-importdata">
                          <i class="nav-icon fas fa-file-excel"></i> Import Data
                        </button> -->
                        <div class="table-responsive">
                          <table class="table table-hover text-wrap table-bordered" id="example1">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Mahasiswa</th>
                                <th>Jurusan</th>
                                <th>Kelas</th>
                                <th>Tanggal Kuliah</th>
                                <th>Keterangan</th>
                                <th>Bukti</th>
                                <th>Waktu Pengajuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $no = 1;
                              $query_riwayat = mysqli_query($con, "SELECT * FROM ajuan_presensi ORDER BY created_at DESC");

                              if (mysqli_num_rows($query_riwayat) > 0) {
                                while ($row = mysqli_fetch_assoc($query_riwayat)) {
                                  $nim = $row['id_mahasiswa'];
                                  $id_kelas = $row['id_kelas'];
                                  $query_mahasiswa = mysqli_query($con, "SELECT * FROM tbl_mahasiswa WHERE nim='$nim'");
                                  $data_mahasiswa = mysqli_fetch_assoc($query_mahasiswa);
                                  $jurusan = $data_mahasiswa['kode_jurusan'];
                                  $query_jurusan = mysqli_query($con, "SELECT * FROM tbl_jurusan WHERE kode_jurusan='$jurusan'");
                                  $data_jurusan = mysqli_fetch_assoc($query_jurusan);
                                  $query_kelas = mysqli_query($con, "SELECT * FROM tbl_klsmatkul WHERE id='$id_kelas'");
                                  $data_kelas = mysqli_fetch_assoc($query_kelas);
                                  $id_mk = $data_kelas['kode_matkul'];
                                  $query_matakuliah = mysqli_query($con, "SELECT * FROM tbl_matkul WHERE kode_matkul='$id_mk'");
                                  $data_matakuliah = mysqli_fetch_assoc($query_matakuliah);
                                  $mk = $data_matakuliah['nama_ind'];
                                  $nid = $data_kelas['nid'];
                                  $query_dosen = mysqli_query($con, "SELECT * FROM tbl_dosen WHERE nid='$nid'");
                                  $data_dosen = mysqli_fetch_assoc($query_dosen);
                                  $nama_dosen = $data_dosen['nama'];
                                  // Menentukan warna badge status
                                  $badge = 'badge-secondary';
                                  if ($row['status_ajuan'] == 'Menunggu')  $badge = 'badge-warning';
                                  if ($row['status_ajuan'] == 'Disetujui') $badge = 'badge-success';
                                  if ($row['status_ajuan'] == 'Ditolak')   $badge = 'badge-danger';
                              ?>
                                  <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                      <?= $data_mahasiswa['nama']; ?> - [<?= $data_mahasiswa['nim']; ?>]
                                    </td>
                                    <td><?= $data_jurusan['nama']; ?></td>
                                    <td><?= $data_kelas['kelas']; ?> - <?= $mk; ?> (<?= $nama_dosen; ?>)</td>
                                    <td><?= date('d/m/Y', strtotime($row['tanggal_kuliah'])); ?></td>
                                    <td><?= $row['keterangan'] ?></td>
                                    <td><a href="../mhs_backend_ajuan/bukti_presensi/<?= $row['file_bukti']; ?>" target="_blank" class="btn btn-xs btn-info"><i class="fas fa-eye"></i> Lihat</a></td>
                                    <td>
                                      <?= date('d/m/Y', strtotime($row['created_at'])); ?><br>
                                      <i class="fas fa-clock"></i> [<?= date('H:i', strtotime($row['created_at'])); ?>] WIB
                                    </td>
                                    <td><span class="badge <?= $badge; ?>"><?= $row['status_ajuan']; ?></span></td>
                                    <td>
                                      <?php if ($row['status_ajuan'] == 'Menunggu') {
                                      ?>
                                        <a href="update.php?id=<?= $row['id_ajuan']; ?>&aksi=acc" class="btn btn-xs btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui ajuan ini?')">
                                          <i class="fas fa-check"></i> Acc
                                        </a>
                                        <a href="update.php?id=<?= $row['id_ajuan']; ?>&aksi=tolak" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak ajuan ini?')">
                                          <i class="fas fa-times"></i> Tolak
                                        </a>
                                      <?php
                                      } else { ?>
                                        <span class="text-muted"><i class="fas fa-lock"></i> Selesai</span>
                                      <?php
                                      } ?>
                                    </td>
                                  </tr>
                                <?php
                                }
                              } else {
                                ?>
                                <tr>
                                  <td colspan="10" class="text-center text-muted py-3">Belum ada riwayat pengajuan presensi.</td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>

                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
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
    <!-- /.modal -->
  </div>

  <!-- ./wrapper -->

  <?php
  include "../script.php";
  ?>

  <script type="text/javascript">
    $('#modal-editdata').on('show.bs.modal', function(e) {

      //get data-id attribute of the clicked element
      var id = $(e.relatedTarget).data('id');
      var kd_jurusan = $(e.relatedTarget).data('kd_jurusan');
      var nama = $(e.relatedTarget).data('nama');

      $(e.currentTarget).find('input[name="id"]').val(id);
      $(e.currentTarget).find('input[name="kd_jurusan"]').val(kd_jurusan);
      $(e.currentTarget).find('input[name="nama"]').val(nama);

    });
  </script>

</body>

</html>