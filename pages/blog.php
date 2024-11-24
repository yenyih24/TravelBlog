<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Travel Blog</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
  </head>

  <body>
  <?php include './headerTB.php'; ?> <

  <main>
  <?php
  // Connect to the database
  require_once('../server/database.php');
  $db = db_connect();

  // Access URL parameter to get the blog post ID
  if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { // Check if the ID is provided and valid
    header("Location: index.php"); // Redirect to the main page if the ID is invalid
  }

  $id = $_GET['id']; // Retrieve the post ID from the URL

  // Query to fetch blog post details
  $sql = "SELECT p.title, p.content, p.state, p.country, p.image_path, p.created_at, a.username 
          FROM post p 
          JOIN account a ON p.user_id = a.id 
          WHERE p.post_id = ?";
  $stmt = mysqli_prepare($db, $sql); // Prepare the SQL statement
  mysqli_stmt_bind_param($stmt, 'i', $id); // Bind the ID parameter to the query
  mysqli_stmt_execute($stmt); // Execute the query
  $result_set = mysqli_stmt_get_result($stmt); // Retrieve the result set

  // Check if any post matches the provided ID
  if (!$result_set || mysqli_num_rows($result_set) === 0) {
    echo "<p>No post found with ID: $id</p>"; // Display an error message if no post is found
    echo '<a href="index.php">Back to List</a>'; // Provide a link to return to the main page
    exit();
  }

  $post = mysqli_fetch_assoc($result_set); // Fetch the blog post details as an associative array
  ?>

<main class="blogPage">
<!-- Display the blog post data -->
  <div id="content">
    <div class="page show">
     
      <h1><?php echo ($post['title']); ?></h1> 

      <div class="attributes">

        <div class='author'> <p><?php echo ($post['username']); ?></p></div> 

       
        <div class='country'> <p><?php echo ($post['country']); ?></p></div>

       
        <div class='state'> <p><?php echo ($post['state']); ?></p></div> 

       
        <div class='image'>
          <p>
            <?php if (!empty($post['image_path'])): ?>
              <img src="<?php echo ($post['image_path']); ?>" alt="Post Image">
            <?php endif; ?>
          </p>
        </div>

        <div class='content'> 
          <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
          <!-- nl2br(): Converts newline characters (\n) in the content to HTML <br> tags for proper display -->
        </div>

        <!-- Display the creation time of the post -->
        <div class='time'> <p><?php echo ($post['created_at']); ?></p></div> 
      </div>
    </div>
  </div>
</main>

  <?php include 'footerTB.php'; ?> 
</body>

</html>
