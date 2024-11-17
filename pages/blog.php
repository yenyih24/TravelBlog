<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Travel Blog</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
  </head>

  <body>
    <header>
      <h1>Travel Blog</h1>
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li> <!-- Link to Home page -->
          <li><a href="login.html">Login in</a></li> <!-- Link to Login page -->

          <main>
  <?php
  //conect to the datbase

  require_once('database.php');
  include "headerEm.php";
  $db = db_connect();
  //access URL parameter
  if (!isset($_GET['id'])) { //check if we get the id
    header("Location:  index.php");
  }
  $id = $_GET['id'];

  //prepare your query
  $sql = "SELECT * FROM employees WHERE id= '$id'";

  $result_set = mysqli_query($db, $sql);

  $result = mysqli_fetch_assoc($result_set);

  ?>
  <!-- display the employee data -->
  <div id="content">

    <a class="back-link" href="index.php"> Back to List</a>

    <div class="page show">

      <h1> <?php echo $result['name']; ?></h1>

      <div class="attributes">
        <dl>
          <dt>Employee Name</dt>
          <dd><?php echo $result['name']; ?></dd>
        </dl>
        <dl>
          <dt>Employee address</dt>
          <dd><?php echo $result['address']; ?></dd>
        </dl>
        <dl>
          <dt>Employee salary</dt>
          <dd><?php echo $result['salary']; ?></dd>
        </dl>
        <dl>

      </div>


    </div>

  </div>

</main>

  <?php include 'footerEm.php'; ?>
</body>

</html>