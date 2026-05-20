<?php
session_start();
include('koneksi.php');

/*
|--------------------------------------------------------------------------
| CEK SUDAH LOGIN
|--------------------------------------------------------------------------
*/
if(isset($_SESSION['username'])){
    if($_SESSION['role'] == 'admin'){
        header('Location: admin/dashboard.php');
    }else{
        header('Location: user/index.php');
    }
    exit;
}

$pesan_error = '';

/*
|--------------------------------------------------------------------------
| PROSES LOGIN
|--------------------------------------------------------------------------
*/
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Menggunakan mysqli_real_escape_string untuk mencegah error karakter unik dan SQL Injection
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    // CEK USER DI DATABASE
    $query = mysqli_query($conn, "
        SELECT * FROM user 
        WHERE username='$username' 
        AND password='$password'
    ");

    // JIKA USER DITEMUKAN
    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        // Menyimpan data login ke dalam SESSION
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        // PINDAH HALAMAN SESUAI ROLE
        if($data['role'] == 'admin'){
            header('Location: admin/dashboard.php');
        }else{
            header('Location: user/index.php');
        }
        exit;

    }else{
        $pesan_error = 'Username atau password salah';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Inventaris</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            background:#e2e8f0;
            font-family:Arial, Helvetica, sans-serif;
            margin:0;
            padding:0;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
        }

        .kotak-login{
            background:white;
            width:320px;
            padding:30px 25px;
            border-radius:12px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
            border:1px solid #cbd5e1;
        }

        .kotak-login h2{
            margin:0 0 8px 0;
            color:#0f172a;
            font-size:24px;
        }

        .kotak-login p{
            margin:0 0 25px 0;
            color:#475569;
            font-size:14px;
        }

        input{
            width:100%;
            padding:10px;
            margin-bottom:15px;
            border:1px solid #cbd5e1;
            border-radius:8px;
            font-size:14px;
            box-sizing:border-box;
        }

        button{
            background:#3b82f6;
            color:white;
            border:none;
            padding:10px;
            width:100%;
            border-radius:8px;
            font-size:15px;
            cursor:pointer;
            font-weight:bold;
        }

        button:hover{
            background:#2563eb;
        }

        .error{
            background:#fee2e2;
            color:#991b1b;
            padding:8px 12px;
            border-radius:8px;
            font-size:13px;
            margin-bottom:15px;
            border-left:3px solid #dc2626;
        }
    </style>
</head>
<body>

<div class="kotak-login">
    <h2>Login Inventaris</h2>
    <p>Masukkan username dan password</p>

    <?php if($pesan_error): ?>
        <div class="error">
            ⚠️ <?= $pesan_error ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>