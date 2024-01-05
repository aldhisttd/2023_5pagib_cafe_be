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

$query = mysqli_prepare($koneksi, "SELECT * FROM menu 
                                   INNER JOIN kategori ON menu.kode_kategori = kategori.kode
                                   WHERE menu.kode_kategori = ?");

mysqli_stmt_bind_param($query, "s", $kode);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$menuData = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($menuData) {
    $response = [
        'status' => 200,
        'msg' => 'success',
        'body' => [
            'data' => $menuData
        ]
    ];
} else {
    $response['status'] = 400;
    $response['msg'] = 'Error';
}

echo json_encode($response);
?>
