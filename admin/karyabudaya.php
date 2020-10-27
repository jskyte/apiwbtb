<?php 

  include "includes/config.php";

    ob_start();
  session_start();
  if(!isset($_SESSION['admin_id'])) {
    header("location:login.php");
  }

  $query = mysqli_query($connection, "SELECT k.kd_karyabudaya, k.karya_budaya, k.foto_budaya, k.deskripsi_singkat, k.sejarah_singkat, d.dokumentasi
FROM karyabudaya k JOIN dokumentasi d ON (k.kd_dokumentasi = d.kd_dokumentasi)");
  $query2 = mysqli_query($connection, "SELECT * FROM dokumentasi");

  if(isset($_POST['Simpan'])) {
    $kodeKaryaBudaya = $_REQUEST["inputankode"];
    $namaKaryaBudaya = $_REQUEST["inputanKaryaBudaya"];
    $fotoKaryaBudaya = $_FILES['file']['name']; 
    $file_tmp = $_FILES["file"]["tmp_name"];
    move_uploaded_file($file_tmp, '../foto/'.$fotoKaryaBudaya);
    $deskripsisingkat = $_REQUEST["inputandeskripsi"];
    $sejarahsingkat = $_REQUEST["inputansejarah"];
    $kddokumentasi = $_REQUEST["inputandokumentasi"];

    mysqli_query($connection, "INSERT INTO karyabudaya VALUES ('$kodeKaryaBudaya', '$namaKaryaBudaya', '$fotoKaryaBudaya', '$deskripsisingkat', '$sejarahsingkat', '$kddokumentasi')");


    header("location:karyabudaya.php");
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
            <h1 class="m-0 text-dark">Karya Budaya</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Karya Budaya</li>
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
                <h3 class="card-title">Forms Karya Budaya</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="kdKaryaBudaya">Kode Karya Budaya</label>
                    <input type="text" class="form-control" id="kdKaryaBudaya" name="inputankode" placeholder="Masukkan Kode Karya Budaya">
                  </div>

                  <div class="form-group">
                    <label for="namaKaryaBudaya">Nama Karya Budaya</label>
                    <input type="text" class="form-control" id="namaKaryaBudaya" name="inputanKaryaBudaya" placeholder="Masukkan Karya Budaya">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputFile">Gambar Karya Budaya</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="file">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="deskripsisingkat">Deskripsi Karya Budaya</label>
                    <textarea class="form-control" id="deskripsisingkat" name="inputandeskripsi" cols="40" rows="5"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="sejarahsingkat">Sejarah Karya Budaya</label>
                    <textarea class="form-control" id="sejarahsingkat" name="inputansejarah" cols="40" rows="5"></textarea>
                  </div>

                  <div class="form-group">
              <label for="inputdokumentasi">Dokumentasi</label>
              <select name="inputandokumentasi" class="form-control" id="inputdokumentasi">
                <option value="NULL">Pilih Dokumentasi</option>
                <?php if (mysqli_num_rows($query2) > 0) {?>
                <?php while($row = mysqli_fetch_array($query2)) {?>
                  <option value="<?php echo $row["kd_dokumentasi"]?>">
                  <?php echo $row["dokumentasi"];?>
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
                <h3 class="card-title">Data Karya Budaya</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Kode Karya Budaya</th>
                    <th>Nama Karya Budaya</th>
                    <th>Gambar</th>
                    <th>Deskripsi</th>
                    <th>Sejarah</th>
                    <th>Kode Dokumentasi</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody>
                 <?php if(mysqli_num_rows($query) > 0) { ?>
                          <?php while($row = mysqli_fetch_array($query)) { ?>
                  <tr>
                    <td><?php echo $row['kd_karyabudaya'] ?></td>

                    <td><?php echo $row['karya_budaya'] ?></td>

                    <td>
                                <?php if($row['foto_budaya']=="") { 
                                echo "<img src='img/noimage.png' width='90' />";
                                } 
                                else {?>
                                <img src="../foto/<?php echo $row['foto_budaya'] ?>" width="100" class="img-responsive" />
                              <?php } ?>
                    </td>
                    
                    <td align="justify"><?php echo $row['deskripsi_singkat'] ?></td>
                    <td align="justify"><?php echo $row['sejarah_singkat'] ?></td>
                    <td><?php echo $row['dokumentasi'] ?></td>  
                    <td>
                    <a href="updatedelete/updatedeletekaryabudaya.php?kdkaryabudayahapus=<?php echo $row['kd_karyabudaya'] ?>" onclick="return confirm ('Apakah Anda Yakin?')"><i class="fas fa-trash"></i></a> | 
                    <a href="updatedelete/updatedeletekaryabudaya.php?kdkaryabudaya=<?php echo $row['kd_karyabudaya'] ?>"><i class="fas fa-edit"></i></a>
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