<?php
require_once("../resources/config.php");
?>

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<!-- Page Content -->
<div class="container">

    <header>
        <h1 class="text-center">Login</h1>
        <div class="col-sm-4 col-sm-offset-5">
            <b class="text-center text-danger bg-warning"><?php display_message(); ?></b>
            <form class="" action="" method="post">
                <?php login_user(); ?>
                <div class="form-group"><label for="">
                        username<input type="text" name="username" class="form-control" required></label>
                </div>
                <div class="form-group"><label for="password">
                        Password<input type="password" name="password" class="form-control" required></label>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary">
                </div>
            </form>
        </div>


    </header>

</div>

<!-- /.container -->
<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>