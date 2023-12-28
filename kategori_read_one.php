<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => [
            'kode' => '',
            'nama' => '',
            'kode_kategori' => '',
            'gambar' => '',
            'harga' => ''
        ]
    ]
];

// Cek koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'cafe');

// Query untuk mendapatkan data menu berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE kode='$kode'");

if ($query) {
    $kategoriData = mysqli_fetch_assoc($query);

    if ($kategoriData) {
        $response['status'] = 200;
        $response['msg'] = 'Data menu ditemukan';
        $response['body']['data'] = $kategoriData;
    } else {
        // Ganti dengan pesan umum
        $response['status'] = 400;
        $response['msg'] = 'Data eror';
    }
}

// Tutup koneksi database
mysqli_close($koneksi);

echo json_encode($response);
?>
