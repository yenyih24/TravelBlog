<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Travel Blog</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
  </head>

  <body>
  <?php include './headerTB.php'; ?>

  <div class="big-container">
      <aside>
        <ul>
          <li><a href="create.php">New Post</a></li>
        </ul>

      </aside>

  <main>
  <?php
  //connect to the database
  require_once('../server/database.php');
  $db = db_connect();

  //access URL parameter
  if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { //check if we get the id
    header("Location: index.php"); // 如果 id 無效，返回主頁
  }

  $id = $_GET['id'];

  // 查詢博客文章詳細資訊
  $sql = "SELECT p.title, p.content, p.state, p.country, p.image_path, p.created_at, a.username 
          FROM post p 
          JOIN account a ON p.user_id = a.id 
          WHERE p.post_id = ?";
  $stmt = mysqli_prepare($db, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $id); // 綁定 id 參數
  mysqli_stmt_execute($stmt);
  $result_set = mysqli_stmt_get_result($stmt);

  // 檢查是否有結果
  if (!$result_set || mysqli_num_rows($result_set) === 0) {
    echo "<p>No post found with ID: $id</p>";
    echo '<a href="index.php">Back to List</a>';
    exit();
  }

  $post = mysqli_fetch_assoc($result_set);
  ?>


<!-- display the blog data -->
  <div id="content">

    <div class="page show">
      <h1><?php echo ($post['title']); ?></h1> <!-- 顯示文章標題 -->
      <div class="attributes">
        <dl>
          <dt>Author</dt>
          <dd><?php echo ($post['username']); ?></dd>
        </dl>
        <dl>
          <?php echo ($post['country']); ?> <!-- 顯示國家 -->
        </dl>
        <dl>
          <?php echo ($post['state']); ?> <!-- 顯示state -->
        </dl>
        <?php if (!empty($post['image_path'])): ?> <!-- 如果有圖片路徑 -->
        <dl>
          <dt>Image</dt>
          <dd><img src="<?php echo ($post['image_path']); ?>" alt="Post Image"></dd>
        </dl>
        <?php endif; ?>
        <dl>
          <dt>Content</dt>
          <dd><?php echo ($post['content']); ?></dd> <!-- 顯示文章內容 -->
        </dl>

        <dl>
          <dt>Created At</dt>
          <dd><?php echo ($post['created_at']); ?></dd> <!-- 顯示建立時間 -->
        </dl>
      </div>
    </div>
  </div>
</main>

  <?php include 'footerTB.php'; ?>
</body>

</html>