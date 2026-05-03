<?php
session_start();
include 'config.php'; // your database connection file
include 'header.php';
$msg = '';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check username and password in the database
    $sql = "SELECT * FROM police_officer WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        // Store police officer info in session
        $_SESSION['police_id'] = $row['officer_id'];
        $_SESSION['police_name'] = $row['officer_name'];
        $_SESSION['station_id'] = $row['station_id'];

        header("Location: view_complaint.php"); // redirect to police dashboard
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
<title>Police Login</title>
<style>
    body {
        margin: 0;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-image:url('images/5.jpg');
            background-size:cover;
        
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-container {
        background: #ffffff;
        padding: 40px 50px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        width: 350px;
        text-align: center;
        margin:50px auto;
    }

    h2 {
        margin-bottom: 25px;
        color: #0d3b66;
    }

    .login-container label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
        font-weight: 600;
        color: #333;
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 20px;
        border-radius: 6px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        transition: 0.3s;
    }

    .login-container input[type="text"]:focus,
    .login-container input[type="password"]:focus {
        border-color: #0d3b66;
        outline: none;
        box-shadow: 0 0 5px rgba(13,59,102,0.3);
    }

    .login-container input[type="submit"] {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 6px;
        background-color: #0d3b66;
        color: white;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    .login-container input[type="submit"]:hover {
        background-color: #092c4a;
    }

    .msg {
        margin-bottom: 20px;
        color: red;
        font-weight: 600;
    }
</style>
</head>
<body>

<div class="login-container">
    <h2>Police Login</h2>

    <?php if($msg != '') { echo "<p class='msg'>$msg</p>"; } ?>

    <form method="POST" action="">
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter username" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <input type="submit" name="login" value="Login">
    </form>
</div>

</body>
</html>
