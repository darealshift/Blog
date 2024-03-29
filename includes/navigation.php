<?php include "db.php"; ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="/index.php">Home</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php

                $query = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {

                    $cat_title = escape($row['cat_title']);
                    $cat_id = escape($row['cat_id']);

                    $category_class = '';
                    $registration_class = '';
                    $contact_class = '';
                    $page_name = basename($_SERVER['PHP_SELF']);


                    if (isset($_GET['category']) && $_GET['category'] == $cat_id) {

                        $category_class = 'active';

                    } else {
                        switch ($page_name) {
                            case 'contact';
                                $registration_class = '';
                                $contact_class = 'active';
                            break;

                            case 'registration';
                                $registration_class = 'active';
                                $contact_class = '';
                            break;

                            default:
                                $registration_class = '';
                                $contact_class = '';

                        }

                        echo "<li class='$category_class'><a href='/category.php?category={$cat_id}'>{$cat_title}</a></li>";

                    }
                }

                ?>

                <?php if(!isset($_SESSION['user_role'])): ?>

                <?php else: ?>
                <?php
                if (is_admin($_SESSION['username'])) {
                ?>
                    <li>
                        <a href="/admin/index.php">Admin</a>
                    </li>
                <?php
                } else {
                    ?>
                    <li>
                        <a href="/admin/profile.php">Profile</a>
                    </li>
                    <?php
                }
                ?>
                <?php endif; ?>

                <li class='<?php echo $contact_class; ?>'>
                    <a href="/contact.php">Contact</a>
                </li>

                <?php if(isset($_SESSION['user_role'])): ?>
                <li>
                    <a href="/includes/logout.php">Logout</a>
                </li>
                <?php else: ?>
                <li class='<?php echo $registration_class; ?>'>
                    <a href="/registration.php">Registration</a>
                </li>
                <li>
                    <a href="/login.php">Login</a>
                </li>
                <?php endif; ?>

                <?php
                if (isset($_SESSION['user_role'])) {
                    if (isset($_GET['p_id'])) {
                        $the_post_id = escape($_GET['p_id']);
                        echo "<li><a href='/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                    }
                }
                ?>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>