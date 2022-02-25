
<?php

include('config/constants.php');
$foodid = $_GET['foodid'];

$sql = "SELECT status FROM finalorder WHERE FinalID = '$foodid'";
$result = mysqli_query($conn, $sql);
while ($row = $result-> fetch_assoc()) {
                            $checkstat = $row['status'];
}

$stat = false;
if($checkstat != "Yet to Approve")
  $stat = true;
else
  $stat = false;

?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">   
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" />


</head>
<body>
<?php

if($stat)
{
  ?>
  <div id="finish">
        <div class="container">

<div class="jumbotron text-center">
  <h1 class="display-3">Thank You!</h1>
  <p class="lead"><strong>Your Payment is successful.</strong> </p>
  <hr>
  <p>
    Having trouble? <a href="">Contact us</a>
  </p>
  <p class="lead">
    <a class="btn btn-primary btn-sm" href="index.php" role="button">Continue to homepage</a>
  </p>
</div>
</div>
</div>

<?php } else { ?>
<div id="pending">
        <div class="container">

<div class="jumbotron text-center">
  <h1 class="display-3">Hang On Tight...!</h1>
  <p class="lead"><strong>Your Payment is being processing.</strong> </p>
  <hr>
  <p>
    Please do Not Refresh or close this Tab
  </p>
  
</div>
</div>
</div>
<?php } ?>
</body>
</html>