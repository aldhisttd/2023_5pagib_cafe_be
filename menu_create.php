<?php
include 'env.php';

$response = [
    'status' => '',
    'msg' => '',
    'body' => [
        'data' => [
            'kode' => '',
            'nama' => '',
            'kode_kategori' => '', // Perubahan ini
            'harga' => ''
        ]
    ]
];

if (!isset($koneksi)) {
    $response['status'] = 500;
    $response['msg'] = 'Gagal terhubung ke database';
} else {
    $kode = isset($_POST['kode']) ? $_POST['kode'] : null;
    $nama = isset($_POST['nama']) ? $_POST['nama'] : null;
    $kode_kategori = isset($_POST['kode_kategori']) ? $_POST['kode_kategori'] : null;
    $harga = isset($_POST['harga']) ? $_POST['harga'] : null;

    // Memastikan data yang diinput tidak kosong
    if (empty($kode) || empty($nama) || empty($kode_kategori) || empty($harga)) {
        $response['status'] = 400;
        $response['msg'] = 'Data tidak lengkap';
    } else {
        // Menangani upload gambar
        $gambar = isset($_FILES['gambar']['name']) ? $_FILES['gambar']['name'] : null;
        $gambar_tmp = isset($_FILES['gambar']['tmp_name']) ? $_FILES['gambar']['tmp_name'] : null;

        if ($gambar === null || $gambar_tmp === null) {
            $response['status'] = 400;
            $response['msg'] = 'Gagal mengupload gambar: File tidak ditemukan';
        } else {
            $upload_path = "upload/"; // Sesuaikan dengan folder penyimpanan gambar
            $gambar_upload = $upload_path . $gambar;

            if (move_uploaded_file($gambar_tmp, $gambar_upload)) {
                // Menambahkan data menu baru ke dalam database
                $query = mysqli_query($koneksi, "INSERT INTO menu (kode, nama, kode_kategori, harga, gambar) VALUES ('$kode', '$nama', '$kode_kategori', '$harga', '$gambar')");

                if ($query) {
                    $response['status'] = 200;
                    $response['msg'] = 'Data berhasil diinsert';
                    $response['body']['data']['kode'] = $kode;
                    $response['body']['data']['nama'] = $nama;
                    $response['body']['data']['kode_kategori'] = $kode_kategori;
                    $response['body']['data']['harga'] = $harga;
                } else {
                    $response['status'] = 400;
                    $response['msg'] = 'Proses insert gagal';
                }
            } else {
                $response['status'] = 400;
                $response['msg'] = 'Gagal mengupload gambar: Terjadi kesalahan saat mengupload';
            }
        }
    }
}

echo json_encode($response);
?>
