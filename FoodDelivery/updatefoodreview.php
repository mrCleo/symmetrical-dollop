<?php 
session_start();
$comment=strip_tags($_POST['comment']);
$rating=strip_tags($_POST['rating']);
$timestamp=strip_tags($_POST['timestamp']);
$reviewid=strip_tags($_POST['reviewid']);
$userid = strip_tags($_SESSION['UserID']);
$user = strip_tags($_POST['userid']);
if (!isset($_SESSION['token']))
{
    $_SESSION['token'] = hash("sha256",uniqid(rand(), TRUE));
}
if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])  //check if token valid
{
    $token_age = time() - $_SESSION['token_time'];   //calculate token age

    if ($token_age <= 300){
$con = mysqli_connect("localhost", "root", "", "food-order");
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno());
}
if ($userid != $user){
    $con -> close();
    echo "This is not yours!";
    echo "<a href='index.php'> Go back to main page </a>";
}
else{
$query= $con->prepare("UPDATE review_food SET Comment=?, Rating=?, Timestamp=? WHERE ReviewFoodID=? AND UserID=?");
$query -> bind_param('sdsii', $comment, $rating, $timestamp, $reviewid, $userid );
if ($query->execute()){
    echo "Updated successfuly.";
    echo "<a href='index.php'> Go back to main page </a>";
}else{
    echo "Error executing query.";
}
}
    }
    else{
        echo "Token expired.";
        echo "<a href='index.php'> Go back to main page </a>";
    }
}




?>