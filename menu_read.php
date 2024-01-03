<?php
include "env.php";

$response = [
    'status' => '',
    'message' => '',
    'body' => [
        'data' => []
    ]
];

$q = mysqli_query($koneksi, "SELECT * FROM menu");

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
