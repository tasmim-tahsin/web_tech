<?php
session_start();
include './DB/database.php';

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    echo "Unauthorized access.";
    header("refresh: 0; url=errorpage.html");
    exit;
}

$email = $_SESSION['email'];
$updateMsg = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update password
    if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        $pass = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];

        if ($pass === $confirm) {
            $hashed = password_hash($pass, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password='$hashed' WHERE email='$email'";
            mysqli_query($conn, $query);
            $updateMsg .= "Password updated successfully.<br>";
        } else {
            $updateMsg .= "Passwords do not match.<br>";
        }
    }

    // Upload profile photo and store in session
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        $target_dir = "uploads/profile_pics/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $filename = basename($_FILES["profile_photo"]["name"]);
        $target_file = $target_dir . time() . "_" . $filename;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                // Save path in session for immediate use
                $_SESSION['profile_photo'] = $target_file;

    // Also update the database with this path
                $updatePhotoQuery = "UPDATE users SET profile_photo='$target_file' WHERE email='$email'";
                mysqli_query($conn, $updatePhotoQuery);

                $updateMsg .= "Profile photo uploaded.<br>";
            }
      else {
                $updateMsg .= "Error uploading the file.<br>";
            }
        } else {
            $updateMsg .= "Only JPG, PNG, JPEG, and GIF are allowed.<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Info</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6ff;
            padding: 30px;
        }
        form {
            background: white;
            padding: 20px;
            width: 400px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px #999;
        }
        h2 {
            text-align: center;
        }
        input[type=password],
        input[type=file] {
            width: 90%;
            padding: 10px;
            margin: 8px 0 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .btndiv {
            margin: 20px auto;
            display: flex;
            justify-content: center;
            /* justify-content: space-around; */
            gap: 20px;
        }

        .btn2 {
            padding: 10px 20px;
            background-color: #e83159;
            color: white;
            border: none;
            border-radius: 5px;
            width:200px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn1 {
            padding: 10px 20px;
            background-color: #6c47ff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }
        .msg {
            text-align: center;
            margin: 10px;
            color: green;
        }
        .preview {
            text-align: center;
            margin-top: 10px;
        }
        .preview img {
            max-width: 150px;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<form action="" method="POST" enctype="multipart/form-data">
    <h2>Update Info</h2>

    <label>New Password</label>
    <input type="password" name="new_password" placeholder="New Password">

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" placeholder="Confirm Password">

    <label>Upload Profile Photo</label>
    <input type="file" name="profile_photo" accept="image/*">
    
    <div class="btndiv">
        <a class="btn1" href="selectcities.php" >⬅ Back</a>
        <button class="btn2" type="submit">
      ↻
       Update</button>
    </div>
    

    <div class="msg"><?php echo $updateMsg; ?></div>

    <div class="preview">
        <?php
        if (isset($_SESSION['profile_photo'])) {
            echo "<p>Current Profile Photo:</p>";
            echo "<img src='{$_SESSION['profile_photo']}' alt='Profile Photo'style='width:100px; height:100px; border-radius:100%; vertical-align:middle;'>";
        }
        ?>
    </div>
</form>

</body>
</html>
