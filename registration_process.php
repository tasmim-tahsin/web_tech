<?php
session_start();

if (isset($_POST["confirm"])) {
    // echo "Submitted";
    //print_r($_SESSION);
    
    include './DB/database.php';

    // Get values from session
    $fullname = $_SESSION['fname'];
    $email = $_SESSION['email'];
    $password = $_SESSION['pass'];
    $location = $_SESSION['loc'];
    $color = $_SESSION['color'];
    $zip = $_SESSION['zipcode'];

    // Check if email already exists
    $checkSql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($result) > 0) {
        echo "Email already registered!";
        header("refresh: 2; url = index.php"); // redirect to signup page or show a message
    } else {
        // Insert into DB
        $sql = "INSERT INTO users (full_name, email, password, location, zip)
                VALUES ('$fullname', '$email', '$password', '$location', '$zip')";

        try {
            mysqli_query($conn, $sql);
            echo "User is now registered";
            setcookie('bgcolor', $color, time() + (30 * 24 * 60 * 60), "/");
            // remove all session variables
            session_unset();

            // destroy the session
            session_destroy();

            header("refresh: 2; url = index.php");
        } catch (mysqli_sql_exception) {
            echo "Could not register user";
        }
    }

    mysqli_close($conn);
}
?>
