
<?php include('partials/menu.php'); 
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
    exit;
}
?>

        <!-- Main Content Section Starts -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Dashboard</h1>
                <br><br>
                <?php 
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }
                ?>
                <br><br>



                <div class="col-4 text-center">

                    <?php 
                    $con = mysqli_connect("localhost", "root", "", "food-order");
                    if (!$con){
                        die('Could not connect: ' . mysqli_connect_errno());
                    }
                        //Sql Query 
                        $sql2 = "SELECT * FROM food";
                        //Execute Query
                        $res2 = mysqli_query($con, $sql2);
                        //Count Rows
                        $count2 = mysqli_num_rows($res2);
                    ?>

                    <h1><?php echo $count2; ?></h1>
                    <br />
                    Foods
                </div>

                <div class="col-4 text-center">
                    
                    <?php 
                    $con = mysqli_connect("localhost", "root", "", "food-order");
                    if (!$con){
                        die('Could not connect: ' . mysqli_connect_errno());
                    }
                        //Sql Query 
                        $sql3 = "SELECT * FROM finalorder";
                        //Execute Query
                        $res3 = mysqli_query($con, $sql3);
                        //Count Rows
                        $count3 = mysqli_num_rows($res3);
                    ?>

                    <h1><?php echo $count3; ?></h1>
                    <br />
                    Total Orders
                </div>

                <div class="col-4 text-center">
                    
                    <?php 
                    $con = mysqli_connect("localhost", "root", "", "food-order");
                    if (!$con){
                        die('Could not connect: ' . mysqli_connect_errno());
                    }
                        //Creat SQL Query to Get Total Revenue Generated
                        //Aggregate Function in SQL
                        $sql4 = "SELECT SUM(totalPrice) AS Total FROM finalorder WHERE status='Delivered'";

                        //Execute the Query
                        $res4 = mysqli_query($con, $sql4);

                        //Get the VAlue
                        $row4 = mysqli_fetch_assoc($res4);
                        
                        //GEt the Total REvenue
                        $total_revenue = $row4['Total'];

                    ?>

                    <h1>$<?php echo $total_revenue; ?></h1>
                    <br />
                    Revenue Generated
                </div>

                <div class="clearfix"></div>

            </div>
        </div>
        <!-- Main Content Setion Ends -->

