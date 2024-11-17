<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name=" description " content=" Assignment2 " />
  <!-- Add authorship metadata and link CSS and JS files -->

  <title>Assignment2 - Travel blog- New post</title>
  <!-- <script src="script.js" defer></script> -->
  
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
        <dd><input type="text" name="title" /></dd>
      </dl>

      <dl>
        <dt>State</dt>
          <select name="state" id="state">
          <option value="africa">Africa</option>
          <option value="asia">Asia</option>
          <option value="europe">Europe</option>
          <option value="north_america">North America</option>
          <option value="south_america">South America</option>
          <option value="oceania">Oceania</option>
          </select>
      </dl>

      <dl>
        <dt>Country</dt>
        <dd><input type="text" name="name" /></dd>
      </dl>

      <dl>
        <dt>Picture</dt>
      <input type="file" name="picture" accept="image/*" /></dd>
      </dl>

      <dl>
        <dt>Content</dt>
        <dd><textarea id="post_content" name="post_content"></textarea></dd>
      </dl>
   
      <div id="operations">
        <input type="submit" value="Create Post" />
      </div>
    </form>


  </div>

</div>

<?php include 'footerTB.php'; ?>
