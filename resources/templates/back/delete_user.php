<?php
require_once("../../config.php");
?>

<?php
if (isset($_GET['u_id'])) {
    $result = query("DELETE FROM users WHERE user_id = " . escape_value($_GET['u_id']) . " ");
    confirm($result);
    set_message("User ID {$_GET['u_id']} deleted successfully");
    redirect("../../../public/admin/index.php?users");
} else {
    redirect("../../../public/admin/index.php?users");
}
