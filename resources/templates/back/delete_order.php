<?php
require_once("../../config.php");
?>

<?php
if (isset($_GET['o_id'])) {
    $result = query("DELETE FROM orders WHERE order_id = " . escape_value($_GET['o_id']) . " ");
    confirm($result);
    set_message("Order deleted successfully");
    redirect("../../../public/admin/index.php?orders");
} else {
    redirect("../../../public/admin/index.php?orders");
}
