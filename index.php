<?php
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Crime Data Identification & Reporting</title>

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body{
            height: 100vh;
            background: linear-gradient(
                        rgba(225,225,225,0.5),
                        rgba(225,225,225,0.5)
                      ),
                      url('images/1.jpg') no-repeat center center/cover;
           
            align-items: center;
            justify-content: center;
            color: #0d3b66;
        }

        .hero-container{
            text-align: center;
            max-width: 900px;
            padding: 50px;
            background: rgba(225, 225, 225, 0.5);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            margin:50px auto;
        }

        .hero-container h1{
            font-size: 36px;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 20px;
            letter-spacing: 1px;
            text-transform:uppercase;
        }

        .hero-container p{
            font-size: 18px;
            line-height: 1.7;
            color: #0d3b66;
            font-weight:600;
        }

        @media (max-width: 768px){
            .hero-container{
                padding: 30px;
            }
            .hero-container h1{
                font-size: 26px;
            }
            .hero-container p{
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <div class="hero-container">
        <h1>A Web-Based Platform for E-Crime Data Identification and Reporting</h1>
        <p>
            A secure and intelligent digital platform designed to identify, report,
            and manage e-crime data efficiently. The system enhances communication
            between citizens and law enforcement while ensuring transparency,
            reliability, and data integrity.
        </p>
    </div>

</body>
</html>
