<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => []
    ]
];

$kode = isset($_GET['kode']) ? mysqli_real_escape_string($koneksi, $_GET['kode']) : '';

if (!empty($kode)) {
    $query = mysqli_query($koneksi, "SELECT * FROM menu WHERE kode='$kode'");

    if ($query) {
        $menuData = mysqli_fetch_assoc($query);

        if ($menuData) {
            $response['status'] = 200;
            $response['msg'] = 'Success';
            $response['body']['data'] = $menuData;
        } else {
            $response['status'] = 400;
            $response['msg'] = 'Error';
        }
    }
}

echo json_encode($response);
?>
