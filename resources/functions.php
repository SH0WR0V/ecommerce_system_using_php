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
                        <a href="item.php?id={$product_id}"><img src="../resources/uploads/{$product_image}" style="height:180px; width:auto;" alt=""></a>
                        <div class="caption">
                            <h4 class="pull-right">&#36;{$product_price}</h4>
                            <h4><a href="item.php?id={$product_id}">{$product_name}</a>
                            </h4>
                            <p class="text-justify">{$short_desc}...</p>
                            <a class="btn btn-primary" href="../resources/cart.php?add={$product_id}">Add to cart</a>
                        </div>
                    </div>
                </div>
        DELIMETER;
        echo $products;
    }
}

function get_shop_products()
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
        <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/uploads/{$product_image}" style="height:200px; width:auto;" alt="">
                    <div class="caption">
                        <h4 class="pull-right">&#36;{$product_price}</h4>
                        <h4 class="pull-left">{$product_name}</h4>
                        <br><br>
                        <p class="text-justify">{$short_desc}..</p>
                        <p>
                            <a href="../resources/cart.php?add={$product_id}" class="btn btn-primary">Add to cart</a> <a href="item.php?id={$product_id}" class="btn btn-default">More Info</a>
                        </p>
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
            <td><a href='index.php?reports&o_id={$row['order_id']}'>{$row['order_id']}</a></td>
            <td>{$row['payer_id']}</td>
            <td>&#36;{$row['order_amount']}</td>
            <td>{$row['order_transaction']}</td>
            <td><a href='index.php?reports&o_id={$row['order_id']}'>{$row['order_status']}</a></td>
            <td>{$row['order_currency']}</td>
            <td><a class='btn btn-danger' href='../../resources/templates/back/delete_order.php?o_id={$row['order_id']}'><span class='glyphicon glyphicon-remove'></span></a></td>
        </tr>
    DELIMETER;
        echo $display_orders;
    }
}

function get_reports()
{
    $get_orders = query("SELECT * FROM reports");
    confirm($get_orders);
    while ($row = fetch_array($get_orders)) {
        $display_reports = <<<DELIMETER
        <tr>
            <td>{$row['report_id']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['product_name']}</td>
            <td>&#36;{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
        </tr>
    DELIMETER;
        echo $display_reports;
    }
}

function get_specific_report_from_orders($o_id)
{
    $get_orders = query("SELECT * FROM reports WHERE order_id = " . escape_value($o_id));
    confirm($get_orders);
    while ($row = fetch_array($get_orders)) {
        $display_reports = <<<DELIMETER
        <tr>
            <td>{$row['report_id']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['product_name']}</td>
            <td>&#36;{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
        </tr>
    DELIMETER;
        echo $display_reports;
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
                <a href='index.php?edit_product&p_id={$row['product_id']}'><img src="../../resources/uploads/{$row['product_image']}" alt="" style="height:180px;"></a>
            </td>
            <td>{$category_title}</td>
            <td>{$row['product_quantity']}</td>
            <td>&#36;{$row['product_price']}</td>
            <td><a class='btn btn-danger' href='../../resources/templates/back/delete_product.php?p_id={$row['product_id']}'><span class='glyphicon glyphicon-remove'></span></a></td>
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

function update_product_in_admin()
{
    if (isset($_POST['update'])) {
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

        if (empty($product_image)) {
            $query_for_selecting_image = query("SELECT product_image FROM products WHERE product_id = " . escape_value($_GET['p_id']));
            confirm($query_for_selecting_image);
            $row = fetch_array($query_for_selecting_image);
            $product_image = $row['product_image'];
        }

        $update_product = "UPDATE products SET product_name = '{$product_name}', ";
        $update_product .= "short_desc = '{$product_short_description}', ";
        $update_product .= "product_description = '{$product_description}', ";
        $update_product .= "product_category_id = '{$product_category}', ";
        $update_product .= "product_tags = '{$product_tags}', ";
        $update_product .= "product_image = '{$product_image}', ";
        $update_product .= "product_quantity = '{$product_quantity}', ";
        $update_product .= "product_price = '{$product_price}' ";
        $update_product .= "WHERE product_id = " . escape_value($_GET['p_id']);
        $update_product = query($update_product);
        confirm($update_product);
        set_message("You have updated {$product_name} product successfully");
        redirect("index.php?view_products");
    }
}

function get_categories_in_admin()
{
    $result = query("SELECT * FROM categories");
    confirm($result);
    while ($row = fetch_array($result)) {
        $categories = <<<DELIMETER
            <tr>
                <td>{$row['cat_id']}</td>
                <td>{$row['cat_title']}</td>
                <td><a class='btn btn-warning' href='index.php?edit_category&c_id={$row['cat_id']}'><span class='glyphicon glyphicon-cog'></span></a></td>
                <td><a class='btn btn-danger' href='../../resources/templates/back/delete_category.php?c_id={$row['cat_id']}'><span class='glyphicon glyphicon-remove'></span></a></td>
            </tr>
        DELIMETER;
        echo $categories;
    }
}

function create_category_in_admin()
{
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        $query = query("INSERT INTO categories(cat_title) VALUES ('{$cat_title}')");
        confirm($query);
        set_message("New Category {$cat_title} added");
    }
}

function update_category_in_admin()
{
    if (isset($_POST['update'])) {
        $cat_title = escape_value($_POST['cat_title']);

        $update_category = "UPDATE categories SET cat_title = '{$cat_title}' ";
        $update_category .= "WHERE cat_id = " . escape_value($_GET['c_id']);
        $update_category = query($update_category);
        confirm($update_category);
        set_message("You have updated {$cat_title} category successfully");
        redirect("index.php?categories");
    }
}

function get_users_in_admin()
{
    $result = query("SELECT * FROM users");
    confirm($result);
    while ($row = fetch_array($result)) {
        $users = <<<DELIMETER
            <tr>
                <td>{$row['user_id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['user_email']}</td>
                <td><a class='btn btn-danger' href='../../resources/templates/back/delete_user.php?u_id={$row['user_id']}'><span class='glyphicon glyphicon-remove'></span></a></td>
            </tr>
        DELIMETER;
        echo $users;
    }
}

function create_user_in_admin()
{
    if (isset($_POST['create'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $query = query("INSERT INTO users(username, user_email, password) VALUES ('{$username}', '{$email}', '{$password}')");
        confirm($query);
        set_message("New user {$username} added");
    }
}
