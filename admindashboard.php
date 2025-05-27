<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin.php');
    exit;
}
include './DB/database.php';
$feedback="";

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    if ($_POST["action"] == "add" && isset($_POST["city"], $_POST["country"], $_POST["aqi"])) {
        $city = $_POST["city"];
        $country = $_POST["country"];
        $aqi = $_POST["aqi"];
        mysqli_query($conn, "INSERT INTO cities (city_name, country, aqi) VALUES ('$city', '$country', $aqi)");
        $feedback="City added successfully!";
    } elseif ($_POST["action"] == "update" && isset($_POST["id"], $_POST["city"], $_POST["country"], $_POST["aqi"])) {
        $id = $_POST["id"];
        $city = $_POST["city"];
        $country = $_POST["country"];
        $aqi = $_POST["aqi"];
        mysqli_query($conn, "UPDATE cities SET city_name='$city', country='$country', aqi=$aqi WHERE id=$id");
        $feedback="City updated successfully!";
    } elseif ($_POST["action"] == "delete" && isset($_POST["id"])) {
        $id = $_POST["id"];
        mysqli_query($conn, "DELETE FROM cities WHERE id=$id");
        $feedback="City removed successfully!";
    }
}

$cities = mysqli_query($conn, "SELECT * FROM cities");
$totalCities = mysqli_num_rows($cities);
$users = mysqli_query($conn, "SELECT * FROM users");
$totalUsers = mysqli_num_rows($users);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 20px;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6ff;
        }
        h2 {
            color: #333;
        }
        .btn-group button {
            margin-right: 10px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-group button:hover {
            background-color: #0056b3;
        }
        .section {
            display: none;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        form input[type="text"], form input[type="number"] {
            padding: 5px;
            margin-right: 10px;
        }
        form input[type="submit"] {
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <h2>Welcome, Admin</h2>

    <div class="btn-group">
        <button onclick="toggleSection('manage')">Manage Cities</button>
        <button onclick="toggleSection('cities')">Show Cities</button>
        <button onclick="toggleSection('users')">Show Users</button>
        <button class="btn1" style="background-color:red; color:white;">
        <a style="text-decoration:none; color:white;" href="./signout.php">
            Signout
        </a>
    </button>
    </div>

    <?php if (!empty($feedback)): ?>
    <div id="feedbackMessage" style="padding: 10px; background-color: #e0ffe0; color: green; border: 1px solid green; border-radius: 5px; margin-top:10px; width:20%;">
    <?php echo $feedback; ?>
    <?php endif; ?>

    </div>

    <div id="manage" class="section">
        <h3>Add City</h3>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="country" placeholder="Country" required>
            <input type="number" name="aqi" placeholder="AQI" required>
            <input type="submit" value="Add">
        </form>

        <h3>Update City</h3>
        <form method="POST">
            <input type="hidden" name="action" value="update">
            <input type="number" name="id" placeholder="City ID" required>
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="country" placeholder="Country" required>
            <input type="number" name="aqi" placeholder="AQI" required>
            <input type="submit" value="Update">
        </form>

        <h3>Delete City</h3>
        <form method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="number" name="id" placeholder="City ID" required>
            <input type="submit" value="Delete">
        </form>
    </div>

    <div id="cities" class="section">
        <h3>Total Cities: <?php echo $totalCities?></h3>
        <table>
            <tr>
                <th>ID</th>
                <th>City</th>
                <th>Country</th>
                <th>AQI</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($cities)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['city_name'] ?></td>
                <td><?= $row['country'] ?></td>
                <td><?= $row['aqi'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div id="users" class="section">
        <h3>Total Registered User: <?php echo $totalUsers?></h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Location</th>
                <th>Zip</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($users)): ?>
            <tr>
                <td><?= $row['u_id'] ?></td>
                <td><?= $row['full_name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['location'] ?></td>
                <td><?= $row['zip'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <script>
        function toggleSection(sectionId) {
            document.querySelectorAll('.section').forEach(sec => sec.style.display = 'none');
            document.getElementById(sectionId).style.display = 'block';
        }
        setTimeout(function () {
        var message = document.getElementById('feedbackMessage');
        if (message) {
            message.style.display = 'none';
            
        }
        }, 3000);
    </script>
</body>
</html>
