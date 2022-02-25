<?php 
include('partials/menu.php');
session_start();
?>
<form action="updatestatus.php" method="post"> 
<br>
<table border='1'>
<tr>
<td>
Action Type <br>
<input type="radio" id="Delivered" name="action" value="Delivered">
<label for="Delivered">Delivered</label><br>
<input type="radio" id="Transit" name="action" value="Transit">
<label for="Transit">Transit</label><br>
<input type="radio" id="Canceled" name="action" value="Canceled">
<input type="hidden" name="orderkey" value="<?php echo $_GET['id']; ?>">
<label for="Canceled">Canceled</label>
<input value="Update" type="submit">
</td>
</tr>
</table>
</form>