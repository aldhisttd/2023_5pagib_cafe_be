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
    $response['status'] = 500;
    $response['msg'] = 'Gagal terhubung ke database';
} else {
    // Perbaikan pada bagian ini
    $kode = isset($_POST['kode']) ? mysqli_real_escape_string($koneksi, $_POST['kode']) : '';
    $nama = isset($_POST['nama']) ? mysqli_real_escape_string($koneksi, $_POST['nama']) : '';
    $kode_kategori = isset($_POST['kode_kategori']) ? mysqli_real_escape_string($koneksi, $_POST['kode_kategori']) : '';
    $harga = isset($_POST['harga']) ? mysqli_real_escape_string($koneksi, $_POST['harga']) : '';

    // Periksa apakah ada file gambar yang diupload
    if (!empty($_FILES['gambar']['name'])) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['gambar']['name']);
        $gambarFileName = $_FILES['gambar']['name'];

        // Proses upload gambar
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadFile)) {
            // Hapus file gambar lama jika ada
            $oldImagePathQuery = mysqli_query($koneksi, "SELECT gambar FROM menu WHERE kode='$kode'");
            $oldImagePathResult = mysqli_fetch_assoc($oldImagePathQuery);
            $oldImage = isset($oldImagePathResult['gambar']) ? $oldImagePathResult['gambar'] : null;

            // Periksa apakah file gambar lama ada sebelum dihapus
            if (!empty($oldImage) && file_exists($oldImage)) {
                unlink($oldImage);
            }

            // Update data menu ke database
            $query = mysqli_query($koneksi, "UPDATE menu SET 
                nama='$nama', 
                kode_kategori='$kode_kategori', 
                gambar='$gambarFileName', 
                harga='$harga' 
                WHERE kode='$kode'");
        } else {
            $response['status'] = 400;
            $response['msg'] = 'Gagal upload gambar';
        }
    } else {
        // Jika tidak ada file gambar yang diupload, update data tanpa mengubah gambar
        $query = mysqli_query($koneksi, "UPDATE menu SET 
            nama='$nama', 
            kode_kategori='$kode_kategori', 
            harga='$harga' 
            WHERE kode='$kode'");
    }

    if ($query) {
        $response['status'] = 200;
        $response['msg'] = 'Data berhasil diupdate';
        $response['body']['data']['kode'] = $kode;
        $response['body']['data']['nama'] = $nama;
        $response['body']['data']['kode_kategori'] = $kode_kategori;
        $response['body']['data']['gambar'] = isset($gambarFileName) ? $gambarFileName : '';
        $response['body']['data']['harga'] = $harga;
        
        // API endpoint
        $api_url = "http://localhost/2023_5pagib_cafe_be/obat_read.php";

        // Data yang akan dikirim ke API
        $api_data = [
            'kode' => $kode,
            'nama' => $nama,
            'kode_kategori' => $kode_kategori,
            'gambar' => isset($gambarFileName) ? $gambarFileName : '',
            'harga' => $harga
        ];

        // Konfigurasi cURL untuk mengirim data ke API
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_data));

        // Eksekusi cURL dan dapatkan respons
        $api_response = curl_exec($ch);

        // Tutup sesi cURL
        curl_close($ch);

        // Log respons dari API
        error_log($api_response);
    } else {
        $response['status'] = 400;
        $response['msg'] = 'Gagal update menu';
    }

    // Tutup koneksi database
    mysqli_close($koneksi);
}

echo json_encode($response);
?>
