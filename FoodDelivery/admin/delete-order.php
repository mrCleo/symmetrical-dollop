<?php
include('partials/menu.php');
//include('../config/constants.php'); 
if(isset($_GET['id']))
{
    $con = mysqli_connect("localhost", "root", "", "food-order");
    if (!$con){
        die('Could not connect: ' . mysqli_connect_errno());
    }
                //GEt the Order Details
                $id=$_GET['id'];
		$sql = "DELETE FROM finalorder WHERE orderKey = '$id'";
		mysqli_query($con, $sql);
		header('orders.php');
}
else
{
                //REdirect to Manage ORder PAge
                header('location:orders.php');
}

?>