<?php 
session_start();
include('partials-front/menu.php');
?>
<html>
<head>
<title>Restaurant Website</title>
</head>
<body>
</body>
<style>
.box{
        height:70px;
        width:30cm;
        margin:20px;
}
.submit{
        height:50px;
        width:10cm;
        margin:18px;
        background-color: #ff6b81;
        color: white;
        cursor: pointer;        
}
</style>
<form action="submit.php" method="post">
<h3>Special Delivery Comments :</h3><br>
<input class=box type="text" name="Comments"/><br><br>
<input class=submit type="submit" value="Comments">
<input type="hidden" name="orderkey" value="<?php echo $_SESSION["orderKey"]; ?>"><br>
<input type="hidden" name="status" value="pending"><br>
</form>
</html>
    <?php include('partials-front/footer.php'); ?>