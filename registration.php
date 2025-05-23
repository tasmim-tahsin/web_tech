
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
  <!-- <link rel="stylesheet" href="./css/registration.css"> -->
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align:center;
      margin:0;
      
      
    }
#information {
      text-align:left;
      background:rgb(220, 212, 251);
      padding: 15px;
      border-radius: 5px;
      margin-bottom:10px;
      max-width: 50%;
      margin:auto;
    }
.btndiv{
            margin: 20px auto;
            display: flex;
            justify-content: center;

            gap: 10px;
      
    }
    .btn1{
      padding: 10px 20px;
            background-color: #6c47ff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
      
    }
    .btn2{
            padding: 10px 20px;
            background-color: #e83159;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
      
    }
    .btn3{
            padding: 10px 20px;
            background-color: #19be84;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
      
    }
    ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
  position: fixed;
  z-index: 10;
  top: 0px;
  width: 100%;
}

li {
  display: inline-block;
  padding: 10px;
  /* float: right; */
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: #111;
}

.active {
  background-color: #4c84ec;
}
  </style>
</head>
<body>
      <ul>
            <li><a class="active" href="./index.html">Home</a></li>
            <li><a href="./selectcities.php">Select Cities</a></li>
            <li><a href="./savecities.php">Save Cities</a></li>
            <li><a href="./admin.php">Admin Login</a></li>
        </ul>

  <h1>Information</h1>
  <div id="information">
    <p><strong>Full Name:</strong> <?php echo $fullname; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <p><strong>Password:</strong> <?php echo $hash; ?></p>
    <p><strong>Location:</strong> <?php echo $location; ?></p>
    <p><strong>Zip:</strong> <?php echo $zip; ?></p>
    <p><strong>Color:</strong> <?php echo $color; ?></p>
    <p><strong>Preferred Cities:</strong> <?php echo implode(", ", $cities); ?></p>
  </div>
  <div class="btndiv">
    <button class="btn2" type="button"><a href="../web_tech/" style="text-decoration:none; color:white;">Cancel</a></button>
    <form action="registration_process.php" method="post">
      <input class="btn1" id="confirm" type="submit" name="confirm" value= "Confirm"></input>
    </form>
  </div>

</body>
</html>
