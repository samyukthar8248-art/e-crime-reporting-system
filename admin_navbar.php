<?php
session_start();

// Only admin can access
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f4f8;
        }

        /* NAVBAR */
        .navbar {
            background-color: #0d3b66;
            padding: 14px 30px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);

            position: sticky; /* Make sticky */
            top: 0;
            z-index: 1000; /* Stay on top */
        }

        /* LEFT ADMIN NAME */
        .admin-name {
            color: #ffffff;
            font-weight: bold;
            font-size: 18px;
            letter-spacing: 1px;
        }

        /* RIGHT MENU */
        .nav-right {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        /* NAV LINKS */
        .navbar a {
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            margin-left: 10px;
            padding: 10px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .navbar a:hover {
            background-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        /* LOGOUT BUTTON */
        .logout {
            background-color: #092c4a;
        }

        .logout:hover {
            background-color: #061f33;
        }

        /* PAGE CONTENT */
        .content {
            max-width: 1200px;
            margin: 80px auto 30px auto; /* top margin to clear sticky navbar */
            padding: 20px;
        }

        .page-title {
            font-size: 26px;
            color: #0d3b66;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <!-- LEFT SIDE -->
        <span class="admin-name">Admin Panel</span>

        <!-- RIGHT SIDE -->
        <div class="nav-right">
            
            <a href="add_station.php">Add Station</a>
            <a href="view_station.php">View Station</a>
            <a href="add_police.php">Add Police Officer</a>
            <a href="view_police.php">View Police Officer</a>
            <a href="admin_view_complaint.php">View Complaints</a>
            <a href="admin_login.php" class="logout">Logout</a>
        </div>
    </div>

    <!-- PAGE CONTENT -->
    

</body>
</html>
