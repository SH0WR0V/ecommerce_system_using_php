<?php
require_once("../resources/config.php");
?>

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<!-- Page Content -->
<div class="container">



    <!-- Jumbotron Header -->
    <header class="jumbotron hero-spacer">
        <h1>A Warm Welcome!</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
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
        $result = query("SELECT * FROM products WHERE product_category_id = " . escape_value($_GET['id']));
        confirm($result);
        while ($row = fetch_array($result)) :
            $product_id = $row['product_id'];
            $product_name = $row['product_name'];
            $product_price = $row['product_price'];
            $product_image = $row['product_image'];
            $short_desc = substr($row['short_desc'], 0, 75);

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
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id=<?php echo $product_id ?>" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>


        <?php
        endwhile;
        ?>


    </div>

    <!-- /.row -->

    <hr>

    <!-- Footer -->


</div>
<!-- /.container -->

<!-- jQuery -->
<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>