<?php
session_start();
include 'config.php';
include 'header.php';
$msg = '';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $password = $_POST['password'];

    // Check if username already exists
    $check = mysqli_query($conn, "SELECT * FROM public_user WHERE username='$username'");
    if(mysqli_num_rows($check) > 0){
        $msg = "Username already exists!";
    } else {
        $sql = "INSERT INTO public_user (username, email, phone, password) 
                VALUES ('$username', '$email', '$phone', '$password')";
        if(mysqli_query($conn, $sql)){
            $msg = "Registration successful! You can login now.";
        } else {
            $msg = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Public Registration</title>
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
        max-width: 450px;
        margin: 60px auto;
        background: #fff;
        padding: 30px 35px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        color: #0d3b66; /* Main color applied */
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #0d3b66; /* Main color applied */
    }

    input[type="text"], input[type="email"], input[type="password"] {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 15px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 15px;
        outline: none;
        transition: 0.3s;
    }

    input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
        border-color: #0d3b66;
        box-shadow: 0 0 5px rgba(13,59,102,0.3);
    }

    input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #0d3b66; /* Button color updated */
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #092c4a; /* Darker shade on hover */
    }

    .msg {
        text-align: center;
        font-weight: bold;
        margin-bottom: 15px;
        color: #0d3b66; /* Message color updated */
    }

    p {
        text-align: center;
        margin-top: 15px;
    }

    a {
        color: #0d3b66; /* Link color updated */
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
        <h2>Public Registration</h2>

        <?php if($msg != '') { echo "<p class='msg'>$msg</p>"; } ?>

        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Phone:</label>
            <input type="text" name="phone" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <input type="submit" name="register" value="Register">
        </form>

        <p>Already registered? <a href="public_login.php">Login here</a></p>
    </div>
</body>
</html>

