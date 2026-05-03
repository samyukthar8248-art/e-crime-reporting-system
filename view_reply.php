<?php
ob_start();
include 'config.php';
include 'public_navbar.php';

if(!isset($_SESSION['public_id'])){
    header("Location: user_login.php");
    exit();
}

$public_id = $_SESSION['public_id'];

$cq = mysqli_query($conn, "SELECT * FROM complaint WHERE public_id='$public_id' ORDER BY date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Complaints & FIRs</title>
<style>
body {
    margin: 0;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background-image:url('images/3.jpg');
    background-size:cover;
    color: #333;
    height: 100vh;
}

.container {
    width: 95%;
    max-width: 900px;
    margin: 40px auto;
    padding: 20px 25px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

h2, h3 {
    color: #0d3b66;
    text-align: center;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

th, td {
    border: 1px solid #ccc;
    padding: 10px 12px;
    text-align: left;
}

th {
    background-color: #0d3b66;
    color: white;
    font-weight: 600;
}

td {
    background: #f9f9f9;
}

p {
    text-align: center;
    font-weight: bold;
    color: #0d3b66;
    margin-bottom: 20px;
}

button.toggle-btn {
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

button.toggle-btn:hover {
    background: #092c4a;
}

.fir-details {
    display: none;
    margin-top: 10px;
}

hr {
    border: 0;
    height: 1px;
    background: #ccc;
    margin: 30px 0;
}

@media(max-width: 600px) {
    table, th, td {
        font-size: 14px;
    }
}
</style>
<script>
function toggleFIR(id){
    const div = document.getElementById('fir-' + id);
    if(div.style.display === 'none' || div.style.display === ''){
        div.style.display = 'block';
    } else {
        div.style.display = 'none';
    }
}
</script>
</head>
<body>
<div class="container">
<h2>My Complaints & FIRs</h2>

<?php if(mysqli_num_rows($cq) == 0){ ?>
    <p>No complaints found.</p>
<?php } else { 
    while($complaint = mysqli_fetch_assoc($cq)) { 
        $complaint_id = $complaint['complaint_id'];
?>

<!-- Complaint Table -->
<table>
    <tr><th>Complaint ID</th><td><?php echo $complaint['complaint_id']; ?></td></tr>
    <tr><th>Subject</th><td><?php echo $complaint['subject']; ?></td></tr>
    <tr><th>Place</th><td><?php echo $complaint['place']; ?></td></tr>
    <tr><th>Status</th><td><?php echo $complaint['status']; ?></td></tr>
</table>

<?php
$fir_q = mysqli_query($conn, "SELECT * FROM fir WHERE complaint_id='$complaint_id'");
if(mysqli_num_rows($fir_q) > 0){
    $fir = mysqli_fetch_assoc($fir_q);
?>
    <button class="toggle-btn" onclick="toggleFIR(<?= $complaint_id; ?>)">View FIR Details</button>
    <div class="fir-details" id="fir-<?= $complaint_id; ?>">
        <h3>FIR Reply</h3>
        <table>
            <tr><th>FIR No</th><td><?= $fir['fir_no']; ?></td></tr>
            <tr><th>Date</th><td><?= $fir['date']; ?></td></tr>
            <tr><th>Act</th><td><?= $fir['act']; ?></td></tr>
            <tr><th>Section</th><td><?= $fir['section']; ?></td></tr>
            <tr><th>Occurrence Details</th><td><?= $fir['occurrence_details']; ?></td></tr>
            <tr><th>Suspect Details</th><td><?= $fir['suspect_details']; ?></td></tr>
        </table>
    </div>
<?php } else { ?>
    <p>FIR not registered yet.</p>
<?php } ?>

<hr>
<?php } } ?>
</div>
</body>
</html>
