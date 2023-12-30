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

if(!isset($koneksi)){

    $response['status'] = 400;
    $response['msg'] = 'error';
}else{
    
    $result = mysqli_query($koneksi, "SELECT * FROM kategori WHERE kode = '$kode'");
    $row = mysqli_fetch_assoc($result);

    $response['status'] = 200;
    $response['msg'] = 'success';
    $response['body']['data'] = $row;
}

echo json_encode($response);