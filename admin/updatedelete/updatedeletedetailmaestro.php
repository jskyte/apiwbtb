<?php 

  include "../includes/config.php";

  $query = mysqli_query($connection, "SELECT * FROM karyabudaya");
  $query2 = mysqli_query($connection, "SELECT * FROM maestro");
  $query3 = mysqli_query($connection, "SELECT * FROM kecamatan");

  if(isset($_POST['Simpan'])) {
    $kdkaryabudayaedit = $_POST['editkdkaryabudaya'];
    $kdmaestroedit = $_POST['editkdmaestro'];
    $kdkecamatanedit = $_POST["editkdkecamatan"];
    $pendapat = $_POST["editpendapat"];

    $karyabudaya = $_GET["kdkaryabudaya"];
    $kecamatan = $_GET["kdkecamatan"];
    $maestro = $_GET["kdmaestro"];

      mysqli_query($connection, "UPDATE detil_maestro SET kd_karyabudaya = '$kdkaryabudayaedit', kd_maestro = '$kdmaestroedit', kd_kecamatan = '$kdkecamatanedit', pendapat = '$pendapat' WHERE kd_karyabudaya = '$karyabudaya' AND kd_kecamatan = '$kecamatan' AND kd_maestro = '$maestro'");

    header("location:../detailmaestro.php");
  } 
  else if (isset($_GET["kdkaryabudayahapus"])) {
    $kdkaryabudaya = $_GET["kdkaryabudayahapus"];
    $kdkecamatan = $_GET["kdkecamatanhapus"];
    $kdmaestro = $_GET["kdmaestrohapus"];
    mysqli_query($connection, "DELETE FROM detil_maestro WHERE kd_karyabudaya = '$kdkaryabudaya' AND kd_kecamatan = '$kdkecamatan' AND kd_maestro = '$kdmaestro'");
    header("location:../detailmaestro.php");
  }

  $karyabudaya = $_GET["kdkaryabudaya"];
  $kecamatan = $_GET["kdkecamatan"];
  $maestro = $_GET["kdmaestro"];
  $edit = mysqli_query($connection, "SELECT * FROM detil_maestro WHERE kd_karyabudaya = '$karyabudaya' AND kd_kecamatan = '$kecamatan' AND kd_maestro = '$maestro'");
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
            <h1 class="m-0 text-dark">Detail Maestro</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Detail Maestro</li>
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
                <h3 class="card-title">Forms Detail Maestro</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <label for="editkaryabudaya">Karya Budaya</label>
                  <select name="editkdkaryabudaya" class="form-control" id="editkaryabudaya">
                <option value="<?php echo $row_edit['kd_karyabudaya'] ?>"><?php echo $row_edit['kd_karyabudaya'] ?></option>
                <?php if (mysqli_num_rows($query) > 0) {?>
                <?php while($row = mysqli_fetch_array($query)) {?>
                  <option value="<?php echo $row["kd_karyabudaya"]?>">
                  <?php echo $row["karya_budaya"];?>
                  </option>
                <?php }?>
                <?php }?>
              </select>

              <label for="editmaestro">Maestro</label>
                  <select name="editkdmaestro" class="form-control" id="editmaestro">
                <option value="<?php echo $row_edit['kd_maestro'] ?>"><?php echo $row_edit['kd_maestro'] ?></option>
                <?php if (mysqli_num_rows($query2) > 0) {?>
                <?php while($row = mysqli_fetch_array($query2)) {?>
                  <option value="<?php echo $row["kd_maestro"]?>">
                  <?php echo $row["maestro"];?>
                  </option>
                <?php }?>
                <?php }?>
              </select>

                <label for="editdkecamatan">Kecamatan</label>
                  <select name="editkdkecamatan" class="form-control" id="editdkecamatan">
                <option value="<?php echo $row_edit['kd_kecamatan'] ?>"><?php echo $row_edit['kd_kecamatan'] ?></option>
                <?php if (mysqli_num_rows($query3) > 0) {?>
                <?php while($row = mysqli_fetch_array($query3)) {?>
                  <option value="<?php echo $row["kd_kecamatan"]?>">
                  <?php echo $row["kecamatan"];?>
                  </option>
                <?php }?>
                <?php }?>
              </select>

              <div class="form-group">
                    <label for="pendapat">Pendapat</label>
                    <input type="text" class="form-control" id="pendapat" name="editpendapat" value="<?php echo $row_edit['pendapat'] ?>">
                  </div>
              
                
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name= "Simpan" class="btn btn-primary">Submit</button>
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
