<?php
require_once("../resources/config.php");
require_once("cart.php");
?>

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<?php
if (isset($_GET['PayerID'])) {
    $amount = $_GET['amt'];
    $currency = $_GET['cc'];
    $transaction = $_GET['tx'];
    $status = $_GET['st'];

    $query = query("INSERT INTO orders(order_amount, order_transaction, order_status, order_currency) VALUES('{$amount}', '{$transaction}', '{$status}', '{$currency}')");
    confirm($query);
    session_destroy();
}
?>

<!-- Page Content -->
<div class="container text-center">

    <h1>Thank you for your purchase</h1>

</div>
<!-- /.container -->

<!-- jQuery -->
<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>