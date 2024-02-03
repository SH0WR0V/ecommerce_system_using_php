<?php
require_once("../resources/config.php");
?>

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<?php

process_transaction();

?>

<!-- Page Content -->

<?php
if (isset($_GET['PayerID'])) {
    $PayerID = $_GET['PayerID'];
    $tx = $_GET['tx'];
    $cc = $_GET['cc'];
    $amt = $_GET['amt'];
    $payer_email = $_GET['payer_email'];
    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];
    $address_street = $_GET['address_street'];
    $address_city = $_GET['address_city'];
    $address_state = $_GET['address_state'];
    $address_country_code = $_GET['address_country_code'];
    $address_zip = $_GET['address_zip'];
    $payment_status = $_GET['payment_status'];
    // $item_name1 = $_GET['item_name1'];
    // $quantity1 = $_GET['quantity1'];
    // $mc_gross_1 = $_GET['mc_gross_1'];
    $payment_date = $_GET['payment_date'];
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />

<style>
    body {
        background-color: #eee;
    }

    .card-body {
        padding: 80px;
    }

    .card {
        box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0, 0, 0, .125);
        border-radius: 2.5rem;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-15">Payment Status: <span class="badge bg-success"><?php echo $payment_status; ?></span></h4>
                        <div class="mb-4">
                            <h2 class="mb-1 text-muted">E-Commerce Store</h2>
                        </div>
                        <div class="text-muted">
                            <p class="mb-1">3184 Spruce Drive Pittsburgh, PA 15201</p>
                            <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i> sm.shahriar1231@gmail.com</p>
                            <p><i class="uil uil-phone me-1"></i>Phone - 4084897369</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Billed To: <?php if (isset($first_name)) echo $first_name; ?> <?php if (isset($last_name)) echo $last_name; ?></h5>
                                <p class="mb-1"><?php echo $address_street;
                                                echo ", ";
                                                echo $address_city;
                                                echo $address_state;
                                                echo $address_country_code;
                                                echo $address_zip; ?></p>
                                <p class="mb-1"><?php echo $payer_email; ?></p>
                                <p>001-234-5678</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-6">
                            <div class="text-muted text-sm-end">
                                <div>
                                    <h5 class="font-size-15 mb-1">Payer ID: <?php echo $PayerID; ?></h5>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Payment Date: <?php echo $payment_date; ?></h5>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Order No:</h5>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="py-2">
                        <h5 class="font-size-15">Order Summary</h5>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th class="text-end" style="width: 120px;">Total</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    <tr>


                                        <?php
                                        $last_order_id = query("SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1");
                                        confirm($last_order_id);
                                        $row = fetch_array($last_order_id);
                                        $order_id = $row['order_id'];
                                        $report_result = query("SELECT * FROM reports WHERE order_id = " . $order_id . "");
                                        confirm($report_result);
                                        $i = 1;
                                        while ($row = fetch_array($report_result)) {
                                        ?>
                                            <th scope="row"><?php echo $i;
                                                            $i++; ?></th>
                                            <td>
                                                <div>
                                                    <h5 class="text-truncate font-size-14 mb-1"><?php echo $row['product_name']; ?></h5>
                                                </div>
                                            </td>
                                            <td><?php echo $row['product_price']; ?></td>
                                            <td><?php echo $row['product_quantity']; ?></td>
                                            <td class="text-end">$ 245.50</td>
                                    </tr>
                                <?php } ?>
                                <!-- end tr -->

                                <tr>
                                    <th scope="row" colspan="4" class="text-end">Sub Total</th>
                                    <td class="text-end"><?php echo $amt; ?></td>
                                </tr>
                                <!-- end tr -->
                                <tr>
                                    <th scope="row" colspan="4" class="border-0 text-end">
                                        Discount :</th>
                                    <td class="border-0 text-end">$0.00</td>
                                </tr>
                                <!-- end tr -->
                                <tr>
                                    <th scope="row" colspan="4" class="border-0 text-end">
                                        Shipping Charge :</th>
                                    <td class="border-0 text-end">$0.00</td>
                                </tr>
                                <!-- end tr -->
                                <!-- end tr -->
                                <tr>
                                    <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                                    <td class="border-0 text-end">
                                        <h4 class="m-0 fw-semibold"><?php echo $amt; ?></h4>
                                    </td>
                                </tr>
                                <!-- end tr -->
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div><!-- end table responsive -->
                        <div class="d-print-none mt-4">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-success me-1"><i class="fa fa-print"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    </div>
</div>

<!-- /.container -->

<!-- jQuery -->
<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>