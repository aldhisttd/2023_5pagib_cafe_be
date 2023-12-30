<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => []
    ]
];

// Periksa apakah data diterima dengan benar
$kode = isset($_POST['kode']) ? mysqli_real_escape_string($koneksi, $_POST['kode']) : '';
$nama = isset($_POST['nama']) ? mysqli_real_escape_string($koneksi, $_POST['nama']) : '';
$kode_kategori = isset($_POST['kode_kategori']) ? mysqli_real_escape_string($koneksi, $_POST['kode_kategori']) : '';
$harga = isset($_POST['harga']) ? mysqli_real_escape_string($koneksi, $_POST['harga']) : '';


    // Proses upload gambar
    if (isset($_FILES['gambar'])) {
        $uploadDir = 'upload/';
        $uploadFile = $uploadDir . basename($_FILES['gambar']['name']);
        $gambar = $_FILES['gambar']['name'];

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadFile)) {
            // Jika upload gambar berhasil, lanjutkan proses penyimpanan data ke database
            $query = mysqli_query($koneksi, "INSERT INTO menu (kode, nama, kode_kategori, gambar, harga) 
                                              VALUES ('$kode', '$nama', '$kode_kategori', '$gambar', '$harga')");

            if ($query) {
                $response['status'] = 200;
                $response['msg'] = 'Data berhasil diinsert';
                $response['body']['data']['kode'] = $kode;
                $response['body']['data']['nama'] = $nama;
                $response['body']['data']['kode_kategori'] = $kode_kategori;
                $response['body']['data']['gambar'] = $gambar;
                $response['body']['data']['harga'] = $harga;
            } else {
                $response['status'] = 400;
                $response['msg'] = 'Gagal membuat menu: ' . mysqli_error($koneksi);
            }
        }
    }


echo json_encode($response);
?>
