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

$query = mysqli_query($koneksi, "SELECT gambar FROM menu WHERE kode='$kode'");
$data = mysqli_fetch_assoc($query);
$gambar = $data['gambar'];

$data = mysqli_query($koneksi, "DELETE FROM menu WHERE kode = '$kode'");

if ($data) {

    unlink($gambar);

    $response['status'] = 200;
    $response['msg'] = 'Data berhasil dihapus';
    $response['body']['data']['kode'] = $kode;
} else {

    $response['status'] = 400;
    $response['msg'] = 'Data gagal dihapus';
    $response['body']['data']['kode'] = $kode;
}

echo json_encode($response);
