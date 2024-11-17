<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Travel Blog - Main page</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
  </head>

  <body>
    <?php include 'headerTB.php'; ?>

<div class="big-container">
      <aside>
        <ul>
          <li><a href="post.php">New Post</a></li>
        </ul>

      </aside>

      <main>
        <div class="post-container">

        <?php
require_once('../server/database.php');

$db = db_connect(); // Connect to the database

$sql = "SELECT p.post_id, p.title, p.state, p.country, p.content, p.created_at, a.username ";
$sql .= "FROM post p ";
$sql .= "JOIN account a ON p.user_id = a.id "; // Join with the account table to fetch username
$sql .= "ORDER BY p.created_at DESC"; // Order by the most recent posts

$result_set = mysqli_query($db, $sql); // Execute the query
if (!$result_set) {
    die("Database query failed: " . mysqli_error($db));
}
?>


    <div class="blog">

    <?php while ($post = mysqli_fetch_assoc($result_set)) { ?>

    <p><?php echo $post['title']; ?><p>
    <p><?php echo $post['state']; ?><p>
    <p><?php echo $post['country']; ?><p>
    <p><?php echo $post['content']; ?><p>

     <!-- send the id as parameter -->
     <p><a class="action" href="<?php echo "blog.php?id=" . $post['post_id']; ?>">View</a></p>
          <p><a class="action" href="<?php echo "edit.php?id=" . $post['post_id']; ?>">Edit</a></p>
          <p><a class="action" href="<?php echo "delete.php?id=" . $post['post_id']; ?>">Delete</a></p>
          <?php } ?>


        <?php include 'footerTB.php'; ?>

  </body>
</html>
