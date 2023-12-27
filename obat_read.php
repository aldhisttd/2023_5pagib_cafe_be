<?php
include "env.php";

$response = [
    'status' => '',
    'message' => '',
    'body' => [
        'data' => []
    ]
];

// Coba terhubung ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'cafe');

if ($koneksi) {
    // Lakukan query untuk mendapatkan data
    $q = mysqli_query($koneksi, "SELECT * FROM menu");

    // Mengambil semua baris hasil query sebagai array
    $dataArray = mysqli_fetch_all($q, MYSQLI_ASSOC);

    // Memeriksa apakah ada data yang ditemukan
    if (!empty($dataArray)) {
        $response['status'] = 200;
        $response['message'] = 'Success';
        $response['body']['data'] = $dataArray;
    } else {
        $response['status'] = 400;
        $response['message'] = 'Data tidak ditemukan';
    }

    // Tutup koneksi database
    mysqli_close($koneksi);
} else {
    $response['status'] = 500;
    $response['message'] = 'Gagal terhubung ke database';
}

// Set header untuk JSON
header('Content-Type: application/json');

// Mengirimkan respons JSON ke client
echo json_encode($response);
?>
