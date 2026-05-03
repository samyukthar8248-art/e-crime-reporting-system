<?php
ob_start();
include 'config.php';
include 'public_navbar.php';

if(!isset($_SESSION['public_id'])){
    header("Location: public_login.php");
    exit();
}

$public_id = $_SESSION['public_id'];

/* Fetch ONLY CLOSED complaints */
$cq = mysqli_query($conn,
    "SELECT * FROM complaint WHERE public_id='$public_id' AND status='Closed' ORDER BY date DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Closed Complaints & Criminals</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-image: url('images/1.jpg');
    background-size: cover;
    margin: 0;
    padding: 0;
    color: #333;
    height:  100vh;
    
}

.container {
    max-width: 1000px;
    background-color: rgba(255, 255, 255, 0.95);
    margin: 30px auto;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

h2, h3 {
    color: #0d3b66;
    margin-top: 20px;
    margin-bottom: 20px;
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #0d3b66;
    color: #fff;
    font-weight: 600;
}

tr:hover {
    background-color: #f1f1f1;
}

img {
    width: 120px;
    border-radius: 6px;
    object-fit: cover;
}

.closed {
    color: green;
    font-weight: bold;
}

button.view-more {
    display: block;
    margin: 10px auto 20px;
    padding: 8px 16px;
    background: #0d3b66;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

button.view-more:hover {
    background: #092c4a;
}

.details-section {
    display: none;
    margin-top: 10px;
}

hr {
    border: 0;
    border-top: 2px dashed #ccc;
    margin: 30px 0;
}

@media(max-width: 768px){
    table, th, td {
        font-size: 14px;
    }
    img {
        width: 80px;
    }
}

@media(max-width: 480px){
    .container {
        padding: 15px 20px;
    }
    table {
        font-size: 13px;
    }
    img {
        width: 60px;
    }
}
</style>
<script>
function toggleDetails(id){
    const div = document.getElementById('details-' + id);
    if(div.style.display === 'none' || div.style.display === ''){
        div.style.display = 'block';
    } else {
        div.style.display = 'none';
    }
}
</script>
</head>
<body>

<?php if(mysqli_num_rows($cq) == 0){ ?>
    <p>No closed complaints found.</p>
<?php } else { 
    while($complaint = mysqli_fetch_assoc($cq)) { 
        $complaint_id = $complaint['complaint_id'];
?>
<div class="container">
<h2>My Closed Complaints</h2>

<!-- Complaint Table -->
<h3>Complaint Details</h3>
<table>
    <tr><th>Complaint ID</th><td><?= $complaint['complaint_id']; ?></td></tr>
    <tr><th>Subject</th><td><?= $complaint['subject']; ?></td></tr>
    <tr><th>Place</th><td><?= $complaint['place']; ?></td></tr>
    <tr><th>Date</th><td><?= $complaint['date']; ?></td></tr>
    <tr><th>Status</th><td class="closed"><?= $complaint['status']; ?></td></tr>
    <tr><th>Description</th><td><?= $complaint['complaint_text']; ?></td></tr>
    <tr><th>Image</th>
        <td>
            <?php if($complaint['image']){ ?>
                <img src="uploads/<?= $complaint['image']; ?>" alt="Complaint Image">
            <?php } else { echo "No Image"; } ?>
        </td>
    </tr>
</table>

<!-- View More Button -->
<button class="view-more" onclick="toggleDetails(<?= $complaint_id; ?>)">View More Details</button>

<!-- FIR & Criminal Details -->
<div class="details-section" id="details-<?= $complaint_id; ?>">

    <!-- FIR Details -->
    <?php
    $fir_q = mysqli_query($conn, "SELECT * FROM fir WHERE complaint_id='$complaint_id'");
    if(mysqli_num_rows($fir_q) > 0){
        $fir = mysqli_fetch_assoc($fir_q);
    ?>
    <h3>FIR Details</h3>
    <table>
        <tr><th>FIR No</th><td><?= $fir['fir_no']; ?></td></tr>
        <tr><th>Date</th><td><?= $fir['date']; ?></td></tr>
        <tr><th>Act</th><td><?= $fir['act']; ?></td></tr>
        <tr><th>Section</th><td><?= $fir['section']; ?></td></tr>
        <tr><th>Occurrence Details</th><td><?= $fir['occurrence_details']; ?></td></tr>
        <tr><th>Suspect Details</th><td><?= $fir['suspect_details']; ?></td></tr>
    </table>
    <?php } else { ?>
        <p><b>FIR not registered yet.</b></p>
    <?php } ?>

    <!-- Criminal Details -->
    <?php 
    $criminal_q = mysqli_query($conn, "SELECT * FROM criminals WHERE complaint_id='$complaint_id'");
    if(mysqli_num_rows($criminal_q) > 0){ ?>
        <h3>Criminal Details</h3>
        <table>
            <tr>
                <th>Name</th><th>Age</th><th>Gender</th><th>Address</th><th>Crime</th><th>Image</th>
            </tr>
            <?php while($cr = mysqli_fetch_assoc($criminal_q)){ ?>
            <tr>
                <td><?= $cr['name']; ?></td>
                <td><?= $cr['age']; ?></td>
                <td><?= $cr['gender']; ?></td>
                <td><?= $cr['address']; ?></td>
                <td><?= $cr['crime']; ?></td>
                <td>
                    <?php if($cr['image']){ ?>
                        <img src="uploads/<?= $cr['image']; ?>" alt="Criminal Image">
                    <?php } else { echo "No Image"; } ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No criminal details available.</p>
    <?php } ?>

</div> <!-- End of details-section -->

</div>
<hr>
<?php } } ?>

</body>
</html>
