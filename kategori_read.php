<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => []
    ]
];

if (!isset($koneksi)) {

    $response['status'] = 400;
    $response['msg'] = 'error';
} else {

    $result = mysqli_query($koneksi, "SELECT * FROM kategori");
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response['status'] = 200;
    $response['msg'] = 'success';
    $response['body']['data'] = $row;
}

echo json_encode($response);
?>