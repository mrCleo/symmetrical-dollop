<?php
session_start();
$id = strip_tags($_POST['id']);
$user = strip_tags($_SESSION['UserID']);
$userid = strip_tags($_POST['userid']);
$privilege = strip_tags($_SESSION['Privilege']);
//$token_age = null;
if (!isset($_SESSION['token']))
{
    $_SESSION['token'] = hash("sha256",uniqid(rand(), TRUE));
}
if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token']){
    $token_age = time() - $_SESSION['token_time'];

if ($token_age <= 300){
$con = mysqli_connect("localhost", "root", "", "food-order");
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno());
}
if ($user == $userid || $privilege == 3){
    $query=$con->prepare("DELETE FROM review_food WHERE ReviewFoodID=?");
    $query->bind_param('i', $id);
    if ($query->execute()){
        echo "Deleted Successfuly";
        echo "<a href='index.php'> Go back to main page </a>";
    }
}
else if ($user != $userid){
    $con -> close();
    echo "This is not yours";
    echo "<a href='index.php'> Go back to main page </a>";
}
}
else{
    echo "Token expired";
}
}

?>