<?php
session_start();
$product_ids = array();

//clear all memory after each refresh
//session_destroy();



include('./header.php');
?>
<div class="banner">
    <img src="./img/banner.jpg" class="banner-img">
</div>

<div class="container goods-container">
    <div class="Checkout-title bg-success text-white">
        Thank you for your purchase!<br>
		Here are the download link(s) for your order:<br>
    </div>
	
	
	<div class="Checkout-content">
	<?php
	
	//initialize the list of purchased books.
	$book_list = array();
	
	//initialize the quantity of purchased books.
	$quantity_list = array();
	
	//loop through all products in the shopping cart until it matches with GET id variable
	foreach($_SESSION["shopping_cart"] as $key => $product) {
		$book_list[] = $product["id"];  
		$quantity_list[] = $product["quantity"];  
		unset($_SESSION["shopping_cart"][$key]);	
    }
	
    //reset session array keys so they match with $product_ids numeric array
    $_SESSION["shopping_cart"] = array_values($_SESSION["shopping_cart"]);
	
	//initialize the variable for traversing quantity_list
	$i = 0;
	
	foreach($book_list as &$book_id){
		
		$info = mysqli_query($dbConnection, "SELECT image, name, link FROM goods WHERE id='$book_id'");
		$info_row = mysqli_fetch_row($info);
		
		//show each item as a card box
		echo '<div class="card">';
		
		//show each item picture
		echo '<div class="card-body"> <img class="rounded" src="';
		echo $info_row[0]; 
		echo '" height=500px>';
		
		//show each item name
		echo '<h4 class="card-title">';
		echo $info_row[1];
		echo '</h4> <br>';
		
		//show each item link
		echo '<a class="card-text" href="';
		echo $info_row[2];
		echo '">download link</a>';
		
		//show each item quantity
		echo '<p class="card-text">Quantity: ';
		echo $quantity_list[$i];
		echo '</p>';
		$i = $i + 1;
		
		//end of card box
		echo '</div> </div>';
	}
	?>
	</div>
	
	<div class="bg-danger text-white"  >
		<a href="./index.php" target="_top">Return to homepage</a>
	</div

</div>


<br />
<?php include('./footer.php'); ?>
