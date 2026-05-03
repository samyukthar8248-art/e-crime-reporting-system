<?php
session_start();

// Example: Assuming police officer info is stored in session after login
$police_name = isset($_SESSION['police_name']) ? $_SESSION['police_name'] : 'Officer';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Police Dashboard</title>
<style>
    body {
        margin: 0;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f2f4f8;
    }

    /* STICKY NAVBAR */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #0d3b66;
        padding: 12px 25px;
        color: #fff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    /* Left side: welcome message */
    .navbar .left {
        font-size: 18px;
        font-weight: bold;
    }

    /* Right side: links */
    .navbar .right {
        display: flex;
        gap: 15px;
    }

    .navbar .right a {
        color: #ffffff;
        text-decoration: none;
        padding: 10px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        background-color: rgba(255,255,255,0.1);
    }

    .navbar .right a:hover {
        background-color: rgba(255,255,255,0.25);
        transform: translateY(-2px);
    }

    /* Active link styling */
    .navbar .right a.active {
        background-color: #1abc9c;
        color: #fff;
    }

    /* Responsive */
    @media(max-width:768px){
        .navbar {
            flex-direction: column;
            align-items: flex-start;
        }
        .navbar .right {
            width: 100%;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .navbar .right a {
            width: auto;
            flex: 1 1 45%;
            margin-bottom: 8px;
        }
    }
</style>
</head>
<body>

    <div class="navbar">
        <div class="left">
            Police Panel - Welcome, <?php echo htmlspecialchars($police_name); ?>
        </div>
        <div class="right">
            <a href="view_complaint.php">View Complaint</a>
            <a href="fir.php">FIR</a>
            <a href="add_criminal.php">Criminals</a>
            <a href="manage_status.php">Manage Status</a>
            <a href="police_login.php">Logout</a>
        </div>
    </div>

    

</body>
</html>
