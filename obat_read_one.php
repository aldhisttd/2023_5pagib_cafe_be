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
if (!$koneksi) {
    $response['status'] = 500;
    $response['msg'] = 'Gagal terhubung ke database';
} else {
    // Perbaikan pada bagian ini
    $kode = isset($_GET['kode']) ? mysqli_real_escape_string($koneksi, $_GET['kode']) : '';

    // Memastikan data yang diinput tidak kosong
    if (empty($kode)) {
        $response['status'] = 400;
        $response['msg'] = 'ID menu tidak valid';
    } else {
        // Query untuk mendapatkan data menu berdasarkan ID
        $query = mysqli_query($koneksi, "SELECT * FROM menu WHERE kode='$kode'");

        if ($query) {
            $menuData = mysqli_fetch_assoc($query);

            if ($menuData) {
                $response['status'] = 200;
                $response['msg'] = 'Data menu ditemukan';
                $response['body']['data'] = $menuData;
            } else {
                $response['status'] = 404;
                $response['msg'] = 'Data menu tidak ditemukan';
            }
        } else {
            $response['status'] = 400;
            $response['msg'] = 'Gagal mendapatkan data menu';
        }
    }

    // Tutup koneksi database
    mysqli_close($koneksi);
}

echo json_encode($response);
?>
