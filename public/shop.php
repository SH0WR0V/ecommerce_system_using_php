<?php
require_once("../resources/config.php");
?>

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<!-- Page Content -->
<div class="container">



    <!-- Jumbotron Header -->
    <header class="jumbotron hero-spacer text-justify">
        <h1>A Warm Welcome!</h1>
        <p>Welcome to our ecommerce store, your one-stop destination for a seamless online shopping experience. Discover a curated selection of high-quality products across diverse categories. With user-friendly navigation, secure transactions, and top-notch customer service, we redefine convenience in e-commerce. Elevate your shopping journey with exclusive deals and a commitment to customer satisfaction. Welcome to a world of ease and style at our shop.</p>
        <p><a class="btn btn-primary btn-large">Call to action!</a>
        </p>
    </header>

    <hr>

    <!-- Title -->
    <div class="row">
        <div class="col-lg-12">
            <h3>Latest Features</h3>
        </div>
    </div>
    <!-- /.row -->



    <!-- Page Features -->
    <div class="row text-center">
        <?php
        $result = query("SELECT * FROM products WHERE product_quantity >= 1");
        confirm($result);
        while ($row = fetch_array($result)) :
            $product_id = $row['product_id'];
            $product_name = $row['product_name'];
            $product_price = $row['product_price'];
            $product_image = $row['product_image'];
            $short_desc = substr($row['short_desc'], 0, 70);

        ?>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="<?php echo $product_image; ?>" alt="">
                    <div class="caption">
                        <h4 class="pull-right">&#36;<?php echo $product_price; ?></h4>
                        <h4 class="pull-left"><?php echo $product_name; ?></h4>
                        <br><br>
                        <p><?php echo $short_desc . ".."; ?></p>
                        <p>
                            <a href="../resources/cart.php?add=<?php echo $product_id; ?>" class="btn btn-primary">Add to cart</a> <a href="item.php?id=<?php echo $product_id ?>" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
        <?php
        endwhile;
        ?>
    </div>

    <!-- /.row -->


    <!-- Footer -->


</div>
<!-- /.container -->

<!-- jQuery -->
<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>