<div class="col-md-3">
    <p class="lead">Shop Name</p>
    <div class="list-group">
        <?php
        $query = "SELECT * FROM categories";
        $result = query($query);
        confirm($result);
        while ($row = fetch_array($result)) {
            $cat_title = $row['cat_title'];
            echo "<a href='' class='list-group-item'>{$cat_title}</a>";
        }
        ?>
    </div>
</div>