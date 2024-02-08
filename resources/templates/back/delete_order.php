<?php
require_once("../../config.php");
?>

<?php
if (isset($_GET['o_id'])) {
    $result_for_delete_order = query("DELETE FROM orders WHERE order_id = " . escape_value($_GET['o_id']) . " ");
    confirm($result_for_delete_order);
    $result_for_delete_report = query("DELETE FROM reports WHERE order_id = " . escape_value($_GET['o_id']) . " ");
    confirm($result_for_delete_report);
    set_message("Order deleted successfully");
    redirect("../../../public/admin/index.php?orders");
} else {
    redirect("../../../public/admin/index.php?orders");
}
