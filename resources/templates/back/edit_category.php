<?php update_category_in_admin(); ?>

<?php if (isset($_GET['c_id'])) {
    $query = query("select * from categories where cat_id = " . escape_value($_GET['c_id']));
    confirm($query);
    $row = fetch_array($query);
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];
?>

    <div class="row">
        <h1 class="page-header text-center">
            Edit Product Category
        </h1>
        <h3 class='bg-success text-center'><?php display_message(); ?></h3>
    </div>


    <div class="col-md-4">

        <form action="" method="post">

            <div class="form-group">
                <label for="category-title">Category Title</label>
                <input type="text" name="cat_title" class="form-control" value="<?php echo $cat_title; ?>" required>
            </div>

            <div class="form-group">
                <input type="submit" name="update" class="btn btn-primary" value="Update">
            </div>

        </form>

    </div>

<?php
} else {
    redirect("index.php?categories");
} ?>