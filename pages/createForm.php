<?php
session_start();

// 檢查是否登入，否則跳轉到登入頁面
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: loginForm.php");
    exit;
}

// 確認用戶名稱
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name=" description " content=" Assignment2 " />
  <title>Assignment2 - Travel Blog - New Post</title>
  <link rel="stylesheet" type="text/css" href="../css/form.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<?php include './headerTB.php'; ?>

<div id="content">
  <div class="New Post">
    <h1>Create New Post</h1>

    <form action='create_post.php' method="POST" enctype="multipart/form-data"> <!-- allow user to upload files (pictures) -->
      <dl>
        <dt>Title</dt>
        <dd><input type="text" name="title" required /></dd>
      </dl>

      <dl>
        <dt>State</dt>
        <select name="state" id="state" required>
          <option value="Africa">Africa</option>
          <option value="Asia">Asia</option>
          <option value="Europe">Europe</option>
          <option value="North America">North America</option>
          <option value="South America">South America</option>
          <option value="Oceania">Oceania</option>
        </select>
      </dl>

      <dl>
        <dt>Country</dt>
        <dd><input type="text" name="country" required /></dd>
      </dl>

      <dl>
        <dt>Picture</dt>
        <input type="file" name="picture" accept="image/*" /></dd>
      </dl>

      <dl>
        <dt>Content</dt>
        <dd><textarea id="post_content" name="post_content" required></textarea></dd>
      </dl>
   
      <div id="operations">
        <input type="submit" value="Create Post" />
      </div>
    </form>
  </div>
</div>

<?php include 'footerTB.php'; ?>
</body>
</html>
