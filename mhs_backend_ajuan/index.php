<?php
require_once "../database/config.php";
$hal = 'ajuan_presensi';
if (isset($_SESSION['peran'])) {
  if ($_SESSION['peran'] != 'mhs') {
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
            <br>
            <div class="content">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header" style="background-color:#86090f">
                        <font color="ffffff">
                          <h3 class="card-title"> <i class="nav-icon fas fa-clipboard"></i>Form Ajuan Presensi</h3>
                        </font>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <form action="simpan.php" method="POST" enctype="multipart/form-data">
                          <div class="card-body">

                            <div class="form-group">
                              <label for="tanggal_kuliah">Tanggal Kuliah <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="tanggal_kuliah" name="tanggal_kuliah" required>
                            </div>

                            <div class="form-group">
                              <label for="pilih_kelas">Kelas - Mata Kuliah <span class="text-danger">*</span></label>
                              <?php
                              $data_kelas = mysqli_query($con, "SELECT * FROM tbl_klsmatkul");
                              $kelas_options = '';
                              while ($row = mysqli_fetch_assoc($data_kelas)) {
                                $id_matkul = $row['kode_matkul'];
                                $data_matkul = mysqli_query($con, "SELECT * FROM tbl_matkul WHERE kode_matkul='$id_matkul'");
                                $matkul_row = mysqli_fetch_assoc($data_matkul);
                                $nidn = $row['nid'];
                                $data_dosen = mysqli_query($con, "SELECT * FROM tbl_dosen WHERE nid='$nidn'");
                                $dosen_row = mysqli_fetch_assoc($data_dosen);
                                $kelas_options .= '<option value="' . $row['Id'] . '" data-matkul="' . $matkul_row['nama_ind'] . '" data-dosen="' . $dosen_row['nama'] . '">' . $row['kelas'] . ' | ' . $matkul_row['nama_ind'] . '</option>';
                              }

                              ?>
                              <select class="form-control" id="pilih_kelas" name="id_kelas" required>
                                <option value="" selected disabled>-- Pilih Kelas Mata Kuliah --</option>
                                <?php echo $kelas_options; ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="nama_matkul">Mata Kuliah</label>
                              <input type="text" class="form-control" id="nama_matkul" placeholder="Otomatis terisi..." readonly style="background-color: #e9ecef;">
                            </div>

                            <div class="form-group">
                              <label for="nama_dosen">Dosen Pengampu</label>
                              <input type="text" class="form-control" id="nama_dosen" placeholder="Otomatis terisi..." readonly style="background-color: #e9ecef;">
                            </div>

                            <div class="form-group">
                              <label for="keterangan">Keterangan / Alasan <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Jelaskan alasan pengajuan perubahan presensi (sakit/izin/kendala teknis)..." required></textarea>
                            </div>

                            <div class="form-group">
                              <label for="bukti">Bukti Pendukung <span class="text-danger">*</span></label>
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="bukti" name="bukti" accept="image/*,.pdf" required>
                                <label class="custom-file-label" for="bukti">Pilih file (Foto/PDF)...</label>
                              </div>
                              <small class="form-text text-muted">Unggah surat dokter, tangkapan layar (screenshot) kendala sistem, atau bukti lainnya. Format: JPG, PNG, atau PDF.</small>
                            </div>

                          </div>
                          <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim Ajuan</button>
                            <button type="reset" class="btn btn-secondary">Batal</button>
                          </div>
                        </form>
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
    <!-- ./wrapper -->
    <?php
    include "../script.php";
    ?>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const selectKelas = document.getElementById('pilih_kelas');
        const inputMatkul = document.getElementById('nama_matkul');
        const inputDosen = document.getElementById('nama_dosen');

        selectKelas.addEventListener('change', function() {
          const selectedOption = this.options[this.selectedIndex];
          const matkul = selectedOption.getAttribute('data-matkul') || '';
          const dosen = selectedOption.getAttribute('data-dosen') || '';
          inputMatkul.value = matkul;
          inputDosen.value = dosen;
        });

        const fileInput = document.getElementById('bukti');
        fileInput.addEventListener('change', function(e) {
          let fileName = e.target.files[0].name;
          let nextSibling = e.target.nextElementSibling;
          nextSibling.innerText = fileName;
        });
      });
    </script>
</body>

</html>