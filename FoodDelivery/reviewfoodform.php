<?php include('partials-front/menu.php'); ?>
<?php 
session_start();
$hashAlgo="sha256";
$token = hash($hashAlgo,uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
$_SESSION['token_time'] = time(); 
?>
<?php 
if(isset($_GET['food_id'])){
    $food_id = strip_tags($_GET['food_id']);
}
?>
<html>
<head></head>
<body>
<form action="addReviewfood.php" method="post">
  <label for="comment">Comment:</label><br>
  <input type="text" id="comment" name="comment" value=""><br>
  <label for="rating">Rating/10:</label><br>
  <input type="text" id="rating" name="rating" value=""><br>
  <input type="hidden" id="foodid" name="foodid" value="<?php echo $food_id; ?>"><br>
  <input type="hidden" id="userid" name="userid" value="<?php echo $_SESSION['UserID']; ?>"><br>
  <input type="hidden" id="timestamp" name="timestamp" value="<?php echo date('m-d-Y'); ?>"><br>
  <input type ="hidden" name="token" value="<?php echo $token; ?>" /> 
  <input type="submit" value="Review">
</form> 
</body>
</html>
