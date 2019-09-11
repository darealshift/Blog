<form action="" method="post">

    <table class="table table-bordered table-hover">

        <div id="bulkOptionContainer" class="col-xs-4">

            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="approve">Approve</option>
                <option value="unapprove">Unapprove</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>

        <div class="col-xs-4">

            <input type="submit" name="submit" class="btn btn-primary" value="Apply Changes">
            <a class="btn btn-success" href="comments.php?source=approveAll">Approve All</a>
        </div>
    <thead>
    <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>Id</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In Response to</th>
        <th>Date</th>
        <th>Approve</th>
        <th>Unapprove</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>

<?php
$query = "SELECT * FROM comments";
$select_comments = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_comments)) {
    $comment_id = escape($row['comment_id']);
    $comment_post_id = escape($row['comment_post_id']);
    $comment_author = escape($row['comment_author']);
    $comment_content = escape($row['comment_content']);
    $comment_email = escape($row['comment_email']);
    $comment_status = escape($row['comment_status']);
    $comment_date = escape($row['comment_date']);

    echo "<tr>";
    ?>
    <td><input class='checkBoxes' id='selectAllBoxes' type='checkbox' name='checkBoxArray[]' value= '<?php echo $comment_id; ?>'</td>
    <?php
    echo "<td> {$comment_id} </td>";
    echo "<td> {$comment_author} </td>";
    echo "<td> {$comment_content} </td>";

    echo "<td> $comment_email </td>";
    echo "<td> $comment_status </td>";

    $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
    $select_post_id_query = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_post_id_query)){
        $post_id = escape($row['post_id']);
        $post_title = escape($row['post_title']);

        echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
    }

    echo "<td> {$comment_date} </td>";
    echo "<td> <a class='btn btn-success' href ='comments.php?approve=$comment_id'> Approve </a></td>";
    echo "<td> <a class='btn btn-warning' href ='comments.php?unapprove=$comment_id'> Unapprove </a></td>";
    echo "<td> <a class='btn btn-danger' href ='comments.php?delete=$comment_id'> delete </a></td>";
    echo "</tr>";
}
?>

</tbody>
</table>

<?php
if (isset($_GET['approve'])) {
    $the_comment_id = $_GET['approve'];
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$the_comment_id} ";
    $approve_comment_query = mysqli_query($connection, $query);
    header("Location: comments.php");
}

if (isset($_GET['unapprove'])) {
    $the_comment_id = $_GET['unapprove'];
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$the_comment_id} ";
    $unapprove_comment_query = mysqli_query($connection, $query);
    header("Location: comments.php");
}

if (isset($_GET['delete'])) {
    $the_comment_id = $_GET['delete'];
    $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
    $delete_query = mysqli_query($connection, $query);
    header("Location: comments.php");
}
?>

<?php // SWITCH statements for bulk options

    if(isset($_POST['checkBoxArray'])){

        foreach($_POST['checkBoxArray'] as $commentValueId ){

            // echo $checkBoxValue;
            $bulk_options = $_POST['bulk_options'];

            switch ($bulk_options) {

                case 'approve': //THIS WORKS

                    $query = "UPDATE `comments` SET `comment_status` = '{$bulk_options}' WHERE `comments`.`comment_id` = {$commentValueId}";

                    $update_to_approved_status = mysqli_query($connection,$query);

                    confirmQuery($update_to_approved_status);
                    header("location:comments.php");

                    break;

                case 'unapprove': //THIS WORKS

                    $query = "UPDATE `comments` SET `comment_status` = '{$bulk_options}' WHERE `comments`.`comment_id` = {$commentValueId}";

                    $update_to_unapproved_status = mysqli_query($connection,$query);

                    confirmQuery($update_to_unapproved_status);
                    header("location:comments.php");

                    break;


                case 'delete': //THIS WORKS

                    $query = "DELETE FROM comments WHERE comment_id = {$commentValueId}";

                    $delete_comment = mysqli_query($connection,$query);

                    confirmQuery($delete_comment);

                    header("location:comments.php");

                    break;

            }
        }
    }
?>

<?php

if(isset($_GET['source'])){

    $source = $_GET['source'];

} else {

    $source = '';
}

switch($source) {

    case 'approveAll': //WORKS! dont break it!

        $query = "UPDATE comments SET comment_status = 'approved'";
        $update_all_to_approved_status = mysqli_query($connection, $query);

        confirmQuery($update_all_to_approved_status);
        header("comments.php");

        break;
    case 'approve':
        $query = "UPDATE comments SET comment_status = 'approved'";
        $update_to_approved_status = mysqli_query($connection, $query);

        confirmQuery($update_to_approved_status);
        header("comments.php");
        break;
    case 'unapprove':
        $query = "UPDATE comments SET comment_status = 'unapproved'";
        $update_to_unapproved_status = mysqli_query($connection, $query);

        confirmQuery($update_to_unapproved_status);
        header("comments.php");
        break;
}

?>
