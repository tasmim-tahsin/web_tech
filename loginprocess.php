<?php
session_start();

if (isset($_POST["login"])) {
    include './DB/database.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Look for user by email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            // Password matches
            $_SESSION['user_id'] = $user['u_id'];
            $_SESSION['fname'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            // print_r($_SESSION);

            // echo "Login successful!";
            // After successful login:
            $sql = "SELECT profile_photo FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['profile_photo'] = $row['profile_photo'];
            }

            echo $_SESSION['user_id'];
            header("Location: selectcities.php"); // Change as needed
        } else {
            // Password does not match
            echo "Incorrect password!";
            header("refresh: 2; url = index.html");
        }
    } else {
        // Email not found
        echo "Email not found!";
        header("refresh: 2; url = index.html");
    }

    mysqli_close($conn);
}
?>
