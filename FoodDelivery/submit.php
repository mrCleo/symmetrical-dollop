<?php
$db_host="localhost";
$db_user="root";
$db_pwd="";
$db_name="food-order";

$conn = new mysqli($db_host,$db_user,$db_pwd,$db_name);
?>

<?php 
session_start();
    $sum = $conn->prepare("SELECT SUM(price) FROM orders WHERE orderKey=?");
    $sum->bind_param("i", $_SESSION['orderKey']);
    if($sum->execute()){
    $sum->store_result();
    $sum->bind_result($total);
    while ($sum->fetch()){
        echo "<table border='1'>";
        echo "<tr><td>Total Price:</td><td>$".$total."</td></tr>";
        echo "<a href='index.php'> Go back</a><br>";
        }
    }
echo $total;
?>
    
<?php 
$stmt=$conn->prepare("INSERT INTO finalorder (orderKey,totalprice,UserID,restaurant,orderComments,status) VALUES (?,?,?,?,?,?)");
$stmt->bind_param("idisss",$_SESSION['orderKey'], $total, $_SESSION['UserID'],$_SESSION['restaurant'], $_POST['Comments'], $_POST['status']);
$stmt->execute();
unset($_SESSION['orderKey']);
$_SESSION['orderKey'] = rand();
unset ($_SESSION['restaurant']);
?>