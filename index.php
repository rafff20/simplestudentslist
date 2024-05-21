<?php 

session_start();

// jika tidak ada session login maka kembalikan user ke halaman login
if (!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

// for itu nyambung dengan id

require 'functions.php';

$mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id ASC");

// ketika tombol cari ditekan
if (isset($_POST["cari"])){
    $mahasiswa = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <style>
        .loader{
            width: 130px;
            position: absolute;
            top: 120px;
            z-index: -1;
            left: 260px;
            display: none;
        }
    </style>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"
    />
</head>
<body>

    <a href="logout.php" class="logout">Log out</a>

    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php">Tambah data mahasiswa</a>
    <br><br/>

    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus placeholder="Masukkan keyword pencarian.." autocomplete="off" id="keyword">
        <button type="submit" name="cari" id="tombol-cari">Cari</button>

        <img src="img/loader.gif" class="loader">
    </form>


    <br>

    <div id="container">
    <table border="1" cellpadding="10" cellspacing="0">

        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>

        <?php $i = 1; ?>
        <?php foreach($mahasiswa as $row): ?>
        <tr>
            <td><?= $i ?></td>
            <td>
                <a href="ubah.php?id=<?= $row["id"]; ?>">ubah</a> | 
                <!-- menambahkan tanda tanya untuk mengirim data -->
                <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin');">hapus</a>
            </td>
            <td><img src="img/<?=$row["gambar"]; ?>" alt="" width="50"></td>
            <td><?= $row["nim"] ?></td>
            <td><?= $row["nama"] ?></td>
            <td><?= $row["email"] ?></td>
            <td><?= $row["jurusan"] ?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>

    </table>
    </div>

<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>