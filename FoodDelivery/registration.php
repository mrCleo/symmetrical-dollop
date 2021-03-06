<?php include('partials-front/menu.php'); ?>
<?php 
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
    exit;
}
?>
<?php 
session_start(); 
$hashAlgo="sha256";
$token = hash($hashAlgo,uniqid(rand(), TRUE)); 
$_SESSION['token'] = $token; 
$_SESSION['token_time'] = time(); 
?> 
<html>
<style>
body, html {height: 100%}
body,h1,h2,h3,h4,h5,h6 {font-family: "Amatic SC", sans-serif}
.menu {display: none}
.bgimg {
  background-repeat: no-repeat;
  background-size: cover;
  min-height: 90%;
}
.topnav-right {
  float: right;
}
input[type=text], input[type=password] {
  width: 50%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: 1px solid black;
  background: #f1f1f1;
}

</style>
<body>
<div class="w3-top w3-hide-small">
  <div class="w3-bar w3-xlarge w3-black w3-opacity w3-hover-opacity-off" id="myNavbar">
    <a href="index.php" class="w3-bar-item w3-button">HOME</a>
      <div class="topnav-right">
    <a href="Login.php" class="w3-bar-item w3-button">LOGIN</a>
</div>
  </div>
</div>
<br><br>
<h1>Registration</h1><br>
<a href="Login.php">Registered Successfully? Login here!</a><br><br>
<h6>* means required</h6><br>
<form action="addUser.php" method="post">
  <label for="firstname">First name*:</label><br>
  <input type="text" id="firstname" name="firstname" value=""><br>
  <label for="lastname">Last name*:</label><br>
  <input type="text" id="lastname" name="lastname" value=""><br>
  <label for="username">Username*:</label><br>
  <input type="text" id="username" name="username" value=""><br>
  <label for="address1">Address1*:</label><br>
  <input type="text" id="address1" name="address1" value=""><br>
  <label for="contact">Mobile Number*:</label><br>
  <input type="text" id="contact" name="contact" value=""><br>
  <label for="city">City:</label><br>
  <input type="text" id="city" name="city" value=""><br>
  <label for="state">State:</label><br>
  <input type="text" id="state" name="state" value=""><br>
  <label for="email">Email*:</label><br>
  <input type="text" id="email" name="email" value=""><br>
  <label for="postalcode">Postal Code*:</label><br>
  <input type="text" id="postalcode" name="postalcode" value=""><br>
  <label for="dob">DOB*(mm-dd-yyyy):</label><br>
  <input type="text" id="dob" name="dob" value=""><br>
  <label for="password">Password* (8 characters minimum and at least one special character):</label><br>
  <input type="password" id="password" name="password" value=""><br><br>
  <input type='hidden' name='privilege' value=1>
    <input type ="hidden" name="token" value="<?php echo $token; ?>" /> 
  <input type="submit" value="Register">
</form> 
</body>
</html>        
    <?php include('partials-front/footer.php'); ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  