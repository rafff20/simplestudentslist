<?php 
session_start();

// jika tidak ada session login maka kembalikan user ke halaman login
if (!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
require 'functions.php';


// cek apakah tombol submit sudah ditekan atau belu,

if (isset($_POST["submit"])) {
    
    // cek apakah data berhasil ditambahkan atau tidak
    if(tambah($_POST) > 0){
        echo 
        "<script>
        alert('data berhasil ditambahkan');
        document.location.href = 'index.php';
        </script>";
    } else{
        echo "<script>
        alert('data tidak berhasil ditambahkan');
        document.location.href = 'index.php';
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah data mahasiswa</title>
</head>
<body>
    <h1>Tambah data mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <!-- for itu nyambung dengan id -->
                <label for="nim">NIM : </label>
                <input type="text" name="nim" id="nim"
                required>
                
            </li>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama"
                required>
            </li>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email"
                required>
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan"
                required>
            </li>
            <li>
                <label for="gambar">gambar : </label>
                <input type="file" name="gambar" id="gambar"
                required>
            </li>
            <li>
                <button type="submit" name="submit">Tambah Data</button>
            </li>
        </ul>

    </form>
</body>
</html>