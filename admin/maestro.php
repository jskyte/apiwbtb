<?php 

  include "includes/config.php";

    ob_start();
  session_start();
  if(!isset($_SESSION['admin_id'])) {
    header("location:login.php");
  }

  $query = mysqli_query($connection, "SELECT m.kd_maestro, m.maestro, m.alamat, m.usia, m.telepon, m.email, m.riwayat_hidup, k.kecamatan, m.foto_maestro
FROM maestro m JOIN kecamatan k ON (m.kd_kecamatan = k.kd_kecamatan)");
  $query2 = mysqli_query($connection, "SELECT * FROM kecamatan");

  if(isset($_POST['Simpan'])) {
    $kodemaestro = $_REQUEST["inputankode"];
    $namamaestro = $_REQUEST["inputanmaestro"];
    $alamat = $_REQUEST["inputanalamat"];
    $usia = $_REQUEST["inputanusia"];
    $telepon = $_REQUEST["inputantelepon"];
    $email = $_REQUEST["inputanemail"];
    $riwayathidup = $_REQUEST["inputanriwayathidup"];
    $kdkecamatan = $_REQUEST["inputankecamatan"];

    $fotomaestro = $_FILES['file']['name']; 
    $file_tmp = $_FILES["file"]["tmp_name"];
    move_uploaded_file($file_tmp, '../foto/'.$fotomaestro);
    

    mysqli_query($connection, "INSERT INTO maestro VALUES ('$kodemaestro', '$namamaestro', '$alamat', '$usia', '$telepon', '$email', '$riwayathidup', '$kdkecamatan', '$fotomaestro')");


    header("location:maestro.php");
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
                    <label for="kdmaestro">Kode Maestro</label>
                    <input type="text" class="form-control" id="kdmaestro" name="inputankode" placeholder="Masukkan Kode Maestro">
                  </div>

                  <div class="form-group">
                    <label for="namamaestro">Nama Maestro</label>
                    <input type="text" class="form-control" id="namamaestro" name="inputanmaestro" placeholder="Masukkan Maestro">
                  </div>

                  <div class="form-group">
                    <label for="alamatmaestro">Alamat Maestro</label>
                    <input type="text" class="form-control" id="alamatmaestro" name="inputanalamat" placeholder="Masukkan Alamat Maestro">
                  </div>

                  <div class="form-group">
                    <label for="usiamaestro">Usia Maestro</label>
                    <input type="text" class="form-control" id="usiamaestro" name="inputanusia" placeholder="Masukkan Usia Maestro">
                  </div>

                  <div class="form-group">
                    <label for="teleponmaestro">Telepon Maestro</label>
                    <input type="text" class="form-control" id="teleponmaestro" name="inputantelepon" placeholder="Masukkan Telepon Maestro">
                  </div>

                  <div class="form-group">
                    <label for="emailmaestro">Email Maestro</label>
                    <input type="text" class="form-control" id="emailmaestro" name="inputanemail" placeholder="Masukkan Email Maestro">
                  </div>

                  <div class="form-group">
                    <label for="riwayathidup">Riwayat Maestro</label>
                    <textarea class="form-control" id="riwayathidup" name="inputanriwayathidup" cols="40" rows="5"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="inputkecamatan">Kecamatan</label>
                    <select name="inputankecamatan" class="form-control" id="inputkecamatan">
                      <option value="NULL">Pilih Kecamatan</option>
                      <?php if (mysqli_num_rows($query2) > 0) {?>
                      <?php while($row = mysqli_fetch_array($query2)) {?>
                        <option value="<?php echo $row["kd_kecamatan"]?>">
                        <?php echo $row["kecamatan"];?>
                        </option>
                      <?php }?>
                      <?php }?>
                    </select>
                    
                  </div>

                  <div class="form-group">
                    <label for="exampleInputFile">Gambar Maestro</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="file">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    
                    </div>
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
                <h3 class="card-title">Data Maestro</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Kode Maestro</th>
                    <th>Nama Maestro</th>
                    <th>Alamat</th>
                    <th>Usia</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Riwayat Hidup</th>
                    <th>Kode Kecamatan</th>
                    <th>Foto Maestro</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody>
                 <?php if(mysqli_num_rows($query) > 0) { ?>
                          <?php while($row = mysqli_fetch_array($query)) { ?>
                  <tr>
                    <td><?php echo $row['kd_maestro'] ?></td>

                    <td><?php echo $row['maestro'] ?></td>
                    <td><?php echo $row['alamat'] ?></td>
                    <td><?php echo $row['usia'] ?></td>
                    <td><?php echo $row['telepon'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['riwayat_hidup'] ?></td>
                    <td><?php echo $row['kecamatan'] ?></td>

                    <td>
                                <?php if($row['foto_maestro']=="") { 
                                echo "<img src='img/noimage.png' width='90' />";
                                } 
                                else {?>
                                <img src="../foto/<?php echo $row['foto_maestro'] ?>" width="100" class="img-responsive" />
                              <?php } ?>
                    </td>
                    <td>
                    <a href="updatedelete/updatedeletemaestro.php?kdmaestrohapus=<?php echo $row['kd_maestro'] ?>" onclick="return confirm ('Apakah Anda Yakin?')"><i class="fas fa-trash"></i></a> | 
                    <a href="updatedelete/updatedeletemaestro.php?kdmaestro=<?php echo $row['kd_maestro'] ?>"><i class="fas fa-edit"></i></a>
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