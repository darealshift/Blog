<?php
include "includes/db.php";
include "includes/header.php";
?>

    <!-- Navigation -->
<?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

                if (isset($_GET['p_id'])) {
                    $the_post_id = $_GET['p_id'];
                    $the_post_user = $_GET['author'];
                

                $query = "SELECT * FROM posts WHERE post_user = '{$the_post_user}' ";
                $select_all_posts_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = escape($row['post_id']);
                    $post_title = escape($row['post_title']);
                    $post_user = escape($row['post_user']);
                    $post_date = escape($row['post_date']);
                    $post_image = escape($row['post_image']);
                    $post_content = escape($row['post_content']);
                    ?>
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="/post.php?p_id<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <?php echo $post_user ?>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                    <hr>
                    <a href="/post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="/images/<?php echo $post_image; ?>" alt="<?php echo $post_title; ?>"></a>
                    <hr>
                    <p><?php echo $post_content ?></p>

                    <hr>

                <?php } }?>

                <!-- Blog Comments -->

                <?php
                if (isset($_POST['create_comment'])) {

                    $the_post_id = $_GET['p_id'];
                    $comment_author = escape($_POST['comment_author']);
                    $comment_email = escape($_POST['comment_email']);
                    $comment_content = escape($_POST['comment_content']);

                    if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                        $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";

                        $create_comment_query = mysqli_query($connection, $query);
                        if (!$create_comment_query)  {
                            die("QUERY FAILED!" . mysqli_error($connection));
                        }

                        $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                        $query .= "WHERE post_id = $the_post_id ";
                        $update_comment_count_query = mysqli_query($connection, $query);

                    } else {
                        echo"<script>alert('Fields cannot be empty')</script>";
                    }
                

                $query = "SELECT * FROM comments WHERE comment_post_id = '{$the_post_id}' ";
                $query .= "AND comment_status = 'approved' ";
                $query .= "ORDER BY comment_id DESC ";
                $select_comment_query = mysqli_query($connection, $query);
                if (!$select_comment_query) {
                    die("QUERY FAILED!" . mysqli_error($connection));
                }
                while ($row = mysqli_fetch_array($select_comment_query)) {
                    $comment_date = escape($row['comment_date']);
                    $comment_content = escape($row['comment_content']);
                    $comment_author = escape($row['comment_author']);
                } }
                ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>

    </div>
    <!-- /.row -->

    <hr>

<?php include "includes/footer.php"; ?>