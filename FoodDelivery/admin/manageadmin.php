<html>
<?php
echo "<a href='index.php'> Go back</a><br>";
session_start();
session_regenerate_id();
$mysql_host="localhost"; // Setup connection to databasae
$mysql_user="root";
$mysql_password="";
$mysql_db="food-order";

$con = new mysqli($mysql_host,$mysql_user,$mysql_password,$mysql_db);
if (!$con){
    echo $con->errno ."<br>";
    die('Could not connect: '. $con->error);
}
else {
    echo "Connection to DB server at $mysql_host successful<br>"; //establish the connection to Dbase
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
if(isset($_POST['Submit']) && $_POST['Submit'] === "Submit"){ //check your user input to ensure non empty.
    
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
        !empty($_POST['DOB'])) {
            echo "OK: fields are not empty<br>";
        }
        else {
            echo "<script LANGUAGE='JavaScript'>
    window.alert('Please fill up all the fields!');
    </script>";
        }
        
        $FirstName=strip_tags($_POST['FirstName']); //Variables from your insert form
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
        
        $hashValue=hash('sha256',$Password);
        $revhash = strrev($hashValue);
        $password = base64_encode($revhash);
        $securepass = password_hash($password, PASSWORD_DEFAULT);
        $uppercase=preg_match("/[A-Z]/",$Password);
        $lowercase=preg_match("/[a-z]/",$Password);
        $number=preg_match("/[0-9]/",$Password);
        $specialcharacter=preg_match("/[^\w]/",$Password);
        $underscore=preg_match("/[_]/",$Password);
        if (!$uppercase || !$lowercase || !$number || !$specialcharacter || strlen($Password) < 8){
            $con -> close();
            echo "Password is invalid";
        }
        
        
        if (inputValidation($FirstName,$LastName, $Username, $Address1, $Contact,$City,$State,$Email,$PostalCode,$Privilege,$DOB)){

                                               
                $query= $con->prepare("INSERT INTO `user` (`FirstName`,`LastName`, `Username`, `Address1`, `Contact`,`City`,`State`,`Email`,`PostalCode`,`Password`,`Privilege`,`DOB`) VALUES
    (?,?,?,?,?,?,?,?,?,?,?,?)"); //prepared statement
                $query->bind_param('ssssssssisis', $FirstName,$LastName, $Username, $Address1, $Contact,$City,$State,$Email,$PostalCode,$securepass,$Privilege,$DOB); //bind the parameters, front portion specifies the data type.      
                if ($query->execute()){ 
                    echo "User Added.<br>";//execute query               
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
        


?>
<body>
    <b>CRUD</b><br>
    <form action="manageadmin.php" method="post">
    	<table>    	
        <tr><td>FirstName:</td><td><input type="text" name="FirstName"></td></tr>
        <tr><td>LastName : </td><td><input type="text" name="LastName"></td></tr>
        <tr><td>Username: </td><td><input type="text" name="Username"></td></tr>
        <tr><td>Address1: </td><td><input type="text" name="Address1"></td></tr>
        <tr><td>Contact:</td><td><input type="text" name="Contact"></td></tr>
        <tr><td>City : </td><td><input type="text" name="City"></td></tr>
        <tr><td>State : </td><td><input type="text" name="State"></td></tr>
        <tr><td>Email : </td><td><input type="text" name="Email"></td></tr>
        <tr><td>PostalCode : </td><td><input type="text" name="PostalCode"></td></tr>
        <tr><td>Password : </td><td><input type="text" name="Password"></td></tr>
        <tr><td>Privilege : </td><td><input type="text" name="Privilege"></td></tr>
        <tr><td>Date of Birth : </td><td><input type="text" name="DOB"></td></tr>
        <tr><td></td><td>
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <input type="submit" name="Submit" value="Submit"></td></tr>        
    	</table>
    </form>

<?php 


if(isset($_GET['Submit']) && $_GET['Submit'] === "Delete"){
    $UserID=$_GET['UserID'];
    
    $query= $con->prepare("Delete from user where UserID = ?");
    $query->bind_param('i', $UserID); //bind the parameters
    
    if ($query->execute()){  //execute query
        echo "User Deleted.<br>";
    }else{
        echo "Error executing query.";
    }



}

?>
<?php 
// select statement
$query="SELECT UserID, FirstName, LastName, Username, Address1, Contact, City,State, Email,PostalCode, Password, Privilege, DOB FROM user"; //sql query
$pQuery = $con->prepare($query); //Prepared statement
$result=$pQuery->execute(); //execute the prepared statement
$result=$pQuery->get_result(); //store the result of the query from prepared statement
if(!$result) {
    die("SELECT query failed<br> ".$con->error);
}
else {
    echo "Showing all users of FoodWeb<br>";
}
$nrows=$result->num_rows; //store the number of rows from the results
echo "#Amount of Current Users=$nrows<br>";

if ($nrows>0) {
    echo "<table>"; //Draw the table header
    echo "<table align='left' border='1'>";
    echo "<tr>";
    echo "<th>UserID</th>";
    echo "<th>FirstName</th>";
    echo "<th>LastName</th>";
    echo "<th>Username</th>";
    echo "<th>Address1</th>";
    echo "<th>Contact</th>";
    echo "<th>City</th>";
    echo "<th>State</th>";
    echo "<th>Email</th>";
    echo "<th>PostalCode</th>";
    echo "<th>Password</th>";
    echo "<th>Privilege</th>";
    echo "</tr>";
    while ($row=$result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>";
        echo $row['UserID'];
        echo "</td>";
        echo "<td>";
        echo $row['FirstName'];
        echo "</td>";
        echo "<td>";
        echo $row['LastName'];
        echo "</td>";
        echo "<td>";
        echo $row['Username'];
        echo "</td>";
        echo "<td>";
        echo $row['Address1'];
        echo "</td>";
        echo "<td>";
        echo $row['Contact'];
        echo "</td>";
        echo "<td>";
        echo $row['City'];
        echo "</td>";
        echo "<td>";
        echo $row['State'];
        echo "</td>";
        echo "<td>";
        echo $row['Email'];
        echo "</td>";
        echo "<td>";
        echo $row['PostalCode'];
        echo "</td>";
        echo "<td>";
        echo $row['Password'];
        echo "</td>";
        echo "<td>";
        echo $row['Privilege'];
        echo "</td>";
        echo "<td>";
        echo $row['DOB'];
        echo "</td>";
        echo "<td>";
        echo "<a href='edit.php?Submit=GetUpdate&UserID=".$row['UserID']."'>Edit</a>";
        echo "</td>";
        echo "<td>";
        echo "<a href='manageadmin.php?Submit=Delete&UserID=".$row['UserID']."'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
else {
    echo "0 records<br>";
}

//echo "<p>Disconnecting now</p>";
$con->close();

?>
</body>
</html>