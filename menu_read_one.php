<?php
include 'env.php';

$response = [
    'status' => 0,
    'message' => '',
    'data' => [
        'kode' => '',
        'nama' => '',
        'kode_kategori' => '',
        'harga' => '',
        'gambar' => ''
    ]
];

if (!$koneksi) {
    $response['status'] = 500;
    $response['message'] = 'Gagal terhubung ke database';
} else {
    $kode = isset($_GET['kode']) ? $_GET['kode'] : null;

    if ($kode === null || empty($kode)) {
        $response['status'] = 400;
        $response['message'] = 'Kode Menu tidak valid';
    } else {
        // Gunakan parameterized query
        $query = mysqli_prepare($koneksi, "SELECT * FROM menu WHERE kode = ?");
        mysqli_stmt_bind_param($query, 's', $kode);
        mysqli_stmt_execute($query);

        $result = mysqli_stmt_get_result($query);

        if ($result) {
            $menuData = mysqli_fetch_assoc($result);

            if ($menuData) {
                $response['status'] = 200;
                $response['message'] = 'Data ditemukan';
                $response['data'] = $menuData;
            } else {
                $response['status'] = 404;
                $response['message'] = 'Data tidak ditemukan';
            }
        } else {
            $response['status'] = 500;
            $response['message'] = 'Gagal mengambil data dari database';
        }
    }
}

// Set header untuk JSON
header('Content-Type: application/json');

echo json_encode($response);
?>
