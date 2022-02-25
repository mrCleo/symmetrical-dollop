    <?php 
    session_start();
    if (isset($_SESSION['UserID'])){
        include('partials-front/menu.php');
        echo "Welcome ".$_SESSION['Username'];
    }
    else{
        include('partials-front/nologin.php');
    }
    //$_SESSION["attempts"] = 0;
    if (isset($_SESSION["lock"])){
        $diff = time() - $_SESSION["lock"];
        if ($diff > 1800){
            unset($_SESSION["lock"]);
            unset($_SESSION["attempts"]);
        }
    }
    ?>
    <?php 
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
    exit;
}
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
<div class="w3-top w3-hide-small">
  <div class="w3-bar w3-xlarge w3-black w3-opacity w3-hover-opacity-off" id="myNavbar">
    <a href="index.php" class="w3-bar-item w3-button">HOME</a>
      <div class="topnav-right">
    <a href="#menu" class="w3-bar-item w3-button">LOGIN</a>
</div>
  </div>
</div>
<br><br>
<h1 style=text-align:center>Welcome to FoodWeb !</h1>
<hr>
<form action="Auth.php" method="post">
  <label for="Username" style=font-size:30px>Username:</label><br>
  <input type="text" placeholder="Enter Username" id="LogUsername" name="Username" value=""><br>
  <label for="Password" style=font-size:30px>Password:</label><br>
  <input type="Password" placeholder="Enter Password" id="LogPassword" name="Password" value=""><br><br>
  <label style=font-size:25px> Forgot your <a href="#" style="color:dodgerblue"><b><u>Password</u></b></a> ? <b>|</b></style>
  <label style=font-size:25px> Don't have an account yet ? <a href="registration.php" style="color:dodgerblue"><b><u>Sign Up</u></b></a>!</style>
  <div class="clearfix">
  <?php 
  if (isset($_SESSION["attempts"]) && $_SESSION["attempts"] == 3){
      $_SESSION["lock"] = time();
      echo "<p>Please wait for 30 minutes</p>";
  }

  
  else if(!isset($_SESSION["lock"])){
     echo "<button type='submit' name='Submit' class='loginbtn' value ='Login' style='color: darkslategray;'>Login </button>";
  }
  ?>
    
  </div>
  <?php if (isset($_SESSION["invalid"])){?>
  <p style="color: red;"><?= $_SESSION["invalid"];?></p>
  <?php unset($_SESSION["invalid"]);}?>
  
</form>
<?php 
if (isset($_SESSION["attempts"])){
$test = $_SESSION['attempts'];
echo "$test";
}
?>
</body>
</html>
    <?php include('partials-front/footer.php'); ?>