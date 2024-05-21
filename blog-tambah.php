<?php
$server = "localhost";
$pengguna = "root";
$sandi = "root";
$db = "my_db";

// Membuat koneksi ke database
$koneksi = new mysqli($server, $pengguna, $sandi, $db);

// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mendapatkan data dari form
$judul = $_POST['judul'];
$isi = $_POST['isi'];
$gambar = $_FILES['gambar'];

// Mengunggah file gambar
$direktori_tujuan = "images/";
$file_tujuan = $direktori_tujuan . basename($gambar["name"]);
$tipeFileGambar = strtolower(pathinfo($file_tujuan, PATHINFO_EXTENSION));
$unggahOk = 1;

// Memeriksa apakah file adalah gambar
$cek = getimagesize($gambar["tmp_name"]);
if ($cek !== false) {
    $unggahOk = 1;
} else {
    echo "File bukan gambar.";
    $unggahOk = 0;
}

// Memeriksa apakah file sudah ada
if (file_exists($file_tujuan)) {
    echo "Maaf, file sudah ada.";
    $unggahOk = 0;
}

// Memeriksa ukuran file
if ($gambar["size"] > 500000) {
    echo "Maaf, ukuran file terlalu besar.";
    $unggahOk = 0;
}

// Hanya mengizinkan format gambar tertentu
if ($tipeFileGambar != "jpg" && $tipeFileGambar != "png" && $tipeFileGambar != "jpeg" && $tipeFileGambar != "gif") {
    echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
    $unggahOk = 0;
}

// Memeriksa apakah ada kesalahan
if ($unggahOk == 0) {
    echo "Maaf, file Anda tidak dapat diunggah.";
    // Jika semuanya baik-baik saja, mencoba mengunggah file
} else {
    if (move_uploaded_file($gambar["tmp_name"], $file_tujuan)) {
        echo "File " . basename($gambar["name"]) . " berhasil diunggah.";
    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah file.";
    }
}

// Menyimpan data artikel ke dalam database
$url_gambar = $file_tujuan;
$sql = "INSERT INTO articles (title, content, image_url, created_at) VALUES ('$judul', '$isi', '$url_gambar', NOW())";

if ($koneksi->query($sql) === TRUE) {
    echo "Artikel baru berhasil ditambahkan";
    header("Location: blog.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $koneksi->error;
}

$koneksi->close();
