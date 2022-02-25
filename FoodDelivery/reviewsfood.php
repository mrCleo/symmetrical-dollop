<?php 
session_start();
if (isset($_SESSION['UserID'])){
    include('partials-front/menu.php');
    echo "Welcome ".$_SESSION['Username'];
}
else{
    include('partials-front/nologin.php');
}
?>
<?php
$title = $_GET['title'];
$con = mysqli_connect("localhost", "root", "", "food-order");
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno());
}
$query= $con->prepare ("SELECT review_food.Comment, review_food.Rating, review_food.Timestamp, user.Username, food.FoodID, review_food.ReviewFoodID FROM 
((review_food INNER JOIN user ON review_food.UserID = user.UserID) INNER JOIN food ON review_food.FoodID = food.FoodID) WHERE food.FoodID = ?");
$query->bind_param("i", $_GET['food_id']);
if ($query->execute()){
    $query->store_result();
    $query->bind_result($comment, $rating,$timestamp, $username, $foodid, $reviewfoodid);
    echo "<h2>Reviews for ".$title."</h2>";
    //echo "<table align='center' border='1'><tr>";
   // echo "<th>Comment</th><th>Rating</th><th>Username</th><th>Timestamp</th></tr>";
    //while($query->fetch())
    //{
      //  echo "<h2>Reviews for ".$title."</h2>";
      //  break;
    //}
    while($query->fetch()){
        echo "<table border='1' style='width:800px'>";
        //do something
       // echo "<tr><td>". $comment . "<td>". $rating . "<td>". $username . "<td>" . $timestamp . "<td>"."<a href='updatefoodreviewform.php?operation=update&id=".$reviewfoodid."'>edit</a>" . "<td>"."'<a href='deletefoodreview.php?operation=delet&id=".$reviewfoodid."'>delete</a></tr></td>";
        echo "<div><td><h4>".$username."</h4><br>";
        echo "<p>Review: ".$comment."</p><br>";
        echo "<p>Rating: ".$rating."/10 <br><br>Date: ".$timestamp."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='updatefoodreviewform.php?operation=update&id=".$reviewfoodid."'>edit</a>&nbsp;&nbsp;&nbsp;<a href='deletefoodreview.php?operation=delete&id=".$reviewfoodid."'>delete</a></p></td></div>";
        echo "</table><br>";
    }
    //echo "</table>";
    //echo $_SESSION['UserID'];
}else{
    echo "Error executing query.";
}
?>
