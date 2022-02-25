<?php include('partials-front/menu.php'); 
error_reporting(0);
session_start();
?>

<html>

<style>
.error {color: #FF0000;}
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
/* Full-width input fields */
input[type=text], input[type=password] {
  width: 50%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: 1px solid black;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for all buttons */
button {
  background-color: lightgray;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: 1px solid black;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

button:hover {
  opacity:1;
}



/* Float cancel and signup buttons and add an equal width */
.loginbtn {
  float: left;
  width: 30%;
}

/* Add padding to container elements */
.container {
  padding: 16px;
}

/* Clear floats */
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
  .cancelbtn, .signupbtn {
     width: 100%;
  }
}
</style>
<body>
<?php
$hashAlgo="sha256";
$firstname = strip_tags($_POST['firstname']);
$lastname =  strip_tags($_POST['lastname']);
$username =  strip_tags($_POST['username']);
$address1 =  strip_tags($_POST['address1']);

$contact =  strip_tags($_POST['contact']);
$city =  strip_tags($_POST['city']);
$state =  strip_tags($_POST['state']);
$email =  strip_tags($_POST['email']);
$postalcode =  strip_tags($_POST['postalcode']);
$passwordnohash =  strip_tags($_POST['password']);
$privilege =  strip_tags($_POST['privilege']);
$dob =  strip_tags($_POST['dob']);
$test = array();
//$key = "This is the secret key@!";
//$iv = "00000000000000000000000000000000";
//$crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $passwordnohash, MCRYPT_MODE_CBC, $iv);
//$password = base64_encode($crypt);
$hashValue=hash($hashAlgo,$passwordnohash);
$revhash = strrev($hashValue);
$password = base64_encode($revhash);
$securepass = password_hash($password, PASSWORD_DEFAULT);
$uppercase=preg_match("/[A-Z]/",$passwordnohash);
$lowercase=preg_match("/[a-z]/",$passwordnohash);
$number=preg_match("/[0-9]/",$passwordnohash);
$specialcharacter=preg_match("/[^\w]/",$passwordnohash);
//$underscore=preg_match("/[_]/",$passwordnohash);
$emailused=preg_match("/@gmail.com|@yahoo.com|@hotmail.com|@outlook.com/",$email);
$firstnamepattern=preg_match("/^[A-Z][a-z]+$/",$firstname);
$lastnamepattern=preg_match("/^[A-Z][a-z]+$/",$lastname);
$format = preg_match("/[0-1][0-9][-][0-9][0-9][-][0-9][0-9][0-9][0-9]/",$dob);
$ofage = false;
$usermonth = $dob[0] . $dob[1];
$iusermonth = intval($usermonth);
$userdate = $dob[3] . $dob[4];
$iuserdate = intval($userdate);
$useryear = $dob[6] . $dob[7] . $dob[8] . $dob[9];
$iuseryear = intval($useryear);
$current = date('m-d-Y');
$month = $current[0] . $current[1];
$imonth = intval($month);
$date = $current[3] . $current[4];
$idate = intval($date);
$year = $current[6] . $current[7] . $current[8] . $current[9];
$iyear = intval($year);
$firstnameErr = $lastnameErr = $usernameErr = $address1Err = $contactErr = $emailErr = $postalcodeErr = $passwordErr = $dobErr = "";
if (($iyear - $iuseryear) > 18){
    $ofage = true;
}
else if (($iyear - $iuseryear) == 18 && ($iusermonth < $imonth)){
    $ofage = true;
}
else if (($iyear - $iuseryear) == 18 && ($iusermonth == $imonth) && ($iuserdate <= $idate)){
    $ofage = true;
}
else{
    $ofage = false;
}
if (!isset($_SESSION['token']))
{
    $_SESSION['token'] = hash("sha256",uniqid(rand(), TRUE));
}
if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])  //check if token valid
{
    $token_age = time() - $_SESSION['token_time'];   //calculate token age

if ($token_age <= 300) { // limit validity of the token age to 5 minutes
$con = mysqli_connect("localhost", "root", "", "food-order");
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno());
}
$stmt = $con->prepare ("SELECT Username FROM user");
if ($stmt->execute()){
    $stmt->store_result();
    $stmt->bind_result($usernames);
    while ($stmt->fetch()){
        array_push($test, $usernames);
    }
       
    


    
        
    }

