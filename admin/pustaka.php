<?php 

  include "includes/config.php";

    ob_start();
  session_start();
  if(!isset($_SESSION['admin_id'])) {
    header("location:login.php");
  }

  $query = mysqli_query($connection, "SELECT * FROM pustaka");
  $query2 = mysqli_query($connection, "SELECT * FROM penerbit");

  if(isset($_POST['Simpan'])) {
    $kodePustaka = $_REQUEST["inputankode"];
    $judul = $_REQUEST["inputanjudul"];
    $tahun = $_REQUEST["inputantahun"];
    $penulis = $_REQUEST["inputanpenulis"];
    $namaklas = $_REQUEST["inputannamaklas"];
    $cetakan = $_REQUEST["inputancetakan"];
    $nomor = $_REQUEST["inputannomor"];
    $lokasi = $_REQUEST["inputanlokasi"];
    $isbn = $_REQUEST["inputanisbn"];
    $abstrak = $_REQUEST["inputanabstrak"];
    $kdpenerbit = $_REQUEST["inputankdpenerbit"];

    mysqli_query($connection, "INSERT INTO pustaka VALUES ('$kodePustaka', '$judul', '$tahun', '$penulis', '$namaklas', '$cetakan', '$nomor', '$lokasi', '$isbn', '$abstrak', '$kdpenerbit')");

    header("location:pustaka.php");
  } 

 ?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Admin WBTB</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">
<div class="wrapper">

  <?php include "includes/navbar.php"; ?>

  <?php include "includes/sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pustaka</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Pustaka</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Forms Pustaka</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="kdPustaka">Kode Pustaka</label>
                    <input type="text" class="form-control" id="kdPustaka" name="inputankode" placeholder="Masukkan Kode Pustaka">
                  </div>

                  <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" id="judul" name="inputanjudul" placeholder="Masukkan Judul Pustaka">
                  </div>

                   <div class="form-group">
                    <label for="tahun">Tahun Pustaka</label>
                    <input type="text" class="form-control" id="tahun" name="inputantahun" placeholder="Masukkan Tahun Pustaka">
                  </div>

                  <div class="form-group">
                    <label for="penulis">Penulis Pustaka</label>
                    <input type="text" class="form-control" id="penulis" name="inputanpenulis" placeholder="Masukkan Penulis Pustaka">
                  </div>

                  <div class="form-group">
                    <label for="namaklas">Klas Pustaka</label>
                    <input type="text" class="form-control" id="namaklas" name="inputannamaklas" placeholder="Masukkan Klas Pustaka">
                  </div>

                  <div class="form-group">
                    <label for="cetakan">Nama Pustaka</label>
                    <input type="text" class="form-control" id="cetakan" name="inputancetakan" placeholder="Masukkan Cetakan Pustaka">
                  </div>

                  <div class="form-group">
                    <label for="nomor">Nomor Pustaka</label>
                    <input type="text" class="form-control" id="nomor" name="inputanPustaka" placeholder="Masukkan Nomor Pustaka">
                  </div>

                  <div class="form-group">
                    <label for="lokasi">Lokasi Pustaka</label>
                    <input type="text" class="form-control" id="lokasi" name="inputanlokasi" placeholder="Masukkan Lokasi Pustaka">
                  </div>

                  <div class="form-group">
                    <label for="isbn">ISBN Pustaka</label>
                    <input type="text" class="form-control" id="isbn" name="inputanisbn" placeholder="Masukkan ISBN Pustaka">
                  </div>

                  <div class="form-group">
                    <label for="abstrak">Abstrak Pustaka</label>
                    <textarea class="form-control" id="abstrak" name="inputanabstrak" cols="40" rows="5"></textarea>
                  </div>

                  <div class="form-group">
              <label for="inputankdpenerbit">Penerbit</label>
              <select name="inputankdpenerbit" class="form-control" id="inputankdpenerbit">
                <option value="NULL">Pilih Penerbit</option>
                <?php if (mysqli_num_rows($query2) > 0) {?>
                <?php while($row = mysqli_fetch_array($query2)) {?>
                  <option value="<?php echo $row["kd_penerbit"]?>">
                  <?php echo $row["nama"];?>
                  </option>
                <?php }?>
                <?php }?>
              </select>
              
            </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name= "Simpan" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Pustaka</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Kode Pustaka</th>
                    <th>Judul</th>
                    <th>Tahun</th>
                    <th>Penulis</th>
                    <th>Klas</th>
                    <th>Cetakan</th>
                    <th>Nomor</th>
                    <th>Lokasi</th>
                    <th>ISBN</th>
                    <th>Abstrak</th>
                    <th>Kode Penerbit</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody>
                 <?php if(mysqli_num_rows($query) > 0) { ?>
                          <?php while($row = mysqli_fetch_array($query)) { ?>
                  <tr>
                    <td><?php echo $row['kd_pustaka'] ?></td>
                    <td><?php echo $row['judul'] ?></td>
                    <td><?php echo $row['tahun'] ?></td>
                    <td><?php echo $row['penulis'] ?></td>
                    <td><?php echo $row['nama_klas'] ?></td>
                    <td><?php echo $row['cetakan'] ?></td>
                    <td><?php echo $row['nomor'] ?></td>
                    <td><?php echo $row['lokasi'] ?></td>
                    <td><?php echo $row['ISBN'] ?></td>
                    <td align="justify"><?php echo $row['abstrak'] ?></td> 
                    <td><?php echo $row['kd_penerbit'] ?></td>
                    <td>
                    <a href="updatedelete/updatedeletepustaka.php?kdpustakahapus=<?php echo $row['kd_pustaka'] ?>" onclick="return confirm ('Apakah Anda Yakin?')"><i class="fas fa-trash"></i></a> | 
                    <a href="updatedelete/updatedeletepustaka.php?kdpustaka=<?php echo $row['kd_pustaka'] ?>"><i class="fas fa-edit"></i></a>
                    </td>         

                  </tr>
                    <?php } ?>
              <?php } ?>
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>


        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>

<?php
mysqli_close($connection);
ob_end_flush();
?>