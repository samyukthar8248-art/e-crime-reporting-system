<?php
ob_start();
include 'config.php';
include 'police_navbar.php';

// Only logged-in police can access
if(!isset($_SESSION['police_id'])){
    header("Location: police_login.php");
    exit();
}

$msg = '';

// Update status if form submitted
if(isset($_POST['update'])){
    $complaint_id = $_POST['complaint_id'];
    $status       = $_POST['status'];

    $sql = "UPDATE complaint SET status='$status' WHERE complaint_id='$complaint_id'";
    if(mysqli_query($conn, $sql)){
        $msg = "Complaint status updated successfully!";
    } else {
        $msg = "Error: ".mysqli_error($conn);
    }
}

// Fetch all complaints
$complaints = mysqli_query($conn, "SELECT * FROM complaint ORDER BY date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Complaint Status</title>
<style>
    body {
        margin: 0;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-image:url('images/1.jpg');
            background-size:cover;
        color: #333;
    }

    .container {
        width: 95%;
        max-width: 1200px;
        margin: 40px auto;
        background: #fff;
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        color: #0d3b66;
        margin-top: 0;
        margin-bottom: 25px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th, td {
        padding: 12px 10px;
        border: 1px solid #ddd;
        text-align: left;
        vertical-align: middle;
    }

    th {
        background-color: #0d3b66;
        color: white;
        font-weight: 600;
        text-align: center;
    }

    td img {
        max-width: 80px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    select {
        padding: 6px 8px;
        border-radius: 6px;
        border: 1px solid #ccc;
        outline: none;
        font-size: 14px;
    }

    input[type="submit"] {
        padding: 6px 12px;
        background-color: #1abc9c;
        color: #fff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #16a085;
    }

    .msg {
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
        color: #27ae60;
    }

    tr:nth-child(even) {
        background: #f9f9f9;
    }

    tr:hover {
        background: #eef2f7;
    }

    @media (max-width: 768px) {
        table, th, td {
            font-size: 13px;
        }
        th, td {
            padding: 8px 6px;
        }
        select, input[type="submit"] {
            width: 100%;
            margin-bottom: 5px;
        }
    }
</style>
</head>
<body>
<div class="container">
    <h2>Manage Complaint Status</h2>

    <?php if($msg != '') { echo "<p class='msg'>$msg</p>"; } ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Public ID</th>
            <th>Date</th>
            <th>Place</th>
            <th>Subject</th>
            <th>Complaint Text</th>
            <th>Image</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($complaints)) { ?>
            <tr>
                <td><?php echo $row['complaint_id']; ?></td>
                <td><?php echo $row['public_id']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['place']; ?></td>
                <td><?php echo $row['subject']; ?></td>
                <td><?php echo $row['complaint_text']; ?></td>
                <td>
                    <?php 
                    if($row['image']) { 
                        echo "<img src='uploads/".$row['image']."' alt='Complaint Image'>"; 
                    } else { 
                        echo "No Image"; 
                    } 
                    ?>
                </td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="complaint_id" value="<?php echo $row['complaint_id']; ?>">
                        <select name="status">
                            <option value="Pending" <?php if($row['status']=='Pending') echo "selected"; ?>>Pending</option>
                            <option value="FIR Registered" <?php if($row['status']=='FIR Registered') echo "selected"; ?>>FIR Registered</option>
                            <option value="In Progress" <?php if($row['status']=='In Progress') echo "selected"; ?>>In Progress</option>
                            <option value="Closed" <?php if($row['status']=='Closed') echo "selected"; ?>>Closed</option>
                        </select>
                </td>
                <td>
                        <input type="submit" name="update" value="Update">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
