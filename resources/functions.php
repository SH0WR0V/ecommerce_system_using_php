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
    $result = query("SELECT * FROM products");
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
                        <a href="item.php?id={$product_id}"><img src="{$product_image}" alt=""></a>
                        <div class="caption">
                            <h4 class="pull-right">&#36;{$product_price}</h4>
                            <h4><a href="item.php?id={$product_id}">{$product_name}</a>
                            </h4>
                            <p>{$short_desc}..</p>
                            <a class="btn btn-primary" target="" href="">Add to cart</a>
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
