<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => []
    ]
];

$kode = $_POST['kode'];
$nama = $_POST['nama'];
$kode_kategori = $_POST['kode_kategori'];
$harga = $_POST['harga'];

if ($_FILES["gambar"]["name"] != "") {
    // ambil nama gambar lama
    $query = mysqli_query($koneksi, "SELECT gambar FROM menu WHERE kode = '$kode'");
    $data = mysqli_fetch_assoc($query);
    $gambar = $data['gambar'];

    unlink($gambar);

    $temp = explode(".", $_FILES["gambar"]["name"]);
    $gambarbaru = md5(date('dmy h:i:s')) . '.' . end($temp);
    $target_file = "upload/" . $gambarbaru;
    move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);

    mysqli_query($koneksi, "UPDATE menu SET gambar = 'upload/$gambarbaru' WHERE kode = '$kode'");
}

$query = mysqli_query($koneksi, "UPDATE menu SET nama='$nama', kode_kategori='$kode_kategori', harga='$harga' WHERE kode='$kode'");

if ($query) {
    $response['status'] = 200;
    $response['msg'] = 'Data berhasil diperbarui';
    $response['body']['data']['kode'] = $kode;
    $response['body']['data']['nama'] = $nama;
    $response['body']['data']['kode_kategori'] = $kode_kategori;
    $response['body']['data']['gambar'] = 'upload/' . $gambarbaru;
    $response['body']['data']['harga'] = $harga;
} else {
    $response['status'] = 400;
    $response['msg'] = 'Data Gagal Diperbarui';
}

echo json_encode($response);
?>
