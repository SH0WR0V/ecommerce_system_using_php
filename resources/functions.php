<?php
// TODO: helper Functions
function set_message($message)
{
    if (!empty($message)) {
        $_SESSION['message'] = "$message";
    } else {
        $_SESSION['message'] = "";
    }
}

function display_message()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function redirect($location)
{
    return header("Location: $location");
}

function query($sql)
{
    global $connection;
    return mysqli_query($connection, $sql);
}

function confirm($result)
{
    global $connection;
    if (!$result) {
        die("QUERY FAILED " . mysqli_error($connection));
    }
}

function escape_value($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result)
{
    return mysqli_fetch_array($result);
}

// TODO: Front-End Functions

function get_products()
{
    $result = query("SELECT * FROM products WHERE product_quantity >= 1");
    confirm($result);
    while ($row = fetch_array($result)) {
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $product_image = $row['product_image'];
        $short_desc = substr($row['short_desc'], 0, 100);
        $products = <<<DELIMETER
        <div class="col-sm-4 col-lg-4 col-md-4">
                    <div class="thumbnail">
                        <a href="item.php?id={$product_id}"><img src="../resources/uploads/{$product_image}" alt="" width=320px height=150px></a>
                        <div class="caption">
                            <h4 class="pull-right">&#36;{$product_price}</h4>
                            <h4><a href="item.php?id={$product_id}">{$product_name}</a>
                            </h4>
                            <p>{$short_desc}..</p>
                            <a class="btn btn-primary" href="../resources/cart.php?add={$product_id}">Add to cart</a>
                        </div>
                    </div>
                </div>
        DELIMETER;
        echo $products;
    }
}

function get_categories()
{
    $result = query("SELECT * FROM categories");
    confirm($result);
    while ($row = fetch_array($result)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        $categories = <<<DELIMETER
            <a href='category.php?id={$cat_id}' class='list-group-item'>{$cat_title}</a>
            DELIMETER;
        echo $categories;
    }
}

function login_user()
{
    if (isset($_POST['submit'])) {
        $username = escape_value($_POST['username']);
        $password = escape_value($_POST['password']);

        $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'");
        confirm($query);

        if (mysqli_num_rows($query) == 0) {
            set_message("*invalid username or password");
            redirect("login.php");
        } else {
            $_SESSION['username'] = $username;
            redirect("admin");
        }
    }
}

function send_message()
{
    if (isset($_POST['submit'])) {
        $to = "sm.shahriar1231@gmail.com";
        $from_name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $headers = "From: {$from_name} {$email}";

        $result = mail($to, $subject, $message, $headers);

        if (!$result) {
            set_message("sorry we couldn't send your message");
        } else {
            set_message("your message has been sent");
        }
    }
}



// TODO: Back-End Functions

function get_orders()
{
    $get_orders = query("SELECT * FROM orders");
    confirm($get_orders);
    while ($row = fetch_array($get_orders)) {
        $display_orders = <<<DELIMETER
        <tr>
            <td>{$row['order_id']}</td>
            <td>{$row['payer_id']}</td>
            <td>&#36;{$row['order_amount']}</td>
            <td>{$row['order_transaction']}</td>
            <td>{$row['order_status']}</td>
            <td>{$row['order_currency']}</td>
            <td><a class='btn btn-danger' href='../../resources/templates/back/delete_order.php?o_id={$row['order_id']}'><span class='glyphicon glyphicon-remove'></span></a></td>
        </tr>
    DELIMETER;
        echo $display_orders;
    }
}

function show_product_category_title($product_category_id)
{
    $cat_title = query("SELECT cat_title FROM categories WHERE cat_id = '{$product_category_id}'");
    confirm($cat_title);
    $cat_title = fetch_array($cat_title);
    return $cat_title['cat_title'];
}

function get_products_in_admin()
{
    $result = query("SELECT * FROM products");
    confirm($result);
    while ($row = fetch_array($result)) {
        $category_title = show_product_category_title($row['product_category_id']);
        $products = <<<DELIMETER
        <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_name']}<br>
                <a href='index.php?edit_product&p_id={$row['product_id']}'><img src="../../resources/uploads/{$row['product_image']}" alt="" width=300 height=210></a>
            </td>
            <td>{$category_title}</td>
            <td>{$row['product_quantity']}</td>
            <td>&#36;{$row['product_price']}</td>
            <td><td><a class='btn btn-danger' href='../../resources/templates/back/delete_product.php?p_id={$row['product_id']}'><span class='glyphicon glyphicon-remove'></span></a></td></td>
        </tr>
        DELIMETER;
        echo $products;
    }
}

function add_product_in_admin()
{
    if (isset($_POST['publish'])) {
        $product_name = escape_value($_POST['product_name']);
        $product_short_description = escape_value($_POST['product_short_description']);
        $product_description = escape_value($_POST['product_description']);
        $product_category = escape_value($_POST['product_category']);
        $product_tags = escape_value($_POST['product_tags']);
        $product_image = $_FILES['product_image']['name'];
        $image_tmp_location = $_FILES['product_image']['tmp_name'];
        $product_quantity = escape_value($_POST['product_quantity']);
        $product_price = escape_value($_POST['product_price']);

        move_uploaded_file($image_tmp_location, "../../resources/uploads/$product_image");

        $add_product = query("INSERT INTO products (product_name, product_category_id, short_desc, product_description, product_tags, product_image, product_quantity, product_price) VALUES ('{$product_name}', '{$product_category}', '{$product_short_description}', '{$product_description}', '{$product_tags}', '{$product_image}', '{$product_quantity}', '{$product_price}')");
        confirm($add_product);
        set_message("New product {$product_name} just added");
        redirect("index.php?view_products");
    }
}

function get_categories_in_add_product()
{
    $result = query("SELECT * FROM categories");
    confirm($result);
    while ($row = fetch_array($result)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        $category_options = <<<DELIMETER
        <option value="{$cat_id}">{$cat_title}</option>
        DELIMETER;
        echo $category_options;
    }
}
