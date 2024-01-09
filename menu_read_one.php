<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => []
    ]
];

$kode = $_GET['kode'];

$query = "SELECT menu.*, kategori.nama as nama_kategori
          FROM menu
          INNER JOIN kategori ON menu.kode_kategori = kategori.kode
          WHERE menu.kode = '$kode'";

$q = mysqli_query($koneksi, $query);
$dataMenu = mysqli_fetch_assoc($q);

    if ($dataMenu) {
        $response['status'] = 200;
        $response['msg'] = 'success';
        $response['body']['data'] = $dataMenu;
    } else {
        $response['status'] = 400;
        $response['msg'] = 'error';
    }


echo json_encode($response);
?>
