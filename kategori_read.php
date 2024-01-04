<?php
include "env.php";


$res = [
    "status" => "",
    "msg" => "",
    "body" => [
        "data" => [
            [
                "kode" => "",
                "nama" => ""
            ]
        ],
    ],
];


if (isset($_GET['id'])) {
    $kode = $_GET['id'];

    $stmt = $koneksi->prepare("SELECT * FROM kategori WHERE kode = ?");
    $stmt->bind_param("i", $kode);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $res['body']['data'] = $row;
    } else {
        $res['status'] = 400;
        $res['msg'] = "error";
    }

    $stmt->close();
} else {
    
    $q = mysqli_query($koneksi, "SELECT * FROM kategori");

    $dataArray = array();

    while ($row = mysqli_fetch_array($q)) {
        $data = array(
            'kode' => $row['kode'],
            'nama' => $row['nama'],
        );
        $dataArray[] = $data;
    }
    if (!empty($dataArray)) {
        $res['status'] = 200;
        $res['msg']="success";
        $res['body']['data'] = $dataArray;
    } else {
        $res['status'] = 400;
        $res['msg'] = "error";
    }
}

echo json_encode($res);
?>
