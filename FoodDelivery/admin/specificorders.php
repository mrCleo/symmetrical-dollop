<?php 
$con = mysqli_connect("localhost", "root", "", "food-order");
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno());
}
$query = $con->prepare("SELECT orders.orderKey,orders.title, orders.price FROM orders WHERE orders.orderKey=?");
$query->bind_param("i", $_GET['id']);
$query->store_result();
$query->bind_result($orderkey,$title,$price);
$res = $query->execute();
echo "<table align='center' border='1'><tr>";
echo "<th>Key</th><th>Food</th><th>Price</th></tr>";
while($query->fetch())
{
    //do something
    echo "<tr><td>". $orderkey . "<td>". $title . "<td>". $price . "</tr></td>";
}
echo "</table>";
?>