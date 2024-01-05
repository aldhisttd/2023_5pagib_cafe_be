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
$query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE kode = '$kode'");
$kategoriData = mysqli_fetch_assoc($query);

    if ($kategoriData) {
            $response['status'] = 200;
            $response['msg'] = 'success';
            $response['body']['data'] = $kategoriData;
        } else {
            $response['status'] = 400;
            $response['msg'] = 'error';
        }


echo json_encode($response);
?>
