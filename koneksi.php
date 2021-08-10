<?php
$db_name = "z_laundry";

$koneksi = mysqli_connect("localhost", "root", "", $db_name);

if (mysqli_connect_error()) {
  echo("koneksi gagal : " . mysqli_connect_error()); die;
}

session_start();