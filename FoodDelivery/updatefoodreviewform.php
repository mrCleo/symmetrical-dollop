<html>
<head>
</head>
<body>
<?php 
session_start(); 
$hashAlgo="sha256";
$token = hash($hashAlgo,uniqid(rand(), TRUE)); 
$_SESSION['token'] = $token; 
$_SESSION['token_time'] = time(); 
?> 
<?php 
if(isset($_GET['id'])){
    $review_id = strip_tags($_GET['id']);
}
?>
<?php 
session_start();
$id = $_GET['id'];
$con = mysqli_connect("localhost", "root", "", "food-order");
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno());
}
$query=$con->prepare("SELECT UserID FROM review_food WHERE ReviewFoodID=?");
$query->bind_param("i", $id);
$res = $query->execute();
$query->store_result();
$query->bind_result($userid);
$query -> fetch();

?>
<form action="updatefoodreview.php" method="post">
  <label for="comment">Comment:</label><br>
  <input type="text" id="comment" name="comment" value=""><br>
  <label for="rating">Rating/10:</label><br>
  <input type="text" id="rating" name="rating" value=""><br>
  <input type="hidden" id="timestamp" name="timestamp" value="<?php echo date('m-d-Y'); ?>"><br>
  <input type="hidden" id="reviewid" name="reviewid" value="<?php echo $review_id; ?>"><br>
  <input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>"><br>
  <input type ="hidden" name="token" value="<?php echo $token; ?>" /> 
  <input type="submit" value="Update">
</form> 
</body>
</html>