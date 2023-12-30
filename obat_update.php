<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => []
    ]
];

// Periksa apakah kunci 'kode', 'nama', 'kode_kategori', dan 'harga' ada dalam $_POST
if (isset($_POST['kode'], $_POST['nama'], $_POST['kode_kategori'], $_POST['harga'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $kode_kategori = $_POST['kode_kategori'];
    $harga = $_POST['harga'];

    if (isset($_FILES['gambar']) && $_FILES['gambar']['name'] != "") {
        // ambil nama gambar lama
        $q = mysqli_query($koneksi, "SELECT gambar FROM menu WHERE kode='$kode'");
        $dt = mysqli_fetch_array($q);
        $gambar = isset($dt['gambar']) ? $dt['gambar'] : '';

        unlink('upload/'.$gambar);

        $path = $_FILES['gambar']['name'];
        $ext = "." . pathinfo($path, PATHINFO_EXTENSION);
        $namagambar = md5(time()) . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'upload/' . $namagambar);

        // update nama gambar ke gambar baru
        mysqli_query($koneksi, "UPDATE menu SET gambar='$namagambar' WHERE kode='$kode'");
    }

    // update dengan kondisi
    $query = mysqli_query($koneksi, "UPDATE menu SET nama='$nama', kode_kategori='$kode_kategori', harga='$harga' WHERE kode='$kode'");

    if ($query) {
        $response['status'] = 200;
        $response['msg'] = 'Data berhasil diperbarui';
        $response['body']['data']['kode'] = $kode;
        $response['body']['data']['nama'] = $nama;
        $response['body']['data']['kode_kategori'] = $kode_kategori;
        $response['body']['data']['gambar'] = isset($namagambar) ? $namagambar : '';
        $response['body']['data']['harga'] = $harga;
    } else {
        $response['status'] = 400;
        $response['msg'] = 'Data Gagal Diperbarui';
    }
}

echo json_encode($response);
?>
