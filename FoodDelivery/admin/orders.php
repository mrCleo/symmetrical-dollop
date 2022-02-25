
<?php 
echo "<a href='index.php'> Go back</a><br>";


$con = mysqli_connect("localhost", "root", "", "food-order");
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno());
}
$query = $con->prepare("SELECT finalorder.orderKey, user.Username, user.Address1, finalorder.restaurant, finalorder.totalPrice, finalorder.orderComments, finalorder.status 
FROM finalorder INNER JOIN user on finalorder.UserID = user.UserID");
$query->store_result();
$query->bind_result($orderkey,$username, $address, $restaurant, $price, $comments, $status);
$res = $query->execute();
echo "<table align='center' border='2'><tr>";
echo "<th>Key</th><th>Username</th><th>Address</th><th>Restaurant</th><th>Price</th><th>Comments</th><th>Status</th></tr>";
while($query->fetch())
{
    //do something
    echo "<tr><td>". "<a href='specificorders.php?operation=get&id=".$orderkey."'>".$orderkey."</a>" . "<td>". $username . "<td>". $address . "<td>". $restaurant . "<td>". $price . "<td>". $comments . "<td>". "<a href='updatestatusform.php?operation=update&id=".$orderkey."'>".$status."</a>" . "<td>"."<a href='delete-order.php?operation=delet&id=".$orderkey."'>delete</a></tr></td>";
}
echo "</table>";
?>