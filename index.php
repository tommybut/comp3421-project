<?php include('./header.php'); ?>

<div class="banner">
    <img src="./img/banner.jpg" class="banner-img">
</div>

<?php

// Sql query
$goods = mysqli_query($dbConnection, "SELECT * FROM `goods`");

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