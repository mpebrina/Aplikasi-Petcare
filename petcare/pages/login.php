<?php
session_start();
include "../config/db.php";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM tb_users WHERE username='$username'");
    $data  = mysqli_fetch_assoc($query);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Pet Care</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">

<div class="card shadow p-4" style="width: 380px; border-radius: 20px;">
    
    <div class="text-center mb-4">
        <img src="../assets/img/logo.png" alt="Logo" width="80">
        <h3 class="mt-2" style="color: #3b6fff;">Welcome!</h3>
    </div>

    <?php if(isset($error)) { ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php } ?>

    <form method="post">

        <label class="form-label">Email</label>
        <input type="text" name="username" class="form-control mb-3" placeholder="Masukkan email" required>

        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control mb-4" placeholder="Masukkan password" required>

        <button type="submit" name="login" class="btn w-100" 
                style="background:#f8d94c; font-weight:bold;">
            Login
        </button>

    </form>

</div>

</body>
</html>