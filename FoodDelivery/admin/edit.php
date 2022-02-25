<html>
	<body>
<?php
session_start();
session_regenerate_id();
$mysql_host="localhost"; // MySQL's ip address
$mysql_user="root";
$mysql_password="";
$mysql_db="food-order";

$con = new mysqli($mysql_host,$mysql_user,$mysql_password,$mysql_db);
if (!$con){
    echo $con->errno ."<br>";
    die('Could not connect: '. $con->error);
}
else {
    echo "Connection to DB server at $mysql_host successful<br>";
}
$inactive = 300;

if (isset($_SESSION["timeout"])) {
    // calculate the session's "time to live"
    $sessionTTL = time() - $_SESSION["timeout"];
    if ($sessionTTL > $inactive) {
        session_destroy();
        header("Location: logout.php");
    }
}
?>
<?php
if (empty($_POST['token']))
{
    $token = hash("sha256",uniqid(rand(), TRUE));
    $_SESSION['token'] = $token;
    $_SESSION['token_time'] = time();
    session_regenerate_id();
}

if (!isset($_SESSION['token']))
{
    $_SESSION['token'] = hash("sha256",uniqid(rand(), TRUE));
}


include('validation.php');

?>
<?php 
if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])  //check if token valid
{ 
if(isset($_POST['Submit'])){ //check your user input to ensure non empty.
 
    if (!empty($_POST['FirstName']) &&
        !empty($_POST['LastName']) &&
        !empty($_POST['Username']) &&
        !empty($_POST['Address1']) &&
        !empty($_POST['Contact']) &&
        !empty($_POST['City']) &&
        !empty($_POST['State']) &&
        !empty($_POST['Email']) &&
        !empty($_POST['PostalCode']) &&
        !empty($_POST['Password']) &&
        !empty($_POST['Privilege']) &&
        !empty($_POST['DOB']) &&
        !empty($_POST['UserID'])) {
        echo "OK: fields are not empty<br>";
    }
        else {
            echo "Error: No fields should be empty<br>";
        }
        
        $FirstName=strip_tags($_POST['FirstName']); //Variables for prepared statement
        $LastName=strip_tags($_POST['LastName']);
        $Username=strip_tags($_POST['Username']);
        $Address1=strip_tags($_POST['Address1']);
        $Contact=strip_tags($_POST['Contact']);
        $City=strip_tags($_POST['City']);
        $State=strip_tags($_POST['State']);
        $Email=strip_tags($_POST['Email']);
        $PostalCode=strip_tags($_POST['PostalCode']);
        $Password=strip_tags($_POST['Password']);
        $Privilege=strip_tags($_POST['Privilege']);
        $DOB=strip_tags($_POST['DOB']);
        $UserID=strip_tags($_POST['UserID']);
        $hashValue=hash('sha256',$Password);
        $revhash = strrev($hashValue);
        $password = base64_encode($revhash);
        $securepass = password_hash($password, PASSWORD_DEFAULT);
        $uppercase=preg_match("/[A-Z]/",$Password);
        $lowercase=preg_match("/[a-z]/",$Password);
        $number=preg_match("/[0-9]/",$Password);
        $specialcharacter=preg_match("/[^\w]/",$Password);
        $underscore=preg_match("/[_]/",$Password);
        
        if (inputValidation($FirstName,$LastName, $Username, $Address1, $Contact,$City,$State,$Email,$PostalCode,$Password,$Privilege,$DOB)){
        $query= $con->prepare("UPDATE user set FirstName=?, LastName=?, Username=?, Address1=?, Contact=?, City=?,State=?,Email=?,PostalCode=?,Password=?,Privilege=?,DOB=? WHERE UserID=?
          ");
        $query->bind_param('ssssssssisisi', $FirstName,$LastName, $Username, $Address1, $Contact,$City,$State,$Email,$PostalCode,$securepass,$Privilege,$DOB,$UserID);  
        if ($query->execute()){  //execute query
            echo "Query executed."; //update the row successfully
            header("location: manageadmin.php"); //return to index
        }else{
            echo "Error executing query.";
        }
        }
        $token_age = time() - $_SESSION['token_time']; //calculate token age
        if ($token_age <= 300){
        }
        else{
            echo"session expired";
            echo "<a href='index.php'> Go back</a>";
        }
                
}
        
}

if(isset($_GET['Submit']) && $_GET['Submit']==="GetUpdate"){
    $UserID=$_GET['UserID']; //grab the  UserID from previous page 
    $query="SELECT UserID, FirstName, LastName, Username, Address1, Contact, City,State,Email,PostalCode,Password,Privilege,DOB FROM user WHERE UserID=?"; //to display and select
    $pQuery = $con->prepare($query);
    $pQuery->bind_param('i', $UserID); //bind the parameters
    
    $result=$pQuery->execute(); //execute the query
    $result=$pQuery->get_result(); //Returns a resultset for successful SELECT queries,
    if(!$result) {
        die("SELECT query failed<br> ".$con->error);
    }
    else {
        echo "Showing current selected User<br>";
    }

    
    if ($row=$result->fetch_assoc()) {
?>

    <b>Update</b><br>
    <form action="edit.php" method="post">
    	<table>
        <tr><td>FirstName:</td><td><input type="text" name="FirstName" value="<?php echo $row['FirstName']?>"></td></tr>
        <tr><td>LastName : </td><td><input type="text" name="LastName" value="<?php echo $row['LastName']?>"></td></tr>
        <tr><td>Username: </td><td><input type="text" name="Username" value="<?php echo $row['Username']?>"></td></tr>
        <tr><td>Address1: </td><td><input type="text" name="Address1" value="<?php echo $row['Address1']?>"></td></tr>
        <tr><td>Contact:</td><td><input type="text" name="Contact" value="<?php echo$row['Contact']?>"></td></tr>
        <tr><td>City: </td><td><input type="text" name="City" value="<?php echo $row['City']?>"></td></tr>
        <tr><td>State : </td><td><input type="text" name="State" value="<?php echo $row['State']?>"></td></tr>
        <tr><td>Email : </td><td><input type="text" name="Email" value="<?php echo $row['Email']?>"></td></tr>
        <tr><td>PostalCode : </td><td><input type="text" name="PostalCode" value="<?php echo $row['PostalCode']?>"></td></tr>
        <tr><td>Password : </td><td><input type="text" name="Password" value="<?php echo $row['Password']?>"></td></tr>
        <tr><td>Privilege : </td><td><input type="text" name="Privilege" value="<?php echo $row['Privilege']?>"></td></tr>
         <tr><td>DOB : </td><td><input type="text" name="DOB" value="<?php echo $row['DOB']?>"></td></tr>
        <tr><td></td><td>
        <input type="hidden" name="UserID" value="<?php echo $row['UserID']?>">
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <input type="submit" name="Submit" value="Update"></td></tr>
    	</table>
    </form>
<?php 
    }
}
//echo "Disconnecting now<br>";
$con->close();

?>
</body>
</html>