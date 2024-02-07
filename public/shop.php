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
        <?php get_shop_products(); ?>
    </div>

    <!-- /.row -->


    <!-- Footer -->


</div>
<!-- /.container -->

<!-- jQuery -->
<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>