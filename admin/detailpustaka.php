<?php 

  include "includes/config.php";

    ob_start();
  session_start();
  if(!isset($_SESSION['admin_id'])) {
    header("location:login.php");
  }

  $query = mysqli_query($connection, "SELECT p.judul, p.kd_pustaka, k.kd_karyabudaya, k.karya_budaya, dp.deskripsi
FROM pustaka p JOIN detil_pustaka dp ON (p.kd_pustaka = dp.kd_pustaka)
JOIN karyabudaya k ON (k.kd_karyabudaya = dp.kd_karyabudaya)");
  $query2 = mysqli_query($connection, "SELECT * FROM pustaka");
  $query3 = mysqli_query($connection, "SELECT * FROM karyabudaya");

  if(isset($_POST['Simpan'])) {
    $kdkaryabudaya = $_REQUEST["inputankodekb"];
    $kdpustaka = $_REQUEST["inputankdpustaka"];
    $deskripsi = $_REQUEST["inputandeskripsi"];

    mysqli_query($connection, "INSERT INTO detil_pustaka VALUES ('$kdpustaka', '$kdkaryabudaya', '$deskripsi')");

    if(!mysqli_query($connection, "INSERT INTO detil_pustaka VALUES ('$kdpustaka', '$kdkaryabudaya', '$deskripsi')")) {
      echo("Error description: " . mysqli_error($connection));
    } else {
      header("location:detailpustaka.php");
    }
    
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
            <h1 class="m-0 text-dark">Detail pustaka Karya Budaya</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Detail pustaka Karya Budaya</li>
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
                <h3 class="card-title">Forms Detail pustaka Karya Budaya</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="inputpustaka">Pustaka</label>
                    <select name="inputankdpustaka" class="form-control" id="inputpustaka">
                      <option value="NULL">Pilih Pustaka</option>
                      <?php if (mysqli_num_rows($query2) > 0) {?>
                      <?php while($row = mysqli_fetch_array($query2)) {?>
                        <option value="<?php echo $row["kd_pustaka"]?>">
                        <?php echo $row["judul"];?>
                        </option>
                      <?php }?>
                      <?php }?>
                    </select>
                    
                  </div>

                  <div class="form-group">
                    <label for="inputkaryabudaya">Karya Budaya</label>
                    <select name="inputankodekb" class="form-control" id="inputkaryabudaya">
                      <option value="NULL">Pilih Karya Budaya</option>
                      <?php if (mysqli_num_rows($query3) > 0) {?>
                      <?php while($row = mysqli_fetch_array($query3)) {?>
                        <option value="<?php echo $row["kd_karyabudaya"]?>">
                        <?php echo $row["karya_budaya"];?>
                        </option>
                      <?php }?>
                      <?php }?>
                    </select>
                    
                  </div>

                  
                  <div class="form-group">
                    <label for="deskripsi">Deskripsi pustaka</label>
                    <input type="text" class="form-control" id="deskripsi" name="inputandeskripsi" placeholder="Masukkan Deskripsi pustaka">
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
                <h3 class="card-title">Data Detail pustaka Karya Budaya</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Kode Pustaka</th>
                    <th>Kode Karya Budaya</th>
                    <th>Deskripsi</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody>
                 <?php if(mysqli_num_rows($query) > 0) { ?>
                          <?php while($row = mysqli_fetch_array($query)) { ?>
                  <tr>
                    <td><?php echo $row['judul'] ?></td>
                    <td><?php echo $row['karya_budaya'] ?></td>
                    <td><?php echo $row['deskripsi'] ?></td>
                    <td>
                    <a href="updatedelete/updatedeletedetailpustaka.php?kdpustakahapus=<?php echo $row['kd_pustaka'] ?>&kdkaryabudayahapus=<?php echo $row['kd_karyabudaya'] ?>" onclick="return confirm ('Apakah Anda Yakin?')"><i class="fas fa-trash"></i></a> | 
                    <a href="updatedelete/updatedeletedetailpustaka.php?kdpustaka=<?php echo $row['kd_pustaka'] ?>&kdkaryabudaya=<?php echo $row['kd_karyabudaya'] ?>"><i class="fas fa-edit"></i></a>
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