<?php
include "env.php";

$response = [
    'status' => '',
    'message' => '',
    'body' => [
        'data' => []
    ]
];

$query = "SELECT A.kode, A.nama, A.kode_kategori, B.nama as nama_kategori, A.gambar, A.harga
          FROM menu A
          INNER JOIN kategori B ON A.kode_kategori = B.kode";

$q = mysqli_query($koneksi, $query);
$dataArray = mysqli_fetch_all($q, MYSQLI_ASSOC);

if ($dataArray){
    $response['status'] = 200;
    $response['message'] = 'Success';
    $response['body']['data'] = $dataArray;
} else {
    $response['status'] = 400;
    $response['message'] = 'error';
}

echo json_encode($response);
?>
