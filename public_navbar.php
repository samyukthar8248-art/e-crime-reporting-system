<?php
session_start();

// Only logged-in public users can access
if(!isset($_SESSION['public_id'])){
    header("Location: public_login.php");
    exit();
}

// Get username from session
$username = isset($_SESSION['public_name']) ? $_SESSION['public_name'] : 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Public Dashboard</title>
<style>
    body, html {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f4f9;
    }

    /* STICKY NAVBAR */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #0d3b66; /* main color */
        padding: 10px 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    /* Left side (User Panel) */
    .navbar .left {
        color: #ecf0f1;
        font-weight: 600;
        font-size: 16px;
    }

    /* Right side (Links) */
    .navbar .right a {
        color: #ecf0f1;
        text-decoration: none;
        margin-left: 12px;
        padding: 8px 15px;
        border-radius: 5px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .navbar .right a:hover {
        background-color: #ecf0f1;
        color: #0d3b66;
    }

    /* Logout button styling */
    .navbar .right a.logout {
        background-color: #e74c3c;
        color: #fff;
        font-weight: 600;
    }

    .navbar .right a.logout:hover {
        background-color: #c0392b;
        color: #fff;
    }

    /* Page content styling */
    .content {
        max-width: 900px;
        margin: 50px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        text-align: center;
    }

    h1 {
        color: #0d3b66;
        margin-bottom: 20px;
    }

    p {
        font-size: 18px;
        color: #555;
        line-height: 1.6;
    }

    /* Responsive navbar */
    @media screen and (max-width: 600px) {
        .navbar {
            flex-direction: column;
            align-items: flex-start;
        }
        .navbar .right {
            margin-top: 10px;
        }
        .navbar .right a {
            margin-left: 0;
            margin-right: 10px;
            margin-bottom: 5px;
        }
    }
</style>
</head>
<body>

<div class="navbar">
    <div class="left">
        Public Panel - Welcome <?php echo htmlspecialchars($username); ?>
    </div>
    <div class="right">
        
        <a href="add_complaint.php">Add Complaint</a>
        <a href="view_reply.php">View Reply</a>
        <a href="view_status.php">View Status</a>
        <a href="public_login.php" class="logout">Logout</a>
    </div>
</div>



</body>
</html>
