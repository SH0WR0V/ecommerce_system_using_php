<?php
require_once("config.php");

if (isset($_GET['add'])) {
    $query = query("SELECT * FROM products WHERE product_id = " . escape_value($_GET['add']) . " ");
    confirm($query);

    $row = fetch_array($query);
    if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) {
        $_SESSION['product_' . $_GET['add']] += 1;
        redirect("../public/checkout.php");
    } else {
        set_message("There are only " . $row['product_quantity'] . " " . $row['product_name'] . " available");
        redirect("../public/checkout.php");
    }
}

if (isset($_GET['remove'])) {
    $_SESSION['product_' . $_GET['remove']]--;
    if ($_SESSION['product_' . $_GET['remove']] < 1) {
        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        redirect("../public/checkout.php");
    } else {
        redirect("../public/checkout.php");
    }
}

if (isset($_GET['delete'])) {
    $_SESSION['product_' . $_GET['delete']] = '0';
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);
    redirect("../public/checkout.php");
}

function cart()
{
    $total = 0;
    $sub_quantity = 0;

    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $quantity = 1;

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
            <td><a class="btn btn-warning" href="../resources/cart.php?remove={$row['product_id']}"><span class="glyphicon glyphicon-minus"></span></a>
            <a class="btn btn-success" href="../resources/cart.php?add={$row['product_id']}"><span class="glyphicon glyphicon-plus"></span></a>
            <a class="btn btn-danger" href="../resources/cart.php?delete={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr><input type="hidden" name="item_name_{$item_name}" value="{$row['product_name']}"> 
            <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}"> 
            <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
            <input type="hidden" name="quantity_{$quantity}" value="{$value}">
            DELIMETER;
                    echo $products;

                    $item_name++;
                    $item_number++;
                    $amount++;
                    $quantity++;

                    $_SESSION['item_total'] = $total += $sub_total;
                    $_SESSION['item_quantity'] = $sub_quantity;
                }
            }
        }
    }
}

function show_paypal_button()
{
    if (isset($_SESSION['item_quantity']) && $_SESSION['item_quantity'] >= 1) {
        $show_button = <<<DELIMETER

        <input type="image" name="upload" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">

        DELIMETER;
        return $show_button;
    }
}

function report()
{
    global $connection;
    if (isset($_GET['PayerID'])) {
        $payer_id = $_GET['PayerID'];
        $amount = $_GET['amt'];
        $currency = $_GET['cc'];
        $transaction = $_GET['tx'];
        $status = $_GET['st'];

        if (!empty($_SESSION)) {
            $insert_order = query("INSERT INTO orders(payer_id, order_amount, order_transaction, order_status, order_currency) VALUES('{$payer_id}', '{$amount}', '{$transaction}', '{$status}', '{$currency}')");
            $last_order_id = mysqli_insert_id($connection);
            confirm($insert_order);
        }


        foreach ($_SESSION as $name => $value) {
            if ($value > 0) {
                if (substr($name, 0, 8) == 'product_') {
                    $length = strlen($name);
                    $length = strlen($length - 8);
                    $id = substr($name, 8, $length);

                    $remove_product = query("UPDATE products SET product_quantity = product_quantity - $value WHERE product_id = " . escape_value($id) . " ");
                    confirm($remove_product);

                    $query = query("SELECT * FROM products WHERE product_id = " . escape_value($id) . " ");
                    confirm($query);
                    while ($row = fetch_array($query)) {
                        $product_name = $row['product_name'];
                        $product_price = $row['product_price'];

                        $insert_report = query("INSERT INTO reports(order_id, product_id, product_name, product_price, product_quantity) VALUES('{$last_order_id}', '{$id}', '{$product_name}', '{$product_price}', '{$value}')");
                        confirm($insert_report);
                    }
                }
            }
        }
        session_destroy();
    } else {
        redirect("index.php");
    }
}
