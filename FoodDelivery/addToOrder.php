<?php
$db_host="localhost";
$db_user="root";
$db_pwd="";
$db_name="food-order";
date_default_timezone_set('Asia/Singapore');
$date = date('m-d-Y h:i:s');

$conn = new mysqli($db_host,$db_user,$db_pwd,$db_name);
?>
<?php
session_start();
//header("location:index.php");
        if(!isset ($_SESSION['restaurant'])){
            $_SESSION['restaurant'] = $_GET['restaurant'];
            echo "success";
        }
        if($_SESSION['restaurant'] == $_GET['restaurant']){
            $stmt=$conn->prepare("INSERT INTO orders (orderKey,UserID,FoodID,title,restaurant,price,date) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("iiissds",$_SESSION['orderKey'], $_SESSION['UserID'], $_GET['food_id'], $_GET['title'], $_GET['restaurant'], $_GET['price'],$date);
           // $stmt=$conn->prepare("SELECT OrderID FROM orders WHERE orderKey=?");
            //$stmt->bind_param("i", $_SESSION['orderKey']);
           // $stmt->store_result();
           // $stmt->bind_result($OrderID);
            $stmt->execute();
            echo "Added to your cart!";
            echo "<a href='index.php'> Go back</a><br>";
        }
        else{
            echo "You can only order from one restaurant, logout first if you want to change";
            echo "<a href='index.php'> Go back</a><br>";
        }
?>