<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => []
    ]
];

if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];

    $query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE kode = '$kode'");

    if ($query) {
        $kategoriData = mysqli_fetch_assoc($query);

        if ($kategoriData) {
            $response['status'] = 200;
            $response['msg'] = 'Data menu ditemukan';
            $response['body']['data'] = $kategoriData;
        } else {
            $response['status'] = 400;
            $response['msg'] = 'error';
        }
    }
}

echo json_encode($response);
?>
