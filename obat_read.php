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

    // Inisialisasi array untuk menyimpan data
    $dataArray = array();

    // Mengambil semua baris yang sesuai dari hasil query
    while ($row = mysqli_fetch_assoc($q)) {
        // Menambahkan data dari setiap baris ke dalam array
        $dataArray[] = [
            'kode' => $row['kode'],
            'nama' => $row['nama'],
            'kode_kategori' => $row['kode_kategori'],
            'gambar' => $row['gambar'],
            'harga' => $row['harga'],
        ];
    }

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
