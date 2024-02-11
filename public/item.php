<?php
require_once("../resources/config.php");
?>

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<?php review_submit(); ?>

<!-- Page Content -->
<div class="container">

    <!-- Side Navigation -->

    <?php include(TEMPLATE_FRONT . DS . "side_nav.php"); ?>

    <?php
    $result = query("SELECT * FROM products WHERE product_id = " . escape_value($_GET['id']));
    confirm($result);
    while ($row = fetch_array($result)) :

    ?>

        <div class="col-md-9">

            <!--Row For Image and Short Description-->

            <div class="row">

                <div class="col-md-7">
                    <img class="img-responsive" src="../resources/uploads/<?php echo $row['product_image']; ?>" alt="">
                </div>

                <div class=" col-md-5">

                    <div class="thumbnail">


                        <div class="caption-full">
                            <h4><a href="#"><?php echo $row['product_name']; ?></a></h4>
                            <hr>
                            <h4 class=""><?php echo "&#36;" . $row['product_price']; ?></h4>

                            <div class="ratings">
                                <p><?php echo " " . get_specific_product_avg_rating(); ?></p>
                            </div>

                            <p><?php echo $row['short_desc']; ?></p>


                            <form action="">
                                <div class="form-group">
                                    <a href="../resources/cart.php?add=<?php echo $row['product_id']; ?>" class="btn btn-primary">Add to cart</a>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>


            </div><!--Row For Image and Short Description-->


            <hr>


            <!--Row for Tab Panel-->

            <div class="row">

                <div role="tabpanel">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a></li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">

                            <p></p>
                            <p><?php echo $row['product_description']; ?></p>


                        </div>

                    <?php
                endwhile;
                    ?>




                    <div role="tabpanel" class="tab-pane" id="profile">


                        <div class="col-md-6">
                            <h3>Add a review</h3>
                            <hr>

                            <form action="" class="form-inline rating" method="post">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="enter your name here" required>
                                </div><br>


                                <div class="rate">
                                    <input type="radio" id="star5" name="rate" value="5" />
                                    <label for="star5" title="text">5 stars</label>
                                    <input type="radio" id="star4" name="rate" value="4" />
                                    <label for="star4" title="text">4 stars</label>
                                    <input type="radio" id="star3" name="rate" value="3" checked />
                                    <label for="star3" title="text">3 stars</label>
                                    <input type="radio" id="star2" name="rate" value="2" />
                                    <label for="star2" title="text">2 stars</label>
                                    <input type="radio" id="star1" name="rate" value="1" />
                                    <label for="star1" title="text">1 star</label>
                                </div>


                                <br>

                                <div class="form-group">
                                    <textarea name="review" id="" cols="50" rows="8" class="form-control" placeholder="place your review here..." required></textarea>
                                </div>

                                <br>
                                <br>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                </div>
                            </form>

                        </div>



                        <div class="col-md-6">

                            <?php
                            if (isset($_GET['id'])) {
                                $result = query("SELECT * FROM reviews WHERE product_id = " . escape_value($_GET['id']));
                                confirm($result);
                                $num = mysqli_num_rows($result);
                                echo "<h3>" . $num . " Reviews From </h3>";
                                while ($row = fetch_array($result)) {
                                    $rating = $row['rating'];
                                    $username = $row['username'];
                                    $review_date = $row['review_date'];
                                    $review = $row['review'];
                            ?>
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php
                                            for ($i = 1; $i <= $rating; $i++) {
                                            ?>
                                                <span class="glyphicon glyphicon-star"></span>
                                            <?php
                                            }
                                            ?>
                                            <b><?php echo $username; ?></b>
                                            <span class="pull-right"><?php echo $review_date; ?></span>
                                            <p><?php echo $review; ?></p>
                                        </div>
                                    </div>

                                    <hr>
                            <?php
                                }
                            }
                            ?>

                        </div>




                    </div>

                    </div>

                </div>


            </div><!--Row for Tab Panel-->




        </div>


</div>
<!-- /.container -->
<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>