<div class="col-md-12">
    <div class="row">
        <h1 class="page-header text-center">
            All Orders
        </h1>
        <h3 class='bg-success text-center'><?php display_message(); ?></h3>
    </div>

    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Payer ID</th>
                    <th>Order Amount</th>
                    <th>Transaction ID</th>
                    <th>Order Status</th>
                    <th>Order Currency</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php get_orders(); ?>
            </tbody>
        </table>
    </div>

</div>
<!-- /.container-fluid -->

<!-- /#page-wrapper -->