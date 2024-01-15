<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => []
    ]
];

$kode = $_GET['kode_kategori'];

$query = "SELECT menu.kode, menu.nama, menu.kode_kategori, kategori.nama as nama_kategori, menu.gambar, menu.harga
            FROM menu 
            INNER JOIN kategori ON menu.kode_kategori = kategori.kode
            WHERE menu.kode_kategori = '$kode'";

$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($data) {

    $response['status'] = 200;
    $response['msg'] = 'success';
    $response['body']['data'] = $data;
} else {

    $response['status'] = 400;
    $response['msg'] = 'error';
}

echo json_encode($response);
