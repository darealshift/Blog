<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>

        <?php

        if (isset($_GET['edit'])) {
            global $connection;
            $cat_id = $_GET['edit'];

            $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
            $select_categories_id = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = escape($row['cat_id']);
                $cat_title = escape($row['cat_title']);
            }
            ?>
            <input value="<?php if (isset($cat_title)) { echo $cat_title; } ?>" class="form-control" type="text" name="cat_title">
        <?php } ?>

        <?php
        if (isset($_POST['update_category'])) {
            $the_cat_title = escape($_POST['cat_title']);

            $stmt = mysqli_prepare($connection,"UPDATE categories SET the_cat_title = ? WHERE cat_id = ? ");

            mysqli_stmt_bind_param($stmt, 'si', $cat_title, $cat_id);

            mysqli_stmt_execute($stmt);

            header("categories.php");
            if (!$stmt) {
                die("test" . mysqli_error($connection));
            }
        }
        ?>

    </div>
    <Div class="form-group">
    <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </Div>
</form>