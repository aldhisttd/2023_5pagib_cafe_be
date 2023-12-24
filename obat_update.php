<?php
include "env.php";

$response = [
    'status' => 200,
    'msg' => 'Berhasil melakukan pembaruan kategori'
];

// Cek apakah data POST terkirim
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dari formulir
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $kode_kategori = $_POST['kode_kategori'];
    $gambar = $_POST['gambar'];
    $harga = $_POST['harga'];

    // Coba terhubung ke database
    $koneksi = mysqli_connect('localhost', 'root', '', 'cafe'); 

    if ($koneksi) {
        // Lakukan query untuk melakukan update data
        $query = "UPDATE kategori SET nama = '$nama', kode_kategori = '$kode_kategori', gambar = '$gambar', harga = '$harga',  WHERE kode = '$kode'";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            $response['status'] = 200;
            $response['msg'] = 'Data kategori berhasil diperbarui';
        } else {
            $response['status'] = 400;
            $response['msg'] = 'Gagal memperbarui data kategori';
        }

        // Tutup koneksi database
        mysqli_close($koneksi);
    }
}

// Set header untuk JSON
header('Content-Type: application/json');

// Mengirimkan respons JSON ke client
echo json_encode($response);
?>
