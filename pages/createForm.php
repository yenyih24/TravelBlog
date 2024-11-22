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

<div class="form-container">
    <h1>Create New Post</h1>

    <form action='create_post.php' method="POST" enctype="multipart/form-data"> <!-- allow user to upload files (pictures) -->
      
    <div class="textfield">
          <label for="title">Title : </label>
          <input type="text" name="title" required />
    </div>

    <div class="select">
    <label for="state">State</label>
        <select name="state" id="state" required>
          <option value="Africa">Africa</option>
          <option value="Asia">Asia</option>
          <option value="Europe">Europe</option>
          <option value="North America">North America</option>
          <option value="South America">South America</option>
          <option value="Oceania">Oceania</option>
        </select>
    </div>

    <div class="country">
    <label for="country">Country : </label>
    <input type="text" name="country" required />
</div>

<div class="picture">
    <label for="picture">Picture : </label>
    <input type="file" name="picture" accept="image/*" />
</div>

<div class="content">
    <label for="content">Content : </label>
    <textarea name="post_content" required style="width:100%; height:200px"></textarea>
</div>

      <div id="operations">
        <input type="submit" value="Create Post" />
      </div>
    </form>
  
</div>

<?php include 'footerTB.php'; ?>
</body>
</html>
