<?php
$db_host="localhost";
$db_user="root";
$db_pwd="";
$db_name="food-order";

$conn = new mysqli($db_host,$db_user,$db_pwd,$db_name);
if($conn->connect_errno)
{
    echo "Unable to connect to database :". $conn->connect_error;
}else{
    echo "Connection is successful !";
}

?>
<div>
	<?php
	$FoodID = $_POST["FoodID"];
	$title = $_POST["title"];
	$price = $_POST["price"];
	$image_name = $_POST["image_name"];
	
	$stmt=$conn->prepare("SELECT FoodID, title, price, image_name FROM food WHERE FoodID='" . $_GET["FoodID"] . "'");
	$res=$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($FoodID,$title,$price,$image_name);
	/*$product_array = $db_handle->runQuery("SELECT * FROM food ORDER BY FoodID ASC");*/
	if (!empty($stmt)) { 
	    foreach($stmt as $key=>$value){
	?>
		<div class="product-item">
			<form method="post" action="cart.php<?php echo $stmt[$key]["FoodID"]; ?>">
			<div class="product-image"><img src="<?php echo $stmt[$key]["image_name"]; ?>"></div>
			<div class="product-tile-footer">
			<div class="product-title"><?php echo $stmt[$key]["title"]; ?></div>
			<div class="product-price"><?php echo "$".$stmt[$key]["price"]; ?></div>
			<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
			</div>
			</form>
		</div>
	<?php
		}
	}
	?>
</div>