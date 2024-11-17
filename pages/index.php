<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Travel Blog - Main page</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
  </head>

  <body>
    <?php include 'headerTB.php'; ?>

    <div class="big-container">
      <aside>
        <ul>
          <li><a href="post.html">New Post</a></li>
        </ul>

      </aside>

      <main>
        <div class="post-container">
          
  require_once('database.php');

  $db = db_connect(); //my connection

  $sql = "SELECT * FROM employees "; //query string
  $sql .= "ORDER BY salary ASC";
  //execute the query
  $result_set = mysqli_query($db, $sql);

  ?>

  <div id="content">


    <div class="subjects listing">
      <h1>Title</h1>

      <div class="actions">
        <a class="action" href="new.php">Create New Employee</a>
      </div>

      <table class="list">
        <tr>
          <th>ID</th>
          <th>name</th>
          <th>address</th>
          <th>salary</th>
          <th>&nbsp</th>
          <th>&nbsp</th>
          <th>&nbsp</th>
        </tr>
        <!-- Process the results -->
        <?php while ($results = mysqli_fetch_assoc($result_set)) { ?>
          <tr>
            <td><?php echo $results['id']; ?></td>
            <td><?php echo $results['name']; ?></td>
            <td><?php echo $results['address']; ?></td>
            <td><?php echo $results['salary']; ?></td>
            <!-- send the id as parameter -->
            <td><a class="action" href="<?php echo "show.php?id=" . $results['id']; ?>">View</a></td>
            <td><a class="action" href="<?php echo "edit.php?id=" . $results['id']; ?>">Edit</a></td>
            <td><a class="action" href=<?php echo "delete.php?id=" . $results['id']; ?>">delete</a></td>

          </tr>
        <?php } 
        ?>
      </table>
        </div>

        <?php include 'footerTB.php'; ?>

  </body>
</html>
