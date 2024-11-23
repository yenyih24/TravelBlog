<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name=" description " content=" Assignment2 " />

    <!-- Add authorship metadata and link CSS and JS files -->

    <title>Group Project - Travel blog- Edit page</title>
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

</head>

<!-- single page form so we get the id and if we hit post the we update so we will process the update mysqli_query
and redirect to index.php page otherwise just display the record. -->
<?php
require_once('../server/database.php');
$db = db_connect();

include 'headerTB.php' ;
if (!isset($_GET['id'])) { //check if we get the id
  header("Location:  index.php");
}
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //access the employee information
  $title = mysqli_real_escape_string($db, $_POST['title']) ;
  $state = mysqli_real_escape_string($db, $_POST['state']) ;
  $country = mysqli_real_escape_string($db, $_POST['country']) ;
  $content = mysqli_real_escape_string($db, $_POST['post_content']) ;
  $imagePath = null;


  if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/images/';
    $fileName = basename($_FILES['picture']['name']);
    $uploadFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile)) {
      $imagePath = $uploadFile;
    } else {
      die("Failed to upload picture.");
    }
  }

//在更新數據庫時，檢查圖片路徑是否為空。只有當新圖片被上傳時才更新
  $imagePathSql = '';
if ($imagePath) {
    $imagePathSql = ", image_path = '$imagePath'";
}

  // 更新資料表 post
    //update the table with new information
  $sql = "UPDATE post SET title = '$title', 
            state = '$state', 
            country = '$country', 
            content = '$content' 
            $imagePathSql 
          WHERE post_id = '$id'";
  $result = mysqli_query($db, $sql);

  // 重新導向至顯示頁面
  header("Location: blog.php?post_id=$id");
  exit;
} else {
  // 顯示目前的 post 資訊
  $sql = "SELECT * FROM post WHERE post_id='$id'";
  $result_set = mysqli_query($db, $sql);
  $result = mysqli_fetch_assoc($result_set);
}
?>

<div class="form-container">

    <h1>Edit Post</h1>

    <form action="<?php echo 'edit.php?id=' . $result['post_id']; ?>" method="post" enctype="multipart/form-data" >

    <div class="textfield">
          <label for="title">Title : </label>
          <input type="text" name="title" value="<?php echo $result['title']; ?>" />
    </div>

    <div class="select">
    <label for="state">State</label>
        <select name="state" id="state" required value="<?php echo $result['state']; ?>" >
          <option value="Africa">Africa</option>
          <option value="Asia">Asia</option>
          <option value="Europe">Europe</option>
          <option value="North America">North America</option>
          <option value="South America">South America</option>
          <option value="Oceania">Oceania</option>
        </select>
    </div>


    <div class="textfield">
          <label for="country">Country : </label>
          <input type="text" name="country" value="<?php echo $result['country']; ?>" />
    </div>

    <div class="content">
          <label for="post_content">Content : </label>
          <textarea name="post_content" required style="width:100%; height:200px"><?php echo $result['content']; ?></textarea>
    </div>
  
      <dl>
        <dt>Picture</dt>
        <dd><input type="file" name="picture" accept="image/*" /></dd>
      </dl>

      <div id="operations">
        <input type="submit" value="Edit Post" />

        <a href="index.php">
          <button class="back_home">Cancel editing</button>
        </a>
      </div>
    </form>
  </div>


<?php include 'footerTB.php'; ?>

</body>

</html>