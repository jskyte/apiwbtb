<?php 

  include "../includes/config.php";

  $query = mysqli_query($connection, "SELECT * FROM karyabudaya");
  $query2 = mysqli_query($connection, "SELECT * FROM dokumentasi");

  if(isset($_POST['Simpan'])) {
    $kdkaryabudaya = $_POST['editkdkaryabudaya'];
    $karyabudaya = $_POST["editkaryabudaya"];
    $deskripsi = $_POST["editdeskripsi"];
    $sejarah = $_POST["editsejarah"];
    $kddokumentasi = $_REQUEST["editkddokumentasi"];
    $fotokaryabudaya = $_FILES['gambar']['name']; 
    $file_tmp = $_FILES["gambar"]["tmp_name"];
    
    $foto = mysqli_query($connection, "SELECT foto_budaya FROM karyabudaya WHERE kd_kategorikb = '$kdkaryabudaya'");
    $fotof = mysqli_fetch_array($foto);
    $fotorow = $fotof['foto_budaya'];

    if (!empty($fotokaryabudaya)) {
      move_uploaded_file($file_tmp, '../../foto/' . $fotokaryabudaya);
      mysqli_query($connection, "UPDATE karyabudaya SET karya_budaya = '$karyabudaya', foto_budaya='$fotokaryabudaya', deskripsi_singkat='$deskripsi', sejarah_singkat = '$sejarah', kd_dokumentasi = '$kddokumentasi' WHERE kd_karyabudaya = '$kdkaryabudaya'");
    header("location:../karyabudaya.php");
    }
    else {
      mysqli_query($connection, "UPDATE karyabudaya SET karya_budaya = '$karyabudaya', foto_budaya='$fotorow', deskripsi_singkat='$deskripsi', sejarah_singkat = '$sejarah', kd_dokumentasi = '$kddokumentasi' WHERE kd_karyabudaya = '$kdkaryabudaya'");
      header("location:../karyabudaya.php");
      
    }
  } 
  else if (isset($_GET["kdkaryabudayahapus"])) {
    $kdkaryabudaya = $_GET["kdkaryabudayahapus"];
    mysqli_query($connection, "DELETE FROM karyabudaya WHERE kd_karyabudaya = '$kdkaryabudaya'");
    header("location:../karyabudaya.php");
  }

  $karyabudaya = $_GET["kdkaryabudaya"];
  $edit = mysqli_query($connection, "SELECT * FROM karyabudaya WHERE kd_karyabudaya = '$karyabudaya'");
  $row_edit = mysqli_fetch_array($edit);

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
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">
<div class="wrapper">

  <?php include "../includes/navbar.php"; ?>



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
                    <label for="namakaryabudaya">Nama Karya Budaya</label>
                    <input type="text" class="form-control" id="namakaryabudaya" name="editkaryabudaya" value="<?php echo $row_edit['karya_budaya'] ?>">
                  </div>

            Nama Foto: <?php echo $row_edit["foto_budaya"] ?><br>
            Foto Produk: <input type="file" name="gambar"><br>
              <img src="../../foto/<?php echo $row_edit['foto_budaya'] ?>" style="width: 90px; height: 90px;"><br>

                 <div class="form-group">
                    <label for="deskripsisingkat">Deskripsi Karya Budaya</label>
                    <textarea class="form-control" id="deskripsisingkat" name="editdeskripsi" cols="40" rows="5" ><?php echo $row_edit['deskripsi_singkat'] ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="sejarahsingkat">Sejarah Karya Budaya</label>
                    <textarea class="form-control" id="sejarahsingkat" name="editsejarah" cols="40" rows="5"><?php echo $row_edit['sejarah_singkat'] ?></textarea>
                  </div>

                  <label for="editdokumentasi">Dokumentasi</label>
                  <select name="editkddokumentasi" class="form-control" id="editdokumentasi">
                <option value="<?php echo $row_edit['kd_dokumentasi'] ?>"><?php echo $row_edit['kd_dokumentasi'] ?></option>
                <?php if (mysqli_num_rows($query2) > 0) {?>
                <?php while($row = mysqli_fetch_array($query2)) {?>
                  <option value="<?php echo $row["kd_dokumentasi"]?>">
                  <?php echo $row["dokumentasi"];?>
                  </option>
                <?php }?>
                <?php }?>
              </select>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name= "Simpan" class="btn btn-primary">Submit</button>
                  <input type="hidden" name="editkdkaryabudaya" value="<?php echo $row_edit["kd_karyabudaya"]?>">
                </div>
              </form>
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
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
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
