<?php
session_start();
session_regenerate_id();
$LogUsername=strip_tags($_POST['Username']);
$LogPassword=strip_tags($_POST['Password']);
/*unset ($_SESSION['restaurant']);*/
$inactive = 300;
// check to see if $_SESSION["timeout"] is set
if (isset($_SESSION["timeout"])) {
    // calculate the session's "time to live"
    $sessionTTL = time() - $_SESSION["timeout"];
    if ($sessionTTL > $inactive) {
        session_destroy();
        header("Location: logout.php");
    }
}



if(empty($LogUsername) || empty($LogPassword))
{
    die("Username or password is empty!");
}

// encrypt password using sha256

//$key = "This is the secret key@!";
//$iv = "00000000000000000000000000000000";
//$crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $LogPassword, MCRYPT_MODE_CBC, $iv);
//$Encode64 = base64_encode($crypt);
$hashAlgo="sha256";
$hashValue=hash($hashAlgo,$LogPassword);
$revhash = strrev($hashValue);
$password = base64_encode($revhash);
//$securepass = password_hash($password, PASSWORD_DEFAULT);
//$check = password_verify($password, $securepass);
//echo $check;


$connection = mysqli_connect("localhost", "root", "","food-order" )or
die("cannot connect");

//if ($check == 1){
$sql=$connection->prepare("SELECT * FROM user WHERE
Username='$LogUsername'");


$result=$sql->execute();
$sql->bind_result($UserID,$FirstName,$LastName,$Username,$Address1,$Contact,$City,$State,$Email,$PostalCode, $Password, $Privilege,$dob);

// If result matched $Username
if($sql->fetch()){   // Register $Role, $Username and redirect to respective user page
    
    $_SESSION['Privilege'] = $Privilege;
    $_SESSION['Username'] = $Username;
    $_SESSION['orderKey'] = rand();
    $_SESSION['UserID'] = $UserID;
    $check = password_verify($password, $Password);
    //echo $Password;
    
    if ($check != 1){
        $_SESSION["invalid"] = "Invalid password" ;
        $_SESSION["attempts"] += 1;
        //echo "Invalid username or wrong password";
        header("location:Login.php");
    }
    else if ($check == 1){
        if ($_SESSION['Privilege'] == "1") {
            // redirect user to member page if role is member
            header("location:index.php");
            //echo $check;
        }else if($_SESSION['Privilege'] == "2") {
            // redirect user to admin page if role is admin
            header("location:moderator.php");
        }else if($_SESSION['Privilege']== "3"){
            header("location:admin/index.php");
        }
    }
    
}

else{
    $_SESSION["invalid"] = "Invalid username" ;
    $_SESSION["attempts"] += 1;
    echo "Invalid username or wrong password";
    header("location:Login.php");
}




?>
<?php include('partials-front/footer.php'); ?>