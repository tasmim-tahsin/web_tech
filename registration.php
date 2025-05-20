
<?php

  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = htmlspecialchars($_POST['username']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']); // You should not display password in real use
  $location = htmlspecialchars($_POST['location']);
  $zip = htmlspecialchars($_POST['zip']);
  $cities = $_POST['pcities'];
  $color = htmlspecialchars($_POST['color']);
  $hash= password_hash($password, PASSWORD_DEFAULT);

        session_start();
        $_SESSION['fname'] = $fullname;
        $_SESSION['email'] = $email;
        $_SESSION['pass'] = $hash;
        $_SESSION['loc'] = $location;
        $_SESSION['cities'] = $cities;
        $_SESSION['color'] = $color;
        $_SESSION['zipcode'] = $zip;
}
 else{
    http_response_code(403);
    echo "<h3>Access Denied. You must submit the Registration form first.</h3>";
    // header("refresh: 0; url = errorpage.html");
    header("Location: errorpage.html");
    exit;
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Confirm your registration</title>
  <link rel="stylesheet" href="./css/registration.css">
</head>
<body>

  <h1>Information</h1>
  <div class="info">
    <p><strong>Full Name:</strong> <?php echo $fullname; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <p><strong>Password:</strong> <?php echo $hash; ?></p>
    <p><strong>Location:</strong> <?php echo $location; ?></p>
    <p><strong>Zip:</strong> <?php echo $zip; ?></p>
    <p><strong>Color:</strong> <?php echo $color; ?></p>
    <p><strong>Preferred Cities:</strong> <?php echo implode(", ", $cities); ?></p>
  </div>
  <div class="btndiv">
    <button class="btn2" type="button"><a href="../web_tech/" style="text-decoration:none; color:white;">Go to Home</a></button>
    <form action="registration_process.php" method="post">
      <input class="btn1" id="confirm" type="submit" name="confirm" value= "Confirm"></input>
    </form>
  </div>

</body>
</html>
