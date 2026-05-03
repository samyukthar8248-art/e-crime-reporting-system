<?php
ob_start();
include 'config.php';
include 'admin_navbar.php';

// Admin access only
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

$msg = "";

/* DELETE LOGIC */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM police_officer WHERE officer_id='$id'");
    $msg = "Police Officer deleted successfully!";
}

/* FETCH DATA FOR EDIT */
$editData = null;
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $res = mysqli_query($conn,"SELECT * FROM police_officer WHERE officer_id='$id'");
    $editData = mysqli_fetch_assoc($res);
}

/* UPDATE LOGIC */
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $officer_name = $_POST['officer_name'];
    $dob = $_POST['dob'];
    $position = $_POST['position'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query($conn,"UPDATE police_officer SET
        officer_name='$officer_name',
        dob='$dob',
        position='$position',
        contact='$contact',
        email='$email',
        address='$address',
        username='$username',
        password='$password'
        WHERE officer_id='$id'
    ");

    header("Location: view_police.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>View Police Officers</title>

<style>
body{
    margin:0;
    font-family:"Segoe UI", Tahoma, sans-serif;
    background:linear-gradient(135deg,#caf0f8,#90dbf4);
}

/* MESSAGE */
.msg{
    text-align:center;
    margin:20px;
    font-weight:600;
    color:#2d6a4f;
}

/* EDIT FORM */
.form-box{
    width:450px;
    margin:25px auto;
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 12px 30px rgba(0,0,0,0.15);
}

.form-box h3{
    text-align:center;
    color:#0d3b66;
    margin-bottom:20px;
}

input, textarea{
    width:95%;
    padding:10px;
    margin-bottom:12px;
    border:1px solid #ccc;
    border-radius:8px;
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
    font-weight:bold;
    cursor:pointer;
    border-radius:8px;
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
}

.edit{ background:#2d6a4f; }
.edit:hover{ background:#1b4332; }

.delete{ background:#d62828; }
.delete:hover{ background:#9b2226; }

@media(max-width:768px){
    .form-box{ width:90%; }
    table{ font-size:12px; }
}
</style>
</head>

<body>

<?php if($msg!=""){ echo "<div class='msg'>$msg</div>"; } ?>

<!-- EDIT FORM -->
<?php if($editData){ ?>
<div class="form-box">
    <h3>Edit Police Officer</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $editData['officer_id']; ?>">
        <input type="text" name="officer_name" value="<?php echo $editData['officer_name']; ?>" required>
        <input type="date" name="dob" value="<?php echo $editData['dob']; ?>">
        <input type="text" name="position" value="<?php echo $editData['position']; ?>" required>
        <input type="text" name="contact" value="<?php echo $editData['contact']; ?>">
        <input type="email" name="email" value="<?php echo $editData['email']; ?>">
        <textarea name="address"><?php echo $editData['address']; ?></textarea>
        <input type="text" name="username" value="<?php echo $editData['username']; ?>" required>
        <input type="text" name="password" value="<?php echo $editData['password']; ?>" required>
        <input type="submit" name="update" value="Update Officer">
    </form>
</div>
<?php } ?>

<!-- VIEW TABLE -->
<table>
<tr>
    <th>ID</th>
    <th>Officer Name</th>
    <th>DOB</th>
    <th>Position</th>
    <th>Contact</th>
    <th>Email</th>
    <th>Address</th>
    <th>Username</th>
    <th>Action</th>
</tr>

<?php
$res = mysqli_query($conn,"SELECT * FROM police_officer");
while($row = mysqli_fetch_assoc($res)){
?>
<tr>
    <td><?php echo $row['officer_id']; ?></td>
    <td><?php echo $row['officer_name']; ?></td>
    <td><?php echo $row['dob']; ?></td>
    <td><?php echo $row['position']; ?></td>
    <td><?php echo $row['contact']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['address']; ?></td>
    <td><?php echo $row['username']; ?></td>
    <td>
        <a class="edit" href="?edit=<?php echo $row['officer_id']; ?>">Edit</a>
        <a class="delete" href="?delete=<?php echo $row['officer_id']; ?>"
           onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
