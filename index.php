<?php
session_start();
$product_ids = array();

//clear all memory after each refresh
//session_destroy();

//check if Add to Cart button has been submitted
if(filter_input(INPUT_POST, "add_to_cart")) {
    
    if(isset($_SESSION["shopping_cart"])) {
        //keep track of how many products are in the shopping cart
        $count = count($_SESSION["shopping_cart"]);

        //create sequantial array for matching array keys to products id's
        $product_ids = array_column($_SESSION["shopping_cart"], "id");
        
        if(!in_array(filter_input(INPUT_GET, "id"), $product_ids)) {
            $_SESSION["shopping_cart"][$count] = array
            (
                'id' => filter_input(INPUT_GET, "id"),
                'name' => filter_input(INPUT_POST, "name"),
                'price' => filter_input(INPUT_POST, "price"),
                'quantity' => filter_input(INPUT_POST, "quantity")
            );
        }
        else { //product already exits, increase quantity
            //match array key to id of the product being added to the cart
            for($i = 0; $i < count($product_ids); $i++){
                if ($product_ids[$i] == filter_input(INPUT_GET, "id")) {
                    //add itme quantity to the existing product in the array
                    $_SESSION["shopping_cart"][$i]["quantity"] += filter_input(INPUT_POST, "quantity");
                }
            }
        }
    }
    else { //if shopping cart doesn't exits, create first product with array key 0
        //create array using submitted forn data, start from key 0 and fill it with values
        $_SESSION["shopping_cart"][0] = array
        (
            'id' => filter_input(INPUT_GET, "id"),
            'name' => filter_input(INPUT_POST, "name"),
            'price' => filter_input(INPUT_POST, "price"),
            'quantity' => filter_input(INPUT_POST, "quantity")
        );
    }
}

if(filter_input(INPUT_GET, "action") =="delete"){
    //loop through all products in the shopping cart until it matches with GET id variable
    foreach($_SESSION["shopping_cart"] as $key => $product) {
        if ($product["id"] == filter_input(INPUT_GET, "id")) {
            //remove product from the shopping cart when it matches with the GET id
            unset($_SESSION["shopping_cart"][$key]);
        }
    }
    //reset session array keys so they match with $product_ids numeric array
    $_SESSION["shopping_cart"] = array_values($_SESSION["shopping_cart"]);
}

$search_name = '';
if(filter_input(INPUT_GET, "action") =="search"){
    if (isset($_POST['search_name'])) {
		$search_name = $_POST['search_name'];
	} 
		
}

?>

<?php include('./header.php'); ?>

<div class="banner">
    <img src="./img/banner.jpg" class="banner-img">
</div>

<div class="container goods-container">
    <div class="goods-title">
        Commodity
    </div>
	
	<div class="row goods-row">
    <?php
    $goods = mysqli_query($dbConnection, "SELECT * FROM `goods` WHERE `name` LIKE '%$search_name%' ORDER BY `id` ASC");
    if($goods):
        if(mysqli_num_rows($goods) > 0):
            while ($product = mysqli_fetch_assoc($goods)):
            ?>
            <div class="col-4">
                <div class="goods-detail">
					<form method="post" action="index.php?action=add&id=<?php echo $product["id"]; ?>">
						<div class="goods-detail">
							<img src="<?php echo $product["image"]; ?>" class="img-responsive"/>
							<h4 class="text-info"><?php echo $product["name"]; ?></h4>
							<h4>$ <?php echo $product["price"]; ?></h4>
							<input type="number" name="quantity" class="form-control" value="1" min="1"  />
							<input type="hidden" name="name" value="<?php echo $product["name"]; ?>" />
							<input type="hidden" name="price" value="<?php echo $product["price"]; ?>" />
							<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info" value="Add to Cart" />
						</div>
					</form>
				</div>
            </div>
            <?php
            endwhile;
        endif;
    endif;
    ?>
	</div>
	
    <div style="clear:both"></div>  
    <br />   
        <div class="table-responsive">  
            <table class="table">  
                <tr><th colspan="5"><h3>Order Details</h3> </th></tr>
                <tr>  
                    <th width="40%">Item Name</th>  
                    <th width="10%">Quantity</th>  
                    <th width="20%">Price</th>  
                    <th width="15%">Total</th>  
                    <th width="5%">Action</th>  
                </tr>  
                <?php   
                if(!empty($_SESSION["shopping_cart"])):

                    $total = 0;  

                    foreach($_SESSION["shopping_cart"] as $key => $product): 
                ?>  
                <tr>  
                    <td><?php echo $product["name"]; ?></td>  
                    <td><?php echo $product["quantity"]; ?></td>  
                    <td>$ <?php echo $product["price"]; ?></td>  
                    <td>$ <?php echo number_format($product["quantity"] * $product["price"], 2); ?></td>  
                    <td>
                        <a href="index.php?action=delete&id=<?php echo $product["id"]; ?>">
                            <div class="btn-danger">Remove</div>
                        </a>
                    </td>  
                </tr>  
                <?php  
                    $total = $total + ($product["quantity"] * $product["price"]);  
                    endforeach; 
                ?>  
                <tr>  
                    <td colspan="3">Total</td>  
                    <td>$ <?php echo number_format($total, 2); ?></td>  
                    <td></td>  
                </tr>  
                <tr>
                    <td colspan="5">
                    <?php
                        if(isset($_SESSION["shopping_cart"])):
                        if(isset($_SESSION["shopping_cart"]) > 0):
                    ?>
                        <a href="./checkout.php">Checkout</a>
                    <?php endif; endif; ?>
                    </td>
                </tr>
                <?php
                endif;
                ?>
            </table>  
        </div>  
    </div>
</div>


<br />
<?php include('./footer.php'); ?>
