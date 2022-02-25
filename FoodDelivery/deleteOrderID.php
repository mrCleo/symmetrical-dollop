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

<?php
$OrderID= $_GET["OrderID"];

$stmt=$conn->prepare("DELETE FROM orders WHERE OrderID=?");
$stmt->bind_param("i",$OrderID);
$res=$stmt->execute();
if($res){
    echo "Delete Successfully";
}else{
    echo "Unable to delete";
}
?>