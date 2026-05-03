<?php
ob_start();
include 'config.php';
include 'admin_navbar.php'; // Header with Admin, Police, Public

// Only admin can access
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

$msg = '';

// Fetch stations for dropdown
$stations = mysqli_query($conn, "SELECT * FROM station");

if(isset($_POST['submit'])){
    $station_id   = $_POST['station_id'];
    $officer_name = $_POST['officer_name'];
    $dob          = $_POST['dob'];
    $position     = $_POST['position'];
    $contact      = $_POST['contact'];
    $email        = $_POST['email'];
    $address      = $_POST['address'];
    $username     = $_POST['username'];
    $password     = $_POST['password']; // plain text (for now)

    $sql = "INSERT INTO police_officer 
            (station_id, officer_name, dob, position, contact, email, address, username, password)
            VALUES ('$station_id','$officer_name','$dob','$position','$contact','$email','$address','$username','$password')";

    if(mysqli_query($conn, $sql)){
        $msg = "Police Officer added successfully!";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Police Officer</title>

    <style>
        body{
            margin:0;
            font-family: "Segoe UI", Tahoma, sans-serif;
            background-image:url('images/5.jpg');
            background-size:cover;
        }

        /* PAGE CONTAINER */
        .container{
            max-width:900px;
            margin:40px auto;
            background:#ffffff;
            padding:30px 40px;
            border-radius:10px;
            box-shadow:0 10px 25px rgba(0,0,0,0.15);
        }

        h2{
            text-align:center;
            color:#0d3b66;
            margin-bottom:25px;
        }

        /* SUCCESS MESSAGE */
        .msg{
            text-align:center;
            padding:10px;
            background:#e6f7ec;
            color:#1e7e34;
            border-radius:6px;
            margin-bottom:20px;
            font-weight:500;
        }

        /* GRID FORM */
        form{
            display:grid;
            grid-template-columns: repeat(2, 1fr);
            gap:20px;
        }

        .form-group{
            display:flex;
            flex-direction:column;
        }

        /* FULL WIDTH FIELDS */
        .full-width{
            grid-column: 1 / 3;
        }

        label{
            font-weight:600;
            color:#333;
            margin-bottom:6px;
        }

        input, select, textarea{
            padding:10px 12px;
            border:1px solid #ccc;
            border-radius:6px;
            font-size:14px;
            outline:none;
            transition:0.3s;
        }

        input:focus, select:focus, textarea:focus{
            border-color:#0d3b66;
            box-shadow:0 0 5px rgba(13,59,102,0.3);
        }

        textarea{
            resize:none;
        }

        /* SUBMIT BUTTON */
        .btn-submit{
            grid-column: 1 / 3;
            padding:12px;
            background:#0d3b66;
            color:#fff;
            border:none;
            border-radius:6px;
            font-size:16px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        .btn-submit:hover{
            background:#092c4a;
            transform:translateY(-2px);
        }

        /* RESPONSIVE */
        @media(max-width: 768px){
            form{
                grid-template-columns: 1fr;
            }
            .full-width,
            .btn-submit{
                grid-column: 1;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Add Police Officer</h2>

    <?php if($msg != ''){ echo "<div class='msg'>$msg</div>"; } ?>

    <form method="POST">

        <div class="form-group">
            <label>Station</label>
            <select name="station_id" required>
                <option value="">Select Station</option>
                <?php while($row = mysqli_fetch_assoc($stations)){ ?>
                    <option value="<?php echo $row['station_id']; ?>">
                        <?php echo $row['station_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Officer Name</label>
            <input type="text" name="officer_name" required>
        </div>

        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="dob">
        </div>

        <div class="form-group">
            <label>Position</label>
            <input type="text" name="position" required>
        </div>

        <div class="form-group">
            <label>Contact</label>
            <input type="text" name="contact">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email">
        </div>

        <div class="form-group full-width">
            <label>Address</label>
            <textarea name="address" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="text" name="password" required>
        </div>

        <input type="submit" name="submit" value="Add Officer" class="btn-submit">

    </form>
</div>

</body>
</html>
