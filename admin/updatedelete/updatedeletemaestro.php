<?php 

  include "../includes/config.php";

  $query = mysqli_query($connection, "SELECT * FROM maestro");
  $query2 = mysqli_query($connection, "SELECT * FROM kecamatan");

  if(isset($_POST['Simpan'])) {
    $kdmaestro = $_POST['editkdmaestro'];
    $maestro = $_POST["editmaestro"];
    $alamat = $_POST["editalamat"];
    $usia = $_POST["editusia"];
    $telepon = $_POST["edittelepon"];
    $email = $_POST["editemail"];
    $riwayathidup = $_POST["editriwayathidup"];
    $kdkecamatan = $_REQUEST["editkecamatan"];
    $fotomaestro = $_FILES['gambar']['name']; 
    $file_tmp = $_FILES["gambar"]["tmp_name"];
    
    $foto = mysqli_query($connection, "SELECT foto_maestro FROM maestro WHERE kd_maestro = '$kdmaestro'");
    $fotof = mysqli_fetch_array($foto);
    $fotorow = $fotof['foto_maestro'];

    if (!empty($fotomaestro)) {
      move_uploaded_file($file_tmp, '../../foto/' . $fotomaestro);
      mysqli_query($connection, "UPDATE maestro SET maestro = '$maestro', alamat = '$alamat', usia='$usia', telepon = '$telepon', email = '$email', riwayat_hidup = '$riwayathidup', kd_kecamatan = '$kdkecamatan', foto_maestro = '$fotomaestro' WHERE kd_maestro = '$kdmaestro'");
    header("location:../maestro.php");
    }
    else {
      mysqli_query($connection, "UPDATE maestro SET maestro = '$maestro', alamat = '$alamat', usia='$usia', telepon = '$telepon', email = '$email', riwayat_hidup = '$riwayathidup', kd_kecamatan = '$kdkecamatan', foto_maestro = '$fotorow' WHERE kd_maestro = '$kdmaestro'");
      header("location:../maestro.php");
      
    }
  } 
  else if (isset($_GET["kdmaestrohapus"])) {
    $kdmaestro = $_GET["kdmaestrohapus"];
    mysqli_query($connection, "DELETE FROM maestro WHERE kd_maestro = '$kdmaestro'");
    header("location:../maestro.php");
  }

  $maestro = $_GET["kdmaestro"];
  $edit = mysqli_query($connection, "SELECT * FROM maestro WHERE kd_maestro = '$maestro'");
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
            <h1 class="m-0 text-dark">Maestro</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Maestro</li>
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
                <h3 class="card-title">Forms Maestro</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="namamaestro">Nama Maestro</label>
                    <input type="text" class="form-control" id="namamaestro" name="editmaestro" value="<?php echo $row_edit['maestro'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="alamatmaestro">Alamat Maestro</label>
                    <input type="text" class="form-control" id="alamatmaestro" name="editalamat" value="<?php echo $row_edit['alamat'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="usiamaestro">Usia Maestro</label>
                    <input type="text" class="form-control" id="usiamaestro" name="editusia" value="<?php echo $row_edit['usia'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="teleponmaestro">Telepon Maestro</label>
                    <input type="text" class="form-control" id="teleponmaestro" name="edittelepon" value="<?php echo $row_edit['telepon'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="emailmaestro">Email Maestro</label>
                    <input type="text" class="form-control" id="emailmaestro" name="editemail" value="<?php echo $row_edit['email'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="riwayathidup">Riwayat Hidup Maestro</label>
                    <textarea class="form-control" id="riwayathidup" name="editriwayathidup" cols="40" rows="5" ><?php echo $row_edit['riwayat_hidup'] ?></textarea>
                  </div>

                  <label for="editkecamatan">Kecamatan</label>
                  <select name="editkecamatan" class="form-control" id="editkecamatan">
                <option value="<?php echo $row_edit['kd_kecamatan'] ?>"><?php echo $row_edit['kd_kecamatan'] ?></option>
                <?php if (mysqli_num_rows($query2) > 0) {?>
                <?php while($row = mysqli_fetch_array($query2)) {?>
                  <option value="<?php echo $row["kd_kecamatan"]?>">
                  <?php echo $row["kecamatan"];?>
                  </option>
                <?php }?>
                <?php }?>
              </select>



            Nama Foto: <?php echo $row_edit["foto_maestro"] ?><br>
            Foto Produk: <input type="file" name="gambar"><br>
              <img src="../../foto/<?php echo $row_edit['foto_maestro'] ?>" style="width: 90px; height: 90px;"><br>


                  

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name= "Simpan" class="btn btn-primary">Submit</button>
                  <input type="hidden" name="editkdmaestro" value="<?php echo $row_edit["kd_maestro"]?>">
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
