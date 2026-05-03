<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crime Reporting System</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f4f8;
        }

        /* NAVBAR */
        .nav {
            background-color: #0d3b66;
            padding: 12px 30px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* ICON + TITLE */
        .logo-title {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
        }

        .logo-title i {
            font-size: 26px;
            color: #ffffff;
        }

        .logo-title .title {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* RIGHT LINKS */
        .right {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .nav a {
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            margin-left: 15px;
            padding: 10px 18px;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav a i {
            font-size: 16px;
        }

        .nav a:hover {
            background-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="nav">

        <!-- ICON + TITLE -->
        <div class="logo-title">
            <i class="fa-solid fa-shield-halved"></i>
            <div class="title">Crime </div>
        </div>

        <!-- NAV LINKS -->
        <div class="right">
            <a href="index.php">
                <i class="fa-solid fa-house"></i> Home
            </a>
            <a href="admin_login.php">
                <i class="fa-solid fa-user-shield"></i> Admin
            </a>
            <a href="police_login.php">
                <i class="fa-solid fa-user-tie"></i> Police
            </a>
            <a href="public_login.php">
                <i class="fa-solid fa-users"></i> Public
            </a>
        </div>

    </div>

</body>
</html>
