<?php
include 'env.php';

$response = [
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

$koneksi = mysqli_connect('localhost', 'root', '', 'cafe');
if ($koneksi) {
    $kode = isset($_GET['kode']) ? mysqli_real_escape_string($koneksi, $_GET['kode']) : '';

    if (!empty($kode)) {
        $query = mysqli_query($koneksi, "SELECT * FROM menu WHERE kode='$kode'");

        if ($query) {
            $menuData = mysqli_fetch_assoc($query);

            if ($menuData) {
                $response['status'] = 200;
                $response['msg'] = 'Succes';
                $response['body']['data'] = $menuData;
            } else {
                $response['status'] = 400;
                $response['msg'] = 'Error';
            }
        }
    }

    mysqli_close($koneksi);
}

echo json_encode($response);
?>