$query= $con->prepare ("INSERT INTO user (FirstName, LastName, Username, Address1, Contact, City, State, Email, PostalCode, Password, Privilege,DOB) VALUES
(?,?,?,?,?,?,?,?,?,?,?,?)");
$query->bind_param("ssssssssisis", $firstname, $lastname, $username, $address1, $contact, $city, $state, $email, $postalcode, $securepass, $privilege,$dob);
if (empty($firstname) || empty($lastname) || empty($username) || empty($address1) || empty($contact) || empty($email) || empty($postalcode) || empty($password) || empty($dob)){
    $con -> close();
    if (empty($lastname)) {
        $lastnameErr = "Last name is required";
    }
    if (empty($firstname)) {
        $firstnameErr = "First name is required";
    }
    if (empty($username)) {
        $usernameErr = "Username is required";
    }
    if (empty($address1)) {
        $address1Err = "This address is required";
    }
    if (empty($contact)) {
        $contactErr = "Contact is required";
        
    }
    if (empty($email)) {
        $emailErr = "Email is required";
        
    }
    if (empty($postalcode)) {
        $postalcodeErr = "Postal Code is required";
        
    }
    if (empty($passwordnohash)) {
        $passwordErr = "Password is required";
        
    }
    if (empty($dob)) {
        $dobErr = "DOB is required";
        
    }
}
else if (in_array($username,$test)){
    $con->close();
    $usernameErr = "Username is taken already";

}
else if (!preg_match('/^[0-9]+$/',$contact)) {
$con -> close();
$contactErr = "Mobile number is invalid";
}
else if (!$uppercase || !$lowercase || !$number || !$specialcharacter || strlen($passwordnohash) < 8){
    $con -> close();
    $passwordErr = "Password is invalid";
}
else if (!$emailused){
    $con -> close();
    $emailErr = "Email is invalid";
}
else if (!$firstnamepattern){
    $con -> close();
    $firstnameErr = "First name is invalid";
}
else if (!$lastnamepattern){
    $con -> close();
    $lastnameErr = "Last name is invalid";
}
else if (!$ofage){
    $con -> close();
    $dobErr = "You must be at least 18 years of age";
    header("registration.php");
}
else if (!$format){
    $con -> close();
    $dobErr = "DOB format incorrect";
}
else if ($query->execute()){
    //echo "Query executed.";
    
    echo '<script type="text/javascript">';
    echo ' alert("Registered Successfuly")';  
    echo '</script>';
}



else{
    echo "<br><br><br>Please try again";
}
}
else{
    echo "Token expired.";
}
}

?>
<?php 
session_start(); 
$hashAlgo="sha256";
$token = hash($hashAlgo,uniqid(rand(), TRUE)); 
$_SESSION['token'] = $token; 
$_SESSION['token_time'] = time(); 
?> 


<div class="w3-top w3-hide-small">
  <div class="w3-bar w3-xlarge w3-black w3-opacity w3-hover-opacity-off" id="myNavbar">
    <a href="index.php" class="w3-bar-item w3-button">HOME</a>
      <div class="topnav-right">
    <a href="Login.php" class="w3-bar-item w3-button">LOGIN</a>
</div>
  </div>
</div>
<br><br>
<h1 style=text-align:center>Welcome to FoodWeb !</h1>
<hr>
<a href="Login.php">Registered Successfully? Login here!</a>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <label for="firstname">First name*:</label><span class="error">* <?php echo $firstnameErr;?></span> <br>
  <input type="text" id="firstname" name="firstname" value=<?php echo $firstname; ?>><br>
  <label for="lastname">Last name*:</label><span class="error">* <?php echo $lastnameErr;?></span><br>
  <input type="text" id="lastname" name="lastname" value=<?php echo $lastname; ?>><br>
  <label for="username">Username*:</label><span class="error">* <?php echo $usernameErr;?></span>
  <br>
  <input type="text" id="username" name="username" value=<?php echo $username; ?>><br>
  <label for="address1">Address1*:</label><span class="error">* <?php echo $address1Err;?></span><br>
  <input type="text" id="address1" name="address1" value=<?php echo $address1; ?>><br>
  <label for="contact">Mobile Number*:</label><span class="error">* <?php echo $contactErr;?></span><br>
  <input type="text" id="contact" name="contact" value=<?php echo $contact; ?>><br>
  <label for="city">City:</label><br>
  <input type="text" id="city" name="city" value=<?php echo $city; ?>><br>
  <label for="state">State:</label><br>
  <input type="text" id="state" name="state" value=<?php echo $state; ?>><br>
  <label for="email">Email*:</label><span class="error">* <?php echo $emailErr;?></span><br>
  <input type="text" id="email" name="email" value=<?php echo $email; ?>><br>
  <label for="postalcode">Postal Code*:</label><span class="error">* <?php echo $postalcodeErr;?></span><br>
  <input type="text" id="postalcode" name="postalcode" value=<?php echo $postalcode; ?>><br>
  <label for="dob">DOB*(mm-dd-yyyy):</label><span class="error">* <?php echo $dobErr;?></span><br>
  <input type="text" id="dob" name="dob" value=<?php echo $dob; ?>><br>
  <label for="password">Password* (8 characters minimum and at least one special character):</label><span class="error">* <?php echo $passwordErr;?></span><br>
  <input type="password" id="password" name="password" value=""><br><br>
  <input type='hidden' name='privilege' value=1>
    <input type ="hidden" name="token" value="<?php echo $token; ?>" /> 
  <input type="submit" value="Register">
</form> 
</body>
</html>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               