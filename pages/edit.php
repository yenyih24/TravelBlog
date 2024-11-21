<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name=" description " content=" Assignment2 " />
    <!-- Add authorship metadata and link CSS and JS files -->

    <title>Group Project - Travel blog- Edit page</title>
    <!-- <script src="script.js" defer></script> -->
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

</head>

<!-- single page form so we get the id and if we hit post the we update so we will process the update mysqli_query
and redirect to show page otherwise just display the record. -->
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
  $title = $_POST['title'] ;
  $state = $_POST['state'] ;
  $country = $_POST['country'] ;
  $content = $_POST['post_content'] ;
  $imagePath = null;

  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $uploadDir = '../uploads/';
    $imagePath = $uploadDir . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
      $imagePath = mysqli_real_escape_string($db, $imagePath);
    }
  }

  // 更新資料表 post
  $sql = "UPDATE post SET 
            title = '$title', 
            state = '$state', 
            country = '$country', 
            content = '$content', 
            image = '$imagePath' 
          WHERE post_id = '$id'";
  $result = mysqli_query($db, $sql);

  // 重新導向至顯示頁面
  header("Location: index.php?post_id=$id");
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

    <form action="<?php echo 'edit.php?id=' . $result['post_id']; ?>" method="post" >

    <div class="textfield">
          <label for="title">Title : </label>
          <input type="text" name="title" value="<?php echo $result['title']; ?>" />
    </div>

    <div class="textfield">
          <label for="title">State : </label>
          <input type="text" name="state" value="<?php echo $result['state']; ?>" />
    </div>

    <div class="textfield">
          <label for="title">Country : </label>
          <input type="text" name="country" value="<?php echo $result['country']; ?>" />
    </div>

    <div class="content">
          <label for="title">Content : </label>
          <textarea name="post_content"><?php echo $result['content']; ?></textarea>
    </div>
  
      <dl>
        <dt>Image</dt>
        <dd><input type="file" name="image" /></dd>
      </dl>

      <div id="operations">
        <input type="submit" value="Edit Post" />
      </div>
    </form>
  </div>


<?php include 'footerTB.php'; ?>

</body>

</html>