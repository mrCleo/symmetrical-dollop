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

$hashAlgo="sha256";
$firstName = strip_tags($_POST['firstName']);
$lastName = strip_tags($_POST['lastName']);
$username = strip_tags($_POST['username']);
$address1 = strip_tags($_POST['address1']);
$contact = strip_tags($_POST['contact']);
$city = strip_tags($_POST['city']);
$state = strip_tags($_POST['state']);
$email = strip_tags($_POST['email']);
$postalCode = strip_tags($_POST['postalCode']);
$passwordnohash = strip_tags($_POST['password']);
$DOB = strip_tags($_POST['DOB']);
$hashValue=hash($hashAlgo,$passwordnohash);
$revhash = strrev($hashValue);
$password = base64_encode($revhash);
$securepass = password_hash($password, PASSWORD_DEFAULT);
$uppercase=preg_match("/[A-Z]/",$passwordnohash);
$lowercase=preg_match("/[a-z]/",$passwordnohash);
$number=preg_match("/[0-9]/",$passwordnohash);
$specialcharacter=preg_match("/[^\w]/",$passwordnohash);
$underscore=preg_match("/[_]/",$passwordnohash);
$emailused=preg_match("/@gmail.com|@yahoo.com|@hotmail.com|@outlook.com/",$email);
$firstnamepattern=preg_match("/^[A-Z][a-z]+$/",$firstName);
$lastnamepattern=preg_match("/^[A-Z][a-z]+$/",$lastName);
$format = preg_match("/[0-1][0-9][-][0-9][0-9][-][0-9][0-9][0-9][0-9]/",$DOB);
$ofage = false;
$usermonth = $DOB[0] . $DOB[1];
$iusermonth = intval($usermonth);
$userdate = $DOB[3] . $DOB[4];
$iuserdate = intval($userdate);
$useryear = $DOB[6] . $DOB[7] . $DOB[8] . $DOB[9];
$iuseryear = intval($useryear);
$current = date('m-d-Y');
$month = $current[0] . $current[1];
$imonth = intval($month);
$date = $current[3] . $current[4];
$idate = intval($date);
$year = $current[6] . $current[7] . $current[8] . $current[9];
$iyear = intval($year);
$firstNameErr = $lastNameErr = $usernameErr = $address1Err = $contactErr = $cityErr = $stateErr = $emailErr = $postalCodeErr = $passwordErr = $DOBErr = "";
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
$stmt=$conn->prepare("UPDATE user SET FirstName=?,LastName=?,Username=?,Address1=?,Contact=?,City=?,State=?,Email=?,PostalCode=?,password=?,DOB=? WHERE UserID=?");
$stmt->bind_param("ssssssssissi",$firstName,$lastName,$username,$address1,$contact,$city,$state,$email,$postalCode,$securepass,$DOB,$_SESSION['UserID']);
$res=$stmt->execute();
if($res){
    echo "Update Successfully";
}else{
    echo "Unable to update";
}
if (empty($firstName) || empty($lastName) || empty($username) || empty($address1) || empty($contact) || empty($email) || empty($postalCode) || empty($password) || empty($DOB)){
    $conn -> close();
    if (empty($lastName)) {
        $lastNameErr = "Last name is required";
    }
    if (empty($firstName)) {
        $firstNameErr = "First name is required";
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
    if (empty($postalCode)) {
        $postalCodeErr = "Postal Code is required";
        
    }
    if (empty($passwordnohash)) {
        $passwordErr = "Password is required";
        
    }
    if (empty($DOB)) {
        $DOBErr = "DOB is required";
        
    }
}
else if (!preg_match('/^[0-9]+$/',$contact)) {
    $conn -> close();
    $contactErr = "Mobile number is invalid";
}
else if (!$uppercase || !$lowercase || !$number || !$specialcharacter || strlen($passwordnohash) < 8){
    $conn -> close();
    $passwordErr = "Password is invalid";
}
else if (!$emailused){
    $conn -> close();
    $emailErr = "Email is invalid";
}
else if (!$firstnamepattern){
    $conn -> close();
    $firstNameErr = "First name is invalid";
}
else if (!$lastnamepattern){
    $conn -> close();
    $lastNameErr = "Last name is invalid";
}
else if (!$ofage){
    $conn -> close();
    $DOBErr = "You must be at least 18 years of age";
    header("registration.php");
}
else if (!$format){
    $conn -> close();
    $DOBErr = "DOB format incorrect";
}
else if ($stmt->execute()){
    
    echo '<script type="text/javascript">';
    echo ' alert("Updated Successfuly")';
    echo '</script>';
}



else{
    echo "<br><br><br>Please try again";
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
<br><br>
<a href="login.php">Registered Successfully? Login here!</a>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class="form-group">
      <label for="firstName">First name:*</label><span class="error"> <?php echo $firstNameErr;?></span> 
      <input class="form-control" type="text" id="firstName" name="firstName" value=<?php echo $firstName; ?>>
    </div>
   	<div class="form-group">
      <label for="lastName">Last name:*</label><span class="error"> <?php echo $lastNameErr;?></span>
      <input class="form-control" type="text" id="lastName" name="lastName" value=<?php echo $lastName; ?>>
    </div>
    <div class="form-group">
      <label for="username">Username*:</label><span class="error"> <?php echo $usernameErr;?></span>
      <input class="form-control" type="text" id="username" name="username" value=<?php echo $username; ?>>
    </div>
    <div class="form-group">
      <label for="address1">Address1*:</label><span class="error">* <?php echo $address1Err;?></span>
      <input class="form-control" type="text" id="address1" name="address1" value=<?php echo $address1; ?>>
    </div>
    <div class="form-group">
      <label for="contact">Mobile Number*:</label><span class="error"> <?php echo $contactErr;?></span>
      <input class="form-control" type="text" id="contact" name="contact" value=<?php echo $contact; ?>>
    </div>
    <div class="form-group">
      <label for="city">City:</label>
      <input class="form-control" type="text" id="city" name="city" value=<?php echo $city; ?>>
    </div>
    <div class="form-group">
      <label for="state">State:</label>
      <input class="form-control" type="text" id="state" name="state" value=<?php echo $state; ?>>
    </div>
    <div class="form-group">
      <label for="email">Email*:</label><span class="error"> <?php echo $emailErr;?></span>
      <input class="form-control" type="text" id="email" name="email" value=<?php echo $email; ?>>
    </div>
    <div class="form-group">
      <label for="postalCode">Postal Code*:</label><span class="error"> <?php echo $postalCodeErr;?></span>
      <input class="form-control" type="text" id="postalCode" name="postalCode" value=<?php echo $postalCode; ?>>
    </div>
    <div class="form-group">
      <label for="DOB">DOB*(mm-dd-yyyy):</label><span class="error"> <?php echo $DOBErr;?></span>
      <input class="form-control" type="text" id="DOB" name="DOB" value=<?php echo $DOB; ?>>
    </div>
    <div class="form-group">
      <label for="password">Password* (8 characters minimum and at least one special character):</label><span class="error">* <?php echo $passwordErr;?></span>
      <input class="form-control" type="password" id="password" name="password" value="">
    </div>
      <p>Password Check:</p> <br>
      <input type="submit" value="Update">
</form> 
</body>
</html>