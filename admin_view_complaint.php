<?php
ob_start();
include 'config.php';
include 'admin_navbar.php';

// Fetch filter parameter
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Build query based on filter
$query = "SELECT * FROM complaint WHERE 1=1";

if($status_filter != '') {
    $query .= " AND status='$status_filter'";
}

$query .= " ORDER BY date DESC";

$complaints = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Complaints - Admin</title>
<style>
body { margin: 0; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f8; color: #333; }
h2 { text-align: center; margin: 20px 0 20px; color: #0d3b66; font-size: 28px; }

/* Filter Form */
.filter-form {
    max-width: 1000px;
    margin: 0 auto 20px;
    display: flex;
    justify-content: flex-start;
    gap: 10px;
}
.filter-form select {
    padding: 8px 10px;
    font-size: 14px;
    border-radius: 6px;
    border: 1px solid #ccc;
}
.filter-form button {
    padding: 8px 16px;
    background: #0d3b66;
    color: #fff;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: bold;
}
.filter-form button:hover { background: #092c4a; }

/* Complaint Card */
.complaint-card { background: #fff; margin: 20px auto; padding: 20px 25px; border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,0.12); max-width: 1000px; }
table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
th, td { padding: 10px 12px; text-align: left; }
th { background-color: #0d3b66; color: #fff; border-radius: 6px 6px 0 0; }
td { background: #fdfdfd; border-bottom: 1px solid #e0e0e0; }
tr:last-child td { border-bottom: none; }
img { width: 80px; height: auto; border-radius: 6px; border: 1px solid #ccc; }
.status-open { color: #e67e22; font-weight: bold; }
.status-closed { color: #27ae60; font-weight: bold; }
.info-text { color: #555; font-style: italic; margin: 10px 0; }

.btn-view { display: inline-block; padding: 8px 16px; background: #0d3b66; color: #fff; border-radius: 6px; cursor: pointer; margin-top: 10px; border: none; }
.btn-view:hover { background: #092c4a; }
.details-section { display: none; margin-top: 15px; }
</style>
<script>
function toggleDetails(id) {
    const details = document.getElementById('details-' + id);
    details.style.display = (details.style.display === 'block') ? 'none' : 'block';
}
</script>
</head>
<body>

<h2>All Complaints</h2>

<!-- Status Filter -->
<form class="filter-form" method="GET">
    <select name="status">
        <option value="">-- Select Status --</option>
        <option value="Pending" <?= $status_filter=='Pending'?'selected':'' ?>>Pending</option>
        <option value="FIR Registered" <?= $status_filter=='FIR Registered'?'selected':'' ?>>FIR Registered</option>
        <option value="Closed" <?= $status_filter=='Closed'?'selected':'' ?>>Closed</option>
    </select>
    <button type="submit">Filter</button>
</form>

<?php while($row = mysqli_fetch_assoc($complaints)){
    $complaint_id = $row['complaint_id'];
?>

<div class="complaint-card">
    <table>
        <tr><th>Complaint ID</th><td><?= $row['complaint_id']; ?></td></tr>
        <tr><th>Public ID</th><td><?= $row['public_id']; ?></td></tr>
        <tr><th>Date</th><td><?= $row['date']; ?></td></tr>
        <tr><th>Place</th><td><?= $row['place']; ?></td></tr>
        <tr><th>Subject</th><td><?= $row['subject']; ?></td></tr>
        <tr><th>Complaint Text</th><td><?= $row['complaint_text']; ?></td></tr>
        <tr><th>Status</th>
            <td class="<?= ($row['status']=='Closed')?'status-closed':'status-open'; ?>">
                <?= $row['status']; ?>
            </td>
        </tr>
    </table>

    <button class="btn-view" onclick="toggleDetails(<?= $complaint_id; ?>)">View More</button>

    <div class="details-section" id="details-<?= $complaint_id; ?>">
        <?php
        $fir_q = mysqli_query($conn,"SELECT * FROM fir WHERE complaint_id='$complaint_id'");
        if(mysqli_num_rows($fir_q) > 0){
            $fir = mysqli_fetch_assoc($fir_q);
        ?>
            <div><b>FIR No:</b> <?= $fir['fir_no']; ?> | <b>Date:</b> <?= $fir['date']; ?> | <b>Act:</b> <?= $fir['act']; ?> | <b>Section:</b> <?= $fir['section']; ?></div>
            <div><b>Occurrence:</b> <?= $fir['occurrence_details']; ?> | <b>Suspect:</b> <?= $fir['suspect_details']; ?></div>
        <?php } else { ?>
            <p class="info-text"><b>No FIR registered yet.</b></p>
        <?php } ?>

        <?php
        if($row['status']=='Closed'){
            $criminal_q = mysqli_query($conn,"SELECT * FROM criminals WHERE complaint_id='$complaint_id'");
            if(mysqli_num_rows($criminal_q) > 0){
                while($cr = mysqli_fetch_assoc($criminal_q)){ ?>
                    <div><b>Criminal:</b> <?= $cr['name']; ?>, Age: <?= $cr['age']; ?>, Gender: <?= $cr['gender']; ?>, Crime: <?= $cr['crime']; ?></div>
                <?php }
            } else { ?>
                <p class="info-text">No criminal details found yet.</p>
            <?php }
        } ?>
    </div>
</div>

<?php } ?>

</body>
</html>
