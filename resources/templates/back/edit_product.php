<?php update_product_in_admin(); ?>

<?php if (isset($_GET['p_id'])) {
    $query = query("select * from products where product_id = " . escape_value($_GET['p_id']));
    confirm($query);
    $row = fetch_array($query);
    $product_id = $row['product_id'];
    $product_category_id = $row['product_category_id'];
    $product_name = $row['product_name'];
    $product_price = $row['product_price'];
    $product_image = $row['product_image'];
    $product_quantity = $row['product_quantity'];
    $product_description = $row['product_description'];
    $product_short_description = $row['short_desc'];
    $product_tags = $row['product_tags'];
?>

    <div class="col-md-12">

        <div class="row">
            <h1 class="page-header text-center">
                Edit Product
            </h1>
        </div>


        <form action="" method="post" enctype="multipart/form-data">


            <div class="col-md-8">

                <div class="form-group">
                    <label for="product_name">Product Name </label>
                    <input type="text" name="product_name" class="form-control" value="<?php echo $product_name; ?>">
                </div>

                <div class="form-group">
                    <label for="product_short_description">Product Short Description</label>
                    <textarea name="product_short_description" id="" cols="30" rows="3" class="form-control"><?php echo $product_short_description; ?></textarea>
                </div>


                <div class="form-group">
                    <label for="product_description">Product Description</label>
                    <textarea name="product_description" id="" cols="30" rows="10" class="form-control"><?php echo $product_description; ?></textarea>
                </div>

            </div><!--Main Content-->


            <!-- SIDEBAR-->


            <aside id="admin_sidebar" class="col-md-4">


                <!-- Product Categories-->

                <div class="form-group">
                    <label for="product_category">Product Category</label>

                    <select name="product_category" id="" class="form-control">
                        <option value="<?php echo $product_category_id; ?>"><?php echo show_product_category_title($product_category_id); ?></option>
                        <?php get_categories_in_add_product(); ?>
                    </select>
                </div>





                <!-- Product Brands-->


                <!-- <div class="form-group">
                <label for="product-title">Product Brand</label>
                <select name="product_brand" id="" class="form-control">
                    <option value="">Select Brand</option>
                </select>
            </div> -->


                <!-- Product Tags -->


                <div class="form-group">
                    <label for="product_tags">Product Tags</label>
                    <input type="text" name="product_tags" class="form-control" value="<?php echo $product_tags; ?>">
                </div>

                <!-- Product Image -->
                <div class="form-group">
                    <label for="product_image">Product Image</label>
                    <input type="file" name="product_image">
                    <img src="../../resources/uploads/<?php echo $product_image; ?>" alt="" style="width:150px">
                </div>

                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="product-quantity">Product Quantity</label>
                        <input type="number" name="product_quantity" class="form-control" value="<?php echo $product_quantity; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="product-price">Product Price</label>
                        <input type="number" name="product_price" class="form-control" value="<?php echo $product_price; ?>">
                    </div>
                </div>

                <br>

                <div class="form-group">
                    <input type="submit" name="update" class="btn btn-primary btn-lg" value="Update">
                </div>

            </aside><!--SIDEBAR-->



        </form>



    </div>
<?php
} else {
    redirect("index.php?view_products");
} ?>
<!-- /.container-fluid -->