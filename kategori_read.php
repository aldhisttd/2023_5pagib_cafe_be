<?php
// include "../env.php";

$koneksi = mysqli_connect('localhost', 'root', '', 'mydb');

$res = [
    "status" => 200,
    "msg" => "success",
    "body" => [
        "data" => [],
    ],
];

// Check if an ID is provided
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
        $res['status'] = 401;
        $res['msg'] = "Data tidak ditemukan";
    }

    $stmt->close();
} else {
    // Fetch all categories if no ID is provided
    $q = mysqli_query($koneksi, "SELECT * FROM kategori");

    // Inisialisasi array untuk menyimpan data
    $dataArray = array();

    while ($row = mysqli_fetch_array($q)) {
        $data = array(
            'kode' => $row['kode'],
            'nama' => $row['nama'],
        );
        $dataArray[] = $data;
    }

    if (!empty($dataArray)) {
        $res['body']['data'] = $dataArray;
    } else {
        $res['status'] = 401;
        $res['msg'] = "Data tidak ditemukan";
    }
}

echo json_encode($res);
?>
