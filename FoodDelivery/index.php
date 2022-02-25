<?php
    if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on")
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
        exit;
    }
    ?>
<?php 
session_start();
if (isset($_SESSION['UserID'])){
include('partials-front/menu.php');
echo "Welcome ".$_SESSION['Username'];
}
else{
    include('partials-front/nologin.php');
}
?>
    
       

    <?php 
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>

   


    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
            
            //Getting Foods from Database that are active and featured
            //SQL Query
            $con = mysqli_connect("localhost", "root", "", "food-order");
            if (!$con){
                die('Could not connect: ' . mysqli_connect_errno());
            }
            $active="Yes";
            $featured="Yes";
            //Query to Get ACtive Categories
            $stmt = $con->prepare("SELECT * FROM food WHERE active=? AND featured=? LIMIT 6");
            //bind the Query
            $stmt->bind_param('ss',$active,$featured);
            //Execute the Query
            $stmt->execute();
            //Count Rows
            $result = $stmt->get_result();
            //Check whether category available or not
            if($result->num_rows > 0) {
                //CAtegory Available
                while($row = $result->fetch_assoc()) {
                    //Get the Values
                    $id = $row['FoodID'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    $restaurant = $row['restaurant'];
                    
            
//             $sql2 = "SELECT * FROM food WHERE active='Yes' AND featured='Yes' LIMIT 6";
//             $query = $conn -> prepare ("SELECT FoodID, title, price, description, image_name FROM food WHERE active='Yes' AND featured='Yes' LIMIT 6");
//             $res3 = $query->execute();
//             $query->store_result();
//             $query->bind_result($FoodID, $title,$price, $description, $image_name);

//             //Execute the Query
//             $res2 = mysqli_query($conn, $sql2);

//             //Count Rows
//             $count2 = mysqli_num_rows($res2);

//             //CHeck whether food available or not
            
//             if($count2>0)
//             {
//                 //Food Available
//                 while($query->fetch())
//                 {
                    
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php 
                                //Check whether image available or not
                                if($image_name=="")
                                {
                                    //Image not Available
                                    echo "<div class='error'>Image not available.</div>";
                                }
                                else
                                {
                                    //Image Available
                                    ?>
                                    <img src="./images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                            
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                             <p class="food-price"><?php echo $restaurant?></p>
                            <p class="food-price">$<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="addToOrder.php?food_id=<?php echo $id; ?>&title=<?php echo $title; ?>&restaurant=<?php echo $restaurant?>&price=<?php echo $price; ?>" class="btn btn-primary">Add to order</a>
       
                            <a href="reviewsfood.php?food_id=<?php echo $id; ?>&title=<?php echo $title;?>" class="btn btn-primary">Reviews</a>
                            <a href="reviewfoodform.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Write Review</a>
                        </div>
                    </div>

                    <?php
                }
            }
            else
            {
                //Food Not Available 
                echo "<div class='error'>Food not available.</div>";
            }
           
            
            ?>

            

 

            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

    
    <?php include('partials-front/footer.php'); ?>