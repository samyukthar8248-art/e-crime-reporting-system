<?php
ob_start();
include 'config.php';
include 'police_navbar.php'; // navbar for police module

// Only logged-in police can access
if(!isset($_SESSION['police_id'])){
    header("Location: police_login.php");
    exit();
}

// Fetch all complaints
$sql = "SELECT c.complaint_id, c.date, c.place, c.subject, c.complaint_text, c.image, c.status, p.username
        FROM complaint c
        JOIN public_user p ON c.public_id = p.public_id
        ORDER BY c.date DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Complaints</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-image:url('images/6.jpg');
            background-size:cover;
            color: #333;
        }

        /* Container for heading + table */
        .container {
            width: 95%;
            max-width: 1200px;
            margin: 30px auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #0d3b66;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 10px;
            border: 1px solid #ccc;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #0d3b66;
            color: #fff;
            font-weight: 600;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        tr:hover td {
            background-color: #e8f0fe;
        }

        img {
            max-width: 100px;
            max-height: 80px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        /* Status colors */
        td.status-open {
            color: #e67e22;
            font-weight: bold;
        }

        td.status-closed {
            color: #27ae60;
            font-weight: bold;
        }

        /* Responsive */
        @media(max-width: 768px){
            table, th, td {
                font-size: 14px;
            }
            img {
                max-width: 70px;
                max-height: 60px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>All Complaints</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Complainant</th>
                <th>Date</th>
                <th>Place</th>
                <th>Subject</th>
                <th>Complaint</th>
                <th>Image</th>
                <th>Status</th>
            </tr>

            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['complaint_id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['place']; ?></td>
                        <td><?php echo $row['subject']; ?></td>
                        <td><?php echo $row['complaint_text']; ?></td>
                        <td>
                            <?php if($row['image'] != ''): ?>
                                <img src="uploads/<?php echo $row['image']; ?>" alt="Complaint Image">
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td class="<?php echo strtolower($row['status']); ?>">
                            <?php echo $row['status']; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align:center;">No complaints found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
