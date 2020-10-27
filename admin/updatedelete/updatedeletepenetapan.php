<?php 

  include "../includes/config.php";

  $query = mysqli_query($connection, "SELECT * FROM penetapan");
  $query2 = mysqli_query($connection, "SELECT * FROM pencatatan");
  $query3 = mysqli_query($connection, "SELECT * FROM kondisikaryabudaya");

  if(isset($_POST['Simpan'])) {
    $nopenetapan = $_POST["editnopenetapan"];
    $nosk = $_POST["editnosk"];
    $tglpenetapan = $_POST["edittgl"];
    $nopencatatan = $_REQUEST["editnopencatatan"];
    $kdkondisi = $_REQUEST["editkdkondisi"]; 

    $fotopenetapan = $_FILES['gambar']['name']; 
    $file_tmp = $_FILES["gambar"]["tmp_name"];
    
    $foto = mysqli_query($connection, "SELECT file_penetapan FROM penetapan WHERE no_penetapan = '$nopenetapan'");
    $fotof = mysqli_fetch_array($foto);
    $fotorow = $fotof['file_penetapan'];

    if (!empty($fotopenetapan)) {
      move_uploaded_file($file_tmp, '../../foto/' . $fotopenetapan);
      mysqli_query($connection, "UPDATE penetapan SET no_sk = '$nosk', file_penetapan = '$fotopenetapan', tgl_penetapan = '$tglpenetapan', no_pencatatan = '$nopencatatan', kd_kondisi = '$kdkondisi' WHERE no_penetapan = '$nopenetapan'");
      if (!mysqli_query($connection,"UPDATE penetapan SET no_sk = '$nosk', file_penetapan = '$fotopenetapan', tgl_penetapan = '$tglpenetapan', no_pencatatan = '$nopencatatan', kd_kondisi = '$kdkondisi' WHERE no_penetapan = '$nopenetapan'"))
        {
         echo("Error description: " . mysqli_error($connection));
        }else {
          header("location:../penetapan.php");
        }
    }
    else {
      mysqli_query($connection, "UPDATE penetapan SET no_sk = '$nosk', file_penetapan = '$fotorow', tgl_penetapan = '$tglpenetapan', no_pencatatan = '$nopencatatan', kd_kondisi = '$kdkondisi' WHERE no_penetapan = '$nopenetapan'");
      if (!mysqli_query($connection,"UPDATE penetapan SET no_sk = '$nosk', file_penetapan = '$fotopenetapan', tgl_penetapan = '$tglpenetapan', no_pencatatan = '$nopencatatan', kd_kondisi = '$kdkondisi' WHERE no_penetapan = '$nopenetapan'"))
        {
         echo("Error description: " . mysqli_error($connection));
        }else {
          header("location:../penetapan.php");
        }
      
    }
  } 
  else if (isset($_GET["nopenetapanhapus"])) {
    $nopenetapan = $_GET["nopenetapanhapus"];
    mysqli_query($connection, "DELETE FROM penetapan WHERE no_penetapan = '$nopenetapan'");
    header("location:../penetapan.php");
  }

  $penetapan = $_GET["nopenetapan"];
  $edit = mysqli_query($connection, "SELECT * FROM penetapan WHERE no_penetapan = '$penetapan'");
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
            <h1 class="m-0 text-dark">Penetapan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Penetapan</li>
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
                <h3 class="card-title">Forms Penetapan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="nosk">No. Surat Keputusan</label>
                    <input type="text" class="form-control" id="nosk" name="editnosk" value="<?php echo $row_edit['no_sk'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="tglpenetapan">Tanggal Penetapan</label>
                    <input type="date" class="form-control" id="tglpenetapan" name="edittgl" value="<?php echo $row_edit['tgl_penetapan'] ?>">
                  </div>

            Nama File: <?php echo $row_edit["file_penetapan"] ?><br>
            File Penetapan: <input type="file" name="gambar"><br>
              <img src="../../foto/<?php echo $row_edit['file_penetapan'] ?>" style="width: 90px; height: 90px;"><br>

                  

                  <label for="editpencatatan">Pencatatan</label>
                  <select name="editnopencatatan" class="form-control" id="editpencatatan">
                <option value="<?php echo $row_edit['no_pencatatan'] ?>"><?php echo $row_edit['no_pencatatan'] ?></option>
                <?php if (mysqli_num_rows($query2) > 0) {?>
                <?php while($row = mysqli_fetch_array($query2)) {?>
                  <option value="<?php echo $row["no_pencatatan"]?>">
                  <?php echo $row["no_pencatatan"];?>
                  </option>
                <?php }?>
                <?php }?>
              </select>

              <label for="editkondisi">Kondisi</label>
                  <select name="editkdkondisi" class="form-control" id="editkondisi">
                <option value="<?php echo $row_edit['kd_kondisi'] ?>"><?php echo $row_edit['kd_kondisi'] ?></option>
                <?php if (mysqli_num_rows($query3) > 0) {?>
                <?php while($row = mysqli_fetch_array($query3)) {?>
                  <option value="<?php echo $row["kd_kondisi"]?>">
                  <?php echo $row["kondisikaryabudaya"];?>
                  </option>
                <?php }?>
                <?php }?>
              </select>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name= "Simpan" class="btn btn-primary">Submit</button>
                  <input type="hidden" name="editnopenetapan" value="<?php echo $row_edit["no_penetapan"]?>">
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
