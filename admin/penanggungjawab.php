<?php 

  include "includes/config.php";

    ob_start();
  session_start();
  if(!isset($_SESSION['admin_id'])) {
    header("location:login.php");
  }

  $query = mysqli_query($connection, "SELECT p.kd_pngjwb, p.pngjwb, p.alamat, p.telepon, p.usia, p.email, p.riwayat_hidup, k.kecamatan, p.foto_pngjwb
FROM penanggungjawabbudaya p JOIN kecamatan k ON (k.kd_kecamatan = p.kd_kecamatan)");
  $query2 = mysqli_query($connection, "SELECT * FROM kecamatan");

  if(isset($_POST['Simpan'])) {
    $kodepenanggungjawab = $_REQUEST["inputankode"];
    $namapenanggungjawab = $_REQUEST["inputanpenanggungjawab"];
    $alamat = $_REQUEST["inputanalamat"];
    $usia = $_REQUEST["inputanusia"];
    $telepon = $_REQUEST["inputantelepon"];
    $email = $_REQUEST["inputanemail"];
    $riwayathidup = $_REQUEST["inputanriwayathidup"];
    $kdkecamatan = $_REQUEST["inputankecamatan"];

    $fotopenanggungjawab = $_FILES['file']['name']; 
    $file_tmp = $_FILES["file"]["tmp_name"];
    move_uploaded_file($file_tmp, '../foto/'.$fotopenanggungjawab);
    

    mysqli_query($connection, "INSERT INTO penanggungjawabbudaya VALUES ('$kodepenanggungjawab', '$namapenanggungjawab', '$alamat', '$telepon', '$usia', '$email', '$riwayathidup', '$kdkecamatan', '$fotopenanggungjawab')");


    header("location:penanggungjawab.php");
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
            <h1 class="m-0 text-dark">Penanggungjawab</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Penanggungjawab</li>
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
                <h3 class="card-title">Forms Penanggungjawab</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group">
                    <label for="kdpenanggungjawab">Kode Penanggungjawab</label>
                    <input type="text" class="form-control" id="kdpenanggungjawab" name="inputankode" placeholder="Masukkan Kode penanggungjawab">
                  </div>

                  <div class="form-group">
                    <label for="namapenanggungjawab">Nama Penanggungjawab</label>
                    <input type="text" class="form-control" id="namapenanggungjawab" name="inputanpenanggungjawab" placeholder="Masukkan penanggungjawab">
                  </div>

                  <div class="form-group">
                    <label for="alamatpenanggungjawab">Alamat Penanggungjawab</label>
                    <input type="text" class="form-control" id="alamatpenanggungjawab" name="inputanalamat" placeholder="Masukkan Alamat penanggungjawab">
                  </div>

                  <div class="form-group">
                    <label for="usiapenanggungjawab">Usia Penanggungjawab</label>
                    <input type="text" class="form-control" id="usiapenanggungjawab" name="inputanusia" placeholder="Masukkan Usia penanggungjawab">
                  </div>

                  <div class="form-group">
                    <label for="teleponpenanggungjawab">Telepon Penanggungjawab</label>
                    <input type="text" class="form-control" id="teleponpenanggungjawab" name="inputantelepon" placeholder="Masukkan Telepon penanggungjawab">
                  </div>

                  <div class="form-group">
                    <label for="emailpenanggungjawab">Email Penanggungjawab</label>
                    <input type="text" class="form-control" id="emailpenanggungjawab" name="inputanemail" placeholder="Masukkan Email penanggungjawab">
                  </div>

                  <div class="form-group">
                    <label for="riwayathidup">Riwayat Penanggungjawab</label>
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
                    <label for="exampleInputFile">Gambar penanggungjawab</label>
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
                <h3 class="card-title">Data penanggungjawab</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Kode penanggungjawab</th>
                    <th>Nama penanggungjawab</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Usia</th>
                    <th>Email</th>
                    <th>Riwayat Hidup</th>
                    <th>Kode Kecamatan</th>
                    <th>Foto penanggungjawab</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody>
                 <?php if(mysqli_num_rows($query) > 0) { ?>
                          <?php while($row = mysqli_fetch_array($query)) { ?>
                  <tr>
                    <td><?php echo $row['kd_pngjwb'] ?></td>

                    <td><?php echo $row['pngjwb'] ?></td>
                    <td><?php echo $row['alamat'] ?></td>
                    <td><?php echo $row['telepon'] ?></td>
                    <td><?php echo $row['usia'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['riwayat_hidup'] ?></td>
                    <td><?php echo $row['kecamatan'] ?></td>

                    <td>
                                <?php if($row['foto_pngjwb']=="") { 
                                echo "<img src='img/noimage.png' width='90' />";
                                } 
                                else {?>
                                <img src="../foto/<?php echo $row['foto_pngjwb'] ?>" width="100" class="img-responsive" />
                              <?php } ?>
                    </td>
                    <td>
                    <a href="updatedelete/updatedeletepenanggungjawab.php?kdpenanggungjawabhapus=<?php echo $row['kd_pngjwb'] ?>" onclick="return confirm ('Apakah Anda Yakin?')"><i class="fas fa-trash"></i></a> | 
                    <a href="updatedelete/updatedeletepenanggungjawab.php?kdpenanggungjawab=<?php echo $row['kd_pngjwb'] ?>"><i class="fas fa-edit"></i></a>
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