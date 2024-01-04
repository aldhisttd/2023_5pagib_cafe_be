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

$query = mysqli_query($koneksi, "SELECT * FROM menu WHERE kode='$kode'");

if ($query) {
    $menuData = mysqli_fetch_assoc($query);

    if ($menuData) {
        $response = [
            'status' => 200,
            'msg' => 'success',
            'body' => [
                'data' => [
                    'kode' => $menuData['kode'],  
                    'nama' => $menuData['nama'],  
                    'kode_kategori' => $menuData['kode_kategori'],
                    'nama_kategori' => $menuData['nama_kategori'],  
                    'gambar' => $menuData['gambar'],  
                    'harga' => $menuData['harga']  
                ]
            ]
        ]; 
    } else {
        $response['status'] = 400;
        $response['msg'] = 'Error';
    }
}

echo json_encode($response);
?>
