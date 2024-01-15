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

// Proses upload gambar
if (isset($_FILES['gambar'])) {
    
    $gambar = $_FILES['gambar']['name'];
    $temp = explode(".", $_FILES["gambar"]["name"]);
    $gambar = 'upload/'.md5(date('dmy h:i:s')) . '.' . end($temp);
    $target_file = $gambar;
    
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        // Jika upload gambar berhasil, lanjutkan proses penyimpanan data ke database
        $query = mysqli_query($koneksi, "INSERT INTO menu (kode, nama, kode_kategori, gambar, harga) 
                                          VALUES ('$kode', '$nama', '$kode_kategori', '$gambar', '$harga')");

        if ($query) {
            $response['status'] = 200;
            $response['msg'] = 'Data berhasil diinsert';
            $response['body']['data']['kode'] = $kode;
            $response['body']['data']['nama'] = $nama;
            $response['body']['data']['kode_kategori'] = $kode_kategori;
            $response['body']['data']['gambar'] = $gambar;
            $response['body']['data']['harga'] = $harga;
        } else {
            $response['status'] = 400;
            $response['msg'] = 'Proses insert gagal: ' . mysqli_error($koneksi);
        }
    }
}

echo json_encode($response);
?>