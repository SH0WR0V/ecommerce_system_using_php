<?php create_category_in_admin(); ?>

<div class="row">
    <h1 class="page-header text-center">
        Product Categories
    </h1>
    <h3 class='bg-success text-center'><?php display_message(); ?></h3>
</div>


<div class="col-md-4">

    <form action="" method="post">

        <div class="form-group">
            <label for="category-title">Category Title</label>
            <input type="text" name="cat_title" class="form-control" required>
        </div>

        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Add Category">
        </div>

    </form>

</div>


<div class="col-md-8">

    <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>Title</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php get_categories_in_admin(); ?>
        </tbody>
    </table>

</div>