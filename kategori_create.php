<?php
include 'env.php';

$response = [
    'status' => 200,
    'msg' => 'Data berhasil diinsert',
    'body' => [
        'data' => [
            'kode' => '',
            'nama' => '',
        ]
    ]
];

$response = [
    'status' => 400,
    'msg' => 'Gagal membuat Kategori',
    'body' => [
        'data' => [
            'kode' => '',
            'nama' => '',
        ]
    ]
];
$kode = $_POST['kode'];
$nama = $_POST['nama'];

$query = mysqli_query($koneksi, "INSERT INTO kategori (kode, nama) VALUES ('$kode', '$nama')");

if ($query) {
    $response['status'] = 200;
    $response['msg'] = 'Data berhasil diinsert';
    $response['body']['data']['kode'] = $kode;
    $response['body']['data']['nama'] = $nama;
} else {
    $response['status'] = 400;
    $response['msg'] = 'Gagal membuat kategori';
}

echo json_encode($response);
?>
