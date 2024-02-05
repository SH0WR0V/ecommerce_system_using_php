<?php
require_once("../../resources/config.php");
?>

<?php include(TEMPLATE_BACK . DS . "header.php"); ?>

<?php if (!isset($_SESSION['username'])) {
    redirect("../index.php");
} ?>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- FIRST ROW WITH PANELS -->

        <?php
        if ($_SERVER['REQUEST_URI'] == '/ecommerce_system_using_php/public/admin/' || $_SERVER['REQUEST_URI'] == '/ecommerce_system_using_php/public/admin/index.php') {
            include(TEMPLATE_BACK . DS . "admin_content.php");
        } elseif (isset($_GET['orders'])) {
            include(TEMPLATE_BACK . DS . "orders.php");
        } elseif (isset($_GET['view_products'])) {
            include(TEMPLATE_BACK . DS . "products.php");
        } elseif (isset($_GET['add_product'])) {
            include(TEMPLATE_BACK . DS . "add_product.php");
        } elseif (isset($_GET['categories'])) {
            include(TEMPLATE_BACK . DS . "categories.php");
        } elseif (isset($_GET['users'])) {
            include(TEMPLATE_BACK . DS . "users.php");
        } elseif (isset($_GET['edit_product'])) {
            include(TEMPLATE_BACK . DS . "edit_product.php");
        }
        ?>



    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
<?php include(TEMPLATE_BACK . DS . "footer.php"); ?>