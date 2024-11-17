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

$sql = "SELECT p.post_id, p.title, p.content, p.created_at, a.username ";
$sql .= "FROM post p ";
$sql .= "JOIN account a ON p.user_id = a.id "; // Join with the account table to fetch username
$sql .= "ORDER BY p.created_at DESC"; // Order by the most recent posts

$result_set = mysqli_query($db, $sql); // Execute the query
if (!$result_set) {
    die("Database query failed: " . mysqli_error($db));
}
?>

<div id="content">
  <div class="posts listing">
    <h1>Posts</h1>

    <div class="actions">
      <a class="action" href="new_post.php">Create New Post</a>
    </div>

    <table class="list">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Author</th>
        <th>Created At</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <!-- Process and display the results -->
      <?php while ($post = mysqli_fetch_assoc($result_set)) { ?>
        <tr>
          <td><?php echo $post['post_id']; ?></td>
          <td><?php echo $post['title']; ?></td>
          <td><?php echo $post['content']; ?></td>
          <td><?php echo $post['username']; ?></td>
          <td><?php echo $post['created_at']; ?></td>
          <td><a class="action" href="<?php echo "view_post.php?id=" . $post['post_id']; ?>">View</a></td>
          <td><a class="action" href="<?php echo "edit_post.php?id=" . $post['post_id']; ?>">Edit</a></td>
          <td><a class="action" href="<?php echo "delete_post.php?id=" . $post['post_id']; ?>">Delete</a></td>
        </tr>
      <?php } ?>
    </table>
  </div>
</div>



        </div>

        <?php include 'footerTB.php'; ?>

  </body>
</html>
