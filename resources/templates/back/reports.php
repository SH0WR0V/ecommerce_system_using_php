<?php
if (isset($_GET['o_id'])) {

?>
    <div class="col-md-12">
        <div class="row">
            <h1 class="page-header text-center">
                Reports
            </h1>
            <h3 class='bg-success text-center'><?php display_message(); ?></h3>
        </div>

        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php get_specific_report_from_orders($_GET['o_id']); ?>
                </tbody>
            </table>
        </div>

    </div>
<?php
} else {
?>
    <div class="col-md-12">
        <div class="row">
            <h1 class="page-header text-center">
                All Reports
            </h1>
            <h3 class='bg-success text-center'><?php display_message(); ?></h3>
        </div>

        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php get_reports(); ?>
                </tbody>
            </table>
        </div>

    </div>
<?php
}
?>



<!-- /.container-fluid -->

<!-- /#page-wrapper -->