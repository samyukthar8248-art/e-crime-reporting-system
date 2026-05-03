<?php
ob_start();
include 'config.php';
include 'admin_navbar.php';

// Only admin access
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

$msg = "";

/* DELETE LOGIC */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM station WHERE station_id='$id'");
    $msg = "Station deleted successfully!";
}

/* FETCH DATA FOR EDIT */
$editData = null;
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM station WHERE station_id='$id'");
    $editData = mysqli_fetch_assoc($res);
}

/* UPDATE LOGIC */
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $station_name = $_POST['station_name'];
    $circle = $_POST['circle'];
    $contact = $_POST['contact'];
    $fax = $_POST['fax'];
    $address = $_POST['address'];

    mysqli_query($conn,"UPDATE station SET 
        station_name='$station_name',
        circle='$circle',
        contact='$contact',
        fax='$fax',
        address='$address'
        WHERE station_id='$id'
    ");

    $msg = "Station updated successfully!";
    header("Location: view_station.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Police Stations</title>
    <style>

 
    *{
    box-sizing: border-box;
}

body{
    margin:0;
    font-family: "Segoe UI", Tahoma, sans-serif;
    background: linear-gradient(135deg, #caf0f8, #90dbf4);
}

/* MESSAGE */
.msg{
    text-align:center;
    margin-top:20px;
    font-weight:600;
    color:#2d6a4f;
}

/* EDIT FORM */
.form-box{
    width:420px;
    margin:30px auto;
    background:#ffffff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 12px 30px rgba(0,0,0,0.15);
}

.form-box h3{
    text-align:center;
    margin-bottom:20px;
    color:#0d3b66;
}

input, textarea{
    width:100%;
    padding:10px 12px;
    margin-bottom:14px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:14px;
    outline:none;
}

input:focus, textarea:focus{
    border-color:#0d3b66;
    box-shadow:0 0 5px rgba(13,59,102,0.4);
}

input[type=submit]{
    background:#0d3b66;
    color:white;
    border:none;
    padding:12px;
    font-size:15px;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}

input[type=submit]:hover{
    background:#092c4a;
}

/* TABLE */
table{
    width:96%;
    margin:30px auto;
    border-collapse:collapse;
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

th{
    background:#0d3b66;
    color:white;
    padding:12px;
    font-size:14px;
}

td{
    padding:10px;
    border-bottom:1px solid #eee;
    text-align:center;
    font-size:14px;
}

tr:hover{
    background:#f1f9ff;
}

/* ACTION BUTTONS */
a{
    text-decoration:none;
    padding:6px 12px;
    border-radius:6px;
    color:white;
    font-size:13px;
    transition:0.3s;
}

.edit{
    background:#2d6a4f;
}

.edit:hover{
    background:#1b4332;
}

.delete{
    background:#d62828;
}

.delete:hover{
    background:#9b2226;
}

/* RESPONSIVE */
@media(max-width:768px){
    table{
        font-size:12px;
    }
    .form-box{
        width:90%;
    }
}
</style>
</head>

<body>

<?php if($msg!=""){ echo "<div class='msg'>$msg</div>"; } ?>

<!-- EDIT FORM -->
<?php if($editData){ ?>
<div class="form-box">
    <h3>Edit Police Station</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $editData['station_id']; ?>">
        <input type="text" name="station_name" value="<?php echo $editData['station_name']; ?>" required>
        <input type="text" name="circle" value="<?php echo $editData['circle']; ?>" required>
        <input type="text" name="contact" value="<?php echo $editData['contact']; ?>">
        <input type="text" name="fax" value="<?php echo $editData['fax']; ?>">
        <textarea name="address"><?php echo $editData['address']; ?></textarea>
        <input type="submit" name="update" value="Update Station">
    </form>
</div>
<?php } ?>

<!-- VIEW TABLE -->
<table>
<tr>
    <th>ID</th>
    <th>Station Name</th>
    <th>Circle</th>
    <th>Contact</th>
    <th>Fax</th>
    <th>Address</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn,"SELECT * FROM station");
while($row = mysqli_fetch_assoc($result)){
?>
<tr>
    <td><?php echo $row['station_id']; ?></td>
    <td><?php echo $row['station_name']; ?></td>
    <td><?php echo $row['circle']; ?></td>
    <td><?php echo $row['contact']; ?></td>
    <td><?php echo $row['fax']; ?></td>
    <td><?php echo $row['address']; ?></td>
    <td>
        <a class="edit" href="?edit=<?php echo $row['station_id']; ?>">Edit</a>
        <a class="delete" href="?delete=<?php echo $row['station_id']; ?>" 
           onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
