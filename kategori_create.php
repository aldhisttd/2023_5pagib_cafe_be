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
    $kode = isset($_POST['kode']) ? mysqli_real_escape_string($koneksi, $_POST['kode']) : '';
    $nama = isset($_POST['nama']) ? mysqli_real_escape_string($koneksi, $_POST['nama']) : '';

    // Memastikan data yang diinput tidak kosong
    if (empty($kode) || empty($nama)) {
        $response['status'] = 400;
        $response['msg'] = 'Data tidak lengkap';
    } else {
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
    }

    // Tutup koneksi database
    mysqli_close($koneksi);
}

echo json_encode($response);
?>
