<?php
session_start();
$db_host="localhost";
$db_user="root";
$db_pwd="";
$db_name="food-order";

$conn = new mysqli($db_host,$db_user,$db_pwd,$db_name);
?>

<?php
include('partials-front/menu.php');
$stmt=$conn->prepare("SELECT FirstName,LastName,Username,Address1,Contact,City,State,Email,PostalCode,Password,DOB FROM user WHERE UserID=?");
$stmt->bind_param("i", $_SESSION['UserID']);
    if ($stmt->execute()){
         $stmt->store_result();
         $stmt->bind_result($firstName,$lastName,$username,$address1,$contact,$city,$state,$email,$postalCode,$password,$DOB);
         $stmt->fetch();
    }
?>
<html>
  <h1 style=margin:20px>Change Profile</h1>
  <head>
  <style>
  .form-group{
        margin: 20px;
  }
  .label{
  
  }
  .form-control{
        padding: 15px;
        width: 20cm
  }
  </style>
  </head>
          <form method="post" action="update.php?user_id=<?php echo $_SESSION['UserID']?>" >
          <div class="form-group">
            <label>First Name</label><br>
            <input type="text" class="form-control" name="firstName" placeholder="First Name" value="<?php echo "$firstName" ?>" />
          </div>
          <div class="form-group">
            <label>Last Name</label><br>
            <input type="text" class="form-control" name="lastName" placeholder="Last Name" value="<?php echo "$lastName" ?>" />
          </div>
          <div class="form-group">
            <label>Username</label><br>
            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo "$username" ?>">
          </div>
          <div class="form-group">
            <label>Address 1</label><br>
            <input type="text" class="form-control" name="address1" placeholder="Address1" value="<?php echo "$address1" ?>">
          </div>
          <div class="form-group">
            <label>Contact</label><br>
            <input type="text" class="form-control" name="contact" placeholder="Contact" value="<?php echo "$contact" ?>">
          </div>
          <div class="form-group">
            <label>City</label><br>
            <input type="text" class="form-control" name="city" placeholder="City" value="<?php echo "$city" ?>">
          </div>
          <div class="form-group">
            <label>State</label><br>
            <input type="text" class="form-control" name="state" placeholder="State" value="<?php echo "$state" ?>">
          </div>
          <div class="form-group">
            <label>Email</label><br>
            <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo "$email" ?>">
          </div>
          <div class="form-group">
            <label>Postal Code</label><br>
            <input type="text" class="form-control" name="postalCode" placeholder="Postal Code" value="<?php echo "$postalCode" ?>">
          </div>
          <div class="form-group">
            <label>New Password</label><br>
            <input type="text" class="form-control" name="password" placeholder="password">
          </div>
          <div class="form-group">
            <label>Date of Birth</label><br>
            <input type="text" class="form-control" name="DOB" placeholder="DOB" value="<?php echo "$DOB" ?>">
          </div><br>
          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" style="width:20em; margin:0;" value"Update"><br><br>
          </div>
        </form>
 </html>