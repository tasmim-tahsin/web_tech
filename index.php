<?php
$bgcolor = isset($_COOKIE['bgcolor']) ? $_COOKIE['bgcolor'] : '#f4f6ff'; // default 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Index</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="./output.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/AQI.css">
    <style>
        body {
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

<body style="background-color: <?= htmlspecialchars($bgcolor) ?>;">

    <header>
        <ul>
            <li><a class="active" href="./index.php">Home</a></li>
            <li><a href="./selectcities.php">Select Cities</a></li>
            <li><a href="./savecities.php">Save Cities</a></li>
            <li><a href="./admin.php">Admin Login</a></li>
        </ul>

        <img style="width: 110px; border-radius: 100%; margin-top: 80px;" src="./images/logo_AQI.jpg"
            alt="Header image">
        <h1>Air Quality Index for Top Cities</h1>
    </header>
    <main>
        <div class="maindiv">
            <div class="leftdiv">
                <div class="box1" id="box1">
                    <h2 id="aqiHeading">AQI of 10 Cities</h2>
                    <p id="registrationError"></p>
                    <div id="aqiContainer"></div>
                </div>
                <div class="box2">
                    <img style="width:100%;border-radius: 10px;" src="./images/index.jpg" alt="" srcset="">
                </div>
            </div>

            <div class="rightdiv">
                <div class="box3">
                    <div class="container">
                        <h1>Registration</h1>
                        <form id="form" action="registration.php" method="POST" onsubmit="return validateInputs()">

                            <div class="input-control">
                                <label for="username">Full name</label>
                                <input id="username" name="username" type="text">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="password">Password</label>
                                <input id="password" name="password" type="password">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="password2">Password again</label>
                                <input id="password2" name="password2" type="password">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="location">Location</label>
                                <input id="location" name="location" type="text">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="zip">Zip Code</label>
                                <input type="number" name="zip" id="zip">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="cities">Preferred Cities</label>
                                <select class="pcities" name="pcities[]" id="pcities" multiple size="5">

                                </select>
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="color">Select Color</label>
                                <input id="color-picker" name="color" type="color">
                                <div class="error"></div>
                            </div>
                            <div>
                                <div class="termsdiv">
                                    <input class="chk" type="checkbox" id="agree" name="agree" value="agree" required>
                                    <p> Agree with our terms and conditions.</p>
                                </div>
                                <div class="error"></div>
                            </div>
                            <div class="btndiv">
                                <input onsubmit="validateInput()" class="submitbtn1" type="submit" name="submit"
                                    value="Sign Up"></input>
                            </div>
                            <div style="text-align: center;">
                                <p>Already have an account? <a href="#login">Login Now</a></p>
                            </div>

                        </form>
                    </div>

                </div>
                <div class="box4">
                    <div id="login">
                        <form action="loginprocess.php" id="" method="post">
                            <h1>Login</h1>
                            <div class="input-control">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" required>
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="password">Password</label>
                                <input id="password" name="password" type="password" required>
                                <div class="error"></div>
                            </div>
                            <div class="btndiv">
                                <input class="submitbtn2" type="submit" name="login" value="Login"></input>
                            </div>
                            <div style="text-align: center;">
                                <p>Forget password? <a href="resetpassword.php">Reset now</a></p>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <script src="./JS/form.js"></script>
    <script src="./JS/aqi.js"></script>
</body>

</html>