<?php
session_start();
include 'config.php';
include 'header.php';

$msg = '';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['username'] = $row['username'];
        header("Location: add_station.php");
        exit();
    } else {
        $msg = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
           background-image:url('images/2.jpg');
           background-size:cover;
            height: 100vh;
            
            justify-content: center;
            align-items: center;
        }

        /* LOGIN BOX */
        .login-box {
            background: #ffffff;
            padding: 40px;
            width: 360px;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
            margin:50px auto;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #0d3b66;
            letter-spacing: 1px;
        }

        /* FORM ELEMENTS */
        label {
            font-weight: 600;
            color: #333;
            display: block;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            margin-bottom: 18px;
            font-size: 15px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #0d3b66;
            box-shadow: 0 0 4px rgba(13, 59, 102, 0.4);
        }

        /* LOGIN BUTTON */
        input[type="submit"] {
            width: 100%;
            padding: 11px;
            background: #0d3b66;
            border: none;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background: #092c4a;
            transform: translateY(-1px);
        }

        /* ERROR MESSAGE */
        .error {
            text-align: center;
            color: #d00000;
            margin-bottom: 15px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="login-box">
        <h2>Admin Login</h2>

        <?php 
        if($msg != '') { 
            echo "<div class='error'>$msg</div>"; 
        } 
        ?>

        <form method="POST" action="">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <input type="submit" name="login" value="Login">
        </form>
    </div>

</body>
</html>
