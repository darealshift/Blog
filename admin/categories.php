<?php include "includes/admin_header.php"; ?>

<?php
if (!is_admin($_SESSION['username'])) {
    header("Location: index.php");
}
?>

    <div id="wrapper">

<?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="page-header">
                        Welcome to admin
                        <small>Author</small>
                    </h1>

                    <div class="col-xs-6">

                        <?php insert_categories(); ?>

                    <form action="" method="post">
                    <div class="form-group">
                        <label for="cat-title">Add Category</label>
                        <input class="form-control" type="text" name="cat_title">
                    </div>
                        <input class="btn btn-primary" type="submit" name="submit" value="Add Category">

                    </form>

                        <?php update_categories(); ?>

                    </div>

                    <div class="col-xs-6">

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php findAllCategories(); ?>

                                    <?php deleteCategories(); ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>