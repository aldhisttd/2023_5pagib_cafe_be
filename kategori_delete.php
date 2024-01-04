<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => []
    ]
];

$kode = $_POST['kode'];

$query = mysqli_query($koneksi, "DELETE FROM kategori WHERE kode='$kode'");

    if ($query) {
        $response['status'] = 200;
        $response['msg'] = 'Data berhasil dihapus';
        $response['body']['data']['kode'] = $kode;
    } else {
        $response['status'] = 400;
        $response['msg'] = 'Data gagal dihapus';
        $response['body']['data']['kode'] = $kode;
    }
echo json_encode($response);
?>