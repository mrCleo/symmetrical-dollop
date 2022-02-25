<?php
session_start();
$db_host="localhost";
$db_user="root";
$db_pwd="";
$db_name="food-order";

$conn = new mysqli($db_host,$db_user,$db_pwd,$db_name);
?>

<?php
session_start();
header("location:login.php");
$stmt=$conn->prepare("DELETE FROM user WHERE userID=?");
$stmt->bind_param("i",$_SESSION["UserID"]);
$stmt->execute();
session_destroy();
?>