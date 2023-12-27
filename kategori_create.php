<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => [
            'kode' => '',
            'nama' => '',
        ]
    ]
];

// Cek koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'cafe');
if (!$koneksi) {
    $response['status'] = 500;
    $response['msg'] = 'Gagal terhubung ke database';
} else {
    // Perbaikan pada bagian ini
    $kode = mysqli_real_escape_string($koneksi, $_POST['kode'] ?? '');
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');

    // Menambahkan data kategori baru ke dalam database
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

    // Tutup koneksi database
    mysqli_close($koneksi);
}

echo json_encode($response);
?>
