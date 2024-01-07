<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => []
    ]
];

$kode = $_REQUEST['kode'];

$gambar = mysqli_query($koneksi, "SELECT gambar FROM menu WHERE kode='$kode'");

if ($row = mysqli_fetch_assoc($gambar)) {
    $gambar = $row['gambar'];

    // Menghapus file gambar dari sistem file
    $gambar = 'upload/' . $gambar;
    unlink($gambar);

    // Menghapus data dari database
    $query = mysqli_query($koneksi, "DELETE FROM menu WHERE kode='$kode'");

    if ($query) {
        $response['status'] = 200;
        $response['msg'] = 'Data berhasil dihapus';
        $response['body']['data']['kode'] = $kode;
    } else {
        $response['status'] = 400;
        $response['msg'] = 'Data gagal dihapus';
        $response['body']['data']['kode'] = $kode;
    }
}

echo json_encode($response);
?>
