<?php 
session_start();
require "functions.php";

// cek cookie

if(isset($_COOKIE['id']) && isset($_COOKIE['key'])){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    // row disini isinya username aja
    $row = mysqli_fetch_assoc($result);

    // $key adalah username yg sudah diacak
    // cek cookie dan username
    // key adalah username yg diacak lalu kita acak username baru berdasarkan $result diatas
    if($key === hash('sha256', $row['username'])){
        $_SESSION['login'] = true;
    }

}


if (isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}




if (isset($_POST["login"])){

    $username = $_POST["username"];
    // ^
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if(mysqli_num_rows($result) === 1){
        // $row menyimpan data user yang login
        $row = mysqli_fetch_assoc($result);
        
        // kebalikan password hash
        // $password ngambil dari atas ^ dicek sama yg ada di database, lalu password yg ada di database 
        if (password_verify($password, $row["password"])){
            
            // set session
            // jadi dicek dulu apakah ada session nya
            $_SESSION["login"] = true;
            
            // cek remember me
            if(isset($_POST['remember'])){
                // buat cookie
                
                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['username']), time()+60);
            }


            header("Location: index.php");
            exit;
        }
    }

    $error = true;
    

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <!-- kalo ada error (karena error hanya akan dibikin jika ada error) jika tidak ada tidak akan di set -->
    <?php if(isset($error)): ?>

        <p style="color: red;">username / password salah</p>

    <?php endif;?>
    <div class="form-wrapper">
    <h1>Halaman Login</h1>
    <!-- action kosong karena data diolah langsung dihalaman yg sama -->
        <main class="form-side">
            <form action="" method="post" class="my-form">
                <div class="form-welcome-row">
                    <h1>Login! &#128079</h1>
                    <h2>How do I get started?</h2>
                </div>
                <div class="divider">
                    <div class="divider-line"></div>
                    Login with username and password
                    <div class="divider-line"></div>
                </div>
                <div class="text-field">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Masukkan username" autocomplete="off" required>
                </div>
                <div class="text-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan password" title="Minimum 6 characters" autocomplete="off" required>
                </div>
                <div>
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>
                <button type="submit" name="login" class="my-form__button">Log in</button>
                <div class="my-form__actions">
                    <div class="my-form__row">
                        <span>Don't have an account?</span>
                        <a href="#" title="Reset Password">Sign Up Now</a>
                    </div>
                </div>
            </form>
        </main>
    </div>

</body>
</html>