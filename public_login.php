<?php
session_start();
include 'config.php';
include 'header.php';
$msg = '';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM public_user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['public_id'] = $row['public_id'];
        $_SESSION['public_name'] = $row['username'];

        header("Location: add_complaint.php");
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Public Login</title>
<style>
    body {
        margin: 0;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-image:url('images/7.jpg');
            background-size:cover;
        color: #333;
    }

    .container {
        width: 90%;
        max-width: 400px;
        margin: 80px auto;
        background: #fff;
        padding: 30px 35px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        color: #0d3b66;
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #0d3b66;
    }

    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 15px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 15px;
        outline: none;
        transition: 0.3s;
    }

    input[type="text"]:focus, input[type="password"]:focus {
        border-color: #0d3b66;
        box-shadow: 0 0 5px rgba(13,59,102,0.3);
    }

    input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #0d3b66; /* Changed to your requested color */
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #092c4a; /* Slightly darker on hover */
    }

    .msg {
        text-align: center;
        font-weight: bold;
        margin-bottom: 15px;
        color: red;
    }

    p {
        text-align: center;
        margin-top: 15px;
    }

    a {
        color: #0d3b66; /* Link color matches your theme */
        text-decoration: none;
        font-weight: 600;
    }

    a:hover {
        text-decoration: underline;
    }

    @media(max-width: 500px) {
        .container {
            padding: 20px;
        }
        input[type="submit"] {
            font-size: 14px;
        }
    }
</style>
</head>
<body>
    <div class="container">
        <h2>Public Login</h2>

        <?php if($msg != '') { echo "<p class='msg'>$msg</p>"; } ?>

        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <input type="submit" name="login" value="Login">
        </form>

        <p>New user? <a href="public_register.php">Register here</a></p>
    </div>
</body>
</html>
