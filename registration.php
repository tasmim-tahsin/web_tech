
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = htmlspecialchars($_POST['username']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']); // You should not display password in real use
  $location = htmlspecialchars($_POST['location']);
  $cities = $_POST['pcities'];
  $color = htmlspecialchars($_POST['color']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    .info {
      background: #f5f5f5;
      padding: 15px;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <h1>Welcome, <?php echo $fullname; ?>!</h1>
  <div class="info">
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <p><strong>Location:</strong> <?php echo $location; ?></p>
    <p><strong>Color:</strong> <?php echo $color; ?></p>
    <p><strong>Preferred Cities:</strong> <?php echo implode(", ", $cities); ?></p>
  </div>
  <div>
    <button type="button"><a href="../web_tech/">Confirm</a></button>
  </div>

</body>
</html>
