<?php
session_start();
include 'config.php'; // Make sure this file contains $conn for database connection

// Only admin can access
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

// Fetch counts from database
$station_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM station"))['total'];
$police_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM police_officer"))['total'];
$complaint_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM complaint"))['total'];
$fir_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM fir"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - Crime Reporting System</title>

<style>
/* ===== Reset & Fonts ===== */
body, html {
    margin: 0;
    padding: 0;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    overflow-x: hidden;
}

/* ===== Animated Background (Light Blue Theme) ===== */
body {
    background: linear-gradient(-45deg, #a2d5f2, #7cc6fe, #9ad0f5, #b0e0ff);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
}

@keyframes gradientBG {
    0% {background-position: 0% 50%;}
    50% {background-position: 100% 50%;}
    100% {background-position: 0% 50%;}
}

/* ===== STICKY NAVBAR ===== */
.navbar {
    background-color: rgba(0, 123, 255, 0.9); /* lighter blue */
    padding: 14px 30px;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    position: sticky;
    top: 0;
    z-index: 1000;
    backdrop-filter: blur(8px);
}

.admin-name {
    color: #ffffff;
    font-weight: bold;
    font-size: 18px;
    letter-spacing: 1px;
}

.nav-right {
    margin-left: auto;
    display: flex;
    align-items: center;
}

.navbar a {
    color: #ffffff;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    margin-left: 15px;
    padding: 10px 16px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.navbar a:hover {
    background-color: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
}

.logout {
    background-color: #0069d9;
}

.logout:hover {
    background-color: #004a9f;
}

/* ===== DASHBOARD CARDS ===== */
.dashboard {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin: 100px 20px 20px 20px;
}

.card {
    position: relative;
    background-color: rgba(255, 255, 255, 0.9);
    width: 240px;
    margin: 20px;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    text-align: center;
    overflow: hidden;
    cursor: default;
    transition: all 0.5s ease;
}

.card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, rgba(255,255,255,0.15), rgba(255,255,255,0));
    transform: rotate(25deg);
    transition: all 0.5s ease;
}

.card:hover::before {
    transform: rotate(25deg) translateX(20px) translateY(20px);
}

.card h3 {
    margin: 10px 0;
    color: #0d3b66;
    font-size: 20px;
}

.card p {
    color: #333;
    font-size: 26px;
    font-weight: bold;
    margin-top: 15px;
}

/* Color-coded cards (soft pastel colors) */
.card:nth-child(1) { border-top: 5px solid #4db8ff; } /* Stations */
.card:nth-child(2) { border-top: 5px solid #3399ff; } /* Officers */
.card:nth-child(3) { border-top: 5px solid #66ccff; } /* Complaints */
.card:nth-child(4) { border-top: 5px solid #99ddff; } /* FIRs */

/* Responsive */
@media(max-width: 768px){
    .dashboard {
        flex-direction: column;
        align-items: center;
    }
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <span class="admin-name">Admin Panel</span>
    <div class="nav-right">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="add_station.php">Add Station</a>
        <a href="add_police.php">Add Police Officer</a>
        <a href="admin_view_complaint.php">View Complaints</a>
        <a href="admin_login.php" class="logout">Logout</a>
    </div>
</div>

<!-- DASHBOARD CARDS -->
<div class="dashboard">
    <div class="card">
        <h3>Police Stations</h3>
        <p><?php echo $station_count; ?></p>
    </div>

    <div class="card">
        <h3>Police Officers</h3>
        <p><?php echo $police_count; ?></p>
    </div>

    <div class="card">
        <h3>Complaints</h3>
        <p><?php echo $complaint_count; ?></p>
    </div>

    <div class="card">
        <h3>FIRs</h3>
        <p><?php echo $fir_count; ?></p>
    </div>
</div>

</body>
</html>
