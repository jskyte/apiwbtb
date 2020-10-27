<?php 

  include "../includes/config.php";

  $query = mysqli_query($connection, "SELECT * FROM kategoribudaya");

  if(isset($_POST['Simpan'])) {
    $kdkategoribudaya = $_POST['editkdkategoribudaya'];
    $namakategoribudaya = $_POST["editkategoribudaya"];
    $fotokategoribudaya = $_FILES['gambar']['name']; 
    $file_tmp = $_FILES["gambar"]["tmp_name"];
    
    $foto = mysqli_query($connection, "SELECT foto_katkb FROM kategoribudaya WHERE kd_kategorikb = '$kdkategoribudaya'");
    $fotof = mysqli_fetch_array($foto);
    $fotorow = $fotof['foto_katkb'];

    if (!empty($fotokategoribudaya)) {
      move_uploaded_file($file_tmp, '../../foto/' . $fotokategoribudaya);
      mysqli_query($connection, "UPDATE kategoribudaya SET kategori_budaya = '$namakategoribudaya', foto_katkb='$fotokategoribudaya' WHERE kd_kategorikb = '$kdkategoribudaya'");
    header("location:../kategori.php");
    }
    else {
      mysqli_query($connection, "UPDATE kategoribudaya SET kategori_budaya = '$namakategoribudaya', foto_katkb='$fotorow' WHERE kd_kategorikb = '$kdkategoribudaya'");
      header("location:../kategori.php");
      
    }
  } 
  else if (isset($_GET["kdkategorihapus"])) {
    $kdkategoribudaya = $_GET["kdkategorihapus"];
    mysqli_query($connection, "DELETE FROM kategoribudaya WHERE kd_kategorikb = '$kdkategoribudaya'");
    header("location:../kategori.php");
  }

  $kdkategoribudaya = $_GET["kdkategori"];
  $edit = mysqli_query($connection, "SELECT * FROM kategoribudaya WHERE kd_kategorikb = '$kdkategoribudaya'");
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
            <h1 class="m-0 text-dark">Kategori Budaya</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Kategori Budaya</li>
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
                <h3 class="card-title">Forms Kategori Budaya</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="namakategoribudaya">Nama Kategori Budaya</label>
                    <input type="text" class="form-control" id="namakategoribudaya" name="editkategoribudaya" placeholder="Masukkan Kategori Budaya" value="<?php echo $row_edit['kategori_budaya'] ?>">
                  </div>

            Nama Foto: <?php echo $row_edit["foto_katkb"] ?><br>
            Foto Produk: <input type="file" name="gambar"><br>
              <img src="../../foto/<?php echo $row_edit['foto_katkb'] ?>" style="width: 90px; height: 90px;"><br>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name= "Simpan" class="btn btn-primary">Submit</button>
                  <input type="hidden" name="editkdkategoribudaya" value="<?php echo $row_edit["kd_kategorikb"]?>">
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
