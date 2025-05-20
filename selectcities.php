<?php
session_start();
$token = "";
$token2 = "";
if (isset($_SESSION['fname'])){
    echo "Login Successfully!";
    $token ="signout.php";
    $token2= "Sign Out";
    // print_r($_SESSION);
}
// else if (isset($_SESSION['user_id']])){
//     echo "Login Successfully!";
//     print_r($_SESSION);
// }
else{
    http_response_code(403);
    echo "Access Denied. You must login first.";
    echo $_SESSION['user_id'];
    header("refresh: 2; url = index.html");
    exit;
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Successfully</title>
</head>
<body>

<p style="text-align:left">
<?php
      if (isset($_SESSION["uname"])) {
            echo "Username: "."<b style=\"color:red\">".$_SESSION["uname"]."</b><br>";
            
      }
?>
</p>
<br>
<a href="index.html">Home</a>
<a href=<?php echo $token; ?>><?php echo $token2; ?></a> 
    
</body>
</html>