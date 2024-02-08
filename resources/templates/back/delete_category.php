<?php
require_once("../../config.php");
?>

<?php
if (isset($_GET['c_id'])) {
    $result = query("DELETE FROM categories WHERE cat_id = " . escape_value($_GET['c_id']) . " ");
    confirm($result);
    set_message("Category ID {$_GET['c_id']} deleted successfully");
    redirect("../../../public/admin/index.php?categories");
} else {
    redirect("../../../public/admin/index.php?categories");
}
