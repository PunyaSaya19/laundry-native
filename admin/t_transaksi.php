<?php
include("../koneksi.php");
// validasi hak akses 
if(!isset($_SESSION["level"]) || $_SESSION["level"] != "admin"){
  header("location: ../index.php");
}

// logic tambah data
if(isset($_POST["tambah"])){
  // ambil data
  $id_transaksi = $_POST["id_transaksi"];
  $id_user = $_POST["id_user"];
  $id_outlet = $_POST["id_outlet"];
  $id_pelanggan = $_POST["id_pelanggan"];
  $nama_paket = $_POST["nama_paket"];
  $tgl_masuk = $_POST["tgl_masuk"];
  $tgl_selesai = $_POST["tgl_selesai"];
  $berat = $_POST["berat"];
  $status_bayar = $_POST["status_bayar"];
  $status_transaksi = "proses";
  $jenis_pakaian = $_POST["jenis_pakaian"];
  $jumlah = $_POST["jumlah"];
  
  // cek apakah paket nya ada di outlet yg di pilih atau tdk
 // var_dump($id_outlet, $nama_paket); die; 
  $sqlCek = "SELECT * FROM tb_paket WHERE id_outlet = $id_outlet AND jenis = '$nama_paket' ";
  //var_dump($sqlCek); die;
  $cek = mysqli_query($koneksi, $sqlCek) or die(mysqli_error($koneksi));
  //var_dump(mysqli_num_fields($cek));
  if(mysqli_num_rows($cek) < 1){
    echo "
      <script> 
        alert('tidak ada  paket!');
        window.location = 't_transaksi.php';
      </script>
    ";
    die;
  }
  $dt_pkt = [];
  while($dtph = mysqli_fetch_assoc($cek)){
    $dt_pkt[] = $dtph;
  }
  //$dt_pkt = mysqli_fetch_assoc($cek);
  $id_paket = $dt_pkt[0]["id_paket"];
  $harga = $dt_pkt[0]["harga"];
  
  $total_bayar = $harga * $berat;
  
  // query inset data
  $queryInsert = mysqli_query($koneksi, "INSERT INTO tb_transaksi VALUES($id_transaksi, $id_user, $id_outlet, $id_pelanggan, $id_paket, '$tgl_masuk', '$tgl_selesai', $berat, $total_bayar, '$status_bayar', '$status_transaksi')") or die(mysqli_error($koneksi));
  //var_dump(mysqli_affected_rows($koneksi));
  if(mysqli_affected_rows($koneksi) < 0){
    echo "
      <script> 
        alert('gagal insert data!');
        window.location = 't_transaksi.php';
      </script>
    ";
    die;
  }
  
  // insert pakaian
  $index = 0;
  foreach($jenis_pakaian as $jns){
    $jmlh_pkn = $jumlah[$index];
    $queryPakaian = mysqli_query($koneksi, "INSERT INTO tb_pakaian VALUES(NULL, $id_transaksi, '$jns', $jmlh_pkn)");
    $index++;
  }
    echo "
      <script> 
        alert('berhasil insert data!. total biaya anda adlh Rp. " . $total_bayar  . "');
        window.location = 'transaksi.php';
      </script>
    ";
  
}


// get id transaksi
$gIdTrx = mysqli_query($koneksi, "SELECT * FROM tb_transaksi ORDER BY id_transaksi DESC");
$gIdTrx = mysqli_fetch_assoc($gIdTrx)["id_transaksi"];
$gIdTrx = ($gIdTrx != null) ? $gIdTrx + 1 : 1;





// ambil data pelanggan
$query2 = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan");
$data_pelanggan = [];
while($r = mysqli_fetch_assoc($query2)){
  $data_pelanggan[] = $r;
}


// ambil data outlet
$query3 = mysqli_query($koneksi, "SELECT * FROM tb_outlet");
$data_outlet = [];
while($r = mysqli_fetch_assoc($query3)){
  $data_outlet[] = $r;
}

// ambil data user 
$query4 = mysqli_query($koneksi, "SELECT * FROM tb_user");
$data_user = [];
while($r = mysqli_fetch_assoc($query4)){
  $data_user[] = $r;
}



