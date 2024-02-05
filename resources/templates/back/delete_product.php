<?php
require_once("../../config.php");
?>

<?php
if (isset($_GET['p_id'])) {
    $result = query("DELETE FROM products WHERE product_id = " . escape_value($_GET['p_id']) . " ");
    confirm($result);
    set_message("Product ID {$_GET['p_id']} deleted successfully");
    redirect("../../../public/admin/index.php?view_products");
} else {
    redirect("../../../public/admin/index.php?view_products");
}
