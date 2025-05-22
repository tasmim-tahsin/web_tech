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
    header("refresh: 2; url = index.html");
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
</head>
<body>
<div>
    <!-- <?php


    ?>
    <div>
        <img src="./images/cat.png" alt="" srcset="" width="70px">
    </div> -->


    <p style="text-align:center">
    
<?php
    echo '<div style="align: middle; margin:10px">';

    if (isset($_SESSION['profile_photo']) && file_exists($_SESSION['profile_photo'])) {
        echo "<img src='{$_SESSION['profile_photo']}' alt='Profile Photo' style='width:80px; height:80px; border:2px solid green; border-radius:100%; vertical-align:middle;  margin-right:10px;'>";
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
