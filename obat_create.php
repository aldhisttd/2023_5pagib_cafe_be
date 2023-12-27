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
    $kode = isset($_POST['kode']) ? mysqli_real_escape_string($koneksi, $_POST['kode']) : '';
    $nama = isset($_POST['nama']) ? mysqli_real_escape_string($koneksi, $_POST['nama']) : '';
    $kode_kategori = isset($_POST['kode_kategori']) ? mysqli_real_escape_string($koneksi, $_POST['kode_kategori']) : '';
    $harga = isset($_POST['harga']) ? mysqli_real_escape_string($koneksi, $_POST['harga']) : '';

    // Proses upload gambar
    if (isset($_FILES['gambar'])) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['gambar']['name']);
        $gambarFileName = $_FILES['gambar']['name'];

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadFile)) {
            // Jika upload gambar berhasil, lanjutkan proses penyimpanan data ke database
            $query = mysqli_query($koneksi, "INSERT INTO menu (kode, nama, kode_kategori, gambar, harga) 
                                              VALUES ('$kode', '$nama', '$kode_kategori', '$gambarFileName', '$harga')");

            if ($query) {
                $response['status'] = 200;
                $response['msg'] = 'Data berhasil diinsert';
                $response['body']['data']['kode'] = $kode;
                $response['body']['data']['nama'] = $nama;
                $response['body']['data']['kode_kategori'] = $kode_kategori;
                $response['body']['data']['gambar'] = $gambarFileName;
                $response['body']['data']['harga'] = $harga;
            } else {
                $response['status'] = 400;
                $response['msg'] = 'Gagal membuat menu: ' . mysqli_error($koneksi);
            }
        }
    }

    // Tutup koneksi database
    mysqli_close($koneksi);
}

echo json_encode($response);
?>
