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

<main class = blogPage>
<!-- display the blog data -->
  <div id="content">

    <div class="page show">
      <h1><?php echo ($post['title']); ?></h1> <!-- 顯示文章標題 -->
      <div class="attributes">

        <div class = 'author'> <p><?php echo ($post['username']); ?></p></div> 
        
        <div class = 'country'> <p><?php echo ($post['country']); ?></p></div> <!-- 顯示國家 -->

        <div class = 'state'> <p><?php echo ($post['state']); ?></p></div> <!-- 顯示state -->

        <div class = 'image'> <p><?php if (!empty($post['image_path'])): ?></p></div> <!-- 如果有圖片路徑 -->

        <div class = 'image'> <p><img src="<?php echo ($post['image_path']); ?>" alt="Post Image"></p></div> 

          <?php endif; ?>

        <div class = 'content'> <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p></div> <!-- Display the content of the blog -->
        <!-- nl2br(): 將儲存在資料庫中的換行符號（\n）轉換為 HTML 的 <br> 標籤 -->
           
        <div class = 'time'> <p><?php echo ($post['created_at']); ?></p></div> <!-- Display the 顯示建立時間 --> 
      </div>
    </div>
  </div>
</main>

  <?php include 'footerTB.php'; ?>
</body>

</html>