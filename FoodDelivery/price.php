<?php
$db_host="localhost";
$db_user="root";
$db_pwd="";
$db_name="food-order";

$conn = new mysqli($db_host,$db_user,$db_pwd,$db_name);
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.tr, td{
  padding:15px;
}
</style>
</head>

<?php
session_start();

$stmt=$conn->prepare("SELECT UserID FROM user WHERE UserID=?");
$stmt->bind_param("i", $_SESSION['UserID']);
$stmt->store_result();
$stmt->bind_result($UserID);
if(!$_SESSION['UserID']){
    header("location:login.php");
}
 


$stmt=$conn->prepare("SELECT OrderID,title,restaurant,price FROM orders WHERE orderKey=?");
$stmt->bind_param("i", $_SESSION['orderKey']);
if ($stmt->execute()){
$stmt->store_result();
$stmt->bind_result($OrderID,$title,$restaurant,$price);
    echo stripslashes("<h1>Cart</h1>");
    echo stripslashes("<table border='1'>");
    echo stripslashes("<tr><td>Title</td><td>Restaurant</td><td>Price</td></tr>");
    while ($stmt->fetch()){
        echo stripslashes("<tr><td>".$title."</td><td>".$restaurant."</td><td>$".$price."</td>");
        echo stripslashes("<td><a href='deleteOrderID.php?Submit=Delete&OrderID=".$OrderID."'>Delete</a></td>");
        echo stripslashes("</tr>");
    }    
    echo "</table>";
}
?>
<body>
<!-- Trigger/Open The Modal -->
<button id="myBtn">Procced to Payment</button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Do you wish to proceed with the payment</h2>
    <?php 
    $sum = $conn->prepare("SELECT SUM(price) FROM orders WHERE orderKey=?");
    $sum->bind_param("i", $_SESSION['orderKey']);
    if($sum->execute()){
    $sum->store_result();
    $sum->bind_result($total);
    while ($sum->fetch()){
        echo stripslashes("<table border='1'>");
        echo stripslashes("<tr><td>Total Price:</td><td>$".$total."</td></tr>");
        }
    }
    ?>
	<a href="form.php?orderkey=<?php echo $_SESSION['orderKey'];?> class="btn btn-primary">Confirm Payment</a>
  </div>

</div>

            <script>
            // Get the modal
            var modal = document.getElementById("myModal");
            
            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");
            
            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
            
            // When the user clicks the button, open the modal 
            btn.onclick = function() {
              modal.style.display = "block";
            }
            
            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
              modal.style.display = "none";
            }
            
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
              if (event.target == modal) {
                modal.style.display = "none";
              }
            }
            </script>

</body>
</html>