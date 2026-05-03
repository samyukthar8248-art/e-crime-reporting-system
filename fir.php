<?php
ob_start();
include 'config.php';
include 'police_navbar.php'; // navbar for police module

if(!isset($_SESSION['police_id'])){
    header("Location: police_login.php");
    exit();
}

$msg = '';

$complaints = mysqli_query($conn, "SELECT * FROM complaint WHERE status='Pending'");

if(isset($_POST['submit'])){
    $complaint_id       = $_POST['complaint_id'];
    $fir_no             = $_POST['fir_no'];
    $date               = $_POST['date'];
    $act                = $_POST['act'];
    $section            = $_POST['section'];
    $occurrence_details = $_POST['occurrence_details'];
    $suspect_details    = $_POST['suspect_details'];

    $sql = "INSERT INTO fir (complaint_id, fir_no, date, act, section, occurrence_details, suspect_details)
            VALUES ('$complaint_id','$fir_no','$date','$act','$section','$occurrence_details','$suspect_details')";

    if(mysqli_query($conn, $sql)){
        mysqli_query($conn, "UPDATE complaint SET status='FIR Registered' WHERE complaint_id='$complaint_id'");
        $msg = "FIR registered successfully!";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register FIR</title>
<style>
body {
    margin: 0;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background-image:url('images/7.jpg');
    background-size: cover;
    color: #333;
}

.container {
    width: 90%;
    max-width: 900px;
    margin: 40px auto;
    background: #fff;
    padding: 30px 35px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

h2 {
    margin-top: 0;
    margin-bottom: 25px;
    color: #0d3b66;
    text-align: center;
}

.msg {
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
}

.msg.success { color: #27ae60; }
.msg.error { color: #e74c3c; }

/* Row and Column Layout */
.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.form-group {
    flex: 1 1 45%;
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    flex: 1 1 100%;
}

label {
    font-weight: 500;
    margin-bottom: 6px;
    color: #092c4a;
}

input[type="text"],
input[type="date"],
select,
textarea {
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    transition: 0.3s;
    width: 100%;
}

input[type="text"]:focus,
input[type="date"]:focus,
select:focus,
textarea:focus {
    border-color: #0d3b66;
    box-shadow: 0 0 6px rgba(13,59,102,0.2);
}

textarea {
    resize: vertical;
}

input[type="submit"] {
    background-color: #0d3b66;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #092c4a;
    transform: translateY(-2px);
}

@media (max-width: 700px) {
    .form-group { flex: 1 1 100%; }
}
</style>
</head>
<body>
<div class="container">
    <h2>Register FIR</h2>

    <?php if($msg != ''): ?>
        <p class="msg <?php echo strpos($msg,'successfully') !== false ? 'success':'error'; ?>">
            <?php echo $msg; ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
                <label>Select Complaint:</label>
                <select name="complaint_id" required>
                    <option value="">Select Complaint</option>
                    <?php while($row = mysqli_fetch_assoc($complaints)) { ?>
                        <option value="<?php echo $row['complaint_id']; ?>">
                            <?php echo $row['subject'] . " - " . $row['place'] . " (" . $row['date'] . ")"; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label>FIR Number:</label>
                <input type="text" name="fir_no" required>
            </div>

            <div class="form-group">
                <label>Date:</label>
                <input type="date" name="date" required>
            </div>

            <div class="form-group">
                <label>Act:</label>
                <input type="text" name="act">
            </div>

            <div class="form-group">
                <label>Section:</label>
                <input type="text" name="section">
            </div>

            <div class="form-group full-width">
                <label>Occurrence Details:</label>
                <textarea name="occurrence_details" rows="4"></textarea>
            </div>

            <div class="form-group full-width">
                <label>Suspect Details:</label>
                <textarea name="suspect_details" rows="4"></textarea>
            </div>
        </div>

        <input type="submit" name="submit" value="Register FIR">
    </form>
</div>
</body>
</html>
