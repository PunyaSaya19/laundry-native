<?php
include("koneksi.php");

// cek apakah tombol login tlh di klik atau blm
if(isset($_POST["login"])){
  
  // ambil data dari form inputan
  $username = $_POST["username"];
  $password = md5($_POST["password"]);
  
  // query ke tbl user untuk cek apakah user nya ada atau tdk
  $result = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username = '$username' AND password = '$password' ") or die(mysqli_error($koneksi));
  
  // ambil data user 
  $data_user = mysqli_fetch_assoc($result);
  
  // cek apakah datanya ada atau tdk
  if($data_user != null){
    // jika ada set session datanya
    // set session data
    $_SESSION["id_user"] = $data_user["id_user"];
    $_SESSION["nama_user"] = $data_user["nama_user"];
    $_SESSION["level"] = $data_user["level"];
    
    // cek user nama yg sedang login
    if($_SESSION["level"] == "admin"){
      // jika admin redirect ke dashboard admin
      header("location: admin/index.php");
      exit();
    }elseif ($_SESSION["level"] == "kasir") {
      // jika admin redirect ke dashboard admin
      header("location: kasir/index.php");
      exit();
    }else{
      header("location: owner/index.php");
      exit();
    }
    die;
  }
  echo "
    <script> alert('gagal login') </script>
  ";
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

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="assets/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form action="" method="post" class="user">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Username..." name="username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="password">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" type="submit" name="login">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/js/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>