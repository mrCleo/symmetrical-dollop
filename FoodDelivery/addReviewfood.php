<?php 
session_start();
$user = strip_tags($_POST['userid']);
$food = strip_tags($_POST['foodid']);
$comment = strip_tags($_POST['comment']);
$rating = strip_tags($_POST['rating']);
$timestamp = strip_tags($_POST['timestamp']);
$userlist = array();
$conn = mysqli_connect("localhost", "root", "", "food-order");
if (!$conn){
    die('Could not connect: ' . mysqli_connect_errno());
}
$stmt = $conn->prepare ("SELECT UserID FROM review_food WHERE FoodID=?");
$stmt->bind_param("i",$food);
if ($stmt->execute()){
    $stmt->store_result();
    $stmt->bind_result($userID);
    while ($stmt->fetch()){
        array_push($userlist, $userID);
    }  
}
if ($rating > 10 || $rating < 0){
    echo "Invalid rating";
}
else if (!isset($_SESSION['UserID'])){
    echo "You must be logged in first.";
    echo "<a href='index.php'> Go back to main page </a>";
}
else if (in_array($user,$userlist)){
    echo "Delete your existing review first";
    echo "<a href='index.php'> Go back to main page </a>";
}
else{
$con = mysqli_connect("localhost", "root", "", "food-order");
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno());
}
if (!isset($_SESSION['token']))
{
    $_SESSION['token'] = hash("sha256",uniqid(rand(), TRUE));
}

if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])  //check if token valid
{
    $token_age = time() - $_SESSION['token_time'];   //calculate token age
    if ($token_age <= 300){
$query= $con->prepare ("INSERT INTO review_food (UserID, FoodID, Comment, Rating, Timestamp) VALUES
(?,?,?,?,?)");
$query->bind_param("iisds", $user, $food,$comment, $rating, $timestamp);
if ($query->execute()){
    echo "Your review has been posted.";
    echo "<a href='index.php'> Go back to main page </a>";
}else{
    echo "Error writing the review.";
    echo "<a href='index.php'> Go back to main page </a>";
}
    }
    else{
        echo "Session expired!";
        echo "<a href='index.php'> Go back to main page </a>";
    }
}
}
    
?>