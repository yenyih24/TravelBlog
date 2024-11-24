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

<!-- This page allows editing of a blog post by fetching its data using the ID, 
processing the update if the form is submitted, and redirecting to the post display page. -->
<?php
require_once('../server/database.php');
$db = db_connect();

include 'headerTB.php' ;

if (!isset($_GET['id'])) { // Check if the post ID is passed in the URL
  header("Location:  index.php"); // Redirect to the index page if no ID is found
}
$id = $_GET['id']; // Get the post ID

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Access the posted data and clean it before updating the database
  $title = mysqli_real_escape_string($db, $_POST['title']) ;
  $state = mysqli_real_escape_string($db, $_POST['state']) ;
  $country = mysqli_real_escape_string($db, $_POST['country']) ;
  $content = mysqli_real_escape_string($db, $_POST['post_content']) ;
  $imagePath = null;

// Check if an image file is uploaded and handle the upload
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

// Update the image path in the database only if a new image was uploaded
  $imagePathSql = '';
if ($imagePath) {
    $imagePathSql = ", image_path = '$imagePath'";
}

// Update the post in the database with the new values
  $sql = "UPDATE post SET title = '$title', 
            state = '$state', 
            country = '$country', 
            content = '$content' 
            $imagePathSql 
          WHERE post_id = '$id'";
  $result = mysqli_query($db, $sql);

  // Redirect to the updated post page
  header("Location: blog.php?post_id=$id");
  exit;
} else {
  //If the form was not submitted, display the current post data for editing
  $sql = "SELECT * FROM post WHERE post_id='$id'";
  $result_set = mysqli_query($db, $sql);
  $result = mysqli_fetch_assoc($result_set);
}
?>

<!-- Form to edit the post -->
<div class="form-container">

    <h1>Edit Post</h1>
<!-- The form submits to the same page with the current post ID for updating -->
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
      <!-- Submit button to update the post -->
      <div id="operations">
        <input type="submit" value="Edit Post" />
        
        <!-- Link to cancel editing and go back to the homepage -->
        <a href="index.php">
          <button class="back_home">Cancel editing</button>
        </a>
      </div>
    </form>
  </div>


<?php include 'footerTB.php'; ?>

</body>

</html>