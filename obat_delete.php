<?php
include "env.php";

$response = [
    'status' => 200,
    'message' => 'Berhasil terhubung ke database',
    'body' => [
        'data' => []
    ]
];

// Cek apakah ada data POST yang dikirim
if (isset($_POST['kode'])) {
    // Ambil kode dari data POST
    $kode = $_POST['kode'];

    // Coba terhubung ke database
    $koneksi = mysqli_connect('localhost', 'root', '', 'cafe');

    if ($koneksi) {
        // Lakukan query untuk menghapus data
        $query = "DELETE FROM kategori WHERE kode = '$kode'";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            $response['status'] = 200;
            $response['message'] = 'Data berhasil dihapus';
        } else {
            $response['status'] = 400;
            $response['message'] = 'Gagal menghapus data';
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
