<?php include('partials-front/menu.php'); ?>
<?php
session_start();
$db_host="localhost";
$db_user="root";
$db_pwd="";
$db_name="food-order";
date_default_timezone_set('Asia/Singapore');
$date = date('m-d-Y h:i:s');

$conn = new mysqli($db_host,$db_user,$db_pwd,$db_name);
if($conn->connect_errno)
{
    echo "Unable to connect to database :". $conn->connect_error;
}
?>
<?php 
$query= $conn->prepare ("SELECT orderKey, restaurant, price, title, date FROM orders WHERE UserID=?");
$query->bind_param("i", $_SESSION['UserID']);
if ($query->execute()){
    $query->store_result();
    $query->bind_result($orderkey, $restaurant,$totalPrice, $title, $date);
    echo "<h2>Your Past Orders</h2>";
    echo "<table align='center' border='1'><tr>";
    echo "<th>OrderID</th><th>Restaurant</th><th>Price</th><th>Food</th><th>Date</th>";
    //while($query->fetch())
    //{
    //  echo "<h2>Reviews for ".$title."</h2>";
    //  break;
    //}
    while($query->fetch()){
       // echo "<table border='1' style='width:800px'>";
        //do something
        echo "<tr><td>". $orderkey . "<td>". $restaurant . "<td>$". $totalPrice .  "<td>".$title."<td>".$date. "</tr></td>";
        
    }
    echo "</table>";
    //echo $_SESSION['UserID'];
}else{
    echo "Error executing query.";
}
?>