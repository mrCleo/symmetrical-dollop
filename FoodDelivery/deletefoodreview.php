<?php
/*
session_start();
$id = $_GET['id'];
$userid = $_SESSION['UserID'];
$con = mysqli_connect("localhost", "root", "", "food-order");
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno());
}
$query=$con->prepare("DELETE FROM review_food WHERE ReviewFoodID=? AND UserID=?");
$query->bind_param('ii', $id, $userid); 
if ($query->execute()){
    echo "Success";
}
*/
session_start();

if(isset($_GET['id'])){
    $review_id = strip_tags($_GET['id']);
}

//$id = $_GET['id'];
$hashAlgo="sha256";
$token = hash($hashAlgo,uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
$_SESSION['token_time'] = time(); 
$con = mysqli_connect("localhost", "root", "", "food-order");
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno());
}
$query=$con->prepare("SELECT UserID FROM review_food WHERE ReviewFoodID=?");
$query->bind_param("i", $review_id);
if($query->execute()){
$query->store_result();
$query->bind_result($userid);
}
while ($query->fetch()){
echo "<form action='deleteconfirmation.php' method='post'><br>";
echo "Are you sure you want to delete this review?<br>";
echo "<input type='hidden' name='id' value='".$review_id."'>";
echo "<input type='hidden' name='userid' value=".$userid.">";
echo "<input type ='hidden' name='token' value=".$token." /> ";
echo "<input type='submit' value='Delete'>";
echo "</form>";
}
?>