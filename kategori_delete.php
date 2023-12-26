<?php
include 'env.php';

$response = [
    'status' => '200',
    'msg' => 'Data berhasil dihapus'
];

$koneksi = mysqli_connect('localhost', 'root', '', 'cafe');

if ($koneksi) {
    $kode = isset($_POST['kode']) ? mysqli_real_escape_string($koneksi, $_POST['kode']) : '';

    if (!empty($kode)) {
        $query = mysqli_query($koneksi, "DELETE FROM kategori WHERE kode='$kode'");

        if ($query) {
            $response['status'] = 200;
            $response['msg'] = 'Data berhasil dihapus';
        } else {
            $response['status'] = 400;
            $response['msg'] = 'Gagal menghapus data';
        }
    }

    mysqli_close($koneksi);
} else {
    $response['status'] = 500;
    $response['msg'] = 'Gagal terhubung ke database';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
