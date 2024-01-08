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

$result = mysqli_query($koneksi, "SELECT * FROM menu WHERE kode_kategori = '$kode'");
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
