<?php
ob_start();
include 'config.php';
include 'police_navbar.php';

if(!isset($_SESSION['police_id'])){
    header("Location: police_login.php");
    exit();
}

$msg = "";
$complaint = null;

/* Fetch complaints for dropdown */
$complaints = mysqli_query($conn, "SELECT * FROM complaint");

/* When complaint selected */
if(isset($_POST['select_complaint'])){
    $complaint_id = $_POST['complaint_id'];
    $cq = mysqli_query($conn, "SELECT * FROM complaint WHERE complaint_id='$complaint_id'");
    $complaint = mysqli_fetch_assoc($cq);
}

/* Add criminal */
if(isset($_POST['submit'])){
    $complaint_id = $_POST['complaint_id'];
    $name    = $_POST['name'];
    $age     = $_POST['age'];
    $gender  = $_POST['gender'];
    $address = $_POST['address'];

    $image = NULL;
    if(!empty($_FILES['image']['name'])){
        $image = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);
    }

    $crime = $_POST['crime'];

    $sql = "INSERT INTO criminals 
            (complaint_id, name, age, gender, address, crime, image)
            VALUES 
            ('$complaint_id','$name','$age','$gender','$address','$crime','$image')";

    if(mysqli_query($conn,$sql)){
        $msg = "Criminal added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Criminal</title>
<style>
    body {
        margin: 0;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-image:url('images/4.jpg');
            background-size:cover;
        color: #333;
    }

    .container {
        width: 90%;
        max-width: 800px;
        margin: 40px auto;
        background: #fff;
        padding: 30px 35px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    h2 {
        text-align: center;
        margin-top: 0;
        color: #0d3b66;
    }

    h3 {
        color: #092c4a;
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
        color: #092c4a;
    }

    input[type="text"],
    input[type="number"],
    select,
    textarea,
    input[type="file"] {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 18px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: 0.3s;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    select:focus,
    textarea:focus {
        border-color: #0d3b66;
        box-shadow: 0 0 6px rgba(13,59,102,0.2);
    }

    textarea {
        resize: vertical;
    }

    input[type="submit"] {
        background-color: #0d3b66;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #092c4a;
        transform: translateY(-2px);
    }

    .msg {
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
        color: #27ae60;
    }

    hr {
        border: none;
        height: 1px;
        background: #ddd;
        margin: 25px 0;
    }

    .complaint-details {
        background: #f9f9f9;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        border: 1px solid #e0e0e0;
    }

    .complaint-details p {
        margin: 6px 0;
    }

    @media (max-width: 600px) {
        .container {
            padding: 20px;
        }
        input[type="submit"] {
            width: 100%;
        }
    }
</style>
</head>
<body>
<div class="container">
    <h2>Add Criminal</h2>
    <?php if($msg) echo "<p class='msg'>$msg</p>"; ?>

    <!-- Complaint Dropdown -->
    <form method="POST">
        <label>Select Complaint:</label>
        <select name="complaint_id" required>
            <option value="">-- Select Complaint --</option>
            <?php while($row = mysqli_fetch_assoc($complaints)) { ?>
                <option value="<?php echo $row['complaint_id']; ?>">
                    <?php echo $row['subject']." - ".$row['place']; ?>
                </option>
            <?php } ?>
        </select>
        <input type="submit" name="select_complaint" value="View Complaint">
    </form>

    <?php if($complaint){ ?>
    <hr>

    <!-- Complaint Details -->
    <div class="complaint-details">
        <h3>Complaint Details</h3>
        <p><b>Place:</b> <?php echo $complaint['place']; ?></p>
        <p><b>Subject:</b> <?php echo $complaint['subject']; ?></p>
        <p><b>Description:</b> <?php echo $complaint['complaint_text']; ?></p>
    </div>

    <!-- Criminal Form -->
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="complaint_id" value="<?php echo $complaint['complaint_id']; ?>">
        <input type="hidden" name="crime" value="<?php echo $complaint['subject']; ?>">

        <label>Criminal Name:</label>
        <input type="text" name="name" required>

        <label>Age:</label>
        <input type="number" name="age">

        <label>Gender:</label>
        <select name="gender">
            <option value="">Select</option>
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
        </select>

        <label>Address:</label>
        <textarea name="address"></textarea>

        <label>Upload Image (optional):</label>
        <input type="file" name="image" accept="image/*">

        <input type="submit" name="submit" value="Add Criminal">
    </form>
    <?php } ?>
</div>
</body>
</html>
