<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => [
            'kode' => '',
            'nama' => ''
        ]
    ]
];

if (!isset($koneksi)) {

    $response['status'] = 400;
    $response['msg'] = 'data gagal diperbarui';
} else {

    $kode = $_POST['kode'];
    $nama = $_POST['nama'];

    $response['status'] = 200;
    $response['msg'] = 'data berhasil diperbarui';
    $response['body']['data']['kode'] = $kode;
    $response['body']['data']['nama'] = $nama;

    mysqli_query($koneksi, "UPDATE kategori SET nama = '$nama' WHERE kode = '$kode'");
}

echo json_encode($response);