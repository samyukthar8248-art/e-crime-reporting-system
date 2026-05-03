<?php
ob_start();

include 'config.php';
include 'admin_navbar.php';

// Security: Only admin can access
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

$msg = '';

if(isset($_POST['submit'])){
    $station_name = $_POST['station_name'];
    $circle       = $_POST['circle'];
    $contact      = $_POST['contact'];
    $fax          = $_POST['fax'];
    $address      = $_POST['address'];

    $sql = "INSERT INTO station (station_name, circle, contact, fax, address) 
            VALUES ('$station_name','$circle','$contact','$fax','$address')";

    if(mysqli_query($conn, $sql)){
        $msg = "Station added successfully!";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Police Station</title>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-image:url('images/2.jpg');
            background-size:cover;
        }

        /* FORM CONTAINER */
        .form-container {
            max-width: 520px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px 35px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #0d3b66;
        }

        /* LABELS */
        label {
            font-weight: 600;
            color: #333;
            display: block;
            margin-bottom: 6px;
        }

        /* INPUTS & TEXTAREA */
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            margin-bottom: 18px;
            font-size: 15px;
            resize: none;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #0d3b66;
            box-shadow: 0 0 4px rgba(13, 59, 102, 0.4);
        }

        /* SUBMIT BUTTON */
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #0d3b66;
            border: none;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #092c4a;
        }

        /* SUCCESS / ERROR MESSAGE */
        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: 600;
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Add Police Station</h2>

        <?php 
        if($msg != '') {
            echo "<div class='message'>$msg</div>";
        }
        ?>

        <form method="POST" action="">
            <label>Station Name</label>
            <input type="text" name="station_name" required>

            <label>Circle</label>
            <input type="text" name="circle" required>

            <label>Contact</label>
            <input type="text" name="contact">

            <label>Fax</label>
            <input type="text" name="fax">

            <label>Address</label>
            <textarea name="address" rows="3"></textarea>

            <input type="submit" name="submit" value="Add Station">
        </form>
    </div>

</body>
</html>
