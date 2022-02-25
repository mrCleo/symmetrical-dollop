<?php
session_start();
session_unset();
/*unset ($_SESSION['restaurant']);*/
header("location:login.php");
session_destroy();
?>