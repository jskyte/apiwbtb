<?php 

  include "../includes/config.php";

  $query = mysqli_query($connection, "SELECT * FROM karyabudaya");
  $query2 = mysqli_query($connection, "SELECT * FROM pelestarian");

  if(isset($_POST['Simpan'])) {
    $kdkaryabudayaedit = $_POST['editkdkaryabudaya'];
    $kdpelestarianedit = $_POST["editkdpelestarian"];
    $tglpelestarian = $_POST["edittglpelestarian"];


    $pelestarian = $_GET["kdkecamatan"];
    $karyabudaya = $_GET["kdkaryabudaya"];

      mysqli_query($connection, "UPDATE detil_pelestarian SET kd_karyabudaya = '$kdkaryabudayaedit', kd_pelestarian = '$kdpelestarianedit', tgl_pelestarian = '$tglpelestarian' WHERE kd_karyabudaya = '$karyabudaya' AND kd_pelestarian = '$pelestarian'");

    header("location:../detailpelestarian.php");
  } 
  else if (isset($_GET["kdpelestarianhapus"])) {
    $kdkaryabudaya = $_GET["kdkaryabudayahapus"];
    $kdpelestarian = $_GET["kdpelestarianhapus"];
    mysqli_query($connection, "DELETE FROM detil_pelestarian WHERE kd_karyabudaya = '$kdkaryabudaya' AND kd_pelestarian = '$kdpelestarian'");
    header("location:../detaillokasikaryabudaya.php");
  }

  $karyabudaya = $_GET["kdkaryabudaya"];
  $pelestarian = $_GET["kdpelestarian"];
  $edit = mysqli_query($connection, "SELECT * FROM detil_pelestarian WHERE kd_pelestarian = '$pelestarian' AND kd_karyabudaya = '$karyabudaya'");
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
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <?php include "../includes/navbar.php"; ?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail Pelestarian Karya Budaya</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Detail Pelestarian Karya Budaya</li>
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
                <h3 class="card-title">Forms Detail Pelestarian Karya Budaya</h3>
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

                <label for="editpelestarian">Pelestarian</label>
                  <select name="editkdpelestarian" class="form-control" id="editpelestarian">
                <option value="<?php echo $row_edit['kd_pelestarian'] ?>"><?php echo $row_edit['kd_pelestarian'] ?></option>
                <?php if (mysqli_num_rows($query2) > 0) {?>
                <?php while($row = mysqli_fetch_array($query2)) {?>
                  <option value="<?php echo $row["kd_pelestarian"]?>">
                  <?php echo $row["upaya_pelestarian"];?>
                  </option>
                <?php }?>
                <?php }?>
              </select>

              <div class="form-group">
                    <label for="tglpelestarian">Tanggal Pelestarian</label>
                    <input type="date" class="form-control" id="tglpelestarian" name="edittglpelestarian" value="<?php echo $row_edit['tgl_pelestarian'] ?>">
                  </div>
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
