<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => []
    ]
];
if (isset($_POST['kode'])) {
    $kode = $_POST['kode'];
    if (!empty($kode)) {
        $selectQuery = mysqli_query($koneksi, "SELECT * FROM menu WHERE kode='$kode'");
        $deletedData = mysqli_fetch_assoc($selectQuery);
        $query = mysqli_query($koneksi, "DELETE FROM kategori WHERE kode='$kode'");

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
}

echo json_encode($response);
?>
