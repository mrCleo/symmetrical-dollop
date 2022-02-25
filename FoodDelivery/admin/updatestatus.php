<?php 
include('partials/menu.php');
$hasAction = isset($_POST["action"]);
$isDelivered = false;
$isTransit = false;
$isCanceled = false;
$orderkey = $_POST['orderkey'];

//$status = null;
if($hasAction){
    $action = $_POST["action"];
    $isDelivered = $action === "Delivered";
    $isTransit = $action === "Transit";
    $isCanceled = $action === "Canceled";
}
if($isDelivered){
    $status = "Delivered";
}
else if($isTransit){
    $status = "Transit";
}
else if ($isCanceled){
    $status = "Canceled";
}
$con = mysqli_connect("localhost", "root", "", "food-order");
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno());
}
$query= $con->prepare("UPDATE finalorder SET finalorder.status=? WHERE finalorder.orderKey=?");
$query->bind_param('si',$status,$orderkey);
if ($query->execute()){
    echo "Query executed.";
    echo $status;
}else{
    echo "Error executing query.";
}
?>