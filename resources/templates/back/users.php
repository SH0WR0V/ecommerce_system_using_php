<?php create_user_in_admin(); ?>

<div class="col-lg-12">

    <div class="row">
        <h1 class="page-header text-center">
            Users
        </h1>
        <h3 class='bg-success text-center'><?php display_message(); ?></h3>
    </div>

    <div class="col-md-12">

        <form action="" method="post">
            <div class="row">
                <div class="col-md-4">
                    <label for="category-title">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label for="category-title">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-4 form-group">
                    <label for="category-title">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" name="create" class="btn btn-primary" value="Create">
            </div>

        </form>

    </div>


    <div class="col-md-12">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>

                <?php get_users_in_admin(); ?>

            </tbody>
        </table> <!--End of Table-->


    </div>


</div>