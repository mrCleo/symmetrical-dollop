
<?php
// Check if session is not registered, redirect back to main page.
// Put this code in first line of web page.
session_start();
$inactive=40;
if (isset($_SESSION["Timeout"])){
    $sessionTTL= time() - $_SESSION["Timeout"];
    if ($sessionTTL = $inactive){
        session_destroy();
    }
}
if (isset($_SESSION['Username'])) {
 echo "Welcome ".$_SESSION['Username'] ; // When echo'd here, it displays nothing.
echo "<br />".$_SESSION['Privilege']."<br />";
}else{
header("location:Login.php");
}
?>
<html>
<body>
<h2>Member Area</h2>
<a href='logout.php'></a>
</body>
    <?php include('partials-front/footer.php'); ?>
</html>
