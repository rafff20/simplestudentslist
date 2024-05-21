<?php 
// koneksi ke database
// passwordny dikosongin aja
// $conn = mysqli_connect("localhost", "root", "", "phpdasar");

// ambil data dari tabel mahasiswa / query data mahasiswa
// $result = mysqli_query($conn, "SELECT * FROM mahasiswa");
// buat cek sudah connect belum
// if(!$result){
//     echo mysqli_error($conn);
// }

// ambil data (fetch) mahasiswa dari object result
// mysqli_fetch_row() mengembalikan array numerik / array yg indexnya angka
// mysqli_fetch_assoc() mengembalikan array associative / make string
// mysqli_fetch_array() mengembalikan keduanya numerik dan assoc tapi data jadi double
// mysqli_fetch_object()

// while($mhs = mysqli_fetch_assoc($result)){
//     var_dump($mhs);
// };


$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ){
        $rows[]= $row;
    }
    return $rows;
}


function tambah($data){
    global $conn;
    // ambil data dari tiap elemen dalam form
    $nim = htmlspecialchars($data["nim"]);
    $nama =htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // upload gambar
    $gambar = upload();
    if(!$gambar){
        return false;
    }

    // query insert data
    $query = "INSERT INTO mahasiswa VALUES
            ('', '$nama', '$nim', '$email', '$jurusan', '$gambar')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function upload(){
    // bisa cek vardump dulu
    // gambar dapet dari name di index

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gmabar yang diupload
    if ($error === 4){
        echo "<script>
                alert('pilih gambar dahulu')
            </script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar= explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
        echo "<script>
                alert('gambar tidak sesuai format')
            </script>";
        return false;
    };

    // cek jika ukurannya terlalu besar
    if( $ukuranFile > 1000000){
        echo "<script>
                alert('pilih gambar dahulu')
            </script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru biar kalo sama ga keubah semua
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;

}


function hapus($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($conn);
    
}


function ubah ($data){
    global $conn;
    
    // ambil data dari tiap elemen dalam form
    $id = $data["id"];
    $nim = htmlspecialchars($data["nim"]);
    $nama =htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    // query insert data
    $query = "UPDATE mahasiswa SET
                nim = '$nim', 
                nama = '$nama',
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'
                WHERE id = $id
                ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}


function cari($keyword){
    $query = "SELECT * FROM mahasiswa
    -- make % biar bisa wildcard 
    WHERE 
    nama LIKE '%$keyword%' OR 
    nim LIKE '%$keyword%' OR
    jurusan LIKE '%$keyword%'OR
    email LIKE '%$keyword%'";

    return query($query);
}


function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn,$data["password"]);
    $password2 = mysqli_real_escape_string($conn,$data["password2"]);

    
    // cek username sudah ada atau belum

    $result = mysqli_query($conn, "SELECT username from user WHERE username = '$username'");
    
    if( mysqli_fetch_assoc($result)){
        echo "<script>
            alert('username sudah terdaftar')
        </script>";
        return false;
    }
    
    // cek konfirmasi password
    if($password !== $password2){
        echo "<script>
            alert('password tidak sesuai')
            </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // Tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES ('', '$username', '$password')");

    return mysqli_affected_rows($conn);




}





?>
