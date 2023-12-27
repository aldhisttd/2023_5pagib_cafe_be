<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
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

// Cek koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'cafe');
if (!$koneksi) {
    $response['status'] = ''; // Sesuaikan dengan nilai yang diinginkan
    $response['msg'] = 'Gagal terhubung ke database';
} else {
    $kode = isset($_POST['kode']) ? mysqli_real_escape_string($koneksi, $_POST['kode']) : '';
    $nama = isset($_POST['nama']) ? mysqli_real_escape_string($koneksi, $_POST['nama']) : '';
    $kode_kategori = isset($_POST['kode_kategori']) ? mysqli_real_escape_string($koneksi, $_POST['kode_kategori']) : '';
    $harga = isset($_POST['harga']) ? mysqli_real_escape_string($koneksi, $_POST['harga']) : '';

    // Periksa apakah ada file gambar yang diupload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['name'] != "") {

        // ambil nama gambar lama
        $q = mysqli_query($koneksi, "SELECT gambar FROM menu WHERE kode='$kode'");
        $dt = mysqli_fetch_array($q);
        $gambar = isset($dt['gambar']) ? $dt['gambar'] : '';

        // hapus gambar lama
        if (!empty($gambar) && file_exists('uploads/' . $gambar)) {
            unlink('uploads/' . $gambar);
        }

        // upload gambar baru
        $path = $_FILES['gambar']['name'];
        $ext = "." . pathinfo($path, PATHINFO_EXTENSION);
        $namagambar = md5(time()) . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $namagambar);

        // update nama gambar ke gambar baru
        mysqli_query($koneksi, "UPDATE menu SET gambar='$namagambar' WHERE kode='$kode'");
    }

    // update dengan condition
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

    // Tutup koneksi database
    mysqli_close($koneksi);
}

echo json_encode($response);
?>
