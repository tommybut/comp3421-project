<?php include('./header.php'); ?>

<div class="banner">
    <img src="./img/banner.jpg" class="banner-img">
</div>

<?php

//collect data from HTML form
//set the "name" to empty, if the user directy access search.php without posting "name"
if (isset($_POST['name'])) {
	$name = $_POST['name'];
} else {
	$name = '';
}

// Sql query
$goods = mysqli_query($dbConnection, "SELECT * FROM `goods` WHERE `name` LIKE '%$name%' ");

// while ($row = mysqli_fetch_array($goods)) {}


// echo image
// echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image']).'"/>';

?>


<div class="container goods-container">
    <div class="goods-title">
        Commodity
    </div>
    <div class="row goods-row">

        <?php
        while ($row = mysqli_fetch_array($goods)) {
            echo '
            <div class="col-4">
                <div class="goods-detail">
                    <img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '"/>
                    <br>
                    <strong>' . $row['name'].'</strong><br>' . '
                    Price: $'. $row['price'].'<br>' .'
                    Stock: ' . $row['stock'].'<br>' . '
                </div>
            </div>
            ';
        }
        ?>
    </div>
</div>

<?php include('./footer.php'); ?>