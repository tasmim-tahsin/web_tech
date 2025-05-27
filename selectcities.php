<?php
session_start();
$token = "";
$token2 = "";

if (isset($_SESSION['fname'])) {
    $token = "signout.php";
    $token2 = "⏻ Sign Out";
} else {
    http_response_code(403);
    echo "Access Denied. You must login first.";
    header("refresh: 2; url = index.php");
    exit;
}

include './DB/database.php';

// Fetch 20 cities from DB (with country and AQI)
$cities = [];
$sql = "SELECT id, city_name, country FROM cities LIMIT 20";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cities[] = $row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Cities</title>
    <link rel="stylesheet" href="./css/selectcities.css">
    <style>
        body{
            margin: 0;
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
            <li><a  href="./index.php">Home</a></li>
            <li><a class="active" href="./selectcities.php">Select Cities</a></li>
            <li><a href="./savecities.php">Save Cities</a></li>
            <li><a href="./admin.php">Admin Login</a></li>
        </ul>
<div>


    <p style="text-align:center">
    
<?php
    echo '<div style="align: middle; margin-top:100px; margin-bottom:10px">';

    if (isset($_SESSION['profile_photo']) && file_exists($_SESSION['profile_photo'])) {
    echo "<img src='{$_SESSION['profile_photo']}' alt='Profile Photo' style='width:80px; height:80px; border:2px solid green; border-radius:100%; vertical-align:middle;'>";
    } else {
        echo '<div>
            <img src="./images/cat.png" alt="Default Cat" width="70px">
          </div>';
    }


    echo '</div>';
    if (isset($_SESSION["fname"])) {
        echo "Username: <b style=\"color:green\">" . $_SESSION["fname"] . "</b><br>";
    }
    
?>
</p>

</div>

<div class="container">
    <div class="btndiv">
    <button class="btn3" type="button">
        <a href="../web_tech/" style="text-decoration:none; color:white;">🏠︎ Go to Home</a>
    </button>
    <button class="btn2" type="button" name="edit">
        <a href="../web_tech/editinfo.php" style="text-decoration:none; color:white;">✎ Edit Profile</a>
    </button>
    <button class="btn1">
        <a style="text-decoration:none; color:white;" href="<?php echo $token; ?>">
            <?php echo $token2; ?>
        </a>
    </button>
    </div>

    <form action="savecities.php" method="post" class="form">
    <h3>Select Your Preferred Cities:</h3>
    <div class="cities-list">
        <?php foreach ($cities as $city): ?>
            <div class="city-item">
                <label>
                    <input type="checkbox" name="cities[]" value="<?php echo $city['id']; ?>">
                    <b><?php echo $city['city_name']; ?></b> (<?php echo $city['country']; ?>)
                    </span>
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <br>
    <input type="submit" value="Show AQI" class="btn2">
</form>
</div>

<!-- City Selection Form -->


<br>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="cities[]"]');
    const max = 10;

    checkboxes.forEach(cb => {
        cb.addEventListener("change", function () {
            let checkedCount = document.querySelectorAll('input[type="checkbox"][name="cities[]"]:checked').length;
            if (checkedCount > max) {
                alert("You can only select up to 10 cities.");
                this.checked = false;
            }
        });
    });
});
</script>

</body>
</html>
