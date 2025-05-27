<?php
//
if (session_status() >= 0) {

session_start();

session_unset();

session_destroy();
setcookie("bgcolor", "", time() - 3600);
setcookie('bgcolor', '#ffffff', time() + (30 * 24 * 60 * 60), "/");
echo "You are now  Signed Out";
}

header("refresh: 2; url = index.php");
?>