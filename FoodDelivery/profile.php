<?php
session_start();
$db_host="localhost";
$db_user="root";
$db_pwd="";
$db_name="food-order";

$conn = new mysqli($db_host,$db_user,$db_pwd,$db_name);

?>
    
    <?php include('partials-front/menu.php'); ?>
<?php
if (!isset($_SESSION['UserID'])){
    header("location:login.php");
}
else{
    $stmt=$conn->prepare("SELECT FirstName,LastName,Username,Address1,Contact,City,State,Email,PostalCode,DOB FROM user WHERE UserID=?");
    $stmt->bind_param("i", $_SESSION['UserID']);
    if ($stmt->execute()){
        $stmt->store_result();
        $stmt->bind_result($firstName,$lastName,$username,$address1,$contact,$city,$state,$email,$postalCode,$DOB);
        echo "<h1>User Profile</h1>";
        echo "<table border='1'; margin:20px;>";
        echo "<style>";
        echo ".head{padding: 10px; width: 5cm}";
        echo "td{padding: 15px; width: 30cm}";
        echo "</style>";
        while ($stmt->fetch()){
            echo '<tr><td class="head">First Name</td><td>'.$firstName.'</td></tr>';
            echo '<tr><td class="head">Last Name</td><td>'.$lastName.'</td></tr>';
            echo '<tr><td class="head">Username</td><td>'.$username.'</td></tr>';
            echo '<tr><td class="head">Address 1</td><td>'.$address1.'</td></tr>';
            echo '<tr><td class="head">Contact</td><td>'.$contact.'</td></tr>';
            echo '<tr><td class="head">City</td><td>'.$city.'</td></tr>';
            echo '<tr><td class="head">State</td><td>'.$state.'</td></tr>';
            echo '<tr><td class="head">Email</td><td>'.$email.'</td></tr>';
            echo '<tr><td class="head">Postal Code</td><td>'.$postalCode.'</td></tr>';
            echo '<tr><td class="head">Date of Birth</td><td>'.$DOB.'</td></tr>';
        }
        echo "</table>";
    }
}
?>        
<br><br>
          <div>
          <a href="editProfile.php?user_id=<?php echo $_SESSION['UserID'];?>" class="btn btn-primary">Change Profile</a>
          </div><br><br><br>
          <div>
          <a href=deleteUser.php?user_id=<?php echo $_SESSION['UserID'];?>" class="btn btn-primary">Delete</a>
          </div><br><br>
          <div>
          <a href="logout.php">Log out</a>
          </div>
      </html>
    <?php include('partials-front/footer.php'); ?>