<?php
$conn = mysqli_connect('localhost', 'root', '', 'cafe');

$res = [
  "status" => "",
  "msg" => "",
  "body" => [
    "data" => [
      [
        'kode' => "",
        'nama' => "",
        'kode_kategori' =>"",
        'gambar' => "",
        'harga' => "",
      ]
    ]
  ]
];

$q = mysqli_query($conn, "SELECT * FROM menu");

// Inisialisasi array untuk menyimpan data
$dataArray = array();

// Mengambil semua baris yang sesuai dari hasil queri
while ($row = mysqli_fetch_array($q)) {
  // Menambahkan data dari setiap baris ke dalam array
  $data = array(

    'kode' => $row['kode'],
    'nama' => $row['nama'],
    'kode_kategori' => $row['kode_kategori'],
    'gambar' => $row['gambar'],
    'harga' => $row['harga'],

  );

  // Menambahkan data ke dalam array utama
  $dataArray[] = $data;
}

// Memeriksa apakah ada data yang ditemukan
if (!empty($dataArray)) {
  $res['status'] = 200;
  $res['msg'] = "success";
  $res['body']['data'] = $dataArray;
} else {
  $res['status'] = 400;
  $res['msg'] = "error";
}

echo json_encode($res);