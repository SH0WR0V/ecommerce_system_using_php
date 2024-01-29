<?php
require_once("../resources/config.php");

if (isset($_GET['add'])) {
    $query = query("SELECT * FROM products WHERE product_id = " . escape_value($_GET['add']) . " ");
    confirm($query);

    $row = fetch_array($query);
    if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) {
        $_SESSION['product_' . $_GET['add']] += 1;
        redirect("checkout.php");
    } else {
        set_message("There are only " . $row['product_quantity'] . " " . $row['product_name'] . " available");
        redirect("checkout.php");
    }
}

if (isset($_GET['remove'])) {
    $_SESSION['product_' . $_GET['remove']]--;
    if ($_SESSION['product_' . $_GET['remove']] < 1) {
        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        redirect("checkout.php");
    } else {
        redirect("checkout.php");
    }
}

if (isset($_GET['delete'])) {
    $_SESSION['product_' . $_GET['delete']] = '0';
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);
    redirect("checkout.php");
}

function cart()
{
    $total = 0;
    $sub_quantity = 0;
    foreach ($_SESSION as $name => $value) {
        if ($value > 0) {
            if (substr($name, 0, 8) == 'product_') {
                $length = strlen($name);
                $length = strlen($length - 8);
                $id = substr($name, 8, $length);
                $query = query("SELECT * FROM products WHERE product_id = " . escape_value($id) . " ");
                confirm($query);
                while ($row = fetch_array($query)) {
                    $sub_total = $row['product_price'] * $value;
                    $sub_quantity += $value;
                    $products = <<<DELIMETER
            <tr>
            <td>{$row['product_name']}</td>
            <td>&#36;{$row['product_price']}</td>
            <td>{$value}</td>
            <td>&#36;{$sub_total}</td>
            <td><a class="btn btn-warning" href="cart.php?remove={$row['product_id']}"><span class="glyphicon glyphicon-minus"></span></a>
            <a class="btn btn-success" href="cart.php?add={$row['product_id']}"><span class="glyphicon glyphicon-plus"></span></a>
            <a class="btn btn-danger" href="cart.php?delete={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>
            DELIMETER;
                    echo $products;
                    $_SESSION['item_total'] = $total += $sub_total;
                    $_SESSION['item_quantity'] = $sub_quantity;
                }
            }
        }
    }
}