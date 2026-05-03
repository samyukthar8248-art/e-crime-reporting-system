<?php
ob_start();
include 'config.php';
include 'public_navbar.php'; // header with public navbar

// Only logged-in public users can access
if(!isset($_SESSION['public_id'])){
    header("Location: public_login.php");
    exit();
}

$msg = '';

if(isset($_POST['submit'])){
    $public_id      = $_SESSION['public_id'];
    $date           = $_POST['date'];
    $place          = $_POST['place'];
    $subject        = $_POST['subject'];
    $complaint_text = $_POST['complaint_text'];

    // Handle image upload
    $image = '';
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
        $target_dir = "uploads/";
        if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
    }

    $sql = "INSERT INTO complaint (public_id, date, place, subject, complaint_text, image)
            VALUES ('$public_id','$date','$place','$subject','$complaint_text','$image')";

    if(mysqli_query($conn, $sql)){
        $msg = "Complaint submitted successfully!";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Complaint</title>
<style>
    body {
        margin: 0;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-image:url('images/4.jpg');
        background-size:cover;
        min-height: 100vh;

        
    }

    .container {
        width: 90%;
        max-width: 500px;
        margin: 60px auto;
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

    input[type="text"], input[type="date"], textarea {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 15px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 15px;
        outline: none;
        transition: 0.3s;
    }

    input[type="text"]:focus, input[type="date"]:focus, textarea:focus {
        border-color: #0d3b66;
        box-shadow: 0 0 5px rgba(13,59,102,0.3);
    }

    input[type="file"] {
        margin-bottom: 15px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #0d3b66;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #092c4a;
    }

    .msg {
        text-align: center;
        font-weight: bold;
        margin-bottom: 15px;
        color: #0d3b66;
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
        <h2>Add Complaint</h2>

        <?php if($msg != '') { echo "<p class='msg'>$msg</p>"; } ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <label>Date:</label>
            <input type="date" name="date" required>

            <label>Place:</label>
            <input type="text" name="place" required>

            <label>Subject:</label>
            <input type="text" name="subject" required>

            <label>Complaint Details:</label>
            <textarea name="complaint_text" rows="5" required></textarea>

            <label>Upload Image (Optional):</label>
            <input type="file" name="image" accept="image/*">

            <input type="submit" name="submit" value="Submit Complaint">
        </form>
    </div>
</body>
</html>
