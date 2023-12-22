<?php 
$conn = mysqli_connect('localhost', 'root', '', 'cafe');

$res = [
  "status" => "",
  "msg" => "",
  "body" => "",
];

$kode = $_GET['kode'];

$d = mysqli_query($conn, "SELECT gambar FROM menu WHERE kode='$kode'");
$ary = mysqli_fetch_array($d);
$gambar = $ary ['gambar'];

unlink("gambar/".$gambar);

$q = mysqli_query($conn, "DELETE FROM menu WHERE kode='$kode'");

if ($q){
  $res['status'] = 200;
  $res['msg'] = "Data berhasil dihapus";
  $res['body'] = "";
} else {
  $res['status'] = 404;
  $res['msg'] = "Data tidak ditemukan";
  $res['body'] = "";
}

echo json_encode($res);

?>