?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Blank</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pelanggan.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>pelanggan</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="outlet.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>outlet</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="paket.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>paket</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pengguna.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>pengguna</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="transaksi.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>transaksi</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="laporan.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>laporan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            
            
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">tambah transaksi</h1>
                    </div>
                    
                    <div class="row">
                      <div class="col-12">
                        <form action="" method="post">
                          <input type="hidden" name="id_transaksi" value="<?= $gIdTrx; ?>">
                          <div class="form-group">
                            <label>nama pelanggan</label>
                            <select name="id_pelanggan" id="" class="form-control">
                              <?php foreach($data_pelanggan as $dp ) : ?>
                               <option value="<?= $dp['id_pelanggan']; ?>">
                                 <?= $dp["nama_pelanggan"]; ?>
                               </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>nama outlet</label>
                            <select name="id_outlet" id="" class="form-control">
                              <?php foreach($data_outlet as $do ) : ?>
                               <option value="<?= $do['id_outlet']; ?>">
                                 <?= $do["nama_outlet"]; ?>
                               </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>nama paket</label>
                            <select name="nama_paket" id="" class="form-control">
                              <option value="reguler">
                                Reguler
                              </option>
                              <option value="kilat">
                                Kilat
                              </option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>nama user</label>
                            <select name="id_user" id="" class="form-control">
                              <?php foreach($data_user as $du ) : ?>
                               <option value="<?= $du['id_user']; ?>">
                                 <?= $du["nama_user"]; ?>
                               </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          
                          <div class="form-group">
                            <label>tgl masuk</label>
                            <input type="date" class="form-control" name="tgl_masuk">
                          </div>
                          <div class="form-group">
                            <label>tgl selesai</label>
                            <input type="date" class="form-control" name="tgl_selesai">
                          </div>
                          <div class="form-group">
                            <label>berat pakaian</label>
                            <input type="text" class="form-control" name="berat">
                          </div>
                          <div class="form-group">
                            <label>status bayar</label>
                            <select name="status_bayar" id="" class="form-control">
                              <option value="belum">
                                belum
                              </option>
                              <option value="lunas">
                                lunas
                              </option>
                            </select>
                          </div>
                          
                          <hr>
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>jenis pakaian</th>
                                <th>jumlah</th>
                                <th>
                                  <button type="button" id="btnTambah" class="btn btn-info">
                                    tambah
                                  </button>
                                </th>
                              </tr>
                            </thead>
                            
                            <tbody id="bodyTable">
                              <tr>
                                <td>
                                  <input type="text" class="form-control" name="jenis_pakaian[]" required placeholder=" Jenis ">
                                </td>
                                <td>
                                  <input type="number" class="form-control" name="jumlah[]" required placeholder=" Jumlah ">
                                </td>
                                <td class="text-center">
                                  <button class="btn-danger btn btn-hapus-list" type="button">
                                    Hapus
                                  </button>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                         <button type="submit" name="tambah" class="btn btn-primary">
                           tambah
                         </button>
                          
                        </form>
                      </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/js/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.js"></script>
    
    <script>

const btnTambah = document.getElementById("btnTambah");
const bodyTable = document.getElementById("bodyTable");

btnTambah.addEventListener("click", function(e) {

  const inputJenis = document.createElement('input');
  inputJenis.className = "form-control abc";
  inputJenis.name = "jenis_pakaian[]";
  inputJenis.setAttribute("required", "");
  inputJenis.setAttribute("placeholder", " Jenis ");

  const td1 = document.createElement("td");
  td1.appendChild(inputJenis);

  const inputHarga = document.createElement('input');
  inputHarga.className = "form-control abc";
  inputHarga.name = "jumlah[]";
  inputHarga.type = "number";
  inputHarga.setAttribute("required", "");
  inputHarga.setAttribute("placeholder", " Jumlah ");

  const td2 = document.createElement("td");
  td2.appendChild(inputHarga);
  

  const btnHapus = document.createElement("button");
  btnHapus.className = "btn btn-danger btn-hapus-list";
  btnHapus.textContent = "hapus";

  const td3 = document.createElement("td");
  td3.className = "text-center";
  td3.appendChild(btnHapus);

  const tr = document.createElement("tr")

  tr.appendChild(td1);
  tr.appendChild(td2);
  tr.appendChild(td3);

  bodyTable.appendChild(tr);

})

bodyTable.addEventListener("click", function(e) {
  if (e.target.classList.contains("btn-hapus-list")) {
    const elements = e.target.parentElement.parentElement;
    elements.remove();
  }
})
    </script>
    
    
</body>

</html>