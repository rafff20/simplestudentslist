<?php 
session_start();

// jika tidak ada session login maka kembalikan user ke halaman login
if (!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
require 'functions.php';

// Ambil data di URL
$id=$_GET["id"];

// query data mhs berdasarkan id
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")['0'];
// var_dump($mhs['0']['nim']);

// cek apakah tombol submit sudah ditekan atau belu,

if (isset($_POST["submit"])) {
    
    // cek apakah data berhasil ditambahkan atau tidak
    if(ubah($_POST) > 0){
        echo 
        "<script>
        alert('data berhasil diubah');
        document.location.href = 'index.php';
        </script>";
    } else{
        echo "<script>
        alert('data tidak berhasil diubah');
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
    <title>Ubah data mahasiswa</title>
</head>
<body>
    <h1>Ubah data mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $mhs["id"]?>">
        <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"]?>">
        <ul>
            <li>
                <!-- for itu nyambung dengan id -->
                <label for="nim">NIM : </label>
                <input type="text" name="nim" id="nim"
                required value="<?= $mhs["nim"]?>">
                
            </li>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama"
                required value="<?= $mhs["nama"]?>">
            </li>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email"
                required value="<?= $mhs["email"]?>">
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan"
                required value="<?= $mhs["jurusan"]?>">
            </li>
            <li>
                <label for="gambar">gambar : </label><br>
                <img src="img/<?= $mhs['gambar']; ?>" alt=""><br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Ubah Data</button>
            </li>
        </ul>

    </form>
</body>
</html>