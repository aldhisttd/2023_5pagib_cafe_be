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
    $response['status'] = 500;
    $response['msg'] = 'Gagal terhubung ke database';
} else {
    $kode = isset($_POST['kode']) ? $_POST['kode'] : null;
    $nama = isset($_POST['nama']) ? $_POST['nama'] : null;

    // Memastikan data yang diinput tidak kosong
    if ($kode === null || $nama === null || empty($kode) || empty($nama)) {
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
            $response['body']['data']['kode'] = $kode;
            $response['body']['data']['nama'] = $nama;
        }
    }
}

echo json_encode($response);
?>
