<?php

include('config/constants.php');


$foodid = $_GET['foodid'];
$pay = $_GET['pay'];

$sql= "UPDATE finalorder SET Payment_Method = '$pay', status='pending' WHERE id='$foodid'";


mysqli_query($conn, $sql);


header("location:pay_stat.php?foodid=$foodid");

?>