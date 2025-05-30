<?php
include './DB/database.php';

$resetMsg = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $newPass = $_POST['new_password'];
    $confirmPass = $_POST['confirm_password'];

    if (!empty($email) && !empty($newPass) && !empty($confirmPass)) {
        if ($newPass === $confirmPass) {
            // Check if the user exists
            $checkQuery = "SELECT * FROM users WHERE email = ?";
            $stmt = mysqli_prepare($conn, $checkQuery);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $hashedPassword = password_hash($newPass, PASSWORD_DEFAULT);
                $updateQuery = "UPDATE users SET password = ? WHERE email = ?";
                $stmt = mysqli_prepare($conn, $updateQuery);
                mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $email);
                if (mysqli_stmt_execute($stmt)) {
                    $resetMsg = "<span style='color:green;'>Password reset successful!</span>";
                } else {
                    $resetMsg = "<span style='color:red;'>Error updating password.</span>";
                }
            } else {
                $resetMsg = "<span style='color:red;'>No account found with this email.</span>";
            }
        } else {
            $resetMsg = "<span style='color:red;'>Passwords do not match.</span>";
        }
    } else {
        $resetMsg = "<span style='color:red;'>All fields are required.</span>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            background-color: #eef3ff;
            font-family: Arial, sans-serif;
        }
        form {
            width: 400px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px #aaa;
        }
        h2 {
            text-align: center;
        }
        input[type=email],
        input[type=password] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #4c84ec;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #385ec9;
        }
        .msg {
            text-align: center;
            margin-top: 15px;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #4c84ec;
            text-decoration: none;
        }
    </style>
</head>
<body>

<form method="POST" action="">
    <h2>Reset Password</h2>
    <input type="email" name="email" placeholder="Enter your email">
    <input type="password" name="new_password" placeholder="New password">
    <input type="password" name="confirm_password" placeholder="Confirm password">
    <button type="submit" class="btn">Reset Password</button>
    <div class="msg"><?php echo $resetMsg; ?></div>
    <div class="back-link">
        <a href="index.php">Back to Login</a>
    </div>
</form>

</body>
</html>
