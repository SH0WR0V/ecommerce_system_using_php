<h1 class="page-header text-center">
    All Products
</h1>
<h3 class='bg-success text-center'><?php display_message(); ?></h3>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Price</th>
            <th class="text-left">Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php get_products_in_admin(); ?>
    </tbody>
</table>